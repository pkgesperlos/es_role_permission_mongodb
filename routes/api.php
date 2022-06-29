<?php

use Illuminate\Support\Facades\Route;
use Esperlos98\EsAccess\Http\Controllers\{
    CreateRoleController,
    CreatePermissionController,
    AssignRoleToPermissionController,
    AssignRoleToUserController,
    SyncController,};

Route::middleware(['api','auth:apiMongo','permission:user edit'])->prefix("es/api/v1/")->group(function () {

    Route::post("/createRole",[CreateRoleController::class,"create"]);
    Route::post("/createPermission",[CreatePermissionController::class,"create"]);
    Route::post("/assignRoleToPermission",[AssignRoleToPermissionController::class,"assign"]);
    Route::post("/assignRoleToUser",[AssignRoleToUserController::class,"assign"]);
    Route::post("/syncRole",[SyncController::class,"role"]);
    Route::post("/syncPermission",[SyncController::class,"permission"]);

});
