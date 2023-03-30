<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;
session_start();

class ProductController extends Controller
{
    public function get_list()
    {
        $products = DB::table('tbl_products')->get();
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

    public function edit($product_id)
    {
        $product = DB::table('tbl_products')->where('id', $product_id)->first();
        $view = view('admin.edit_product')->with('product', $product);
        return view('admin_layout')->with('admin.edit_product', $view);
    }  

    public function update(Request $request, $product_id)
    {
        $data = [];
        $data['product_name'] = $request->name;
        $data['price'] = $request->price;
        $data['description'] = $request->description;
        $data['status'] = $request->status;
        DB::table('tbl_products')->where('id', $product_id)->update($data);
        Session::put('message', 'Update successfully');
        return Redirect::to('/products');
    }
    
    public function delete($product_id)
    {
        $product = DB::table('tbl_products')->where('id', $product_id)->delete();
        Session::put('message', 'Delete successfully');
        return Redirect::to('/products');
    } 
}
