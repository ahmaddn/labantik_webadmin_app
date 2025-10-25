<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\S_News;
use App\Models\S_Categories as Category;
use App\Models\S_Menu as Menu;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Handle image upload from CKEditor
     */
    public function uploadImage(Request $request)
    {
        // Ensure user is authenticated (uploads should be protected)
        if (!Auth::check()) {
            Log::warning('news.uploadImage unauthenticated attempt', ['ip' => $request->ip()]);
            return response()->json(['error' => ['message' => 'Unauthenticated']], 401);
        }

        // CKEditor sends the file under the 'upload' field. Accept several fallbacks.
        $candidateFields = ['upload', 'image', 'file', 'files', 'files[]'];
        $fileField = null;
        foreach ($candidateFields as $f) {
            if ($request->hasFile($f)) {
                $fileField = $f;
                break;
            }
        }
        if (!$fileField) {
            Log::warning('news.uploadImage no file field present', ['input' => array_keys($request->all())]);
            return response()->json(['error' => ['message' => 'No image uploaded']], 400);
        }

        $image = $request->file($fileField);
        if (!$image->isValid()) {
            Log::error('news.uploadImage invalid upload', ['error' => $image->getErrorMessage()]);
            return response()->json(['error' => ['message' => 'Uploaded file is not valid']], 400);
        }

        try {
            // generate safe unique filename
            $safeName = preg_replace('/[^A-Za-z0-9\-_\.]/', '_', pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME));
            $extension = $image->getClientOriginalExtension();
            $filename = time() . '_' . $safeName . '.' . $extension;

            // Ensure the storage directory exists
            $storage = Storage::disk('public');
            $dirPath = 'images/news';

            if (!$storage->exists($dirPath)) {
                $storage->makeDirectory($dirPath);
            }

            // store in storage/app/public/images/news
            $path = $image->storeAs($dirPath, $filename);

            $url = asset('storage/' . $dirPath . '/' . $filename);
            Log::info('news.uploadImage stored', ['path' => $path, 'url' => $url, 'user' => Auth::id()]);

            // also write a small debug marker file so we can see uploads even if laravel.log is not configured
            try {
                $marker = storage_path('app/public/images/news/_upload_debug.log');
                file_put_contents($marker, date('Y-m-d H:i:s') . " - stored: $path -> $url by user " . Auth::id() . "\n", FILE_APPEND);
            } catch (\Exception $e) {
                // ignore marker write errors
            }

            // CKEditor 5 SimpleUploadAdapter expects JSON with `url` key. Some integrations also look for `default`.
            // Return 200 for broader compatibility.
            return response()->json(['url' => $url, 'default' => $url]);
        } catch (\Exception $e) {
            Log::error('news.uploadImage exception', ['message' => $e->getMessage()]);
            return response()->json(['error' => ['message' => 'Failed to store uploaded image']], 500);
        }
    }
    //
    public function index()

    {
        // get latest news, 15 per page
        $news = S_News::with('category')->orderBy('created_at', 'desc')->simplePaginate(15);

        return view('news.index', compact('news'));
    }
    public function create()
    {
        // load categories so the form can submit the category id (uuid)
        $categories = Category::orderBy('name')->get();
        $menus = Menu::orderBy('name')->get();
        return view('news.create', compact('categories', 'menus'));
    }

    /**
     * Store a newly created news item.
     */
    public function store(Request $request)
    {
        // require category/menu (migration enforces FK non-null)
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            // accept either an id (uuid) or a name - we'll resolve or create below
            's_category_id' => 'required|string|max:255',
            's_menu_id' => 'required|string|max:255',
            'is_published' => 'nullable|boolean',
        ]);

        // Log the raw input for debugging if something is sent strangely from the client
        Log::debug('news.store input', $request->all());

        // Resolve or create category/menu so FK constraints are satisfied
        $categoryId = null;
        if (!empty($data['s_category_id'])) {
            $catInput = trim($data['s_category_id']);
            if (preg_match('/^[0-9a-fA-F\-]{36}$/', $catInput) && Category::where('id', $catInput)->exists()) {
                $categoryId = $catInput;
            } else {
                // find by name case-insensitive or create
                $cat = Category::whereRaw('LOWER(name) = ?', [strtolower($catInput)])->first();
                if (!$cat) {
                    $cat = new Category();
                    $cat->id = (string) Str::uuid();
                    $cat->name = $catInput;
                    $cat->user_id = Auth::id() ?? null;
                    $cat->save();
                }
                $categoryId = $cat->id;
            }
        }

        // ensure content is a string (DB requires not-null)
        $content = trim(string: $data['content'] ?? '');

        $news = new S_News();
        $news->id = (string) Str::uuid();
        $news->title = $data['title'];
        $news->content = $content;

        // resolve or create menu similar to category
        if (!empty($data['s_menu_id'])) {
            $menuInput = trim($data['s_menu_id']);
            if (preg_match('/^[0-9a-fA-F\-]{36}$/', $menuInput) && Menu::where('id', $menuInput)->exists()) {
                $news->s_menu_id = $menuInput;
            } else {
                $m = Menu::whereRaw('LOWER(name) = ?', [strtolower($menuInput)])->first();
                if (!$m) {
                    $m = new Menu();
                    $m->id = (string) Str::uuid();
                    $m->name = $menuInput;
                    $m->user_id = Auth::id() ?? null;
                    $m->save();
                }
                $news->s_menu_id = $m->id;
            }
        }

        $news->s_category_id = $categoryId;
        // set created_by (migration uses created_by/updated_by)
        $news->created_by = Auth::id();
        $news->is_published = $request->boolean('is_published');
        $news->save();

        return redirect()->route('news.index')->with('success', 'Berita berhasil dibuat.');
    }
    public function edit($id)
    {
        $news = S_News::findOrFail($id);
        // load categories and menus for the form
        $categories = Category::orderBy('name')->get();
        $menus = Menu::orderBy('name')->get();
        return view('news.edit', compact('news', 'categories', 'menus'));
    }

    /**
     * Update the specified news item.
     */
    public function update(Request $request, $id)
    {
        $news = S_News::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            // keep required to satisfy FK constraints when present
            's_category_id' => 'required|string|max:255',
            's_menu_id' => 'required|string|max:255',
            'is_published' => 'sometimes|boolean',
        ]);

        $news->title = $data['title'];
        $news->content = $data['content'] ?? null;
        // resolve/create category
        if (!empty($data['s_category_id'])) {
            $catInput = trim($data['s_category_id']);
            if (preg_match('/^[0-9a-fA-F\-]{36}$/', $catInput) && Category::where('id', $catInput)->exists()) {
                $news->s_category_id = $catInput;
            } else {
                $cat = Category::whereRaw('LOWER(name) = ?', [strtolower($catInput)])->first();
                if (!$cat) {
                    $cat = new Category();
                    $cat->id = (string) Str::uuid();
                    $cat->name = $catInput;
                    $cat->user_id = Auth::id() ?? null;
                    $cat->save();
                }
                $news->s_category_id = $cat->id;
            }
        }
        // resolve/create menu
        if (!empty($data['s_menu_id'])) {
            $menuInput = trim($data['s_menu_id']);
            if (preg_match('/^[0-9a-fA-F\-]{36}$/', $menuInput) && Menu::where('id', $menuInput)->exists()) {
                $news->s_menu_id = $menuInput;
            } else {
                $m = Menu::whereRaw('LOWER(name) = ?', [strtolower($menuInput)])->first();
                if (!$m) {
                    $m = new Menu();
                    $m->id = (string) Str::uuid();
                    $m->name = $menuInput;
                    $m->user_id = Auth::id() ?? null;
                    $m->save();
                }
                $news->s_menu_id = $m->id;
            }
        }

        $news->is_published = $request->has('is_published') && $request->boolean('is_published');
        // set updated_by
        $news->updated_by = Auth::id();
        $news->save();

        return redirect()->route('news.index')->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Display the specified news item.
     */
    public function show($id)
    {
        $news = S_News::findOrFail($id);
        return view('news.show', compact('news'));
    }
}
