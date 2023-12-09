<?php

use App\Models\BukuTamu;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    RoleController,
    UserController,
    TahunAjaranController,
    ProdiController,
    SemesterController,
    BiayaController
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
    return redirect()->route('login');
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
    Route::post('/upload-file', [UserController::class, 'upload_file'])->name('upload_file');

    Route::prefix('data-master')->name('data-master.')->group(function () {
        //? Tahun ajaran
        Route::get('tahun-ajaran/data', [TahunAjaranController::class, 'data'])->name('tahun-ajaran.data');
        Route::resource('tahun-ajaran', TahunAjaranController::class);
        
        //? Prodi
        Route::get('prodi/data', [ProdiController::class, 'data'])->name('prodi.data');
        Route::resource('prodi', ProdiController::class);

        Route::prefix('prodi')->name('prodi.')->group(function () {
            //? Semester
            Route::name('semester.')->group(function () {
                Route::get('{prodi_id}/semester/data', [SemesterController::class, 'data'])->name('data');
                Route::get('{prodi_id}/semester/create', [SemesterController::class, 'create'])->name('create');
                Route::post('{prodi_id}/semester', [SemesterController::class, 'store'])->name('store');
                Route::get('{prodi_id}/semester/{semester_id}', [SemesterController::class, 'show'])->name('show');
                Route::get('{prodi_id}/semester/{semester_id}/edit', [SemesterController::class, 'edit'])->name('edit');
                Route::patch('{prodi_id}/semester/{semester_id}', [SemesterController::class, 'update'])->name('update');
                Route::delete('{prodi_id}/semester/{semester_id}', [SemesterController::class, 'destroy'])->name('destroy');

                //? Biaya
                Route::name('biaya.')->group(function () {
                    Route::get('{prodi_id}/semester/{semester_id}/biaya/data', [BiayaController::class, 'data'])->name('data');
                    Route::get('{prodi_id}/semester/{semester_id}/biaya/create', [BiayaController::class, 'create'])->name('create');
                    Route::post('{prodi_id}/semester/{semester_id}/biaya', [BiayaController::class, 'store'])->name('store');
                    Route::get('{prodi_id}/semester/{semester_id}/biaya/{tahun_ajaran_id}', [BiayaController::class, 'show'])->name('show');
                    Route::get('{prodi_id}/semester/{semester_id}/biaya/{tahun_ajaran_id}/edit', [BiayaController::class, 'edit'])->name('edit');
                    Route::patch('{prodi_id}/semester/{semester_id}/biaya/{tahun_ajaran_id}', [BiayaController::class, 'update'])->name('update');
                    Route::delete('{prodi_id}/semester/{semester_id}/biaya/{tahun_ajaran_id}', [BiayaController::class, 'destroy'])->name('destroy');
                });
            });

        });
    });
});

require __DIR__.'/auth.php';
