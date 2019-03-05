<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spiritix\LadaCache\Database\LadaCacheTrait;

class Review extends Model
{
    use SoftDeletes;
    use LadaCacheTrait;

    protected $fillable = [
        'user_id',
        'reviewable_id',
        'reviewable_type',
        'review',
        'rating'
    ];

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
    public function reviewable()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function point()
    {
        return $this->morphOne(Point::class, 'pointable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function submission()
    {
        return $this->morphOne(Submission::class, 'submissionable');
    }
}
