<?php

use DagaSmart\Surveillance\Http\Controllers;
use DagaSmart\Surveillance\Http\Middleware;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use DagaSmart\BizAdmin\Middleware\Permission;
use DagaSmart\BizAdmin\Middleware\Authenticate;


Route::get('surveillance', [Controllers\SurveillanceController::class, 'index']);

//免登录无限制
//Route::get('surveillance', [Controllers\SurveillanceController::class, 'index'])->withoutMiddleware([Authenticate::class, Permission::class]);

Route::group([
    'prefix' => 'biz',
    'middleware' => [Middleware\CheckPackageMiddleware::class],
], function (Router $router) {
    // 监控设备
    $router->resource('surveillance/device', Controllers\SurveillanceDeviceController::class);
    // 推流转码
    $router->resource('surveillance/stream', Controllers\SurveillanceStreamController::class);
    // 直播展板
    $router->get('surveillance/screen', [Controllers\SurveillanceController::class, 'screen']);

});
