<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PendingPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_intent'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
