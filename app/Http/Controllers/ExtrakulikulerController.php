<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\S_Extrakulikuler;
use App\Models\S_Menu as Menu;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExtrakulikulerController extends Controller
{
    public function index()
    {
        $extracurriculars = S_Extrakulikuler::with('menu')->orderBy('created_at', 'desc')->simplePaginate(15);
        return view('extrakulikuler.index', compact('extracurriculars'));
    }

    public function create()
    {
        $menus = Menu::orderBy('name')->get();
        return view('extrakulikuler.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            's_menu_id' => 'nullable|string|max:255',
        ]);

        $menuId = null;
        if (!empty($data['s_menu_id']) && preg_match('/^[0-9a-fA-F\-]{36}$/', $data['s_menu_id']) && Menu::where('id', $data['s_menu_id'])->exists()) {
            $menuId = $data['s_menu_id'];
        }

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('ekstrakulikuler', 'public');
        }

        $ex = new S_Extrakulikuler();
        $ex->id = (string) Str::uuid();
        $ex->name = $data['name'];
        $ex->photo = $photoPath;
        $ex->description = $data['description'] ?? null;
        $ex->s_menu_id = $menuId;
        $ex->save();

        return redirect()->route('extrakulikuler.index')->with('success', 'Ekstrakulikuler berhasil dibuat.');
    }

    public function edit($id)
    {
        $ex = S_Extrakulikuler::findOrFail($id);
        $menus = Menu::orderBy('name')->get();
        return view('extrakulikuler.edit', compact('ex', 'menus'));
    }

    public function update(Request $request, $id)
    {
        $ex = S_Extrakulikuler::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            's_menu_id' => 'nullable|string|max:255',
        ]);

        if (!empty($data['s_menu_id']) && preg_match('/^[0-9a-fA-F\-]{36}$/', $data['s_menu_id']) && Menu::where('id', $data['s_menu_id'])->exists()) {
            $ex->s_menu_id = $data['s_menu_id'];
        }

        if ($request->hasFile('photo')) {
            // delete old photo
            if ($ex->photo) {
                Storage::disk('public')->delete($ex->photo);
            }
            $ex->photo = $request->file('photo')->store('ekstrakulikuler', 'public');
        }

        $ex->name = $data['name'];
        $ex->description = $data['description'] ?? null;
        $ex->save();

        return redirect()->route('extrakulikuler.index')->with('success', 'Ekstrakulikuler berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $ex = S_Extrakulikuler::findOrFail($id);
        if ($ex->photo) {
            Storage::disk('public')->delete($ex->photo);
        }
        $ex->delete();

        return redirect()->route('extrakulikuler.index')->with('success', 'Ekstrakulikuler dihapus.');
    }
}
