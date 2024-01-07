<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login() {
        return view('pages.authLogin.Login');
    }

    public function authenticating(AuthRequest $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        Session::flash('status', 'failed');
        Session::flash('message', "Login was Wrong");
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('/');
        }
        Session::flash('status', 'failed');
        Session::flash('message', 'Login was wrong');
        return back()->with('status', 'failed')->with('message', 'Login Failed');
    }

    public function register() {
        return view('pages.user.Register', ['titles' => 'Register']);
    }

    public function registerAdmin(){
        return view('pages.admin.RegisterAdmin', ['titles' => 'Register']);
    }

    public function creatingacc(RegisterRequest $request) {
        $account = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'role_id' => $request->role,
        ]);

        if($account) {
            Session::flash('statusCreated', 'created');
            Session::flash('messageCreated', "Account berhasil dibuat");
        }

        return redirect('/login');
    }

    public function creatingaccAdmin(RegisterRequest $request) {
        $account = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'role_id' => $request->role,
        ]);

        if($account) {
            Session::flash('statusCreated', 'created');
            Session::flash('messageCreated', "Account berhasil dibuat");
        }

        return redirect('/view-all-account');
    }

    public function logout(Request $request) {
        Auth::logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/login');
    }
}
