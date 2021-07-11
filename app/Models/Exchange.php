<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_user_id',
        'recipient_user_id',
        'proposal_id',
        'value',
        'status'
    ];

    public function source_user() {
        return $this->belongsTo(\App\Models\User::class, 'source_user_id');
    }

    public function recipient_user() {
        return $this->belongsTo(\App\Models\User::class, 'recipient_user_id');
    }

    public function proposal() {
        return $this->belongsTo(\App\Models\Proposal::class);
    }


    public function messages() {
        return $this->hasMany(\App\Models\Message::class);
    }

}
