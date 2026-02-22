<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Auto-generate slug from name
    public static function boot()
    {
        parent::boot();
        static::creating(function ($category) {
            $category->slug = \Str::slug($category->name);
        });
    }
}
