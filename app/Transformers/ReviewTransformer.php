<?php

namespace App\Transformers;

use App\Models\Review;
use App\Serializers\Serializer;
use League\Fractal\TransformerAbstract;

class ReviewTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Review $review)
    {

        $data = [
            'review' => [
                'body' => $review->review,
                'rating' => $review->rating,
                'likes' => $review->likes->count(),
                'created_at' => $review->created_at->diffForHumans(),
            ],
            'user' => fractal($review->user, new UserTransformer())->serializeWith(Serializer::class)->toArray(),
            'location' => [
                'id' => $review->reviewable_id,
                'name' => $review->reviewable ? $review->reviewable->name : null,
            ]
        ];

        return $data;
    }
}
