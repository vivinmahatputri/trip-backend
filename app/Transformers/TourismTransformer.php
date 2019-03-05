<?php

namespace App\Transformers;

use App\Models\Tourism;
use App\Serializers\Serializer;
use League\Fractal\TransformerAbstract;
use function PHPSTORM_META\type;

class TourismTransformer extends TransformerAbstract
{
    private $level;
    private $data;
    public function __construct($level = 1)
    {
        $this->level = $level;
        $this->data = collect();
    }

    public function transform(Tourism $tourism)
    {
        switch ($this->level){
            case 'search':
                $this->search($tourism);
                break;
            case 0:
                $this->picture($tourism, false);
                break;
            case 1:
                $this->basic($tourism);
                break;

            case 2:
                $this->basic($tourism);
                $this->picture($tourism, false);
                break;

            case 2.5:
                $this->basic($tourism);
                $this->location($tourism);
                $this->picture($tourism, false);
                break;

            case 2.6:
                $this->basic($tourism);
                $this->location($tourism);
                break;

            case 3:
                $this->detail($tourism);
                $this->location($tourism);
                $this->picture($tourism);
                break;

            case 4:
                $this->detail($tourism);
                $this->location($tourism);
                $this->picture($tourism);
                $this->engagement($tourism);
                break;

            case 5:
                $type = request('type');
                if($type != ''){
                    switch ($type){
                        case 'overview':
                            $this->detail($tourism);
                            $this->location($tourism);
                            break;
                        case 'review':
                            $this->engagement($tourism);
                            break;
                        case 'photo':
                            $this->picture($tourism, true);
                            break;
                        case 'facility':
                            $this->detail($tourism);
                            break;
                        case 'event':
                            $this->nearby($tourism);
                            break;
                        case 'hotels':
                            $this->nearby($tourism);
                            break;
                        case 'restaurant':
                            $this->nearby($tourism);
                            break;
                        case 'tour_guide':
                            $this->nearby($tourism);
                            break;
                        case 'weather':
                            $this->weather($tourism);
                            break;
                    }
                }
                else {
                    $this->detail($tourism);
                    $this->location($tourism);
                    $this->picture($tourism);
                    $this->engagement($tourism);
                    $this->nearby($tourism);
                    $this->weather($tourism);
                }
                break;
        }

        return $this->data->toArray();
    }

    public function basic($tourism)
    {
        $this->data->put('id', $tourism->id);
        $this->data->put('name', $tourism->name);
        $this->data->put('web_url', route('web.show', [str_slug($tourism->province ? $tourism->province->name: 'undefined'), $tourism->slug]));
        $this->data->put('web_province_url', route('web.province', str_slug($tourism->province->name)));
        $this->data->put('wishlist', [
            'is_in_wishlist' => $tourism->isInWishlist(),
            'action' => [
                'name' => $tourism->isInWishlist() == true ? 'remove' : 'add',
                'url' => $tourism->isInWishlist() == true ? route('wishlist.remove', $tourism) : route('wishlist.add', $tourism),
            ]
        ]);
        $this->data->put('entry_fee', '-');
        $this->data->put('open_hour', $tourism->open_hour ?: '-');
    }

    public function detail($tourism)
    {
        $this->data->put('id', $tourism->id);
        $this->data->put('name', $tourism->name);
        $this->data->put('web_url', route('web.show', [str_slug($tourism->province ? $tourism->province->name: 'undefined'), $tourism->slug]));
        $this->data->put('web_province_url', route('web.province', str_slug($tourism->province->name)));
        $this->data->put('is_in_wishlist', $tourism->isInWishlist());
        $this->data->put('description', $tourism->description);
        $this->data->put('entry_fee', '-');
        $this->data->put('open_hour', $tourism->open_hour);
        $this->data->put('cost_estimation_per_day', $tourism->cost_estimation_per_day);
        $this->data->put('description', $tourism->description);
        $facilities = fractal($tourism->facilities, new FacilityTransformer())->serializeWith(Serializer::class)->toArray();

        $facilities = collect($facilities);

        $groups =  ($facilities->pluck('group')->unique()->values());

        $facilityGroup = collect();
        foreach ($groups as $group){
            $z = collect();
            $z->put('group', $group);

            $z->put('facilities', $facilities->where('group', $group)->pluck('name'));
            $facilityGroup->push($z);
        }

        $this->data->put('facilities', []);
        $this->data->put('facilities_group', $facilityGroup);
        $this->data->put('categories', $tourism->categories->pluck('name'));

    }

