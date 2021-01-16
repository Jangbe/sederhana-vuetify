<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function gHelper($return){
        $data = collect(Storage::disk('google')->listContents());
        $path = $data->where('name', $this->gambar)->first();
        if($path){
           $path = $path['path'];
           $result = [
               'link' => "https://drive.google.com/uc?id=$path",
               'path' => env('GOOGLE_DRIVE_FOLDER_ID').'/'.$path
           ];
        }else{
            $result = [
                'link' => '/img/barang/default.jpg',
                'path' => ''
            ];
        }
        return $result[$return];
    }

    public function toArray($request)
    {
        $kategori = Product::join('categories', 'categories.slug', 'products.category')->where('categories.slug', $this->category)->first();
        $nama = explode('-', $kategori->detail_nama);
        $stok = explode('-', $this->detail_stok);
        for($i = 0; $i < count($nama); $i++){
            $detail[$nama[$i]] = $stok[$i];
        }

        return [
            'id' => $this->id_product,
            'nama' => $this->nama_barang,
            'singkatan' => $this->singkatan,
            'stok' => $this->getStok($this->id_product, 'stok'),
            'stok_kata' => $this->getStok($this->id_product, 'stok_kata'),
            'rincian' => $this->getStok($this->id_product, 'rincian'),
            'harga' => $this->harga_barang,
            'gambar' => $this->gambar,
            'kategori' => $kategori->nama_kategori,
            'slug' => $kategori->slug,
            'detail' => $this->detail_stok,
            'link' => $this->gHelper('link'),
            'path' => $this->gHelper('path')
        ];
    }

    public function getStok($id, $return)
    {
        $product = Product::where('id_product', $id)->first();
        $kategori = Category::where('slug', $product->category)->first();
        $kategori = explode('-', $kategori->detail_nama);
        $data['stok'] = [];
        $stok = $product->stok;
        $detail = explode('-', $product->detail_stok);
        $kali = [];
        $sisa = [];
        $stok_akhir = [];
        $data['stok_kata'] = '';
        for($a = 0; $a < count($detail); $a++){
            $kali[$a] = 1;
            for($i = count($detail); $i > $a; $i--){
                $kali[$a] *= $detail[$i-1];
            }
            $sisa[$a] = $stok % $kali[$a];
            $stok_akhir[$a] = floor(($stok - $sisa[$a]) / $kali[$a]);
            $stok = $sisa[$a];
            $data['stok'][$kategori[$a]] = floor($product->stok / $kali[$a]);
            $data['rincian'][$kategori[$a]] = $kali[$a];
            $data['stok_kata'] .= $stok_akhir[$a].' '.$kategori[$a].' ';
        }
        return $data[$return];
    }
}
