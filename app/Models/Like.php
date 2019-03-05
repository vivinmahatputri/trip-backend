<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Like extends Model
{
    protected $fillable = [
        'user_id',
        'likeable_id',
        'likeable_type'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model)
        {
            $model->attributes['user_id'] = Auth::id();
        });
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function likeable()
    {
        return $this->morphTo();
    }
}
