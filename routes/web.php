<?php

use App\Http\Controllers\ProjectControlller;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ProjectControlller::class, 'getAllDepartments'])->name('home');
Route::post('/showAppointment', [ProjectControlller::class, 'showAppointment'])->name('showAppointment')->middleware('auth');
Route::post('/bookAppoint', [ProjectControlller::class, 'bookAppointment'])->name('bookAppointment')->middleware('auth');
Route::get('/myBookings', [ProjectControlller::class, 'myBookings'])->name('myBooking')->middleware('auth');
Route::post('/cancelBooking', [ProjectControlller::class, 'cancelBooking'])->name('cancelBooking')->middleware('auth');
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
