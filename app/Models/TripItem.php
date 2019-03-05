<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripItem extends Model
{
    protected $fillable = [
        'trip_id',
        'tourism_id',
        'order_number',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tourism()
    {
        return $this->belongsTo(Tourism::class);
    }
}
