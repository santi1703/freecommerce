<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'title', 'price', 'description', 'images', 'category_id', 'created_at', 'updated_at'];


    public function displayPrice(): Attribute
    {
        return Attribute::make(
            get: fn($value, array $attributes) => '$' . $attributes['price'],
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function purchases(): BelongsToMany
    {
        return $this->belongsToMany(Purchase::class);
    }
}
