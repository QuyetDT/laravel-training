<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class ProductController extends Controller
{
    public function get_list()
    {
        $products = DB::table('tbl_products')->get();
        // var_dump($products); die;
        $manager_product = view('admin.products')->with('products', $products);
        return view('admin_layout')->with('admin.products', $manager_product);
    }

    public function add()
    {
        return view('admin.add_product');
    }

    public function create(Request $request)
    {
        $data = [];
        $data['product_name'] = $request->name;
        $data['price'] = $request->price;
        $data['description'] = $request->description;
        $data['status'] = $request->status;
        DB::table('tbl_products')->insert($data);
        Session::put('message', 'Create successfully');
        return Redirect::to('/products');
    }   
}
