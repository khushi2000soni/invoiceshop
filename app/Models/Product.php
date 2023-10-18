<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Product extends Model
{
    use HasFactory,HasApiTokens,Notifiable;
    public $table = 'products';

    protected $fillable = [
        'name',
        'category_id',
        'created_by',
        'updated_at',
        'deleted_at',
        'is_active',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function(Product $model) {
            $model->created_by = auth()->user()->id;
        });
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
