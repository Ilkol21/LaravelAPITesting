<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'category_id', 'image', 'popularity'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function purchaseHistories()
    {
        return $this->hasMany(PurchaseHistory::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
