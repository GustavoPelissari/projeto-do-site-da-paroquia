<?php

use App\Http\Controllers\Admin\AdminGlobalController;
use App\Http\Controllers\Admin\CoordinatorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\MassController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\GroupRequestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/missas', [HomeController::class, 'masses'])->name('masses');
Route::get('/grupos', [HomeController::class, 'groups'])->name('groups');
Route::get('/grupos/{group}/escalas', [ScheduleController::class, 'publicView'])->name('schedules.public');

// Auth routes that redirect to admin
Route::get('/dashboard', function () {
    // Debug: vamos verificar o role do usuário
    if (Auth::check()) {
        $user = Auth::user();
        $userRole = $user->role;

        // Convert enum to string value
        $roleValue = $userRole instanceof \App\Enums\UserRole ? $userRole->value : $userRole;

        // Log para debug
        Log::info('Dashboard redirect - User: '.$user->email.', Role: '.$roleValue);

        if ($roleValue === 'admin_global') {
            return redirect()->route('admin.global.dashboard');
        } elseif ($roleValue === 'coordenador_de_pastoral') {
            return redirect()->route('admin.coordinator.dashboard');
        }
    }

    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Global routes (exclusive for priest - admin_global role)
Route::middleware(['auth', 'role:admin_global'])->prefix('admin/global')->name('admin.global.')->group(function () {
    Route::get('/', [AdminGlobalController::class, 'dashboard'])->name('dashboard');
    Route::get('/system-overview', [AdminGlobalController::class, 'systemOverview'])->name('system-overview');
    Route::get('/manage-users', [AdminGlobalController::class, 'manageUsers'])->name('manage-users');
    Route::get('/parish-stats', [AdminGlobalController::class, 'parishStats'])->name('parish-stats');
});

// Coordinator routes (exclusive for coordinators)
Route::middleware(['auth'])->prefix('admin/coordinator')->name('admin.coordinator.')->group(function () {
    Route::get('/', [CoordinatorController::class, 'dashboard'])->name('dashboard');

    // News management (only own news)
    Route::get('/news', [CoordinatorController::class, 'newsIndex'])->name('news.index');
    Route::get('/news/create', [CoordinatorController::class, 'newsCreate'])->name('news.create');
    Route::post('/news', [CoordinatorController::class, 'newsStore'])->name('news.store');
    Route::get('/news/{news}/edit', [CoordinatorController::class, 'newsEdit'])->name('news.edit');
    Route::put('/news/{news}', [CoordinatorController::class, 'newsUpdate'])->name('news.update');

    // Events management (only own events)
    Route::get('/events', [CoordinatorController::class, 'eventsIndex'])->name('events.index');
    Route::get('/events/create', [CoordinatorController::class, 'eventsCreate'])->name('events.create');
    Route::post('/events', [CoordinatorController::class, 'eventsStore'])->name('events.store');
    Route::get('/events/{event}/edit', [CoordinatorController::class, 'eventsEdit'])->name('events.edit');
    Route::put('/events/{event}', [CoordinatorController::class, 'eventsUpdate'])->name('events.update');

    // Requests management
    Route::get('/requests', [CoordinatorController::class, 'requests'])->name('requests.index');
    Route::post('/requests/{groupRequest}/approve', [CoordinatorController::class, 'approveRequest'])->name('requests.approve');
    Route::post('/requests/{groupRequest}/reject', [CoordinatorController::class, 'rejectRequest'])->name('requests.reject');

    // Schedules management
    Route::get('/schedules', [CoordinatorController::class, 'schedules'])->name('schedules.index');
    Route::post('/schedules/upload', [CoordinatorController::class, 'uploadSchedule'])->name('schedules.upload');

    // Masses management
    Route::get('/masses', [CoordinatorController::class, 'masses'])->name('masses.index');
    Route::get('/masses/create', [CoordinatorController::class, 'massesCreate'])->name('masses.create');
    Route::post('/masses', [CoordinatorController::class, 'massesStore'])->name('masses.store');
});

// Admin routes (protected by auth and role)
Route::middleware(['auth', 'role:admin_global,administrativo,coordenador_pastoral'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // News management - Admins, administrativos and coordenadores can manage
    Route::resource('news', AdminNewsController::class);

    // Mass schedules management - Only admins and administrativos
    Route::middleware('role:manage_masses')->group(function () {
        Route::resource('masses', MassController::class);
    });

    // Groups management - Only admin_global can fully manage
    Route::middleware('role:manage_groups')->group(function () {
        Route::resource('groups', GroupController::class);
    });

    // Events management - Admins, administrativos and coordenadores can manage
    Route::resource('events', EventController::class);

    // Schedules management - admin_global and coordenadores
    Route::middleware('role:manage_schedules')->group(function () {
        Route::resource('schedules', ScheduleController::class);
        Route::get('schedules/{schedule}/download', [ScheduleController::class, 'download'])->name('schedules.download');
    });
});

// Group requests system
Route::middleware('auth')->group(function () {
    // For regular users to request group membership
    Route::get('/solicitar-grupo', [GroupRequestController::class, 'create'])->name('group-requests.create');
    Route::post('/solicitar-grupo', [GroupRequestController::class, 'store'])->name('group-requests.store');
    Route::get('/minhas-solicitacoes', [GroupRequestController::class, 'myRequests'])->name('group-requests.my-requests');

    // For coordinators and admins to manage requests
    Route::middleware('role:approve_requests')->group(function () {
        Route::get('/admin/solicitacoes', [GroupRequestController::class, 'index'])->name('group-requests.index');
        Route::get('/admin/solicitacoes/{groupRequest}', [GroupRequestController::class, 'show'])->name('group-requests.show');
        Route::post('/admin/solicitacoes/{groupRequest}/aprovar', [GroupRequestController::class, 'approve'])->name('group-requests.approve');
        Route::post('/admin/solicitacoes/{groupRequest}/rejeitar', [GroupRequestController::class, 'reject'])->name('group-requests.reject');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
