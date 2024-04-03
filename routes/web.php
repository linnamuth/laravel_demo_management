<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\MissionControlller;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StatusRequestController;
use App\Http\Controllers\WorkflowController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('leaves', LeaveRequestController::class);
    Route::resource('missions', MissionControlller::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('dashboards', dashboardController::class);



    Route::get('leave-request/create', [LeaveRequestController::class, 'create'])->name('leave-request.create');

    // Route to store leave requests
    Route::post('leave-request', [LeaveRequestController::class, 'store'])->name('leave-request.store');

    // Route to display leave requests
    Route::get('leave-requests', [LeaveRequestController::class, 'index'])->name('leave-requests.index');
    Route::get('leave-request/status', [StatusRequestController::class, 'status'])->name('leave-mission.status');

    Route::get('mission-request/status', [StatusRequestController::class, 'statusMissionRequest'])->name('mission-leave.status');


    Route::post('/leave-requests/{id}/approve', [LeaveRequestController::class, 'approves'])->name('leave-requests.approve');
    Route::post('/leave-requests/{id}/reject',  [LeaveRequestController::class, 'reject'])->name('leave-requests.reject');

    // Routes for Departments
    Route::get('/departments/create', [DepartmentController::class, 'create'])->name('departments.create');
    Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
    Route::get('/departments/{department}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');
    Route::put('/departments/{department}', [DepartmentController::class, 'update'])->name('departments.update');
    Route::delete('/departments/{department}', [DepartmentController::class, 'destroy'])->name('departments.destroy');




    /// Routes for mission requests
    Route::get('mission-requests', [MissionControlller::class, 'index'])->name('mission_requests.index');
    Route::get('mission-requests/create', [MissionControlller::class, 'create'])->name('mission_requests.create');
    Route::post('mission-requests', [MissionControlller::class, 'store'])->name('mission_requests.store');

    Route::post('/mission-leaves/{id}/approves', [MissionControlller::class, 'approveMission'])
        ->name('mission-leave.approve');
    Route::post('/mission-leaves/{id}/rejects', [MissionControlller::class, 'reject'])
        ->name('mission-leaves.reject');


    // Routes for department management
    Route::get('departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::get('departments/create', [DepartmentController::class, 'create'])->name('departments.create');
    Route::post('departments', [DepartmentController::class, 'store'])->name('departments.store');

    // Routes for user management
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::put('users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // Routes for admin functionalities
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/permissions', [AdminController::class, 'permissions'])->name('admin.permissions');
    Route::get('admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
});

require __DIR__ . '/auth.php';
