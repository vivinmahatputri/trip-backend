<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Traveller extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'facebook_username',
        'instagram_username',
        'twitter_username',
        'about_me',
        'address',
        'interest',
        'birth_of_date',
        'longitude',
        'latitude',
        'is_guide'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}
