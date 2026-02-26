<?php

use App\Http\Controllers\Admin\AdminGlobalController;
use App\Http\Controllers\Admin\AdministrativeController;
use App\Http\Controllers\Admin\CoordinatorController;
use App\Http\Controllers\GroupRequestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rotas públicas - acessíveis sem autenticação
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);

Route::get('/groups', [HomeController::class, 'groups'])->name('groups');
Route::get('/masses', [HomeController::class, 'masses'])->name('masses');
Route::get('/events', [HomeController::class, 'events'])->name('events');
Route::get('/events/{event}', [HomeController::class, 'showEvent'])->name('events.show');
Route::get('/news', [HomeController::class, 'news'])->name('news');
Route::get('/news/{news}', [HomeController::class, 'showNews'])->name('news.show');
Route::get('/sobre', [HomeController::class, 'about'])->name('about');

// Sitemap XML (SEO)
Route::get('/sitemap.xml', [SitemapController::class, 'index']);

// Robots.txt
Route::get('/robots.txt', function() {
    $content = "User-agent: *\n";
    $content .= "Allow: /\n";
    $content .= "Disallow: /admin\n";
    $content .= "Disallow: /dashboard\n";
    $content .= "Disallow: /login\n";
    $content .= "Sitemap: " . url('/sitemap.xml') . "\n";
    return response($content, 200, ['Content-Type' => 'text/plain']);
});

// Group requests routes (require email verification)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/group-requests/create', [GroupRequestController::class, 'create'])->name('group-requests.create');
    Route::post('/group-requests', [GroupRequestController::class, 'store'])->name('group-requests.store');
    Route::get('/group-requests', [GroupRequestController::class, 'index'])->name('group-requests.index');
    Route::get('/minhas-solicitacoes', [GroupRequestController::class, 'myRequests'])->name('group-requests.my-requests');
});

// Notifications (auth only, no verification required)
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationsController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationsController::class, 'markAsRead'])->name('notifications.read');
});

