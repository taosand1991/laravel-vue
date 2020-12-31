<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'body',
        'user_id',
        'likes',
    ];

    public function users()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    // public function setLikesAttribute($value)
    // {
    //     $this->attributes['likes'] = json_encode($value);
    // }

    // public function getLikesAttribute($key, $value)
    // {
    //     if (is_null($value) && $this->getCastType($key) == 'array') {
    //         return [];
    //     }

    //     return parent::castAttribute($key, $value);
    // }

    protected function castAttribute($key, $value)
    {
        if ($this->getCastType($key) == 'array' && is_null($value)) {
            return [];
        }

        return parent::castAttribute($key, $value);
    }

    protected $casts = [
        'likes' => 'array',
    ];
}