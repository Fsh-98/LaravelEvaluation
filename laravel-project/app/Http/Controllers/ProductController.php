<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function addProduct(Request $request)
    {
        $data = $request->all();

        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'subcategory' => 'required',
            'price' => 'required',
            'thumbnail' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $thumbnail = $request->file('thumbnail')->store('image', 'public');

        $product = Product::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'subcategory_id' => $data['subcategory'],
            'price' => $data['price'],
            'thumbnail' => $thumbnail,  
        ]);

        return redirect('home');

    }

    public function deleteProduct()
    {
        
    }

}
