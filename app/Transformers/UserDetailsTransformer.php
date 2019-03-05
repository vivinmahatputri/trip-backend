<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserDetailsTransformer extends TransformerAbstract
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
            'email' => $user->email,
            'username' => $user->username,
            'name' => $user->userable->name,
            'about_me' => $user->userable->about_me,
            'address' => $user->userable->address,
            'interest' => $user->userable->interest,
            'birth_of_date' => $user->userable->birth_of_date,
            'picture' => $user->getUserPicture(),
            'picture_detail' => $user->picture,
            'social_media' => [
                'facebook_username' => $user->userable->facebook_username,
                'instagram_username' => $user->userable->instagram_username,
                'twitter_username' => $user->userable->twitter_username,
            ],
            'coordinates' => [
                'longitude' => $user->userable->longitude,
                'latitude' => $user->userable->latitude,
            ],
            'is_guide' => $user->userable->is_guide,
            'fcm_token' => $user->fcm_token,
            'total_point' => $user->totalPoint(),
            'total_post' => $user->submissions->count()
        ];

        return $userdata;
    }
}
