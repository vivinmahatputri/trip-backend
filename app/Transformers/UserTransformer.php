<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        $userdata = [
            'id' => $user->id,
            'username' => $user->username,
            'name' => $user->userable->name,
            'picture' => $user->getUserPicture()
        ];

        return $userdata;
    }
}
