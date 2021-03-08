<?php
use App\Http\Controllers\TarefaController;
use App\Http\Controllers\TipoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Tarefas
Route::post('create', [TarefaController::class, 'create']);
Route::get('show', [TarefaController::class, 'show']);
Route::get('show/filter/{filter}', [TarefaController::class, 'filter']);
Route::put('update/{id}', [TarefaController::class, 'update']);
Route::delete('delete/{id}', [TarefaController::class, 'delete']);


//Tipos de tarefas
Route::get('show/tipos', [TipoController::class, 'show']);
Route::post('create/tipos', [TipoController::class, 'create']);
Route::put('update/tipos/{id}', [TipoController::class, 'update']);
Route::delete('delete/tipos/{id}', [TipoController::class, 'delete']);