<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $products = Product::with(['subcategory' => function($q){
            $q->with(['category: title'])->latest()->get();
        }]);

        $products = $products->latest()->paginate();

        return view('home', compact('products'));
    }
}
