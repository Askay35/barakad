<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['table_id', 'phone', 'cost', 'comment', 'status_id', 'payment_type_id'];

    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'status_id');
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type_id');
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderProducts::class, 'order_id');
    }

    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            OrderProducts::class,
            'order_id',
            'id',
            'id',
            'product_id'
        );
    }
}
