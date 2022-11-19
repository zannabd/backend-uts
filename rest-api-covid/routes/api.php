<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function (){

# Menampilakan seluruh data pasien
# methode 
Route::get('/patients', [PatientController::class, 'index']);

# Menambahkan data pasien baru
# method get
Route::post('/patients', [PatientController::class, 'store']);

# Menampilkan Detail data pasien
# method get
Route::get('/patients/{id}', [PatientController::class, 'show']);

# Mengedit single data pasien
# method put
Route::put('/patients/{id}', [PatientController::class, 'update']);

# Menghapus data pasien
# method delete
Route::delete('/patients/{id}', [PatientController::class, 'destroy']);

# Menampilkan data berdasarkan nama
# method get
Route::get('/patients/search/{name}', [PatientController::class, 'search']);

# Menampilkan pasien yang positif
# method get
Route::get('/patients/status/positive', [PatientController::class, 'positive']);

# Menampilkan data pasien yang sembuh
# method get
Route::get('/patients/status/recovered', [ PatientController::class, 'recovered']);

# Menampilkan data pasien yang meninggal
# method get
Route::get('/patients/status/dead', [PatientController::class, 'dead']);

});


# Route untuk register dan login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);