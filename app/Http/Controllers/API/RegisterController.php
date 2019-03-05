<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseHelper;
use App\Http\Requests\RegisterRequest;
use App\Models\Traveller;
use App\Http\Controllers\Controller;
use App\Serializers\Serializer;
use App\Transformers\UserDetailsTransformer;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    private $response;

    /**
     * RegisterController constructor.
     * @param ResponseHelper $response
     */
    public function __construct(ResponseHelper $response)
    {
        $this->response = $response;
    }

    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();
            $traveller = Traveller::create([
                'name' => $request->name
            ]);

            $user = $traveller->user()->create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $data = fractal($user, new UserTransformer())
                ->serializeWith(Serializer::class)
                ->toArray();

            $data = collect($data);
            $token = $user->createToken($user->id)->accessToken;


            $data->put('access_token', $token);

            $data = $data->toArray();


            DB::commit();
            return $this->response->successResponse($data, "Hooraaay~ Registrasi sukses!", 201);

        }

        catch (\Exception $exception) {
            DB::rollBack();
            return $this->response->failedResponse($exception);
        }
    }
}
