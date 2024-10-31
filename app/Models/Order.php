<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'customer_id',
        'product_id',
        'customer_name',
        'customer_phone',
        'quantity',
        'status',
        'date',
        'revenue'
    ];

    public $timestamps = true;

    protected $casts = [
        'revenue' => 'decimal:2',
        'date' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
} 