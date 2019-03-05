<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spiritix\LadaCache\Database\LadaCacheTrait;

class Province extends Model
{

    use LadaCacheTrait;

    protected $fillable = [
        'name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function tourism()
    {
        return $this->hasMany(Tourism::class);
    }

    public function getTourismCountAttribute()
    {
        return $this->tourism()->count();
    }

    public function pictures()
    {
        return $this->hasManyThrough(Picture::class, Tourism::class);
    }

    public function districts()
    {
        return $this->hasManyThrough(District::class, City::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function getNameAttribute($value)
    {
        return ucwords(strtolower($value));
    }

}
