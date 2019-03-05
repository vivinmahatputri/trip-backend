<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseHelper;
use App\Models\Category;
use App\Models\Province;
use App\Models\Tourism;
use App\Scopes\TourismScope;
use App\Serializers\Serializer;
use App\Transformers\TourismDetailTransformer;
use App\Transformers\TourismTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TourismController extends Controller
{

    private $response;

    /**
     * TourismController constructor.
     * @param ResponseHelper $response
     */
    public function __construct(ResponseHelper $response)
    {
        $this->response = $response;
    }

    /**
     * Todo
     */
    public function all()
    {

    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function top()
    {
        try {
            $tourisms = Tourism::limit(10)->has('pictures')->inRandomOrder()->get();

            $data = fractal($tourisms, new TourismTransformer(3))
                ->serializeWith(Serializer::class)
                ->toArray();

            return $this->response->successResponse($data);
        }
        
        catch (\Exception $exception) {
            return $this->response->failedResponse($exception);
        }
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function newest()
    {
        try {
            $tourisms = Tourism::limit(4)->has('pictures')->inRandomOrder()->get();

            $data = fractal($tourisms, new TourismTransformer(3))
                ->serializeWith(Serializer::class)
                ->toArray();

            return $this->response->successResponse($data);
        }


        catch (\Exception $exception) {
            return $this->response->failedResponse($exception);
        }
    }
    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function latest()
    {
        try {
            $tourisms = Tourism::limit(4)->has('pictures')->inRandomOrder()->get();

            $data = fractal($tourisms, new TourismTransformer(3))
                ->serializeWith(Serializer::class)
                ->toArray();

            return $this->response->successResponse($data);
        }


        catch (\Exception $exception) {
            return $this->response->failedResponse($exception);
        }
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function search()
    {
        try {

            $keywords = filter_var(request('q'), FILTER_SANITIZE_STRING);

            $province = (int)request('province');
            $city = (int)request('city');
            $category = request('categories');
            $tourisms = Tourism::search($keywords);
//            $tourisms = Tourism::where('name', 'like', '%' . $keywords . '%');
//
            if ($province != null || $province != "" || $province != 0) {
                $tourisms->where('province_id', $province);
            }

            if ($city != null || $city != "" || $city != 0) {
                $tourisms->where('city_id', $city);
            }


            if($category != null || $category != "")
            {
//                $tourisms->where('categories', $category);
            }

            $orderBy = 'name';
            $direction = 'asc';

            if(\request('order_by') != null && \request('order_by') != "" ){
                if(\request('order_by') == 'name' || \request('order_by') == 'entry_fee') {
                    $orderBy = \request('order_by');
                }
            }

            if(\request('direction') != null && \request('direction') != "" ){
                $direction = \request('direction');
            }



            $tourisms = $tourisms->orderBy($orderBy, $direction)
                ->paginate(10)
                ->appends([
                    'q' => $keywords,
                    'province' => $province,
                    'city' => $city,
                    'category' => $category,
                ]);

            $data = fractal($tourisms, new TourismTransformer('search'))
                ->toArray();

            return $this->response->successResponse($data);
        }

        catch (\Exception $exception) {
            return $this->response->failedResponse($exception);
        }

    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function advanceSearch()
    {
        try {
            $keywords = filter_var(request('q'), FILTER_SANITIZE_STRING);
            $province = (int)request('province');
            $city = (int)request('city');
            $category = (int)request('category');

            $tourisms = Tourism::where('name', 'like', '%' . $keywords . '%');

            if ($province != null || $province != "") {
                $tourisms->where('province_id', $province);
            }

            if ($city != null || $city != "") {
                $tourisms->where('city_id', $city);
            }

//        if($category != null || $category != "")
//        {
//            $tourisms->where('category_id', $category);
//        }

            $tourisms = $tourisms->paginate(10)->appends([
                'q' => $keywords,
                'province' => $province,
                'city' => $city,
                'category' => $category,
            ]);

            $data = fractal($tourisms, new TourismTransformer(3))
                ->toArray();

            return $this->response->successResponse($data);
        }

        catch (\Exception $exception) {
            return $this->response->failedResponse($exception);
        }
    }



    /**
     * @param Tourism $tourism
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show(Tourism $tourism)
    {
        try {
            $data = fractal($tourism, new TourismTransformer(5))
                ->serializeWith(Serializer::class)
                ->toArray();

            return $this->response->successResponse($data);
        }

        catch (\Exception $exception) {
            return $this->response->failedResponse($exception);
        }
    }

    public function category(Category $category)
    {
        try {
            $tourism = Tourism::whereHas('categories', function ($categories) use ($category){
                $categories->where('id', $category->id);
            })
                ->has('pictures')
                ->has('province')
                ->inRandomOrder()
                ->limit(3)
                ->get();
            $data = fractal($tourism, new TourismTransformer(3))
                ->serializeWith(Serializer::class)
                ->toArray();

            return $this->response->successResponse($data);
        }

        catch (\Exception $exception) {
            return $this->response->failedResponse($exception);
        }
    }

    public function featuredProvince()
    {
        try {
            $provinces = Province::whereIn('id', [11, 13, 15, 16, 24])->get();

            $tourisms = collect();
            foreach ($provinces as $province){
                $tourism = Tourism::where('province_id', $province->id)
                    ->has('pictures')
                    ->inRandomOrder()
                    ->first();

                $tourisms->push($tourism);
            }

            $data = fractal($tourisms, new TourismTransformer(3))
                ->serializeWith(Serializer::class)
                ->toArray();

            return $this->response->successResponse($data);
        }

        catch (\Exception $exception) {
            return $this->response->failedResponse($exception);
        }
    }
}
