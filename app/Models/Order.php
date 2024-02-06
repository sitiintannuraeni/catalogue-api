<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_quantity',
        'total_price',
        'status',
    ];

    public function prroduct()
    {
        return $this->hasMany(Product::class);
    }

    public function size(){
        return $this->hasMany(Size::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
