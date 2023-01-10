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
        $products = $this->filterProduct();

        $products = $products->latest()->paginate();

        return view('home', compact('products'));
    }

    public function filterProduct()
    {
        $products = Product::with(['subcategory' => function($q){
            $q->with(['category: title'])->latest()->get();
        }]);

        if(NULL !== request()->get('min_value') && NULL !== request()->get('max_value'))
        {
            if (request()->get('min_value') > request()->get('max_value')) 
            {
                return redirect()->route('home')->with('alert', 'Min value cant be bigger than max value!!');
            }
            else
            {
                $min = request()->get('min_value');
                $max = request()->get('max_value');
                $products = $products->whereBetween('price', [$min, $max]);
            }
        }

        return $products;
    }
}
