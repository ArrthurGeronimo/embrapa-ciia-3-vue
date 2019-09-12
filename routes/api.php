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

Route::apiResources([
	'user' => 'API\UserController',
	'experimento' => 'API\ExperimentoController',
	'experimento_faixa' => 'API\ExperimentoFaixaController'
]);

Route::apiResources([
	'sensor' => 'API\SensorController',
	'sensor_clima' => 'API\SensorClimaController',
	'sensor_solo' => 'API\SensorSoloController'
]);

Route::get('carrega_informacoes_dos_sensores_de_clima/{sensor_id}', 'API\SensorClimaController@busca');

Route::get('carrega_informacoes_do_experimento_faixa/{experimento_id}', 'API\ExperimentoFaixaController@busca');