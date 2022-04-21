<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;
    protected $fillable =[
      'products_id',
      'sku',
      'attr_image',
      'mrp',
      'price',
      'quantity',
      'size_id',
      'color_id',

    ];

    public function size(){
        return $this->belongsTo(Size::class);
    }

    public function color(){
        return $this->belongsTo(Color::class);
    }
}