    public function location($tourism)
    {
        $city = $tourism->city ? $tourism->city->name : null;
        $province = $tourism->province ? $tourism->province->name : null;
        $display = $city != null ? $city . ', ' . $province : $province;
        $this->data->put('location', [
            'province' => $tourism->province ? $tourism->province->name : null,
            'city' => $tourism->city ? $tourism->city->name : null,
            'address' => $tourism->address,
            'display_location' => $tourism->name .', '. $display
        ]);
        $this->data->put('coordinates', [
            'longitude' => $tourism->longitude,
            'latitude' => $tourism->latitude,
        ]);

    }

    public function picture($tourism, $detail = true)
    {
        $this->data->put('pictures', fractal($tourism->topPictures(), new PictureTransformer($detail))->serializeWith(Serializer::class)->toArray());
    }

    public function engagement($tourism)
    {
        $total = number_format($tourism->reviews->count(),1);
        if($tourism->reviews->count() != 0) {
            $rating_details = [
                '5' => number_format($tourism->reviews->where('rating', 5)->count() / $total * 100, 1),
                '4' => number_format($tourism->reviews->where('rating', 4)->count() / $total * 100, 1),
                '3' => number_format($tourism->reviews->where('rating', 3)->count() / $total * 100, 1),
                '2' => number_format($tourism->reviews->where('rating', 2)->count() / $total * 100, 1),
                '1' => number_format($tourism->reviews->where('rating', 1)->count() / $total * 100, 1),
            ];
        }else{
            $rating_details = [
                '5' => 0,
                '4' => 0,
                '3' => 0,
                '2' => 0,
                '1' => 0,
            ];
        }

        $this->data->put('rating', $tourism->rating());
        $this->data->put('rating_detail', $rating_details);
        $this->data->put('total_review', $tourism->reviews->count());
        $this->data->put('is_verified', (boolean)$tourism->is_verified);
        $this->data->put('reviews', fractal($tourism->reviews, new ReviewTransformer())->serializeWith(Serializer::class)->toArray());

    }

    public function nearby($tourism)
    {
        $this->data->put('tour_guides', null);
        $this->data->put('hotels', $tourism->hotels());
        $this->data->put('restaurants', null);
        $this->data->put('events', fractal($tourism->events, new EventTransformer())->serializeWith(Serializer::class)->toArray());

    }

    public function weather($tourism)
    {
        $this->data->put('weather', $tourism->weather());
    }

    public function search($tourism)
    {
        $this->data->put('id', $tourism->id);
        $this->data->put('name', $tourism->name);

        $city = $tourism->city ? $tourism->city->name : null;
        $province = $tourism->province ? $tourism->province->name : null;
        $display = $city != null ? $city . ', ' . $province : $province;
        $this->data->put('location', [
            'province' => $tourism->province ? $tourism->province->name : null,
            'city' => $tourism->city ? $tourism->city->name : null,
            'address' => $tourism->address,
            'display_location' => $tourism->name .', '. $display
        ]);
        $this->data->put('rating', $tourism->rating());
        $this->data->put('total_review', $tourism->reviews->count());
        $this->data->put('entry_fee', $tourism->entry_fee != 0 ? 'Rp '.number_format($tourism->entry_fee) : 'Free Entry');
        $this->data->put('open_hour', $tourism->open_hour ?: '-');
        $this->data->put('categories', $tourism->categories->pluck('name'));
    }


}