// Auth routes that redirect to admin
Route::get('/dashboard', function () {
    if (Auth::check()) {
        $user = Auth::user();
        $userRole = $user->role;

        // Convert enum to string value
        $roleValue = $userRole instanceof \App\Enums\UserRole ? $userRole->value : $userRole;

        // Log para debug
        Log::info('Dashboard redirect - User: '.$user->email.', Role: '.$roleValue);

        // Redirect to appropriate admin area
        switch ($roleValue) {
            case 'admin_global':
                return redirect()->route('admin.global.dashboard');
            case 'coordenador_de_pastoral':
                return redirect()->route('admin.coordenador.dashboard');
            case 'administrativo':
                return redirect()->route('admin.administrativo.dashboard');
            case 'usuario_padrao':
                return redirect()->route('user.dashboard');
            default:
                return redirect()->route('home');
        }
    }

    return redirect()->route('login');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| User Dashboard (usuario_padrao role)
|--------------------------------------------------------------------------
*/
Route::prefix('user')->name('user.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'dashboard'])->name('dashboard');
    
    // Scales (apenas visualização para usuários do grupo Coroinhas)
    Route::prefix('scales')->name('scales.')->group(function () {
        Route::get('/', [UserDashboardController::class, 'scalesIndex'])->name('index');
        Route::get('/{scale}/download', [UserDashboardController::class, 'scalesDownload'])->name('download');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Global Routes (admin_global role only)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.global.')->middleware(['auth', 'admin.area:admin_global'])->group(function () {
    // Dashboard
    Route::get('/', [AdminGlobalController::class, 'dashboard'])->name('dashboard');

    // User Management
    Route::get('/users', [AdminGlobalController::class, 'manageUsers'])->name('users');
    Route::post('/users/{user}/role', [AdminGlobalController::class, 'updateUserRole'])->name('users.updateRole');
    Route::delete('/users/{user}', [AdminGlobalController::class, 'deleteUser'])->name('users.destroy');

    // Parish Statistics
    Route::get('/stats', [AdminGlobalController::class, 'parishStats'])->name('stats');

    // System Overview
    Route::get('/system', [AdminGlobalController::class, 'systemOverview'])->name('system');

    // News Management
    Route::prefix('news')->name('news.')->group(function () {
        Route::get('/', [AdminGlobalController::class, 'newsIndex'])->name('index');
        Route::get('/create', [AdminGlobalController::class, 'newsCreate'])->name('create');
        Route::post('/', [AdminGlobalController::class, 'newsStore'])->name('store');
        Route::get('/{news}', [AdminGlobalController::class, 'newsShow'])->name('show');
        Route::get('/{news}/edit', [AdminGlobalController::class, 'newsEdit'])->name('edit');
        Route::put('/{news}', [AdminGlobalController::class, 'newsUpdate'])->name('update');
        Route::delete('/{news}', [AdminGlobalController::class, 'newsDestroy'])->name('destroy');
    });

    // Events Management
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', [AdminGlobalController::class, 'eventsIndex'])->name('index');
        Route::get('/create', [AdminGlobalController::class, 'eventsCreate'])->name('create');
        Route::post('/', [AdminGlobalController::class, 'eventsStore'])->name('store');
        Route::get('/{event}', [AdminGlobalController::class, 'eventsShow'])->name('show');
        Route::get('/{event}/edit', [AdminGlobalController::class, 'eventsEdit'])->name('edit');
        Route::put('/{event}', [AdminGlobalController::class, 'eventsUpdate'])->name('update');
        Route::delete('/{event}', [AdminGlobalController::class, 'eventsDestroy'])->name('destroy');
    });

    // Groups Management
    Route::prefix('groups')->name('groups.')->group(function () {
        Route::get('/', [AdminGlobalController::class, 'groupsIndex'])->name('index');
        Route::get('/create', [AdminGlobalController::class, 'groupsCreate'])->name('create');
        Route::post('/', [AdminGlobalController::class, 'groupsStore'])->name('store');
        Route::get('/{group}', [AdminGlobalController::class, 'groupsShow'])->name('show');
        Route::get('/{group}/edit', [AdminGlobalController::class, 'groupsEdit'])->name('edit');
        Route::put('/{group}', [AdminGlobalController::class, 'groupsUpdate'])->name('update');
        Route::delete('/{group}', [AdminGlobalController::class, 'groupsDestroy'])->name('destroy');
    });

    // Masses Management
    Route::prefix('masses')->name('masses.')->group(function () {
        Route::get('/', [AdminGlobalController::class, 'massesIndex'])->name('index');
        Route::get('/create', [AdminGlobalController::class, 'massesCreate'])->name('create');
        Route::post('/', [AdminGlobalController::class, 'massesStore'])->name('store');
        Route::get('/{mass}', [AdminGlobalController::class, 'massesShow'])->name('show');
        Route::get('/{mass}/edit', [AdminGlobalController::class, 'massesEdit'])->name('edit');
        Route::put('/{mass}', [AdminGlobalController::class, 'massesUpdate'])->name('update');
        Route::delete('/{mass}', [AdminGlobalController::class, 'massesDestroy'])->name('destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Coordinator Routes (coordenador_de_pastoral role only)
|--------------------------------------------------------------------------
*/
Route::prefix('admin/coordenador')->name('admin.coordenador.')->middleware(['auth', 'admin.area:coordenador_de_pastoral'])->group(function () {
    // Dashboard
    Route::get('/', [CoordinatorController::class, 'dashboard'])->name('dashboard');

    // Restricted News Management (own group only)
    Route::prefix('news')->name('news.')->group(function () {
        Route::get('/', [CoordinatorController::class, 'newsIndex'])->name('index');
        Route::get('/create', [CoordinatorController::class, 'newsCreate'])->name('create');
        Route::post('/', [CoordinatorController::class, 'newsStore'])->name('store');
        Route::get('/{news}', [CoordinatorController::class, 'newsShow'])->name('show');
        Route::get('/{news}/edit', [CoordinatorController::class, 'newsEdit'])->name('edit');
        Route::put('/{news}', [CoordinatorController::class, 'newsUpdate'])->name('update');
        Route::delete('/{news}', [CoordinatorController::class, 'newsDestroy'])->name('destroy');
    });

    // Restricted Events Management (own group only)
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', [CoordinatorController::class, 'eventsIndex'])->name('index');
        Route::get('/create', [CoordinatorController::class, 'eventsCreate'])->name('create');
        Route::post('/', [CoordinatorController::class, 'eventsStore'])->name('store');
        Route::get('/{event}', [CoordinatorController::class, 'eventsShow'])->name('show');
        Route::get('/{event}/edit', [CoordinatorController::class, 'eventsEdit'])->name('edit');
        Route::put('/{event}', [CoordinatorController::class, 'eventsUpdate'])->name('update');
        Route::delete('/{event}', [CoordinatorController::class, 'eventsDestroy'])->name('destroy');
    });

    // Group Requests Management
    Route::prefix('requests')->name('requests.')->group(function () {
        Route::get('/', [CoordinatorController::class, 'requestsIndex'])->name('index');
        Route::post('/{request}/approve', [CoordinatorController::class, 'approveRequest'])->name('approve');
        Route::post('/{request}/reject', [CoordinatorController::class, 'rejectRequest'])->name('reject');
        Route::post('/{request}/formation', [CoordinatorController::class, 'markAsFormation'])->name('formation');
    });

    // Schedule Management
    Route::prefix('schedules')->name('schedules.')->group(function () {
        Route::get('/', [CoordinatorController::class, 'schedulesIndex'])->name('index');
        Route::get('/create', [CoordinatorController::class, 'schedulesCreate'])->name('create');
        Route::post('/', [CoordinatorController::class, 'schedulesStore'])->name('store');
        Route::get('/{schedule}/edit', [CoordinatorController::class, 'schedulesEdit'])->name('edit');
        Route::put('/{schedule}', [CoordinatorController::class, 'schedulesUpdate'])->name('update');
        Route::delete('/{schedule}', [CoordinatorController::class, 'schedulesDestroy'])->name('destroy');
    });

    // Scales Management (Escalas)
    Route::prefix('scales')->name('scales.')->group(function () {
        Route::get('/', [CoordinatorController::class, 'scalesIndex'])->name('index');
        Route::get('/create', [CoordinatorController::class, 'scalesCreate'])->name('create');
        Route::post('/', [CoordinatorController::class, 'scalesStore'])->name('store');
        Route::post('/upload', [CoordinatorController::class, 'scalesUpload'])->name('upload');
        Route::get('/{scale}/download', [CoordinatorController::class, 'scalesDownload'])->name('download');
        Route::get('/{scale}/edit', [CoordinatorController::class, 'scalesEdit'])->name('edit');
        Route::put('/{scale}', [CoordinatorController::class, 'scalesUpdate'])->name('update');
        Route::delete('/{scale}', [CoordinatorController::class, 'scalesDestroy'])->name('destroy');
    });

    // Mass Management (restricted - view only)
    Route::prefix('masses')->name('masses.')->group(function () {
        Route::get('/', [CoordinatorController::class, 'massesIndex'])->name('index');
        Route::get('/{mass}', [CoordinatorController::class, 'massesShow'])->name('show');
    });

    // Group Management (own group only)
    Route::prefix('group')->name('group.')->group(function () {
        Route::get('/edit', [CoordinatorController::class, 'groupEdit'])->name('edit');
        Route::put('/update', [CoordinatorController::class, 'groupUpdate'])->name('update');
    });
});

/*
|--------------------------------------------------------------------------
| Administrative Routes (administrativo role only)
|--------------------------------------------------------------------------
*/
Route::prefix('admin/administrativo')->name('admin.administrativo.')->middleware(['auth', 'admin.area:administrativo'])->group(function () {
    // Dashboard
    Route::get('/', [AdministrativeController::class, 'dashboard'])->name('dashboard');

    // Limited News Management (can't create global news)
    Route::prefix('news')->name('news.')->group(function () {
        Route::get('/', [AdministrativeController::class, 'newsIndex'])->name('index');
        Route::get('/create', [AdministrativeController::class, 'newsCreate'])->name('create');
        Route::post('/', [AdministrativeController::class, 'newsStore'])->name('store');
        Route::get('/{news}', [AdministrativeController::class, 'newsShow'])->name('show');
        Route::get('/{news}/edit', [AdministrativeController::class, 'newsEdit'])->name('edit');
        Route::put('/{news}', [AdministrativeController::class, 'newsUpdate'])->name('update');
        Route::delete('/{news}', [AdministrativeController::class, 'newsDestroy'])->name('destroy');
    });

    // Limited Events Management
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', [AdministrativeController::class, 'eventsIndex'])->name('index');
        Route::get('/create', [AdministrativeController::class, 'eventsCreate'])->name('create');
        Route::post('/', [AdministrativeController::class, 'eventsStore'])->name('store');
        Route::get('/{event}', [AdministrativeController::class, 'eventsShow'])->name('show');
        Route::get('/{event}/edit', [AdministrativeController::class, 'eventsEdit'])->name('edit');
        Route::put('/{event}', [AdministrativeController::class, 'eventsUpdate'])->name('update');
        Route::delete('/{event}', [AdministrativeController::class, 'eventsDestroy'])->name('destroy');
    });

    // Mass Management (view only)
    Route::prefix('masses')->name('masses.')->group(function () {
        Route::get('/', [AdministrativeController::class, 'massesIndex'])->name('index');
        Route::get('/create', [AdministrativeController::class, 'massesCreate'])->name('create');
        Route::post('/', [AdministrativeController::class, 'massesStore'])->name('store');
        Route::get('/{mass}', [AdministrativeController::class, 'massesShow'])->name('show');
        Route::get('/{mass}/edit', [AdministrativeController::class, 'massesEdit'])->name('edit');
        Route::put('/{mass}', [AdministrativeController::class, 'massesUpdate'])->name('update');
        Route::delete('/{mass}', [AdministrativeController::class, 'massesDestroy'])->name('destroy');
    });

    // Groups Management (can create and edit)
    Route::prefix('groups')->name('groups.')->group(function () {
        Route::get('/', [AdministrativeController::class, 'groupsIndex'])->name('index');
        Route::get('/create', [AdministrativeController::class, 'groupsCreate'])->name('create');
        Route::post('/', [AdministrativeController::class, 'groupsStore'])->name('store');
        Route::get('/{group}', [AdministrativeController::class, 'groupsShow'])->name('show');
        Route::get('/{group}/edit', [AdministrativeController::class, 'groupsEdit'])->name('edit');
        Route::put('/{group}', [AdministrativeController::class, 'groupsUpdate'])->name('update');
        Route::delete('/{group}', [AdministrativeController::class, 'groupsDestroy'])->name('destroy');
    });
});

require __DIR__.'/auth.php';
