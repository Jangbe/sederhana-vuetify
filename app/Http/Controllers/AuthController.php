<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function init()
    {
        $routes = [
            [//For admin
                'Dashboard' => [
                    'mdi-monitor-dashboard',
                    ['icon' => 'mdi-view-dashboard', 'text' => 'Dashboard', 'route' => '/admin/pesanan'],
                    ['icon' => 'mdi-note', 'text' => 'Buat Struk', 'route' => '/admin/struct'],
                ],
                'Product' => [
                    'mdi-briefcase-edit',
                    ['icon' => 'mdi-shape', 'text' => 'Kategori', 'route' => '/admin/category'],
                    ['icon' => 'mdi-plus', 'text' => 'Tambah Barang', 'route' => '/admin/add-product'],
                    ['icon' => 'mdi-square-edit-outline', 'text' => 'Edit Barang', 'route' => '/admin/edit-product'],
                    ['icon' => 'mdi-plus-circle', 'text' => 'Tambah Stok', 'route' => '/admin/add-stok'],
                ]
            ],
            [//For user login/not logged in
                ['icon' => 'mdi-home', 'text' => 'Home', 'route' => '/'],
                ['icon' => 'mdi-cog', 'text' => 'About', 'route' => '/about'],
                ['icon' => 'mdi-cart-plus', 'text' => 'Belanja', 'route' => '/belanja'],
                ['icon' => 'mdi-cart-check', 'text' => 'Checkout', 'route' => '/keranjang']
            ]
        ];
        if(Auth::user()){
            if(Auth::user()->role == 1){
               $route = $routes[0];
               $isAdmin = true;
            }else{
                $route = $routes[1];
                $isAdmin = false;
            }
            return response()->json([
                'isLogin' => true,
                'isAdmin' => $isAdmin,
                'user' => Auth::user(),
                'links' => $route
            ]);
        }else{
            return response()->json([
                'isLogin' => false,
                'isAdmin' => false,
                'user' => [ 'name'=>'Unknow'],
                'links' => $routes[1]
            ]);
        }
    }

    public function register()
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'telepon' => 'required|numeric|min:11',
            'pass' => 'required',
            'confirm' => 'required|same:pass'
        ]);
        User::create([
            'name' => request('name'),
            'email' => request('email'),
            'telepon' => request('telepon'),
            'role' => 2,
            'password' => Hash::make(request('pass'))
        ]);
        return response()->json([
            'message' => 'Akun telah berhasil didaftarkan'
        ]);
    }

    public function login()
    {
        request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $remember = request('remember') != null ? true : false;
        if (Auth::attempt(request()->only('email', 'password'), $remember )) {
            if(auth()->user()->role == 1){
                return response()->json(['message' => 'Selamat datang admin!', 'type' => 'success', 'role' => Auth::user()->role]);
            }else{
                return response()->json(['message' => 'Selamat datang! Silahkan berbelanja', 'type' => 'success', 'role' => Auth::user()->role]);
            }
        }else{
            return response()->json(['message' => 'Maaf! email atau kata sandi salah!', 'type' => 'error']);
        }
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'Berhasil logout!'
        ]);
    }
}
