<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spiritix\LadaCache\Database\LadaCacheTrait;

class Picture extends Model
{
    use SoftDeletes;
    use LadaCacheTrait;

    protected $fillable = [
        'pictureable_id',
        'pictureable_type',
        'file_name',
        'tourism_name',
        'source',
        'path'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function pictureable()
    {
        return $this->morphTo('pictureable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function submission()
    {
        return $this->morphOne(Submission::class, 'submissionable');
    }

    public function tourism()
    {

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function point()
    {
        return $this->morphOne(Point::class, 'pointable');
    }

    /**
     * @return string
     */
    public function getPictureUrl()
    {
       return env('DO_SPACES_URL').'/'.$this->path;
    }

}
