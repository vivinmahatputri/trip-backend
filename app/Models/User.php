<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Spiritix\LadaCache\Database\LadaCacheTrait;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    use LadaCacheTrait;

    use SoftDeletes, EntrustUserTrait{
        SoftDeletes::restore insteadof EntrustUserTrait;
        EntrustUserTrait::restore insteadof SoftDeletes;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'socialable_id', 'socialable_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'fcm_token'
    ];

    /**
     *  The attributes that should be casted to native types.
     *
     *  @var array
     */
    protected $casts = [
        'settings' => 'array'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function userable()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(){
        return $this->belongsToMany(Role::class, 'role_user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function points()
    {
        return $this->morphMany(Point::class, 'pointable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function ratings()
    {
        return $this->morphMany(Rating::class, 'ratingable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * @return int
     */
    public function totalPoint()
    {
        return $this->points()->count();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function pictures()
    {
        return $this->morphMany(Picture::class, 'pictureable');
    }


    public function picture()
    {
        return $this->morphOne(Picture::class, 'pictureable')->latest();
    }

    /**
     * @return string
     */
    public function getUserPicture()
    {
        return $this->picture ? $this->picture->getPictureUrl() : asset('images/main/default-user.png');
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }


}
