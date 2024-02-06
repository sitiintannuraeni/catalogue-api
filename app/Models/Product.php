<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'product_name',
        'material',
        'features',
        'overview',
        'desc',
        'price',
        'total_sold',
        'images',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(Product_image::class);
    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

    public function size()
    {
        return $this->belongsToMany(Size::class, 'stocks', 'product_id')->withPivot('stock');
        
    }
}
