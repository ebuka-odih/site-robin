<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'previous_amount',
        'new_amount',
        'delta',
        'reason',
        'metadata',
    ];

    protected $casts = [
        'previous_amount' => 'float',
        'new_amount' => 'float',
        'delta' => 'float',
        'metadata' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
