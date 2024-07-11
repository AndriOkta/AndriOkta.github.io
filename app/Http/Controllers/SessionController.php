<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SessionController extends Controller
{
    function index(){
        return view("sesi/index");
    }
    
     // Proses login
     public function login(Request $request)
     {
         // Simpan email di session untuk diisi ulang jika login gagal
         Session::flash('email', $request->email);
 
         // Validasi input
         $request->validate([
             'email' => 'required|email',
             'password' => 'required|min:6'
         ], [
             'email.required' => 'Email Wajib Diisi',
             'email.email' => 'Masukkan format email yang valid',
             'password.required' => 'Password Wajib Diisi',
             'password.min' => 'Password minimal harus 6 karakter'
         ]);
 
         // Informasi login
         $infologin = [
             'email' => $request->email,
             'password' => $request->password
         ];
 
         // Coba autentikasi
         if (Auth::attempt($infologin)) {
             // Redirect ke dashboard dengan pesan sukses
             return redirect('dashboard')->with(['success' => 'Berhasil Login']);
         } else {
             // Redirect kembali ke halaman sesi dengan pesan kesalahan
             return redirect('sesi')->withErrors(['error' => 'Email dan Password Salah']);
         }
     }
 
     // Proses logout
     public function logout()
     {
         Auth::logout();
         return redirect('sesi')->with('success', 'Berhasil Logout');
     }
    
    function register()
    {
        return view('sesi/register');
    }

    function create(Request $request)
    {
        Session::flash('name', $request->name);
        Session::flash('email', $request->email);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ], [
            'name.required' => 'Nama Wajib Diisi',
            'email.required' => 'Email Wajib Diisi',
            'email.email' => 'Silahkab masukkan Email yang Valid',
            'email.uniqe' => 'Email sudah pernah digunakan',
            'password.required' => 'Password Wajib Diisi',
            'password.min' => 'Minimum password yang diizinkan 6 karakter'
        ]);

        $data =[
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];
        User::create($data);

        $infologin = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::attempt($infologin)){
            return redirect('dashboard')->with('success', Auth::user()->name . 'Berhasil Login');
        }else {
            return redirect('sesi')->withErrors('Email dan Password Salah');
        }
    }
}
