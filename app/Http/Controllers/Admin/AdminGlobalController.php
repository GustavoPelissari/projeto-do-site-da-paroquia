<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Group;
use App\Models\GroupRequest;
use App\Models\Mass;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminGlobalController extends Controller
{
    /**
     * Display the admin global dashboard for the priest
     */
    public function dashboard()
    {
        // Ensure only admin_global can access this
        $user = Auth::user();
        if ($user->role->value !== 'admin_global') {
            abort(403, 'Acesso negado. Apenas o Padre (admin global) pode acessar esta área.');
        }

        // Comprehensive statistics for the priest
        $stats = [
            'users_count' => User::count(),
            'active_users' => User::where('role', '!=', 'visitante')->count(),
            'coordinators_count' => User::where('role', 'coordenador_de_pastoral')->count(),
            'admin_users' => User::where('role', 'administrativo')->count(),

            'groups_count' => Group::active()->count(),
            'total_groups' => Group::count(),

            'masses_count' => Mass::active()->count(),
            'total_masses' => Mass::count(),

            'news_count' => News::count(),
            'published_news' => News::published()->count(),
            'draft_news' => News::draft()->count(),

            'events_count' => Event::count(),
            'upcoming_events' => Event::upcoming()->count(),
            'past_events' => Event::where('start_date', '<', now())->count(),

            'pending_requests' => GroupRequest::pending()->count(),
            'approved_requests' => GroupRequest::approved()->count(),
            'total_requests' => GroupRequest::count(),
        ];

        // Recent activity data
        $recent_news = News::with('user')
            ->latest()
            ->take(5)
            ->get();

        $upcoming_events = Event::with('user')
            ->upcoming()
            ->orderBy('start_date')
            ->take(5)
            ->get();

        $recent_requests = GroupRequest::with(['user', 'group'])
            ->latest()
            ->take(3)
            ->get();

        $recent_users = User::where('created_at', '>=', now()->subDays(30))
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.global.dashboard', compact(
            'stats',
            'recent_news',
            'upcoming_events',
            'recent_requests',
            'recent_users'
        ));
    }

    /**
     * Show system overview for admin global
     */
    public function systemOverview()
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        // System health and overview data
        $overview = [
            'system_status' => 'operational',
            'last_backup' => now()->subDays(1),
            'total_storage_used' => '2.3 GB',
            'monthly_visitors' => 1250,
            'active_sessions' => User::whereNotNull('last_login_at')
                ->where('last_login_at', '>=', now()->subHours(24))
                ->count(),
        ];

        return view('admin.global.system-overview', compact('overview'));
    }

    /**
     * Manage users - exclusive to admin global
     */
    public function manageUsers()
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        $users = User::with(['parishGroup'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.global.manage-users', compact('users'));
    }

    /**
     * Show parish statistics
     */
    public function parishStats()
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        $stats = [
            'monthly_stats' => [
                'new_members' => User::whereMonth('created_at', now()->month)->count(),
                'events_held' => Event::whereMonth('date', now()->month)
                    ->where('date', '<', now())
                    ->count(),
                'news_published' => News::whereMonth('created_at', now()->month)
                    ->published()
                    ->count(),
                'group_requests' => GroupRequest::whereMonth('created_at', now()->month)->count(),
            ],
            'yearly_stats' => [
                'total_members_joined' => User::whereYear('created_at', now()->year)->count(),
                'total_events' => Event::whereYear('date', now()->year)->count(),
                'total_news' => News::whereYear('created_at', now()->year)->count(),
                'groups_created' => Group::whereYear('created_at', now()->year)->count(),
            ],
            'top_groups' => Group::withCount('members')
                ->orderBy('members_count', 'desc')
                ->take(5)
                ->get(),
        ];

        return view('admin.global.parish-stats', compact('stats'));
    }

    // News Management Methods
    public function newsIndex()
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        $news = News::with('user')->latest()->paginate(10);

        return view('admin.global.news.index', compact('news'));
    }

    public function newsCreate()
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        return view('admin.global.news.create');
    }

    public function newsStore(Request $request)
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:published,draft',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        $validated['user_id'] = Auth::id();

        $news = News::create($validated);

        return redirect()->route('admin.global.news.index')
            ->with('success', 'Notícia criada com sucesso!');
    }

    public function newsShow(News $news)
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        return view('admin.global.news.show', compact('news'));
    }

    public function newsEdit(News $news)
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        return view('admin.global.news.edit', compact('news'));
    }

    public function newsUpdate(Request $request, News $news)
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:published,draft',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        $news->update($validated);

        return redirect()->route('admin.global.news.index')
            ->with('success', 'Notícia atualizada com sucesso!');
    }

    public function newsDestroy(News $news)
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        $news->delete();

        return redirect()->route('admin.global.news.index')
            ->with('success', 'Notícia excluída com sucesso!');
    }

    // Events Management Methods
    public function eventsIndex()
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        $events = Event::with('user')->latest()->paginate(10);

        return view('admin.global.events.index', compact('events'));
    }

    public function eventsCreate()
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        return view('admin.global.events.create');
    }

    public function eventsStore(Request $request)
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'category' => 'required|string|max:100',
        ]);

        $validated['user_id'] = Auth::id();

        $event = Event::create($validated);

        return redirect()->route('admin.global.events.index')
            ->with('success', 'Evento criado com sucesso!');
    }

    public function eventsShow(Event $event)
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        return view('admin.global.events.show', compact('event'));
    }

    public function eventsEdit(Event $event)
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        return view('admin.global.events.edit', compact('event'));
    }

    public function eventsUpdate(Request $request, Event $event)
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'category' => 'required|string|max:100',
        ]);

        $event->update($validated);

        return redirect()->route('admin.global.events.index')
            ->with('success', 'Evento atualizado com sucesso!');
    }

    public function eventsDestroy(Event $event)
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        $event->delete();

        return redirect()->route('admin.global.events.index')
            ->with('success', 'Evento excluído com sucesso!');
    }

    // Groups Management Methods
    public function groupsIndex()
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

    $groups = Group::withCount('members')->latest()->paginate(10);

        return view('admin.global.groups.index', compact('groups'));
    }

    public function groupsCreate()
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        return view('admin.global.groups.create');
    }

    public function groupsStore(Request $request)
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:100',
            'max_members' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $group = Group::create($validated);

        return redirect()->route('admin.global.groups.index')
            ->with('success', 'Grupo criado com sucesso!');
    }

    public function groupsShow(Group $group)
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

    $group->load(['members', 'groupRequests']);

        return view('admin.global.groups.show', compact('group'));
    }

    public function groupsEdit(Group $group)
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        return view('admin.global.groups.edit', compact('group'));
    }

    public function groupsUpdate(Request $request, Group $group)
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:100',
            'max_members' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $group->update($validated);

        return redirect()->route('admin.global.groups.index')
            ->with('success', 'Grupo atualizado com sucesso!');
    }

    public function groupsDestroy(Group $group)
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        $group->delete();

        return redirect()->route('admin.global.groups.index')
            ->with('success', 'Grupo excluído com sucesso!');
    }

    // Masses Management Methods
    public function massesIndex()
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        $masses = Mass::latest()->paginate(10);

        return view('admin.global.masses.index', compact('masses'));
    }

    public function massesCreate()
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        return view('admin.global.masses.create');
    }

    public function massesStore(Request $request)
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'day_of_week' => 'required|in:sunday,monday,tuesday,wednesday,thursday,friday,saturday',
            'time' => 'required|date_format:H:i',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $mass = Mass::create($validated);

        return redirect()->route('admin.global.masses.index')
            ->with('success', 'Horário de missa criado com sucesso!');
    }

    public function massesShow(Mass $mass)
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        return view('admin.global.masses.show', compact('mass'));
    }

    public function massesEdit(Mass $mass)
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        return view('admin.global.masses.edit', compact('mass'));
    }

    public function massesUpdate(Request $request, Mass $mass)
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'day_of_week' => 'required|in:sunday,monday,tuesday,wednesday,thursday,friday,saturday',
            'time' => 'required|date_format:H:i',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $mass->update($validated);

        return redirect()->route('admin.global.masses.index')
            ->with('success', 'Horário de missa atualizado com sucesso!');
    }

    public function massesDestroy(Mass $mass)
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        $mass->delete();

        return redirect()->route('admin.global.masses.index')
            ->with('success', 'Horário de missa excluído com sucesso!');
    }
}
