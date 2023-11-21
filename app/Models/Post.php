<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [

        'body',
        'user_id',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(user::class);
    }

    public function comments()
    {

        return $this->hasMany(comment::class);
    }

    public function likes()
    {

        return $this->hasMany(like::class);
    }
}
