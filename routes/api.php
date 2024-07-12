<?php

use App\Http\Controllers\AddressesController;
use App\Http\Controllers\AddtocartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\CartsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomersupportsController;
use App\Http\Controllers\DiscountsController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\OrderitemsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ReturnordersController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\statusController;
use App\Models\Customersupports;
use Illuminate\Support\Facades\Route;
use Psy\Command\ListCommand;
use App\Http\Controllers\AcceptedorderController;
use App\Http\Controllers\PendingorderController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SliderController;


Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('password/email',  [AuthController::class, 'sendMail']);
    Route::post('password/verify', [AuthController::class, 'verifyOTP']);
});


Route::group(['middleware' => ['auth:api']], function () {
    //admin/employee apis
    Route::group(['prefix' => 'user'], function () {
        Route::post('list', [UserController::class, 'index']);
        Route::post('details', [UserController::class, 'details']);
        Route::post('add', [UserController::class, 'store']);
        Route::post('edit', [UserController::class, 'update']);
        Route::post('delete', [UserController::class, 'delete']);
    });

    Route::group(['prefix' => 'role'], function () {
        Route::post('list', [RoleController::class, 'index']);
        Route::post('add', [RoleController::class, 'store']);
        Route::post('update', [RoleController::class, 'update']);
        Route::post('delete', [RoleController::class, 'delete']);
    });

    Route::group(['prefix' => 'status'], function () {
        Route::post('list', [statusController::class, 'index']);
        Route::post('add', [statusController::class, 'store']);
        Route::post('update', [statusController::class, 'update']);
        Route::post('delete', [statusController::class, 'delete']);
    });

    Route::group(['prefix' => 'order'], function () {
        Route::post('list', [OrdersController::class, 'index']);
        Route::post('add', [OrdersController::class, 'store']);
        Route::post('update', [OrdersController::class, 'update']);
        Route::post('delete', [OrdersController::class, 'delete']);
    });

    Route::group(['prefix' => 'orderitem'], function () {
        Route::post('list', [OrderitemsController::class, 'index']);
        Route::post('add', [OrderitemsController::class, 'store']);
        Route::post('update', [OrderitemsController::class, 'update']);
        Route::post('delete', [OrderitemsController::class, 'delete']);
    });

    Route::group(['prefix' => 'addresse'], function () {
        Route::post('list', [AddressesController::class, 'index']);
        Route::post('add', [AddressesController::class, 'store']);
        Route::post('update', [AddressesController::class, 'update']);
        Route::post('delete', [AddressesController::class, 'delete']);
    });

    Route::group(['prefix' => 'payment'], function () {
        Route::post('list', [PaymentsController::class, 'index']);
        Route::post('add', [PaymentsController::class, 'store']);
        Route::post('update', [PaymentsController::class, 'update']);
        Route::post('delete', [PaymentsController::class, 'delete']);
    });

    Route::group(['prefix' => 'review'], function () {
        Route::post('list', [ReviewsController::class, 'index']);
        Route::post('add', [ReviewsController::class, 'store']);
        Route::post('update', [ReviewsController::class, 'update']);
        Route::post('delete', [ReviewsController::class, 'delete']);
    });



    // Route::group(['prefix' => 'setting'], function () {
    //     Route::post('list', [SettingsController::class, 'index']);
    //     Route::post('add', [SettingsController::class, 'store']);
    //     Route::post('update', [SettingsController::class, 'update']);
    //     Route::post('delete', [SettingsController::class, 'delete']);
    // });



    Route::group(['prefix' => 'returnorder'], function () {
        Route::post('list', [ReturnordersController::class, 'index']);
        Route::post('add', [ReturnordersController::class, 'store']);
        Route::post('update', [ReturnordersController::class, 'update']);
        Route::post('delete', [ReturnordersController::class, 'delete']);
    });
    Route::group(['prefix' => 'pendingorder'], function () {
        Route::post('list', [PendingorderController::class, 'index']);
        Route::post('add', [PendingorderController::class, 'store']);
        Route::post('update', [PendingorderController::class, 'update']);
        Route::post('delete', [PendingorderController::class, 'destroy']);
    });




    Route::group(['prefix' => 'permission'], function () {
        Route::post('list', [PermissionController::class, 'index']);
        Route::post('add', [PermissionController::class, 'store']);
        Route::post('update', [PermissionController::class, 'update']);
        Route::post('delete', [PermissionController::class, 'delete']);
    });
    Route::group(['prefix' => 'rolepermission'], function () {
        Route::post('list', [RolePermissionController::class, 'index']);
        Route::post('add', [RolePermissionController::class, 'store']);
        Route::post('update', [RolePermissionController::class, 'update']);
        Route::post('delete', [RolePermissionController::class, 'delete']);
    });

    Route::group(['prefix' => 'cart'], function () {
        Route::post('list', [CartsController::class, 'index']);
        Route::post('add', [CartsController::class, 'store']);
        Route::post('update', [CartsController::class, 'update']);
        Route::post('delete', [CartsController::class, 'delete']);
    });

    Route::group(['prefix' => 'acceptedorder'], function () {
        Route::post('list', [AcceptedorderController::class, 'index']);
        Route::post('add', [AcceptedorderController::class, 'store']);
        Route::post('update', [AcceptedorderController::class, 'update']);
        Route::post('delete', [AcceptedorderController::class, 'destroy']);
    });

    Route::group(['prefix' => 'sitesetting'], function () {
        Route::post('update', [SettingController::class, 'update']);
    });



    Route::group(['prefix' => 'brand'], function () {
        Route::post('list', [BrandsController::class, 'index']);
        Route::post('add', [BrandsController::class, 'store']);
        Route::post('update', [BrandsController::class, 'update']);
        Route::post('delete', [BrandsController::class, 'delete']);
    });
    Route::group(['prefix' => 'category'], function () {
        Route::post('list', [CategoryController::class, 'index']);
        Route::post('add', [CategoryController::class, 'store']);
        Route::post('update', [CategoryController::class, 'update']);
        Route::post('delete', [CategoryController::class, 'delete']);
    });

    Route::group(['prefix' => 'wishlist'], function () {
        Route::post('list', [WishlistController::class, 'index']);
        Route::post('add', [WishlistController::class, 'store']);
        Route::post('update', [WishlistController::class, 'update']);
        Route::post('delete', [WishlistController::class, 'delete']);
    });
    Route::group(['prefix' => 'addtocart'], function () {
        Route::post('list', [AddtocartController::class, 'index']);
        Route::post('add', [AddtocartController::class, 'store']);
        Route::post('update', [AddtocartController::class, 'update']);
        Route::post('delete', [AddtocartController::class, 'delete']);
    });
    Route::group(['prefix' => 'product'], function () {
        Route::post('list', [ProductsController::class, 'index']);
        Route::post('add', [ProductsController::class, 'store']);
        Route::post('update', [ProductsController::class, 'update']);
        Route::post('delete', [ProductsController::class, 'delete']);
        Route::post('details', [ProductsController::class, 'show']);
    });
    Route::group(['prefix' => 'slider'], function () {
        Route::post('list', [SliderController::class, 'index']);
        Route::post('add', [SliderController::class, 'store']);
        Route::post('update', [SliderController::class, 'update']);
        Route::post('delete', [SliderController::class, 'destroy']);
    });
    Route::group(['prefix' => 'discount'], function () {
        Route::post('list', [DiscountsController::class, 'index']);
        Route::post('add', [DiscountsController::class, 'store']);
        Route::post('update', [DiscountsController::class, 'update']);
        Route::post('delete', [DiscountsController::class, 'delete']);
    });

    Route::group(['prefix' => 'faq'], function () {
        Route::post('list', [FaqsController::class, 'index']);
        Route::post('add', [FaqsController::class, 'store']);
        Route::post('update', [FaqsController::class, 'update']);
        Route::post('delete', [FaqsController::class, 'delete']);
    });

    Route::group(['prefix' => 'customersupport'], function () {
        Route::post('list', [CustomersupportsController::class, 'index']);
        Route::post('add', [CustomersupportsController::class, 'store']);
        Route::post('update', [CustomersupportsController::class, 'update']);
        Route::post('delete', [CustomersupportsController::class, 'delete']);
    });
});


Route::group(['prefix' => 'web'], function () {
    //web api
    Route::post('faq', [FaqsController::class, 'index']);
    Route::post('slider', [SliderController::class, 'index']);
    Route::post('products', [ProductsController::class, 'index']);
    Route::post('brands', [BrandsController::class, 'index']);
    Route::post('categories', [CategoryController::class, 'index']);
    Route::post('support', [CustomersupportsController::class, 'index']);
});

Route::group(['prefix' => 'auth', ['middleware' => ['auth:api']]], function () {
    //customer apis
    Route::group(['prefix' => 'wishlist'], function () {
        Route::post('list', [WishlistController::class, 'index']);
        Route::post('add', [WishlistController::class, 'store']);
        Route::post('update', [WishlistController::class, 'update']);
        Route::post('delete', [WishlistController::class, 'delete']);
    });
});


Route::post('index', [SettingController::class, 'index']);
Route::post('list', [SettingController::class, 'list']);
Route::post('smtpCredential', [SettingController::class, 'smtpCredential']);
Route::post('prefix', [SettingController::class, 'prefix']);
Route::post('workingDays', [SettingController::class, 'workingDays']);
Route::post('workingTime', [SettingController::class, 'workingTime']);
