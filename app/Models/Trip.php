<?php

namespace App\Models;

use App\Transformers\TripItemTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Serializer\Serializer;
use Spiritix\LadaCache\Database\LadaCacheTrait;

class Trip extends Model
{
    use SoftDeletes;

    use LadaCacheTrait;

    use Searchable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'budged_estimation',
        'time_estimation',
        'user_id',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model)
        {
            $model->attributes['slug'] = str_slug($model->name). '-' .substr(uniqid(), -5);
        });
    }

    public function toSearchableArray()
    {
        fractal($this->tripItems, new TripItemTransformer())->toArray();

        $array = $this->toArray();

        return $array;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tripItems()
    {
        return $this->hasMany(TripItem::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
