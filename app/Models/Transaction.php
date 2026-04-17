<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'type', 'amount', 'category', 'date', 'description', 'badge', 'user_id'
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2'
    ];
}