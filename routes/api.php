<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\MemberController;
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
Route::get('members',[MemberController::class,'index']);

Route::prefix('v1')->group(function(){
     Route::post('auth/login',[AuthController::class,'login'])->name('auth.login');
     Route::post('auth/register',[AuthController::class,'register'])->name('auth.register');

     Route::group(['middleware'=> 'auth:api'],function(){
        Route::apiResources([
         'member'=> MemberController::class,
         'invoice'=> InvoiceController::class,
         'expense'=> ExpenseController::class,
        ]);
      Route::post('/logout', [AuthController::class, 'logout']);
     });
});