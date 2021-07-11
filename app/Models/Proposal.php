<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'title',
        'description',
        'type',
        'places',
        'hours',
    ];

    public function user() {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function exchanges() {
        return $this->hasMany(\App\Models\Exchange::class);
    }

    public function categories() {
        return $this->belongsToMany(\App\Models\Category::class);
    }
}
