<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFreshnessChangeRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'vendor_id',
        'current_arrival_date',
        'requested_arrival_date',
        'current_shelf_life_days',
        'requested_shelf_life_days',
        'reason',
        'status',
        'reviewed_by',
        'reviewed_at',
        'admin_note',
    ];

    protected $casts = [
        'current_arrival_date' => 'date',
        'requested_arrival_date' => 'date',
        'current_shelf_life_days' => 'integer',
        'requested_shelf_life_days' => 'integer',
        'reviewed_at' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}