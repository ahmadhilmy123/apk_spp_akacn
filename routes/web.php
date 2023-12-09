<?php

use App\Models\BukuTamu;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    RoleController,
    UserController,
    TahunAjaranController
};

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
    return view('tamu');
})->name('index');

Route::group(['middleware' => ['auth']], function() {
    Route::get('/dashboard', function(){
        return view('dashboard');
    });
    Route::resource('roles', RoleController::class);
    Route::prefix('users')->name('users.')->middleware('user.role')->group(function () {
        Route::get('{role}', [UserController::class, 'index'])->name('index');
        Route::get('{role}/create', [UserController::class, 'create'])->name('create');
        Route::post('{role}', [UserController::class, 'store'])->name('store');
        Route::get('{role}/data', [UserController::class, 'data'])->name('data');
        Route::get('{role}/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::patch('{role}/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('{role}/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

    Route::get('tahun-ajaran/data', [TahunAjaranController::class, 'data'])->name('tahun-ajaran.data');
    Route::resource('tahun-ajaran', TahunAjaranController::class);
});

require __DIR__.'/auth.php';
