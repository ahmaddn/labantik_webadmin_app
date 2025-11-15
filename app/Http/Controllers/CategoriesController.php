<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\S_Categories;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    //
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $cat = new S_Categories();
        $cat->id = (string) Str::uuid();
        $cat->name = $data['name'];
        // set the creating user if available
        $cat->user_id = Auth::id() ?? null;
        $cat->save();

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $category = S_Categories::find($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($data);

        return redirect()->route('news.index')->with('success', 'Kategori berhasil diubah.');
    }
    public function destroy($id)
    {
        $category = S_Categories::find($id);

        $category->delete();

        return redirect()->route('news.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
