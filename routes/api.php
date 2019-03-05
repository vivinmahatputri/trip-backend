<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Route::domain('api.wesata.gg')->group(function () {
    Route::group(['namespace' => 'API'], function () {
        Route::get('/', function () {
            return response()->json([
                'message' => 'Hi mtf!',
                'code' => 200
            ], 200);
        });

        Route::post('token', 'TokenController@getToken')->name('auth.token');
        Route::post('login', 'UserController@login');
        Route::post('register', 'RegisterController@store')->name('auth.register');

        //tourism public
        Route::get('tourism/top', 'TourismController@top')->name('tourism.top');
        Route::get('tourism/newest', 'TourismController@newest')->name('tourism.newest');
        Route::get('tourism/latest', 'TourismController@latest')->name('tourism.latest');
        Route::get('tourism/search', 'TourismController@search')->name('tourism.search');
        Route::get('tourism/search-advance', 'TourismController@advanceSearch')->name('tourism.search.advance');
        Route::get('tourism/{tourism}/show', 'TourismController@show')->name('tourism.show.api');
        Route::get('tourism/category/{category}', 'TourismController@category')->name('tourism.category');
        Route::get('tourism/featured-province', 'TourismController@featuredProvince')->name('tourism.province');


        //tourism review
//    Route::get('tourism/{tourism}/review', 'ReviewController@show');
        Route::get('tourism/{tourism}/review/submit', 'TourismController@show');

        //timeline

        //region
        Route::get('province', 'RegionController@getProvince')->name('region.all.province');
        Route::get('city', 'RegionController@getAllCity')->name('region.all.city');
        Route::get('province/{province}/city', 'RegionController@getCity')->name('region.city.by.province');

        Route::get('trip', 'TripController@fetch')->name('trip.fetch');
        Route::get('trip/search', 'TripController@search')->name('trip.search');
        Route::get('trip/{trip}/show', 'TripController@show')->name('trip.show');
        Route::get('trip/{trip}/generate', 'TripController@generate')->name('trip.generate');


    });

    Route::group(['namespace' => 'API', 'middleware' => 'auth:api'], function () {
        //user
        Route::get('me', 'UserController@me')->name('auth.me');
        Route::put('update-fcm-token', 'UserController@updateFCMToken');
        Route::post('me/update/info', 'UserController@updateInfo')->name('auth.update.info');
        Route::post('me/update/picture', 'UserController@updatePicture')->name('auth.update.picture');

        //submission
        Route::get('review/mine', 'SubmissionController@review')->name('submission.review');

        //timeline

        //wishlist
        Route::get('wishlist', 'WishlistController@browse')->name('wishlist.browse');
        Route::get('wishlist/{tourism}/add', 'WishlistController@add')->name('wishlist.add');
        Route::get('wishlist/{tourism}/remove', 'WishlistController@remove')->name('wishlist.remove');

        Route::post('trip/store', 'TripController@store')->name('trip.store');
        Route::get('trip/mine', 'TripController@mine')->name('trip.mine');
        Route::post('trip/{trip}/update', 'TripController@update')->name('trip.update');
        Route::post('trip/{trip}/destroy', 'TripController@destroy')->name('trip.destroy');
        Route::post('trip/{trip}/add-item', 'TripController@addItem')->name('trip.addItem');
        Route::post('trip/{trip}/remove-item', 'TripController@removeItem')->name('trip.removeItem');

    });

    Route::fallback(function () {
        return response()->json([
            'message' => 'Request not Found!',
            'code' => 404
        ], 404);
    });
//});
