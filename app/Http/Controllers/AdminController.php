<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class AdminController extends Controller
{
    public function login()
    {
        return view('admin_login');
    }

    public function index()
    {
        return view('admin.dashboard');
    }

    public function dashboard(Request $request)
    {
        $email = $request['email'];
        $password = md5($request['password']);
        $result = DB::table('tbl_admin')->where('email', $email)->where('password', $password)->first();
        if ($result) {
            Session::put('admin_name', $result->name);
            Session::put('id', $result->id);
            return Redirect::to('/dashboard');
        } else {
            Session::put('message', 'Invalid login credentials');
            return Redirect::to('/login');
        }
    }

    public function logout()
    {
        Session::put('admin_name', null);
        Session::put('id', null);
        return Redirect::to('/login');
    }
}
