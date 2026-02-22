<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('root');

Route::get('/register', [RegisterController::class, 'create'])->name('signup');

Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [SessionController::class, 'create'])->name('signin');

Route::post('/login', [SessionController::class, 'store']);


Route::middleware('auth')->group(function () {
    Route::delete('/logout', [SessionController::class, 'destroy'])->name('logout');

    // Profile
    Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create');
    Route::get('/profile/{profile}', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/store', [ProfileController::class, 'storeOrUpdate'])->name('profile.store');


    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('profile.complete')->name('dashboard.index');


    Route::get('/enrollments', [EnrollmentController::class, 'index'])->name('enrollments.index');
    Route::post('/enrollments/{program}', [EnrollmentController::class, 'store'])->middleware('can:enrollIntoProgram,program')->name('enrollments.store');
    Route::delete('/enrollments/{program}', [EnrollmentController::class, 'destroy'])->middleware('can:deleteProgramEnrollment,program')->name('enrollments.destroy');


    // Route::get('/programs/search/', [ProgramController::class, 'search'])->name('programs.search');
    Route::get('/programs', [ProgramController::class, 'index'])->name('programs.index');
    Route::get('/programs/create', [ProgramController::class, 'create'])->middleware('can:create,App\Models\Program')->name('programs.create');
    Route::get('/programs/edit/{program}', [ProgramController::class, 'edit'])->middleware('can:create,App\Models\Program')->name('programs.edit');
    Route::get('/programs/show/{program}', [ProgramController::class, 'show'])->name('programs.show');
    Route::post('/programs', [ProgramController::class, 'store'])->middleware('can:create,App\Models\Program')->name('programs.store');
    Route::delete('/programs/{program}', [ProgramController::class, 'destroy'])->middleware('can:delete,program')->name('programs.destroy');
    Route::patch('/programs/{program}', [ProgramController::class, 'patch'])->middleware('can:update,program')->name('programs.patch');


    Route::get('/trainers', [TrainerController::class, 'index'])->name('trainers.index');
    Route::get('/trainers/programs', [TrainerController::class, 'indexPrograms'])->middleware('can:viewAny,App\Models\Program')->name('trainers.index.programs');
    Route::get('/trainers/clients', [TrainerController::class, 'indexClients'])->middleware('can:viewAny,App\Models\Program')->name('trainers.index.clients');
    Route::get('/trainers/{trainer}', [TrainerController::class, 'show'])->name('trainers.show');


    Route::post('/review/{program}', [ReviewsController::class, 'store'])->name('review.store');
    Route::delete('/review/{review}/{program}', [ReviewsController::class, 'delete'])->name('review.delete');


    Route::get('/notifications', [NotificationController::class, 'index'])->name('notification.index');

});


Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    Route::get('/admin/{controller}/{method}/{id?}', [AdminController::class, 'callControllerMethod'])->name('admin.callControllerMethod');

    Route::patch('/admin/{controller}/{method}/{id}', [AdminController::class, 'callControllerMethodForPatch'])->name('admin.callControllerMethodForPatch');

    Route::post('/admin/{controller}/{method}/{id?}', [AdminController::class, 'callControllerMethodForPost'])->name('admin.callControllerMethodForPost');
});