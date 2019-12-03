<?php

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
//Modul Web
Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::match(['GET', 'POST'], '/register', function(){
    return redirect('/login');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('roles')->group(function(){
    Route::get('/','RoleController@index')->name('roles');
    Route::get('/delete/{id}','RoleController@delete')->name('roles.delete');
    Route::get('/getData/{id}','RoleController@getdata')->name('roles.get');

    Route::post('/add','RoleController@add')->name('roles.add');
    Route::post('/edit','RoleController@edit')->name('roles.edit');
});

Route::prefix('users')->group(function(){
    Route::get('/','UserController@index')->name('users');
    Route::get('/delete/{id}','UserController@delete')->name('users.delete');
    Route::get('/getData/{id}','UserController@getdata')->name('users.get');

    Route::post('/add','UserController@add')->name('users.add');
    Route::post('/edit','UserController@edit')->name('users.edit');
});

Route::prefix('vacancy')->group(function(){
    Route::get('/', 'VacancyController@index')->name('vacancy');
    Route::get('/approve/{id}', 'VacancyController@approve')->name('vacancy.approve');
    Route::get('/reject/{id}', 'VacancyController@reject')->name('vacancy.reject');
});

//Modul Mobile
Route::group(['prefix' => 'api/v1'], function () {
    //Modul User
    Route::post('doLogin', 'MobileController@doLogin');
    Route::post('doRegist', 'MobileController@doRegist');

    //Modul Petani
    Route::post('petani/{id}/addVacancy', 'MobileController@addVacancy');

    Route::get('petani/{id}/vacancies', 'MobileController@petaniVacancies');

    //Modul Buruh
});