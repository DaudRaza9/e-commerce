<?php

namespace App\Models\Admin;

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
        'image',
        'lead_time',
        'tax_id',
        'is_promo',
        'is_featured',
        'is_discounted',
        'is_tranding',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function brand(){
        return $this->belongsTo(Brand::class);
    }
    public function tax(){
        return $this->belongsTo(Tax::class);
    }
}
