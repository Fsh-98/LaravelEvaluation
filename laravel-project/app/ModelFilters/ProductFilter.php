<?php 

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class ProductFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    
    public function search($search)
    {
        return $this->whereLike('title', $search)
                    ->OrWhereHas('subcategory', function ($query) use ($search) {
                        return $query->whereLike('title', $search);
                    })
                    ->OrWhereHas('subcategory', function ($query) use ($search) {
                        $query->whereHas('category', function($q) use ($search){
                            return $query->whereLike('title', $search);
                        });
                    });
    }
}
