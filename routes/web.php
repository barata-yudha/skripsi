<?php

use App\Models\Odp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});

Route::get('/cek', function() {
    $odps = Odp::all();
    $warned = $odps->map(function ($odp) {
        $check_sisa = $odp->port_max - $odp->port_used;
        if ($check_sisa <= 2) {
            return (object) [
                'id' => $odp->id,
                'kode' => $odp->kode,
                'sisa_port' => $odp->port_max - $odp->port_used
            ];
        }
    });

    $filtered = array_filter($warned->toArray());

    dd($filtered);

});

Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => 'auth'], function() {
    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('index');

    Route::get('user/profile', [\App\Http\Controllers\UserController::class, 'profile'])->name('user.profile');
    Route::put('user/profile_update', [\App\Http\Controllers\UserController::class, 'profile_update'])->name('user.profile_update');

    // Master Data
    Route::resource('user', \App\Http\Controllers\UserController::class)->except('show');
    Route::resource('odp', \App\Http\Controllers\OdpController::class)->except('show');
    Route::resource('ont', \App\Http\Controllers\OntController::class)->except('show');
    Route::resource('customer', \App\Http\Controllers\CustomerController::class)->except('show');
    Route::resource('timeslot', \App\Http\Controllers\TimeslotController::class);
    Route::get('ticket/open', [\App\Http\Controllers\TimeslotController::class, 'ticket_open'])->name('timeslot.open');
    Route::get('ticket/progress', [\App\Http\Controllers\TimeslotController::class, 'ticket_progress'])->name('timeslot.progress');
    Route::get('ticket/solve', [\App\Http\Controllers\TimeslotController::class, 'ticket_solve'])->name('timeslot.solve');
    Route::get('ticket/reject', [\App\Http\Controllers\TimeslotController::class, 'ticket_reject'])->name('timeslot.reject');

    // Set state
    Route::post('ticket/approve/{id}', [\App\Http\Controllers\TimeslotController::class, 'approve'])->name('ticket.approve');
    Route::post('ticket/reject/{id}', [\App\Http\Controllers\TimeslotController::class, 'reject'])->name('ticket.reject');
    Route::put('ticket/finish/{id}', [\App\Http\Controllers\TimeslotController::class, 'finish'])->name('ticket.finish');

    Route::get('my_area', [\App\Http\Controllers\DashboardController::class, 'my_area'])->name('my_area');
    Route::get('check_coverage', [\App\Http\Controllers\DashboardController::class, 'check_coverage'])->name('check_coverage');

    // Laporan Routes
    Route::get('laporan/periode', [\App\Http\Controllers\LaporanController::class, 'periode'])->name('laporan.periode');
});

require __DIR__.'/auth.php';
