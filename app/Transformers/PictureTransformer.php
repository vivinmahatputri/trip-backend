<?php

namespace App\Transformers;

use App\Models\Picture;
use App\Serializers\Serializer;
use League\Fractal\TransformerAbstract;

class PictureTransformer extends TransformerAbstract
{
    private $detail;

    public function __construct($detail = false)
    {
        $this->detail = $detail;
    }

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Picture $picture)
    {
        if($this->detail == true) {
            $data = [
                'url' => $picture->getPictureUrl(),
                'likes' => $picture->submission ? $picture->submission->totalLikes() : 0,
                'user' => isset($picture->submission)
                    ? fractal($picture->submission->user, new UserTransformer())->serializeWith(Serializer::class)->toArray()
                    : null,
            ];
        }

        else{
            $data = [
                'url' => $picture->getPictureUrl(),
            ];
        }
        return $data;
    }
}
