<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spiritix\LadaCache\Database\LadaCacheTrait;

class City extends Model
{
    use LadaCacheTrait;

    protected $fillable = [
        'province_id',
        'name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function getNameAttribute($value)
    {
        return ucwords(strtolower($value));
    }
}
