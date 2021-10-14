<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Image;
use Storage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'date_of_birth',
        'password',
        'type',
        'approved',
        'has_completed_profile',
        'phone',
        'description',
        'photo',
        'credits',
        'notes'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'approved' => 'boolean',
        'has_completed_profile' => 'boolean',
    ];

    public function setPhotoAttribute($value) {
        $logo = Image::make($value)
            ->fit(250, 250)
            ->encode("png", 80);
        $logo_name = Str::random(12) . ".png";
        Storage::disk("public")->put($logo_name, $logo);
        $this->attributes['photo'] = Storage::disk("public")->url($logo_name);
    }

    public function categories() {
        return $this->belongsToMany(\App\Models\Category::class);
    }

    public function pledges() {
        return $this->hasMany(\App\Models\Exchange::class, 'source_user_id');
    }

    public function requests() {
        return $this->hasMany(\App\Models\Request::class);
    }
}
