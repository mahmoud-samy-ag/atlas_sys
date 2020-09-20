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

Route::group(['middleware' => 'guest'] , function(){
    Route::get('/', function () {
        return view('auth.login');
    });
});







Auth::routes();


Route::group(['middleware' => 'auth'] , function(){
    

    Route::get('/home', 'DashboardController@index' )->name('home');
    Route::get('/product_feedback/{id?}/', 'DashboardController@product_feedback' )->name('product_feedback');
    
    Route::resource('/users','UserController');
    Route::get('allow_plan/{id?}/', 'UserController@allow_plan')->name('users.allow_plan');
    Route::get('reset_password/{id?}/', 'UserController@reset_password')->name('users.reset_password');
    Route::post('update_password/{id?}/', 'UserController@update_password')->name('users.update_password');
    Route::get('disable_plan/{id?}/', 'UserController@disable_plan')->name('users.disable_plan');
    Route::get('approve/{id?}/', 'DoctorController@approve')->name('doctors.approve');
    Route::resource('/areas','AreaController');
    Route::resource('/locations','LocationController');
    Route::resource('/doctors','DoctorController');
    Route::resource('/products','ProductController');
    Route::resource('/weeklyPlans','WeeklyPlanController');
    Route::resource('/dailyReports','DailyReportController');
    Route::resource('/coverages','CoverageController');
    Route::resource('/marketFeedbacks','MarketFeedbackController');
    Route::resource('/productfeedbacks','ProductFeedbackController');
    Route::resource('/sales_report','SalesReportController');
    Route::get('/sales_report/create/{id?}/','SalesReportController@create');
    Route::get('/sales_graph/{id?}/','DashboardController@sales_graph');
});


Route::get('/test',function(){
    // $reals = App\area_user::where('user_id')->get();
});