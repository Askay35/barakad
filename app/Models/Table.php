<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = ['number', 'is_enabled'];

    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
