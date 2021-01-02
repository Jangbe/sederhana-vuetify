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
}
