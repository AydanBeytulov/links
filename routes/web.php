<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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

Route::group(['middleware' => ['blocks']], function () {

    Route::group(['middleware' => ['twostep']], function () {
        Route::get('/', 'OrdersController@redirectHome')->name('home');
        Route::get('/home', 'OrdersController@list')->name('home');
        Route::get('/orders', 'OrdersController@list')->name('orders_list');
        Route::get('/orders/add', 'OrdersController@add')->name('orders_add');
        Route::post('/orders/add', 'OrdersController@addProcess')->name('orders_add_process');
        Route::get('/orders/edit/{id}', 'OrdersController@edit')->name('orders_edit');
        Route::post('/orders/edit', 'OrdersController@editProcess')->name('orders_edit_process');
        Route::get('/orders/activate/{id}', 'OrdersController@activate')->name('orders_activate');
        Route::get('/orders/stop/{id}', 'OrdersController@stop')->name('orders_stop');
        Route::get('/orders/orders_close/{id}', 'OrdersController@close')->name('orders_close');

        Route::get('/funds', 'FundsController@list')->name('funds_list');
        Route::get('/funds/view/{id}', 'FundsController@view')->name('funds_view');
        Route::get('/funds/add', 'FundsController@add')->name('funds_add');
        Route::post('/funds/add', 'FundsController@addProcess')->name('funds_add_process');

        Route::get('/settings', 'SettingsController@index')->name('settings');
        Route::get('/settings/edit', 'SettingsController@index')->name('settings2');
        Route::post('/settings/edit', 'SettingsController@editProcess')->name('users_edit_process');
        Route::post('/settings/edit/password', 'SettingsController@editProcessPassword')->name('users_edit_process_password');

        Route::get('/my-api', 'MyAPIController@index')->name('my_api');
        Route::get('/my-api/regenerate', 'MyAPIController@regenerate')->name('my_api_regenerate');
        Route::post('/my-api/allowDataProcess', 'MyAPIController@allowDataProcess')->name('my_api_allow_data_process');

        Route::get('/logs', 'LogsController@index')->name('logs');
    });

 //   Route::get('/link', 'LinksController@link')->name('link');
    Route::post('/ipn', 'CoinPaymentsController@ipn')->name('ipn');

    Auth::routes();

    Route::prefix('api/v1')->group(function () {
        Route::post('/', 'API\APIController@index')->name('API')->middleware('auth:api');
    });
    Route::get('/apitest/{type}', 'API\TestAPIController@test')->name('test');

    Route::prefix('admin')->group(function () {
        Route::get('/', 'Admin\AdminController@login')->name('admin_login');
        Route::post('/authenticate', 'Admin\AdminController@authenticate')->name('admin_authenticate');

        Route::group(['middleware' => ['twostep']], function () {

            Route::get('/logs', 'LogsController@adminLogs')->name('admin_logs');

            Route::get('/users', 'Admin\UsersController@list')->middleware('is_admin')->name('admin_users');
            Route::get('/users/add', 'Admin\UsersController@add')->middleware('is_admin')->name('admin_users_add');
            Route::post('/users/add', 'Admin\UsersController@addProcess')->middleware('is_admin')->name('admin_users_add_process');
            Route::get('/users/edit/{id}', 'Admin\UsersController@edit')->middleware('is_admin')->name('admin_users_edit');
            Route::post('/users/edit', 'Admin\UsersController@editProcess')->middleware('is_admin')->name('admin_users_edit_process');
            Route::post('/users/edit/funds', 'Admin\UsersController@editProcessFunds')->middleware('is_admin')->name('admin_users_edit_process_funds');
            Route::post('/users/edit/password', 'Admin\UsersController@editProcessPassword')->middleware('is_admin')->name('admin_users_edit_process_password');
            Route::get('/users/delete/{id}', 'Admin\UsersController@delete')->middleware('is_admin')->name('admin_users_delete');

            Route::get('/urls', 'Admin\URLsController@list')->middleware('is_admin')->name('admin_urls');
            Route::get('/urls/add', 'Admin\URLsController@add')->middleware('is_admin')->name('admin_urls_add');
            Route::post('/urls/add', 'Admin\URLsController@addProcess')->middleware('is_admin')->name('admin_urls_add_process');
            Route::get('/urls/edit/{id}', 'Admin\URLsController@edit')->middleware('is_admin')->name('admin_urls_edit');
            Route::post('/urls/edit', 'Admin\URLsController@editProcess')->middleware('is_admin')->name('admin_urls_edit_process');
            Route::get('/urls/delete/{id}', 'Admin\URLsController@delete')->middleware('is_admin')->name('admin_urls_delete');

            Route::get('/categories', 'Admin\CategoriesController@list')->middleware('is_admin')->name('admin_categories');
            Route::get('/categories/add', 'Admin\CategoriesController@add')->middleware('is_admin')->name('admin_categories_add');
            Route::post('/categories/add', 'Admin\CategoriesController@addProcess')->middleware('is_admin')->name('admin_categories_add_process');
            Route::get('/categories/edit/{id}', 'Admin\CategoriesController@edit')->middleware('is_admin')->name('admin_categories_edit');
            Route::post('/categories/edit', 'Admin\CategoriesController@editProcess')->middleware('is_admin')->name('admin_categories_edit_process');
            Route::get('/categories/delete/{id}', 'Admin\CategoriesController@delete')->middleware('is_admin')->name('admin_categories_delete');

            Route::get('/services', 'Admin\ServicesController@list')->middleware('is_admin')->name('admin_services');
            Route::get('/services/add', 'Admin\ServicesController@add')->middleware('is_admin')->name('admin_services_add');
            Route::post('/services/add', 'Admin\ServicesController@addProcess')->middleware('is_admin')->name('admin_services_add_process');
            Route::get('/services/edit/{id}', 'Admin\ServicesController@edit')->middleware('is_admin')->name('admin_services_edit');
            Route::post('/services/edit', 'Admin\ServicesController@editProcess')->middleware('is_admin')->name('admin_services_edit_process');
            Route::get('/services/delete/{id}', 'Admin\ServicesController@delete')->middleware('is_admin')->name('admin_services_delete');

            Route::get('/orders', 'Admin\OrdersController@list')->middleware('is_admin')->name('admin_orders');
            Route::get('/orders/add', 'Admin\OrdersController@add')->middleware('is_admin')->name('admin_orders_add');
            Route::post('/orders/add', 'Admin\OrdersController@addProcess')->middleware('is_admin')->name('admin_orders_add_process');
            Route::get('/orders/edit/{id}', 'Admin\OrdersController@edit')->middleware('is_admin')->name('admin_orders_edit');
            Route::post('/orders/edit', 'Admin\OrdersController@editProcess')->middleware('is_admin')->name('admin_orders_edit_process');
            Route::get('/orders/delete/{id}', 'Admin\OrdersController@delete')->middleware('is_admin')->name('admin_orders_delete');
            Route::get('/orders/approve/{id}', 'Admin\OrdersController@approve')->middleware('is_admin')->name('admin_orders_approve');
            Route::get('/orders/addUrlInList/{id}', 'Admin\OrdersController@addUrlInList')->middleware('is_admin')->name('admin_orders_add_url');
            Route::get('/orders/activate/{id}', 'Admin\OrdersController@activate')->name('admin_orders_activate');
            Route::get('/orders/stop/{id}', 'Admin\OrdersController@stop')->name('admin_orders_stop');
            Route::get('/orders/refues/{id}', 'Admin\OrdersController@refuse')->name('admin_orders_refuse');

            Route::get('/rotators', 'Admin\RotatorsController@list')->middleware('is_admin')->name('admin_rotators');
            Route::get('/rotators/add', 'Admin\RotatorsController@add')->middleware('is_admin')->name('admin_rotators_add');
            Route::post('/rotators/add', 'Admin\RotatorsController@addProcess')->middleware('is_admin')->name('admin_rotators_add_process');
            Route::get('/rotators/edit/{id}', 'Admin\RotatorsController@edit')->middleware('is_admin')->name('admin_rotators_edit');
            Route::post('/rotators/edit', 'Admin\RotatorsController@editProcess')->middleware('is_admin')->name('admin_rotators_edit_process');
            Route::get('/rotators/delete/{id}', 'Admin\RotatorsController@delete')->middleware('is_admin')->name('admin_rotators_delete');

            Route::get('/blocks', 'Admin\BlocksController@list')->middleware('is_admin')->name('admin_blocks');
            Route::get('/blocks/add', 'Admin\BlocksController@add')->middleware('is_admin')->name('admin_blocks_add');
            Route::post('/blocks/add', 'Admin\BlocksController@addProcess')->middleware('is_admin')->name('admin_blocks_add_process');
            Route::get('/blocks/edit/{id}', 'Admin\BlocksController@edit')->middleware('is_admin')->name('admin_blocks_edit');
            Route::post('/blocks/edit', 'Admin\BlocksController@editProcess')->middleware('is_admin')->name('admin_blocks_edit_process');
            Route::get('/blocks/delete/{id}', 'Admin\BlocksController@delete')->middleware('is_admin')->name('admin_blocks_delete');

            Route::get('/ipblocks', 'Admin\IPBlocksController@list')->middleware('is_admin')->name('admin_ip_blocks');
            Route::get('/ipblocks/add', 'Admin\IPBlocksController@add')->middleware('is_admin')->name('admin_ip_blocks_add');
            Route::post('/ipblocks/add', 'Admin\IPBlocksController@addProcess')->middleware('is_admin')->name('admin_ip_blocks_add_process');
            Route::get('/ipblocks/edit/{id}', 'Admin\IPBlocksController@edit')->middleware('is_admin')->name('admin_ip_blocks_edit');
            Route::post('/ipblocks/edit', 'Admin\IPBlocksController@editProcess')->middleware('is_admin')->name('admin_ip_blocks_edit_process');
            Route::get('/ipblocks/delete/{id}', 'Admin\IPBlocksController@delete')->middleware('is_admin')->name('admin_ip_blocks_delete');

            Route::get('/settings', 'Admin\SettingsController@edit')->middleware('is_admin')->name('admin_settings_edit');
            Route::post('/settings/edit', 'Admin\SettingsController@editProcess')->middleware('is_admin')->name('admin_settings_edit_process');
        });
    });
});
