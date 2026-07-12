<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id', // Tambahan pos kantong kas (Cash / Bank)
        'title', 
        'type', 
        'amount', 
        'category', 
        'date', 
        'description', 
        'badge', 
        'user_id'
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2'
    ];

    /**
     * Relasi ke master data Wallet (Kantong Kas)
     */
    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    /**
     * Relasi bawaan ke master data Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category');
    }
}