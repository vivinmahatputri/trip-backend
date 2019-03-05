<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spiritix\LadaCache\Database\LadaCacheTrait;

class Event extends Model
{
//    use LadaCacheTrait;
    
    protected $fillable = [
        'tourism_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'eo_name',
        'eo_phone',
        'eo_mail'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tourism()
    {
        return $this->belongsTo(Tourism::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function pictures()
    {
        return $this->morphMany(Picture::class, 'pictureable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function submission()
    {
        return $this->morphOne(Submission::class, 'submissionable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function point()
    {
        return $this->morphOne(Point::class, 'pointable');
    }
}
