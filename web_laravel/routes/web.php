<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentsController as StudentsControllerAlias;
use App\Http\Middleware\CheckLoginMiddleware;
use App\Http\Middleware\CheckSupperAdminMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//
//Route::group(['prefix' => 'courses','as'=> 'course.'],function (){
//    Route::get('/',[CourseController::class,'index'])->name('index');
//});
Route::get('login', [AuthController::class,'login'])->name('login');
Route::post('login', [AuthController::class,'processLogin'])->name('process_login');
Route::get('register', [AuthController::class,'register'])->name('register');
Route::post('register', [AuthController::class,'processRegister'])->name('process_register');
Route::group([
    'middleware' => CheckLoginMiddleware::class
],function (){
    Route::get('logout', [AuthController::class,'logout'])->name('logout');
    Route::group(['prefix' => 'courses','as'=> 'course.'],function (){
        Route::get('/',[CourseController::class,'index'])->name('index');
        Route::get('create',[CourseController::class,'create'])->name('create');
        Route::post('store',[CourseController::class,'store'])->name('store');
        Route::get('edit/{course}',[CourseController::class,'edit'])->name('edit');
        Route::put('update/{course}',[CourseController::class, 'update'])->name('update');
        Route::get('api',[CourseController::class,'api'])->name('api');
        Route::get('api/name',[CourseController::class,'apiName'])->name('api.name');
    });
    Route::group(['prefix' => 'students','as'=> 'student.'],function (){
        Route::get('/',[StudentsControllerAlias::class,'index'])->name('index');
        Route::get('create',[StudentsControllerAlias::class,'create'])->name('create');
        Route::post('store',[StudentsControllerAlias::class,'store'])->name('store');
        Route::get('edit/{course}',[StudentsControllerAlias::class,'edit'])->name('edit');
        Route::put('update/{course}',[StudentsControllerAlias::class, 'update'])->name('update');
        Route::get('api',[StudentsControllerAlias::class,'api'])->name('api');
        Route::get('api/name',[StudentsControllerAlias::class,'apiName'])->name('api.name');
    });
    Route::group([
        'middleware' => CheckSupperAdminMiddleware::class
    ],function (){
        Route::delete('destroy/{course}',[CourseController::class,'destroy'])->name('destroy');
        Route::delete('destroy/{course}',[StudentsControllerAlias::class,'destroy'])->name('destroy');
    });
});

//Route::get('test',function (){
//    return view('auth.login');
//});
