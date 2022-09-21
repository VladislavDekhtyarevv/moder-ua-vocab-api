<?php

// OrderFilter.php

namespace App\Filters;

class OrderFilter
{
    public function filter($builder, $value)
    {
//        return $builder->where('type', $value);
        if($value == 1) {
            return $builder->orderBy('name', 'ASC');
        }elseif ($value == 2) {
            return $builder->orderBy('name', 'DESC');
        }elseif ($value == 3) {
            return $builder->orderBy('id', 'ASC');
        }elseif ($value == 4) {
            return $builder->orderBy('id', 'DESC');
        }else {
            return $builder->orderBy('id', 'DESC');
        }
    }
}
