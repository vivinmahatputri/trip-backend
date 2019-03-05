<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseHelper;
use App\Models\City;
use App\Models\Province;
use App\Serializers\Serializer;
use App\Transformers\CityTransformer;
use App\Transformers\ProvinceTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegionController extends Controller
{
    private $response;

    /**
     * RegionController constructor.
     * @param ResponseHelper $response
     */
    public function __construct(ResponseHelper $response)
    {
        $this->response = $response;
    }

    /**
     * Get all city from database
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getAllCity()
    {
        try {
            $cities = City::all();

            $data = fractal($cities, new CityTransformer())
                ->serializeWith(Serializer::class)
                ->toArray();

            return $this->response->successResponse($data);
        }

        catch (\Exception $exception) {
            return $this->response->failedResponse($exception);
        }
    }

    /**
     * Get city from database based on selected province
     * @param Province $province
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getCity(Province $province)
    {
        try {
            $cities = $province->cities;

            $data = fractal($cities, new CityTransformer())
                ->serializeWith(Serializer::class)
                ->toArray();

            return $this->response->successResponse($data);
        }

        catch (\Exception $exception) {
            return $this->response->failedResponse($exception);
        }
    }

    /**
     * Get all province from database
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getProvince()
    {
        try {
            $provinces = Province::all();

            $data = fractal($provinces, new ProvinceTransformer())
                ->serializeWith(Serializer::class)
                ->toArray();

            return $this->response->successResponse($data);
        }

        catch (\Exception $exception) {
            return $this->response->failedResponse($exception);
        }
    }
}
