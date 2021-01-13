<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::get());
    }

    public function show($id)
    {
        $category = Category::where('id', $id)->orWhere('slug', $id)->first();
        $detail = explode('-', $category->detail_nama);
        return response()->json([
            'id' => $category->id,
            'nama' => $category->nama_kategori,
            'jumlah' => count($detail),
            'detail' => $detail
        ]);
    }

    public function edit()
    {
        request()->validate([
            'nama' => 'required|string',
            'jumlah' => 'required|min:1|max:6|numeric',
            'detail' => 'required|array'
        ]);
        Category::find(request('id'))->update([
            'nama_kategori' => request('nama'),
            'detail_nama' => implode('-', request('detail'))
        ]);
        return response()->json([
            'type' => 'success',
            'message' => 'Kategori berhasil diedit'
        ]);
    }

    public function destroy()
    {
        $id = request('id');
        Category::find($id)->delete();
        return response()->json([
            'type' => 'success',
            'message' => 'Kategori berhasil dihapus'
        ]);
    }
}
