<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseHelper;
use App\Models\Tourism;
use App\Models\Wishlist;
use App\Serializers\Serializer;
use App\Transformers\WishlistTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
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
     * @return array|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function browse()
    {
        try {
            $user = Auth::user();
            $wishlists = $user->wishlists;

            $data = fractal($wishlists, new WishlistTransformer())
                ->serializeWith(Serializer::class)
                ->toArray();

            return $this->response->successResponse($data);
        }

        catch (\Exception $exception) {
            return $this->response->failedResponse($exception);
        }
    }

    /**
     * @param Tourism $Destinasi
     * @return array|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function add(Tourism $tourism)
    {
        try {
            $user = Auth::id();

            if($tourism->wishlists->where('user_id', $user)->count() > 0){
                return [
                    'code' => 409,
                    'message' => 'Destinasi ini udah ada wishlist kamu..'
                ];
            }

            $wishlist = $tourism->wishlists()->create([
                'user_id' => $user
            ]);

            $data = $wishlist;

            return $this->response->successResponse($data, 'Destinasi telah ditambahkan ke wishlist ~', 201);
        }

        catch (\Exception $exception) {
            return $this->response->failedResponse($exception);
        }
    }

    public function remove(Tourism $tourism)
    {
        try {
            $user = Auth::id();
            $wishlist = $tourism->wishlists->where('user_id', $user)->first();

            if($wishlist) {
                $data = Wishlist::find($wishlist->id)->delete();

                return $this->response->successResponse($data, 'Destinasi telah dihapus wishlist telah dihapus');
            }

            return [
                'code' => 409,
                'message' => 'Destinasi ini ga ada di wishlist kamu..'
            ];
        }

        catch (\Exception $exception) {
            return $this->response->failedResponse($exception);
        }
    }
}
