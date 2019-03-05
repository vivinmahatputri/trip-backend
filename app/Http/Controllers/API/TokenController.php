<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\GetAccessTokenRequest;
use App\Models\Traveller;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class TokenController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getToken(Request $request)
    {
        $credential['password'] = $request->password;

        filter_var($request->email, FILTER_VALIDATE_EMAIL)
            ? $credential['email'] = $request->email
            : $credential['username'] = $request->email;

        return auth()->attempt($credential)
            ? $this->sendAuthSuccessfulResponse($request->user())
            : $this->sendAuthFailedResponse();
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    private function sendAuthSuccessfulResponse(User $user)
    {
        $data = [
            'access_token' => $user->createToken($user->id)->accessToken,
        ];

        return response($data, 200);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    private function sendAuthFailedResponse()
    {
        return response(['message' => 'Invalid credentials.'], 401);
    }

    /**
     * Redirect the user to the social provider authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    /**
     * Obtain the user information from social provider.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $userSocial = Socialite::driver($provider)->stateless()->user();

        $name = $userSocial->getName();
        $username = $userSocial->getNickname();
        $id = $userSocial->getId();
        $email = $userSocial->getEmail();
        $avatar = $userSocial->getAvatar();

        try {
            $exist = User::where([
                'socialable_id' => $id,
                'socialable_type' => $provider
            ])->first();

            if ($exist) {
                $data = [
                    'access_token' => $exist->createToken($exist->id)->accessToken,
                ];
                return response($data, 200);
            } else {
                DB::beginTransaction();
                $traveller = new Traveller();
                $traveller->name = $name;
                $traveller->save();

                $user = new User();
                $user->email = $email;
                $user->username = $username;
                $user->userable_id = $traveller->id;
                $user->userable_type = 'App\Models\Traveller';
                $user->socialable_id = $id;
                $user->socialable_type = $provider;
                $user->socialable_avatar = $avatar;
                $user->save();

                $data = [
                    'access_token' => $user->createToken($user->id)->accessToken,
                ];
                DB::commit();

                return response($data, 200);
            }
        }

        catch (\Exception $exception){
            DB::rollBack();
        }
    }

    public function socialLoginMobile(Request $request, $provider)
    {
        $name = $request->name;
        $username = $request->username;
        $id = $request->id;
        $email = $request->email;
        $avatar = $request->avatar;

        try {
            $exist = User::where([
                'socialable_id' => $id,
                'socialable_type' => $provider
            ])->first();

            if ($exist) {
                $data = [
                    'access_token' => $exist->createToken($exist->id)->accessToken,
                ];
                return response($data, 200);
            } else {
                DB::beginTransaction();
                $traveller = new Traveller();
                $traveller->name = $name;
                $traveller->save();

                $user = new User();
                $user->email = $email;
                $user->username = $username;
                $user->userable_id = $traveller->id;
                $user->userable_type = 'App\Models\Traveller';
                $user->socialable_id = $id;
                $user->socialable_type = $provider;
                $user->socialable_avatar = $avatar;
                $user->save();

                $data = [
                    'access_token' => $user->createToken($user->id)->accessToken,
                ];
                DB::commit();

                return response($data, 200);
            }
        }

        catch (\Exception $exception){
            DB::rollBack();
        }
    }

}
