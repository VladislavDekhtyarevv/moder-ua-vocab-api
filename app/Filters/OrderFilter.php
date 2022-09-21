<?php

// OrderFilter.php

namespace App\Filters;

class OrderFilter
{
    public function filter($builder, $value)
    {
        if($value == 1) {
            return $builder->orderBy('name', 'ASC');
        }elseif ($value == 2) {
            return $builder->orderBy('name', 'DESC');
        }elseif ($value == 3) {
            return $builder->orderBy('id', 'DESC');
        }elseif ($value == 4) {
            return $builder->orderBy('id', 'ASC');
        }else {
            return $builder->orderBy('upvoters_count', 'DESC');
        }
    }
}
