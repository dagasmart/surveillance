<?php

use DagaSmart\Surveillance\Http\Controllers;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use DagaSmart\BizAdmin\Middleware\Permission;
use DagaSmart\BizAdmin\Middleware\Authenticate;


Route::get('surveillance', [Controllers\SurveillanceController::class, 'index']);

//免登录无限制
//Route::get('surveillance', [Controllers\SurveillanceController::class, 'index'])->withoutMiddleware([Authenticate::class, Permission::class]);

Route::group([
    'prefix' => 'biz',
], function (Router $router) {
    // 转码直播
    $router->resource('surveillance/index', Controllers\SurveillanceController::class);
    // 直播大屏
    $router->get('surveillance/screen', [Controllers\SurveillanceController::class, 'screen']);

});
