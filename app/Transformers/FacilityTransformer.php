<?php

namespace App\Transformers;

use App\Models\Facility;
use League\Fractal\TransformerAbstract;

class FacilityTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Facility $facility)
    {
        $data = [
            'name' => $facility->name,
            'group' => $facility->facilityGroup->name,
        ];

        return $data;
    }
}
