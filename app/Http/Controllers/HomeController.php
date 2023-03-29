<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// $user = Auth::user();
// $id = Auth::id();

class HomeController extends Controller
{
    public function index()
    {

        return view('pages.home');
    }

    public function show_login()
    {
        return view('login');
    }

    public function show_signup()
    {
        return view('signup');
    }

    public function signup(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        $data = $request->all();
        $check = $this->create($data);
        return redirect('dashboard');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            Auth::user();
            if (Auth::user()->role == 1) {
                return redirect()->intended('/dashboard')->with('message', 'Signed in!');
            }
            return redirect()->intended('/')->with('message', 'Signed in!');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
            'message' => 'Login detail is not valid!'
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => '1'
        ]);
    }
}
