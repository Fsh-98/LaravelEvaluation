<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
