<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'recipient_id',
        'sender_id',
        'exchange_id',
        'proposal_id'
    ];

    public function sender() {
        return $this->hasOne(\App\Models\User::class, 'id', 'sender_id');
    }

    public function recipient() {
        return $this->hasOne(\App\Models\User::class, 'id', 'recipient_id');
    }
}
