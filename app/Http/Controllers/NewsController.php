<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\S_News;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    //
    public function index()

    {
        // get latest news, 15 per page
        $news = S_News::orderBy('created_at', 'desc')->simplePaginate(15);

        return view('news.index', compact('news'));
    }
    public function create()
    {
        return view('news.create');
    }

    /**
     * Store a newly created news item.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'category' => 'nullable',
            'is_published' => 'sometimes|boolean',
        ]);

        $news = new S_News();
        $news->id = (string) Str::uuid();
        $news->title = $data['title'];
        $news->content = $data['content'] ?? null;
        // map incoming 'category' to column name used in migration
        if (isset($data['category'])) {
            $news->s_category_id = $data['category'];
        }
        // set the current user if available
        $news->user_id = Auth::id();
        $news->is_published = $request->has('is_published') && $request->boolean('is_published');
        $news->save();

        return redirect()->route('news.index')->with('success', 'Berita berhasil dibuat.');
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
            'category' => 'nullable',
            'is_published' => 'sometimes|boolean',
        ]);

        $news->title = $data['title'];
        $news->content = $data['content'] ?? null;
        if (isset($data['category'])) {
            $news->s_category_id = $data['category'];
        }
        $news->is_published = $request->has('is_published') && $request->boolean('is_published');
        $news->save();

        return redirect()->route('news.index')->with('success', 'Berita berhasil diperbarui.');
    }
}
