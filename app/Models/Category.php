<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public $table = 'categories';
    protected $fillable = ['name'];
    public $timestamps = true;
    protected $appends = [
        'total_product'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getTotalProductAttribute()
    {
        return $this->products()->count();
    }
}
