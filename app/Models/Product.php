<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable =[
        'name',
        'slug',
        'category_id',
        'brand',
        'model',
        'short_desc',
        'desc',
        'keywords',
        'technical_specification',
        'uses',
        'warranty',
        'status',
        'image'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
