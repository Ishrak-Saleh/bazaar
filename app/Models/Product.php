<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'arrival_date',
        'shelf_life_days',
        'image_path',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'arrival_date' => 'date',
        'shelf_life_days' => 'integer',
        'is_active' => 'boolean',
    ];

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFreshnessScoreAttribute(): int
    {
        if (!$this->arrival_date || !$this->shelf_life_days) {
            return 0;
        }

        $daysSinceArrival = $this->arrival_date->diffInDays(now());
        $remaining = max(
            0,
            $this->shelf_life_days - $daysSinceArrival
        );

        return (int) round(
            ($remaining / $this->shelf_life_days) * 100
        );
    }
}
