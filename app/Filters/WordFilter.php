<?php

// WordFilter.php

namespace App\Filters;

use App\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class WordFilter extends AbstractFilter
{
    protected $filters = [
        'text' => TextFilter::class,
        'sort' => OrderFilter::class,
    ];
}
