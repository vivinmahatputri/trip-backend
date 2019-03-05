<?php

namespace App\Transformers;

use App\Models\TripItem;
use App\Serializers\Serializer;
use League\Fractal\TransformerAbstract;

class TripItemTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(TripItem $tripItem)
    {
        return [
            'order_number' => $tripItem->order_number,
            'tourism' => fractal($tripItem->tourism, new TourismTransformer(2))->serializeWith(Serializer::class)->toArray(),
        ];
    }
}
