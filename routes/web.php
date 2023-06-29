<?php

use App\Http\Controllers\Apps\ActivityController;
use App\Http\Controllers\Apps\DashboardController;
use App\Http\Controllers\Apps\FieldController;
use App\Http\Controllers\Apps\PermissionController;
use App\Http\Controllers\Apps\RoleController;
use App\Http\Controllers\Apps\UserController;
use App\Http\Controllers\GroupController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Auth/Login');
})->middleware('guest');

Route::prefix('apps')->group(function () {
    Route::group(['middleware' => ['auth']], function () {
        // Route Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('apps.dashboard');

        // Route Permissions
        Route::get('/permissions', PermissionController::class)->name('apps.permissions.index')
            ->middleware('permission:permissions.index');

        // Route Users
        Route::resource('/users', UserController::class, ['as' => 'apps'])
            ->middleware('permission:users.index|users.create|users.edit|users.delete');

        // Route Roles
        Route::resource('/roles', RoleController::class, ['as' => 'apps'])
            ->middleware('permission:roles.index|roles.create|roles.edit|roles.delete');

        // Route Fields
        Route::resource('/fields', FieldController::class, ['as' => 'apps'])
            ->middleware('permission:fields.index|fields.create|fields.edit|fields.delete');

        // Route Groups
        Route::resource('/groups', GroupController::class, ['as' => 'apps'])
            ->middleware('permission:groups.index|groups.create|groups.edit|groups.delete');


        // Route Filter Activities
        Route::get('/activities/filter', [ActivityController::class, 'filter'])->name('apps.activities.filter');

        // Route Activity Export EXCEL
        Route::get('/activities/export', [ActivityController::class, 'export'])->name('apps.activity.export');

        // Route Activity Export PDF
        Route::get('/activities/export-pdf', [ActivityController::class, 'pdf'])->name('apps.activity.export-pdf');

        // Route Activities
        Route::resource('/activities', ActivityController::class, ['as' => 'apps'])
            ->middleware('permission:activities.index|activities.create|activities.edit|activities.show|activities.delete');
    });
});
