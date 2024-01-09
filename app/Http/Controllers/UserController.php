<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function viewLogin(){
        return view('login');
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('/');
        }
 
        return back()->with('alert', ['message' => 'Login Gagal', 'status' => 'danger']);
    }

    public function viewRegister(){
        return view('register');
    }

    public function register(Request $request){
        $validated = $request->validate([
            'username' => ['required', 'unique:users'],
            'email' => ['required', 'email:dns', 'unique:users'],
            'password' => ['required', 'min:8'],
            'confirm_password' => ['same:password']
        ]);
        
        $validated['password'] = bcrypt($validated['password']);
        User::create($validated);

        $request->session()->flash('alert', ['message' => 'regristrasi Berhasil, Silahkan Login', 'status' => 'success']);
        return redirect('login');
    }

    public function logout(Request $request){
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect('/');
    }
}
