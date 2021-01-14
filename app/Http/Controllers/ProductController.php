<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index($category = null)
    {
        if($category){
            $product = Product::where('category', $category)->get();
        }else{
            $product = Product::get();
        }
        return ProductResource::collection($product);
    }

    public function show(Product $id)
    {
        return ProductResource::make($id);
    }

    public function search($category, $id)
    {
        $result = $category != 'all'? Product::where('category', $category)
                         ->where('nama_barang', 'like', "%$id%")
                         ->orWhere('singkatan', 'like', "%$id%")
                         ->get() : Product::where('nama_barang', 'like', "%$id%")
                         ->orWhere('singkatan', 'like', "%$id%")
                         ->get();
        return ProductResource::collection($result);
    }

    public function store(Request $request)
    {
        request()->validate([
            'nama' => 'required|string',
            'singkatan' => 'required|max:11',
            'gambar' => 'required|mimes:png,jpg,jpeg',
            'harga' => 'required|numeric|min:0',
            'kategori' => 'required'
        ]);
        $id = Product::id_uniq('PD', 'products', 'id_product');
        $file = $request->file('gambar');
        $detail = request('detail');
        $detail = str_replace(',', '-', $detail);
        $eks = $file->getClientOriginalExtension();
        // $content = $file->getContent();
        $fileName = date('dmy-').uniqid().'.'.$eks;;
        // Storage::disk('google')->put($fileName, $content);
        $file->move(public_path('img/barang'), $fileName);
        Product::create([
            'id_product' => $id,
            'nama_barang' => $request->nama,
            'singkatan' => $request->singkatan,
            'gambar' => $fileName,
            'category' => $request->kategori,
            'harga_barang' => $request->harga,
            'stok' => 0,
            'detail_stok' => $detail
        ]);
        return response()->json([
            'message' => 'Barang berhasil di tambahkan',
            'type' => 'success'
        ]);
    }
}
