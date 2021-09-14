<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use Hash;

class AuthController extends Controller
{
    public function showFormLogin()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        };
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|string',
            'password' => 'required|string'
        ];
        $messages = [
            'email.required' => 'Email wajib diisi',
            'email.string' => 'Email harus berupa string',
            'password.required' => 'Password wajib diisi',
            'password.string' => 'Password harus berupa string',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        };
        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];
        Auth::attempt($data);
        if (Auth::check()) {
            return redirect()->route('home');
        } else {
            Session::flash('error', 'Email atau Password salah');
            return redirect()->route('login');
        }
    }

    public function showFormRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|number',
            'address' => 'required|string',
            'password' => 'required|confirmed',
        ];

        $messages = [
            'name.required' => 'Nama wajib diisi',
            'name.string' => 'Nama harus berupa string',
            'email.required' => 'Email wajib diisi',
            'email.string' => 'Email harus berupa string',
            'phone.required' => 'Nomor WhatsApp wajib diisi',
            'phone.number' => 'Nomor WhatsApp harus berupa angka',
            'address.required' => 'Alamat wajib diisi',
            'address.string' => 'Alamat harus berupa string',
            'password.required' => 'Password wajib diisi',
            'password.confirmed' => 'Password tidak sama dengan konfirmasi password',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $user = new User;
        $user->name = ($request->name);
        $user->email = ($request->email);
        $user->phone = ($request->phone);
        $user->address = ($request->address);
        $user->password = Hash::make($request->password);
        $check = $user->save();

        if ($check) {
            Session::flash('success', 'Register berhasil! Silahkan login untuk masuk ke sistem');
            return redirect()->route('login');
        } else {
            Session::flash('errors', ['' => 'Register gagal! Silahkan ulangi beberapa saat lagi']);
            return redirect()->route('register');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
