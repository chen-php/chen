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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['namespace' => 'Api'], function () {
    Route::post('/busins', 'Api@busins');
    Route::post('/getChannelStati', 'Api@getChannelStati');
    Route::post('/getDownloadStati', 'Api@getDownloadStati');
    Route::post('/getErrorStati', 'Api@getErrorStati');
    Route::post('/getSuccessStati', 'Api@getSuccessStati');
    Route::post('/getFlowStati', 'Api@getFlowStati');
    Route::post('/getChannelOutput', 'Api@getChannelOutput');
    Route::post('/getTerminal', 'Api@getTerminal');
});