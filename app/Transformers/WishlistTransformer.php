<?php

namespace App\Transformers;

use App\Models\Wishlist;
use App\Serializers\Serializer;
use League\Fractal\TransformerAbstract;

class WishlistTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Wishlist $wishlist)
    {
        return [
            'id' => $wishlist->id,
            'tourism' => fractal($wishlist->wishlistable, new TourismTransformer(2))->serializeWith(Serializer::class)->toArray(),
        ];
    }
}
