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

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();





/******************************* Admin login part start **********************************************/
Route::group(['middleware' => ['check-permission:super_admin|user|operator','checkactivestatus']], function () {

    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        /***************** Profile *************************/
        Route::get('profile', ['as' => 'profile', 'uses' => 'ProfileController@index']);

        /***************** Dashboard *************************/
        Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);
        Route::post('filterdata', ['as' => 'filterdata', 'uses' => 'DashboardController@filterdata']);
        Route::post('loadimages', ['as' => 'loadimages', 'uses' => 'DashboardController@loadimages']);


        Route::group(['middleware' => 'check-permission:super_admin|user'], function () {
            /******************** User Dev : Dilip 15-06 ***********************/
            Route::resource('school', 'SchoolController');
            Route::group(['prefix' => 'school', 'as' => 'school.'], function () {
                Route::post('storecommision', ['as' => 'storecommision', 'uses' => 'SchoolController@storecommision']);
                Route::post('getall', ['as' => 'getall', 'uses' => 'SchoolController@getall']);
                Route::post('getcomissionmodal', ['as' => 'getcomissionmodal', 'uses' => 'SchoolController@getcomissionmodal']);
                Route::post('getmodal', ['as' => 'getmodal', 'uses' => 'SchoolController@getmodal']);
                 Route::post('viewdetail', ['as' => 'viewdetail', 'uses' => 'SchoolController@viewdetail']);
                Route::post('citywithstatecountry',['as' => 'citywithstatecountry', 'uses' => 'SchoolController@citywithstatecountry']);
                Route::post('storehistoryuniform', ['as' => 'storehistoryuniform', 'uses' => 'SchoolController@storehistoryuniform']);
            });
        });

        Route::group(['middleware' => 'check-permission:super_admin'], function () {
            /******************** User Dev : Dilip 15-06 ***********************/
            Route::resource('users', 'UserController');
            Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
                Route::post('getall', ['as' => 'getall', 'uses' => 'UserController@getall']);
                Route::post('getmodal', ['as' => 'getmodal', 'uses' => 'UserController@getmodal']);
                Route::post('changestatus', ['as' => 'changestatus', 'uses' => 'UserController@changestatus']);
            });
        });

        Route::group(['middleware' => 'check-permission:super_admin'], function () {
            Route::resource('uniform', 'UniformController');
            Route::group(['prefix' => 'uniform', 'as' => 'uniform.'], function () {
                Route::post('loaduniform', ['as' => 'loaduniform', 'uses' => 'UniformController@loaduniform']);
                Route::post('submituniform', ['as' => 'submituniform', 'uses' => 'UniformController@submituniform']);
                Route::post('delete', ['as' => 'delete', 'uses' => 'UniformController@delete']);
                Route::post('loafcopydropdown', ['as' => 'loafcopydropdown', 'uses' => 'UniformController@loafcopydropdown']);
                Route::post('copyfinal', ['as' => 'copyfinal', 'uses' => 'UniformController@copyfinal']);
                Route::post('saveimage', ['as' => 'saveimage', 'uses' => 'UniformController@saveimage']);
                Route::post('savetext', ['as' => 'savetext', 'uses' => 'UniformController@savetext']);
                Route::post('savesize', ['as' => 'savesize', 'uses' => 'UniformController@savesize']);
                Route::post('getmodal', ['as' => 'getmodal', 'uses' => 'UniformController@getmodal']);
                Route::post('storeitem', ['as' => 'storeitem', 'uses' => 'UniformController@storeitem']);


            });
        });

        Route::group(['middleware' => 'check-permission:super_admin'], function () {
            Route::resource('reports', 'ReportsController');
            Route::group(['prefix' => 'reports', 'as' => 'reports.'], function () {
                Route::post('loadreport', ['as' => 'loadreport', 'uses' => 'ReportsController@loadreport']);
                Route::post('changedrop', ['as' => 'changedrop', 'uses' => 'ReportsController@changedrop']);
                Route::post('changedropvalue', ['as' => 'changedropvalue', 'uses' => 'ReportsController@changedropvalue']);


            });
        });


         Route::group(['middleware' => 'check-permission:super_admin'], function () {
            Route::resource('vendors', 'VendorsController');
            Route::group(['prefix' => 'vendors', 'as' => 'vendors.'], function () {
                Route::post('getall', ['as' => 'getall', 'uses' => 'VendorsController@getall']);
                Route::post('getmodal', ['as' => 'getmodal', 'uses' => 'VendorsController@getmodal']);
            });

            Route::resource('stocks', 'StockController');

            Route::group(['prefix' => 'stocks', 'as' => 'stocks.'], function () {
                Route::post('getmodal', ['as' => 'getmodal', 'uses' => 'StockController@getmodal']);
                Route::post('getall', ['as' => 'getall', 'uses' => 'StockController@getall']);
                Route::post('excelexport', ['as' => 'excelexport', 'uses' => 'StockController@export']);
            });



        });

        /*********************** In out past date setting*********************************/
        Route::get('setting', ['as' => 'setting', 'uses' => 'SettingController@index']);
        Route::post('setting', ['as' => 'setting.store', 'uses' => 'SettingController@store']);
        /***************************** users *****************************************/


    });
    /**************** employee login part***************/

});

/***************************** Company login part end **************************************************/


/********************** common *********************/

Route::get('profile', ['as' => 'profile', 'uses' => 'ProfileController@index']);
Route::post('/profileupdate', ['as' => 'profileupdate', 'uses' => 'ProfileController@profileupdate']);
Route::post('/changepassword', ['as' => 'changepassword', 'uses' => 'ProfileController@changepassword']);
/********************** common *********************/


