<?php

namespace App\Transformers;

use App\Http\Requests\GetAccessTokenRequest;
use App\Models\Tourism;
use App\Models\Trip;
use App\Serializers\Serializer;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Location\Coordinate;
use Location\Distance\Vincenty;

class TripTransformer extends TransformerAbstract
{
    private $generate;

    public function __construct($generate = false)
    {
        $this->generate = $generate;
    }
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Trip $trip)
    {
        return [
            'id' => $trip->id,
            'name' => $trip->name,
            'slug' => $trip->slug,
            'description' => $trip->description,
            'budged_estimation' => 'Rp. '.number_format($trip->budged_estimation),
            'time_estimation' => $trip->time_estimation,
            'user' => fractal($trip->user, new UserTransformer())->serializeWith(Serializer::class)->toArray(),
            'trip_items' => $this->generate ? $this->generate($trip->tripItems) : fractal($trip->tripItems, new TripItemTransformer())->serializeWith(Serializer::class)->toArray(),
        ];
    }

    public function generate($items){
        $calculator = new Vincenty();

        $lat = \request('lat');
        $lng = \request('lon');
        $base = new Coordinate($lat, $lng);

        $order = collect();
        foreach ($items as $tripItem){
            $item = collect();
            $targetLat = $tripItem->tourism->latitude;
            $targetLng = $tripItem->tourism->longitude;
            $target = new Coordinate($targetLat, $targetLng);

            $distance = $calculator->getDistance($base, $target);
            $weather = $tripItem->tourism->weather();
            $code = $weather->current->condition->code;

            $bobot = $this->bobotDistance($distance) + $this->bobotWeather($code) + $this->bobotJamBuka($tripItem->tourism->open_hour);
            
            $item->put('tourism', $tripItem->tourism->id);
            $item->put('xxx', $tripItem->tourism);
            $item->put('distance', $distance);
            $item->put('item_id', $tripItem->id);
            $item->put('old_order', $tripItem->order_number);
            $item->put('bobot', $bobot);
            $item->put('bobot_var', [
                'distance' => $this->bobotDistance($distance),
                'weather' => $this->bobotWeather($code),
                'open_hour' => $this->bobotJamBuka($tripItem->tourism->open_hour),
            ]);
            $order->push($item);

        }

        $order = $order->sortByDesc('bobot');

        $i = 1;

        $data = collect();
        foreach ($order as $x){
            $t = ($x['xxx']);
            $d = ($x['distance']);
            $b = ($x['bobot']);
            $v = ($x['bobot_var']);
            $tourism = collect();
            $tourism->put('tourism', fractal($t, new TourismTransformer(2))->serializeWith(Serializer::class)->toArray());
            $tourism->put('order_number', $i);
            $tourism->put('distance', $d);
            $tourism->put('bobot', $b);
            $tourism->put('bobot_var', $v);
            $data->push($tourism);

            $i++;
        }


        return $data->toArray();
    }

    public function bobotDistance($distance)
    {
        if($distance < 1000){
            return 10;
        }

        else if($distance > 1000 && $distance < 3000){
            return 9;
        }

        else if($distance > 3000 && $distance < 5000){
            return 8;
        }

        else if($distance > 5000 && $distance < 7000){
            return 7;
        }

        else if($distance > 7000 && $distance < 9000){
            return 6;
        }

        else if($distance > 9000 && $distance < 11000){
            return 5;
        }

        else if($distance > 11000 && $distance < 13000){
            return 4;
        }

        else if($distance > 13000 && $distance < 15000){
            return 3;
        }

        else if($distance > 15000 && $distance < 17000){
            return 2;
        }

        else if($distance > 17000 && $distance < 19000){
            return 1;
        }

        else {
            return 0;
        }
    }

    public function bobotWeather($code)
    {
        if($code == 1000){
            return 10;
        }

        else if($code == 1003){
            return 9;
        }

        else if($code == 1006){
            return 8;
        }

        else if($code ==1009){
            return 7;
        }

        else if($code == 1030 || $code == 1150 || $code == 1180) {
            return 6;
        }


        else if($code == 1063 || $code == 1153 || $code == 1183 || $code == 1240){
            return 5;
        }

        else if($code == 1135 || $code == 1186 || $code == 1246){
            return 4;
        }

        else if($code == 1189 || $code == 1243){
            return 3;
        }

        else if($code == 1102 || $code == 1249 || $code == 1273){
            return 2;
        }

        else {
            return 1;
        }

    }

    public function bobotJamBuka($openHour){
//        dd($openHour);
        if($openHour == null){
            return 0;
        }

        else if($openHour != null && $openHour == '24 Jam' || $openHour == '24Jam' || $openHour == '24 Hour' || $openHour == '24Hour'){
            return 0;
        }

        else if($openHour != null){
            $now = Carbon::now();
            $currentHour = $now->format('G:i');

            $time = $openHour;
            if(strpos($time, '-')) {
                $oh = explode('-', $time);
                $jamBuka = Carbon::parse($oh[0]);
                $jamTutup = Carbon::parse($oh[1]);

                $parsedJamBuka = $jamBuka->format('G:i');
                $parsedJamTutup = $jamTutup->format('G:i');


                if ($now->diffInHours($parsedJamTutup) <= 2) {
                    return 10;
                } else if ($now->diffInHours($parsedJamTutup) > 2 && $now->diffInHours($parsedJamTutup) < 4) {
                    return 8;
                } else if ($now->diffInHours($parsedJamTutup) > 4 && $now->diffInHours($parsedJamTutup) < 6) {
                    return 6;
                } else if ($now->diffInHours($parsedJamTutup) > 6 && $now->diffInHours($parsedJamTutup) < 8) {
                    return 4;
                } else if ($now->diffInHours($parsedJamTutup) > 8 && $now->diffInHours($parsedJamTutup) < 10) {
                    return 2;
                } else {
                    return 1;
                }
            }

            return 0;

        }else {
            return 0;
        }
    }
}
