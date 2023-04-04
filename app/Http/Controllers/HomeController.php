<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// $user = Auth::user();
// $id = Auth::id();

class HomeController extends Controller
{
    public function index()
    {
        $products = DB::table('tbl_products')->get();
        $manager_product = view('pages.home')->with('products', $products);
        return view('layout')->with(['pages.home' => $manager_product, 'page_name' => 'home']);
    }

    public function show_login()
    {
        return view('pages.login');
    }

    public function show_signup()
    {
        return view('pages.signup');
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

    public function add_to_cart($id)
    {
        $product = DB::table('tbl_products')->where('id', $id)->first();
        $cart_items = session('cart_items');
        if(!$cart_items) {
            $cart_items = array();
        }

        if(isset($cart_items[$id])) {
            $cart_items[$id]['quantity']++;
        } else {
            $cart_items[$id] = array(
                'id' => $product->id,
                'name' => $product->product_name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1
            );
        }
        Session::put('cart_items', $cart_items);
        return back();
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

    public function shopping_cart()
    {
        $cart_items = session('cart_items');
        return view('pages.cart', ['cart_items' => $cart_items]);
    }
}
