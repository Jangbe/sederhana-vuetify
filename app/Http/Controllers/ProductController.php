<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        $result = Product::when($category != 'all', function ($query){
                $category = explode('/', request()->getRequestUri())[4];
                return $query->where('category', $category)->where(function ($query) {
                    $id = explode('/', request()->getRequestUri())[5];
                    $query->where('nama_barang', 'like', "%$id%")->orWhere('singkatan', 'like', "%$id%");
                });
            }, function($query) {
                $id = explode('/', request()->getRequestUri())[5];
                return $query->where('nama_barang', 'like', "%$id%")->orWhere('singkatan', 'like', "%$id%");
            })->get();
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
        $content = $file->getContent();
        $fileName = date('dmy-').uniqid().'.'.$eks;;
        Storage::disk('google')->put($fileName, $content);
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

    public function edit(Request $request){
        $request->validate([
            'nama' => 'required|string',
            'singkatan' => 'required|max:11',
            'harga' => 'required|numeric|min:0',
            'kategori' => 'required'
        ]);
        $gambar = $request->file('gambar');
        $oldName = Product::where('id_product', $request->id)->firstOrFail();
        $oldName = $oldName->gambar;
        if($gambar){
            $eks = $gambar->getClientOriginalExtension();
            $fileName = date('dmy-').uniqid().'.'.$eks;
            $pictures = ['default.jpg', 'default1.jpg', 'default2.jpg', 'default3.jpg', 'default5.jpg'];
            if(!in_array($oldName, $pictures)) unlink(public_path("img/barang/$oldName"));
            $gambar->move(public_path('img/barang'), $fileName);
            // $content = $gambar->getContent();
            // Storage::disk('google')->put($fileName, $content);
            // Storage::disk('google')->delete(Ghelper::getPathId($oldName));
        }else{
            $fileName = $oldName;
        }
        Product::where('id_product', $request->id)->update([
            'nama_barang' => $request->nama,
            'singkatan' => $request->singkatan,
            'gambar' => $fileName,
            'category' => $request->kategori,
            'harga_barang' => $request->harga,
            'detail_stok' => str_replace(',', '-', $request->detail)
        ]);
        return response()->json([
            'message' => 'Barang berhasil di edit',
            'type' => 'success'
        ]);
    }
    
    public function destroy(Request $request)
    {
        Product::where('id_product', $request->id)->delete();
        return response()->json([
            'type' => 'success',
            'message' => 'Barang berhasil dihapus'
        ]);
    }

    public function add_stok(Request $request)
    {
        $jumlah = Product::convertStok($request);
        if($jumlah['hasil'] < 1){
            return response()->json([
                'type' => 'error',
                'message' => 'Stok barang gagal ditambahkan'
            ]);
        }
        Product::where('id_product', $request->id)->update([
            'stok' => ($jumlah['stok'] + $jumlah['hasil'])
        ]);
        return response()->json([
            'type' => 'success',
            'message' => 'Stok barang telah ditambahkan'
        ]);
    }
}
