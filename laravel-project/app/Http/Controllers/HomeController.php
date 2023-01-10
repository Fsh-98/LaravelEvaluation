<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;

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

        $categories = Category::select('title')->distinct()->get();

        $subcategories = Subcategory::select('title')->distinct()->get();

        return view('home', compact('products', 'categories', 'subcategories'));
    }

    public function filterProduct()
    {
        $products = Product::with(['subcategory' => function($q){
            $q->with(['category: title']);
        }]);

        // for price range filter.

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

        // Search filter by title, category and subcategory.

        if (request()->has('search'))
        {
            $search = request()->get('search');

            $products = $products->where('title','LIKE','%'.$search.'%')
                            ->OrWhereHas('subcategory', function ($query) use ($search) {
                                return $query->where('title','LIKE','%'.$search.'%');
                            })
                            ->OrWhereHas('subcategory', function ($query) use ($search) {
                                $query->whereHas('category', function($query) use ($search){
                                    return $query->where('title','LIKE','%'.$search.'%');
                                });
                            });
        }

        // Filter via category

        if (request()->has('category'))
        {
            $category = request()->get('category');

            $products = $products->whereHas('subcategory', function ($query) use ($category){
                            $query->whereHas('category', function($query) use ($category){
                                return $query->where('title', $category);
                            });     
                        });
        }

        // Filter via subcategory

        if (request()->has('subcategory'))
        {
            $subcategory = request()->get('subcategory');

            $products = $products->whereHas('subcategory', function ($query) use ($subcategory){
                            return $query->where('title', $subcategory);    
                        });
        }

        return $products;
    }
}
