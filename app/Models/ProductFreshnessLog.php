<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFreshnessLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'user_id',
        'old_arrival_date',
        'new_arrival_date',
        'old_shelf_life_days',
        'new_shelf_life_days',
        'changed_at',
    ];
    protected $casts = [
        'old_arrival_date' => 'date',
        'new_arrival_date' => 'date',
        'old_shelf_life_days' => 'integer',
        'new_shelf_life_days' => 'integer',
        'changed_at' => 'datetime',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}