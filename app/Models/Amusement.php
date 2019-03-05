<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Amusement extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'tourism_id',
        'name',
        'description',
        'entry_fee'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tourism()
    {
        return $this->belongsTo(Tourism::class);
    }


}
