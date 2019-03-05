<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseHelper;
use App\Http\Requests\UpdateFCMTokenRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Serializers\Serializer;
use App\Services\SubmissionService;
use App\Transformers\UserDetailsTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    private $response;

    /**
     * UserController constructor.
     * @param ResponseHelper $response
     */
    public function __construct(ResponseHelper $response)
    {
        $this->response = $response;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function me(Request $request)
    {
        try {
            $data = fractal($request->user(), new UserDetailsTransformer())->serializeWith(Serializer::class)->toArray();

            return $this->response->successResponse($data);
        }

        catch (\Exception $exception) {
            return $this->response->failedResponse($exception);
        }
    }

    /**
     * @param UpdateFCMTokenRequest $request
     * @return array|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function updateFCMToken(UpdateFCMTokenRequest $request)
    {
        try {
            $request->user()->update([
                'fcm_token' => $request->fcm_token,
            ]);

            return fractal()
                ->item($request->user())
                ->transformWith(new UserDetailsTransformer())
                ->toArray();
        }

        catch (\Exception $exception) {
            return $this->response->failedResponse($exception);
        }
    }

    /**
     * @param UpdateUserRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function updateInfo(Request $request)
    {
        try {
            $data = $request->user()->userable->update($request->all());
            return $this->response->successResponse($data, 'Data profile berhasil diupdate ~');
        }

        catch (\Exception $exception) {
            return $this->response->failedResponse($exception);
        }
    }

    /**
     * @param UpdateUserRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function updatePicture(Request $request)
    {
        try {
            $picture = $request->picture;
            $data = (new SubmissionService())->picture($picture, $request->user(), false);
            return $this->response->successResponse($data, 'Foto profile berhasil diupdate ~');

        }

        catch (\Exception $exception) {
            return $this->response->failedResponse($exception);
        }
    }

}
