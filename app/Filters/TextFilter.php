<?php

// OrderFilter.php

namespace App\Filters;

class TextFilter
{
    public function filter($builder, $value)
    {
        if($value) {
            return $builder->where('name', 'Like', '%' .$value .'%')->orWhere('description',  'Like', '%' .$value .'%');
        }else {
            return $builder;
        }
    }
}
