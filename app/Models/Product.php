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
        'freshness_locked_at',
        'image_path',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'arrival_date' => 'date',
        'shelf_life_days' => 'integer',
        'freshness_locked_at' => 'datetime',
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

        //Negative if arrival date is in the future
        $daysSinceArrival = $this->arrival_date
            ->startOfDay()
            ->diffInDays(now()->startOfDay(), false);

        //Product hasn't arrived yet
        if ($daysSinceArrival < 0) {
            return 100;
        }

        $remaining = max(
            0,
            $this->shelf_life_days - $daysSinceArrival
        );

        return min(
            100,
            (int) round(
                ($remaining / $this->shelf_life_days) * 100
            )
        );
    }

    public function freshnessLogs()
    {
        return $this->hasMany(ProductFreshnessLog::class);
    }

    public function freshnessChangeRequests()
    {
        return $this->hasMany(ProductFreshnessChangeRequest::class);
    }
}