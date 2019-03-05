<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spiritix\LadaCache\Database\LadaCacheTrait;

class Facility extends Model
{
    use LadaCacheTrait;
    protected $fillable = [
        'name',
        'facility_group_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tourisms()
    {
        return $this->belongsToMany(Tourism::class);
    }

    public function facilityGroup()
    {
        return $this->belongsTo(FacilityGroup::class);
    }
}
