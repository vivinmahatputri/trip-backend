<?php

namespace App\Models;

use Apixu\Api\Api;
use Apixu\Apixu;
use Apixu\ApixuInterface;
use App\Scopes\TourismScope;
use App\Services\WeatherService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Laravel\Scout\Searchable;
use Rjvandoesburg\Apixu\Filters;
use Spiritix\LadaCache\Database\LadaCacheTrait;

class Tourism extends Model
{
    use SoftDeletes;

    use LadaCacheTrait;

    use Searchable;

    protected $fillable = [
        'province_id',
        'city_id',
        'district_id',
        'village_id',
        'name',
        'description',
        'address',
        'open_hour',
        'longitude',
        'latitude',
        'is_active',
        'is_verified',
        'slug',
        'is_scrapped'
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new TourismScope());
        static::creating(function ($model)
        {
            $model->attributes['slug'] = str_slug($model->name);
        });
    }

    public function shouldBeSearchable()
    {
        return $this->is_active;
    }

    public function toSearchableArray()
    {
        $this->categories;

        $array = $this->toArray();

        $array['province_name'] = $this->province->name;
        $array['categories'] = $this->categories;
        $array['city_name'] = $this->city ? $this->city->name : '';

        return $array;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function facilities()
    {
        return $this->belongsToMany(Facility::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function village()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function reviews()
    {
        return $this->morphMany(Review::class,'reviewable')->latest();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function pictures()
    {
        return $this->morphMany(Picture::class,'pictureable')->latest();
    }

    public function picture()
    {
        return $this->morphOne(Picture::class,'pictureable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function ratings()
    {
        return $this->morphMany(Rating::class, 'ratingable')->latest();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function submission()
    {
        return $this->morphOne(Submission::class, 'submissionable')->latest();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable')->latest();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function point()
    {
        return $this->morphOne(Point::class, 'pointable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany(Event::class)->latest();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function wishlists()
    {
        return $this->morphMany(Wishlist::class, 'wishlistable');
    }

    /**
     * @return int
     */
    public function totalLikes()
    {
        return $this->likes()->count();
    }

    /**
     * @return float|int|null
     */
    public function rating()
    {
        $review = $this->reviews();
        $totalRow = $review->count();
        $totalRating = $review->sum('rating');

        if($totalRow == 0){
            return null;
        }

        return number_format($totalRating / $totalRow, 1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function topReviews()
    {
        return $this->reviews()->limit(3)->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function topPictures()
    {
        return $this->pictures()->limit(3)->get();
    }

    /**
     * @return bool
     */
    public function isInWishlist(){
        $check = $this->wishlists()->whereIn('user_id', [Auth::id()])->count();
        if($check > 0) {
            return true;
        }

        return false;
    }

    public function hotels()
    {
        $longitude = $this->longitude;
        $latitude = $this->latitude;

        $hotels = Hotel::selectRaw("
                id,
                name,
                rating,
                address,
                longitude,
                latitude,
                ( 6371 * acos( cos( radians('" . $latitude . "') ) 
                       * cos( radians(latitude) ) 
                       * cos( radians(longitude) 
                       - radians('" . $longitude . "') ) 
                       + sin( radians('" . $latitude . "') ) 
                       * sin( radians(latitude) ) ) ) AS distances
            ");

        $hotels = $hotels->havingRaw('distances < 10');

        $hotels = $hotels->get();

        return $hotels;
    }

    public function weather()
    {

        $filters = new Filters([
            'q' => $this->latitude.",".$this->longitude,
        ]);

        $response = \Apixu::current($filters);

        return $response;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function accessibilities()
    {
        return $this->belongsToMany(Accessibility::class);
    }

    public function getFirstPictureAttribute()
    {
        if($this->picture()->count() > 0){
            return $this->picture->getPictureUrl();
        }
        return asset('images/default-image.png');

    }
}
