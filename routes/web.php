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



Route::get('test','Whstappcontroller@test');

/******************************* Admin login part start **********************************************/
Route::group(['middleware' => ['check-permission:super_admin|user|operator','checkactivestatus']], function () {

    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        /***************** Profile *************************/
        Route::get('profile', ['as' => 'profile', 'uses' => 'ProfileController@index']);

        /***************** Dashboard *************************/
        Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);
        Route::get('board', ['as' => 'board', 'uses' => 'DashboardController@board']);
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
                Route::post('getmodalsmall', ['as' => 'getmodalsmall', 'uses' => 'UniformController@getmodalsmall']);
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
                Route::post('editmodal', ['as' => 'editmodal', 'uses' => 'StockController@editmodal']);
                Route::post('export', ['as' => 'export', 'uses' => 'StockController@export']);
                Route::post('addlog', ['as' => 'addlog', 'uses' => 'StockController@addlog']);
                Route::post('storelog', ['as' => 'storelog', 'uses' => 'StockController@storelog']);
                Route::post('sendlog', ['as' => 'sendlog', 'uses' => 'StockController@sendlog']);
                Route::post('getmodalhistory', ['as' => 'getmodalhistory', 'uses' => 'StockController@getmodalhistory']);
                Route::post('addsize', ['as' => 'addsize', 'uses' => 'StockController@addsize']);
                Route::post('loadsize', ['as' => 'loadsize', 'uses' => 'StockController@loadsize']);
                
                
            });

            Route::resource('pendingstock', 'PendingStockController');

            Route::group(['prefix' => 'pendingstock', 'as' => 'pendingstock.'], function () {
                Route::post('getmodal', ['as' => 'getmodal', 'uses' => 'PendingStockController@getmodal']);
                Route::post('getall', ['as' => 'getall', 'uses' => 'PendingStockController@getall']);
                Route::post('editmodal', ['as' => 'editmodal', 'uses' => 'PendingStockController@editmodal']);
                Route::post('export', ['as' => 'export', 'uses' => 'PendingStockController@export']);
                Route::post('addlog', ['as' => 'addlog', 'uses' => 'PendingStockController@addlog']);
                Route::post('storelog', ['as' => 'storelog', 'uses' => 'PendingStockController@storelog']);
                Route::post('getmodalhistory', ['as' => 'getmodalhistory', 'uses' => 'PendingStockController@getmodalhistory']);
                Route::post('addsize', ['as' => 'addsize', 'uses' => 'PendingStockController@addsize']);
                Route::post('loadsize', ['as' => 'loadsize', 'uses' => 'PendingStockController@loadsize']);
                Route::post('loadimport', ['as' => 'loadimport', 'uses' => 'PendingStockController@loadimport']);
                 Route::post('cancleorder', ['as' => 'cancleorder', 'uses' => 'PendingStockController@cancleorder']);
                Route::post('sendorder', ['as' => 'sendorder', 'uses' => 'PendingStockController@sendorder']);
                Route::post('sendorderimage', ['as' => 'sendorderimage', 'uses' => 'PendingStockController@sendorderimage']);

                Route::post('storereminder', ['as' => 'storereminder', 'uses' => 'PendingStockController@storereminder']);
                
            });

            Route::delete('caclestock/{id}', ['as' => 'caclestock', 'uses' => 'PendingStockController@caclestock']);
            

            Route::resource('po', 'POController');
            Route::group(['prefix' => 'po', 'as' => 'po.'], function () {
                Route::post('getmodal', ['as' => 'getmodal', 'uses' => 'POController@getmodal']);
                Route::post('getall', ['as' => 'getall', 'uses' => 'POController@getall']);
                Route::post('editmodal', ['as' => 'editmodal', 'uses' => 'POController@editmodal']);
                Route::post('excelexport', ['as' => 'excelexport', 'uses' => 'POController@export']);
                Route::post('viewmodal', ['as' => 'viewmodal', 'uses' => 'POController@viewmodal']);
                Route::post('updatevalue', ['as' => 'updatevalue', 'uses' => 'POController@updatevalue']);
                Route::post('vieworder', ['as' => 'vieworder', 'uses' => 'POController@vieworder']);
                Route::post('sendtovendor', ['as' => 'sendtovendor', 'uses' => 'POController@sendtovendor']);

                
                
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


