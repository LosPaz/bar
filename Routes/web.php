<?php

/*
|--------------------------------------------------------------------------
| Module Web Routes
|--------------------------------------------------------------------------
*/

Route::group(['domain' => 'bar.' . config('app.normalurl')], function () {

    Route::get('/', 'LoginController@home');

    Route::group(['prefix' => 'auth'], function (){
        Route::get('/login', 'LoginController@index')->name('bar.login');
        Route::post('/login', 'LoginController@login');
    });
    
    Route::group(['middleware' => 'bar'], function (){
        /*
         * Settings
         */
        Route::get('/settings', 'SettingController@index')->name('manager.settings.index');
        Route::post('/settings/update', 'SettingController@update')->name('manager.settings.update');

        /*
         * Products
         */
        Route::get('/products', 'ProductController@index')->name('bar.home');
        Route::post('/transactions/bar', 'TransactionController@bar')->name('transactions.create');

        /*
         * Categories
         */
        Route::resource('/categories', 'CategoryController', ['as' => 'manager']);

        /*
         * Suppliers
         */
        Route::resource('/suppliers', 'SupplierController', ['as' => 'manager']);

        /*
         * Items
         */
        Route::resource('/items', 'ItemController', ['as' => 'manager']);

        /*
         * Stocks
         */
        Route::resource('/stocks', 'StockController', ['as' => 'manager']);
        Route::get('/stocks/{id}/transactions/create', 'StockTransactionController@create')->name('manager.stocks.transactions.create');
        Route::post('/stocks/{id}/transactions', 'StockTransactionController@store')->name('manager.stocks.transactions.store');

        Route::get('/stocks/{id}/transactions/move', 'StockTransactionController@moveIndex')->name('manager.stocks.transactions.move');
        Route::post('/stocks/{id}/transactions/move', 'StockTransactionController@move');

        /*
         * Workshift
         */
        Route::post('/workshifts/open', 'WorkshiftController@open')->name('workshifts.open');
        Route::post('/workshifts/close', 'WorkshiftController@close')->name('workshifts.close');
        Route::get('/workshifts', 'WorkshiftController@index')->name('manager.workshifts.index');

        Route::get('/workshifts/{id}/edit', 'WorkshiftController@edit')->name('manager.workshifts.edit');
        Route::put('/workshifts/{id}', 'WorkshiftController@update')->name('manager.workshifts.update');

        /*
         * History
         */
        Route::get('/history', 'HistoryController@index')->name('manager.history.index');

    });
});
