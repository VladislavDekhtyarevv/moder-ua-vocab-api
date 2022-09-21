<?php

namespace App\Models;

use App\Filters\WordFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Overtrue\LaravelVote\Traits\Votable;

class Word extends Model
{
    use HasFactory, Searchable, Votable;

    protected $fillable = [
        'name',
        'description',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter(Builder $builder, $request)
    {
        return (new WordFilter($request))->filter($builder);
    }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'description' => $this->description
        ];
    }
}
