<?php

Route::group([
    'namespace'  => 'Botble\Marketplace\Http\Controllers\Fronts',
    'middleware' => ['web', 'core'],
], function () {
    Route::group(['prefix' => 'vendor', 'as' => 'marketplace.vendor.', 'middleware' => ['vendor']], function () {
        Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
            Route::resource('', 'OrderController')->parameters(['' => 'order'])->except(['create', 'store']);

            Route::delete('items/destroy', [
                'as'   => 'deletes',
                'uses' => 'OrderController@deletes',
            ]);

            Route::get('generate-invoice/{id}', [
                'as'   => 'generate-invoice',
                'uses' => 'OrderController@getGenerateInvoice',
            ]);

            Route::post('confirm', [
                'as'   => 'confirm',
                'uses' => 'OrderController@postConfirm',
            ]);

            Route::post('send-order-confirmation-email/{id}', [
                'as'   => 'send-order-confirmation-email',
                'uses' => 'OrderController@postResendOrderConfirmationEmail',
            ]);

            Route::post('update-shipping-address/{id}', [
                'as'   => 'update-shipping-address',
                'uses' => 'OrderController@postUpdateShippingAddress',
            ]);

            Route::post('cancel-order/{id}', [
                'as'   => 'cancel',
                'uses' => 'OrderController@postCancelOrder',
            ]);
        });
    });
});
