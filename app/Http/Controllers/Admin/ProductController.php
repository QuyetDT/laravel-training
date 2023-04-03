<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
// use Illuminate\View\View;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;
session_start();

class ProductController extends Controller
{
    public function get_list()
    {
        $products = Product::get();
        return view('admin.products')->with('products', $products);
    }

    public function add()
    {
        return view('admin.add_product');
    }

    public function create(ProductRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Product::create($data);
        Session::put('message', 'Create successfully');
        return Redirect::to('/products');
    }   

    public function edit($product_id)
    {
        $product = DB::table('tbl_products')->where('id', $product_id)->first();
        $view = view('admin.edit_product')->with('product', $product);
        return view('admin_layout')->with('admin.edit_product', $view);
    }  

    public function update(ProductRequest $request, $product_id)
    {
        $data = [];
        $data['product_name'] = $request->name;
        $data['price'] = $request->price;
        $data['description'] = $request->description;
        $data['status'] = $request->status;
        Product::find($product_id)->update($data);
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
