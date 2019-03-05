<?php

namespace App\Transformers;

use App\Models\Province;
use League\Fractal\TransformerAbstract;

class ProvinceTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Province $province)
    {
        return [
            'id' => $province->id,
            'name' => $province->name,
        ];
    }
}
