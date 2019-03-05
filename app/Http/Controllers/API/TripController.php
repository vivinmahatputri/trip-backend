<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseHelper;
use App\Http\Requests\TripRequest;
use App\Models\Trip;
use App\Serializers\Serializer;
use App\Transformers\TripTransformer;
use DemeterChain\C;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class TripController extends Controller
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

    public function fetch(){
        try {
            $trips = Trip::with('tripItems')->latest()->paginate(5);

            $data = fractal($trips, new TripTransformer(false))
                ->toArray();

            return $this->response->successResponse($data);
        }

        catch (\Exception $exception) {
            return $this->response->failedResponse($exception);
        }
    }

    public function show(Trip $trip){
        try {
            $data = fractal($trip, new TripTransformer(false))
                ->serializeWith(Serializer::class)
                ->toArray();

            return $this->response->successResponse($data);
        }

        catch (\Exception $exception) {
            return $this->response->failedResponse($exception);
        }
    }

    public function mine(){
        try {
            $trips = Trip::where('user_id', Auth::id())->with('tripItems')->latest()->paginate(5);

            $data = fractal($trips, new TripTransformer(false))
                ->toArray();

            return $this->response->successResponse($data);
        }

        catch (\Exception $exception) {
            return $this->response->failedResponse($exception);
        }
    }

    public function generate(Trip $trip){

        $data = fractal($trip, new TripTransformer(true))
            ->serializeWith(Serializer::class)
            ->toArray();
        try {


            return $this->response->successResponse($data);
        }

        catch (\Exception $exception) {
            return $this->response->failedResponse($exception);
        }
    }

    public function store(TripRequest $request){
        DB::beginTransaction();
        try {

            $trip = new Trip();
            $trip->name = $request->name;
            $trip->description = $request->description;
            $trip->budged_estimation = $request->budged_estimation;
            $trip->time_estimation = $request->time_estimation;
            $trip->user_id = Auth::id();
            $trip->save();

            foreach ($request->destinations as $key => $item) {
                $trip->tripItems()->create([
                    'tourism_id' => $item,
                    'order_number' => $key
                ]);
            }

            DB::commit();

            $data = fractal($trip, new TripTransformer(false))
                ->toArray();

            return $this->response->successResponse($data, 'Trip successfully created!');
        }

        catch (\Exception $exception) {
            DB::rollBack();
            return $this->response->failedResponse($exception);
        }
    }

    public function update(TripRequest $request, Trip $trip){}

    public function destroy(Trip $trip){}

    public function addItem(Trip $trip){}

    public function removeItem(Trip $trip){}

    public function generateFromWishList(){}

    public function search(){
        try {
            $keywords = filter_var(request('q'), FILTER_SANITIZE_STRING);

            $trips = Trip::search($keywords);

            $orderBy = 'name';
            $direction = 'asc';

            if(\request('order_by') != null && \request('order_by') != "" ){
                if(\request('order_by') == 'name' || \request('order_by') == 'time_estimation'|| \request('order_by') == 'budged_estimation')  {
                    $orderBy = \request('order_by');
                }
            }

            if(\request('direction') != null && \request('direction') != "" ){
                $direction = \request('direction');
            }



            $trips = $trips->orderBy($orderBy, $direction)
                ->paginate(10)
                ->appends([
                    'q' => $keywords,
                ]);

            $data = fractal($trips, new TripTransformer(false))
                ->toArray();

            return $this->response->successResponse($data);
        }

        catch (\Exception $exception) {
            return $this->response->failedResponse($exception);
        }
    }

}
