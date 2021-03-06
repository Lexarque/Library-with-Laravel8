<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {

    return $request->user();

});

Route::post('/register', 'UserController@register');
Route::post('/login', 'UserController@login');
Route::get('/getAuth', 'UserController@getAuthenticatedUser');

Route::group(['middleware' => ['jwt.verify:SuperAdmin,Admin,Customers']], function ()
{
    Route::group(['middleware' => ['jwt.verify:SuperAdmin']], function (){
        Route::delete('/student_class/{id_student_class}', 'StudentClassController@destroy');
        Route::delete('/students/{id_students}', 'StudentsController@destroy');
        Route::delete('/book/{id_book}', 'BookController@destroy');
        Route::delete('/borrow/{id_borrow}', 'BorrowController@destroy');
        Route::delete('/book_return/{id_book_return}', 'BookReturnController@destroy');
        Route::delete('/book_return_details/{id_book_return_details}', 'BookReturnDetailsController@destroy');
    });

    Route::group(['middleware' => ['jwt.verify:SuperAdmin,Admin']],function(){
        Route::post('/add_student_class', 'StudentClassController@store');
        Route::put('/student_class/{id_student_class}', 'StudentClassController@update');

        Route::post('/add_students', 'StudentsController@store');
        Route::put('/students/{id_students}', 'StudentsController@update');

        Route::post('/add_book', 'BookController@store');
        Route::put('/book/{id_book}', 'BookController@update');

        Route::post('/add_borrow', 'BorrowController@store');
        Route::put('/borrow/{id_borrow}', 'BorrowController@update');

        Route::post('/add_book_return', 'BookReturnController@store');
        Route::put('/book_return/{id_book_return}', 'BookReturnController@update');

        Route::post('/add_book_return_details', 'BookReturnDetailsController@store');
        Route::put('/book_return_details/{id_book_return_details}', 'BookReturnDetailsController@update');
    }); 
    
   
    Route::get('/student_class', 'StudentClassController@show');
    Route::get('/student_class/{id_student-class}', 'StudentClassController@detail');
   
    Route::get('/students', 'StudentsController@show');
    Route::get('/students/{id_students}', 'StudentsController@detail');
   
    Route::get('/book', 'BookController@show');
    Route::get('/book/{id_book}', 'BookController@detail');
    
    Route::get('/borrow', 'BorrowController@show');
    Route::get('/borrow/{id_borrow}', 'BorrowController@detail');
    
    Route::get('/book_return', 'BookReturnController@show');
    Route::get('/book_return/{id_book_return}', 'BookReturnController@detail');
    
    Route::get('/book_return_details', 'BookReturnDetailsController@show');
    Route::get('/book_return_details/{id_book_return_details}', 'BookReturnDetailsController@detail');
    
   
});

