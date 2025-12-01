<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Models\Event;
use App\Models\Group;
use App\Models\GroupRequest;
use App\Models\Mass;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
     * Update user role
     */
    public function updateUserRole(Request $request, User $user)
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        $validated = $request->validate([
            'role' => 'required|in:admin_global,coordenador_de_pastoral,administrativo,usuario_padrao',
        ]);

        $user->update(['role' => $validated['role']]);

        return redirect()->route('admin.global.users')
            ->with('success', 'Função do usuário atualizada com sucesso!');
    }

    /**
     * Delete user
     */
    public function deleteUser(User $user)
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        // Prevent admin from deleting themselves
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.global.users')
                ->with('error', 'Você não pode excluir sua própria conta.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.global.users')
            ->with('success', "Usuário '{$userName}' excluído com sucesso!");
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
        $user = Auth::user();
        
        // Permite admin_global e coordenadores acessarem
        if (!in_array($user->role->value, ['admin_global', 'coordenador_de_pastoral'])) {
            abort(403, 'Acesso negado.');
        }

        // Admin global vê todas as notícias, coordenadores veem apenas as suas
        if ($user->role->value === 'admin_global') {
            $news = News::with('user')->latest()->paginate(10);
        } else {
            $news = News::with('user')->where('user_id', $user->id)->latest()->paginate(10);
        }

        return view('admin.global.news.index', compact('news'));
    }

    public function newsCreate()
    {
        $user = Auth::user();
        
        // Permite admin_global e coordenadores criarem notícias
        if (!in_array($user->role->value, ['admin_global', 'coordenador_de_pastoral'])) {
            abort(403, 'Acesso negado.');
        }

        return view('admin.global.news.create');
    }

    public function newsStore(StoreNewsRequest $request)
    {
        // Permite admin_global e coordenadores criarem notícias
        $user = Auth::user();
        if (!in_array($user->role->value, ['admin_global', 'coordenador_de_pastoral'])) {
            abort(403, 'Você não tem permissão para criar notícias.');
        }

        Log::info('=== INICIO DO UPLOAD DE NOTÍCIA ===');
        Log::info('Usuário: ' . $user->email);
        Log::info('Arquivos no request: ' . json_encode($request->allFiles()));
        Log::info('Tem arquivo featured_image? ' . ($request->hasFile('featured_image') ? 'SIM' : 'NÃO'));

        $validated = $request->validated();

        $validated['user_id'] = Auth::id();

        // Processar upload da imagem se houver
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            Log::info('Arquivo detectado: ' . $file->getClientOriginalName() . ' - Tamanho: ' . $file->getSize() . ' bytes');
            
            $validated['featured_image'] = $file->store('news', 'public');
            Log::info('Imagem salva em: ' . $validated['featured_image']);
        } else {
            Log::info('Nenhuma imagem foi enviada no request');
        }

        Log::info('Dados validados: ' . json_encode($validated));
        
        $news = News::create($validated);
        
        Log::info('Notícia criada com ID: ' . $news->id);
        Log::info('=== FIM DO UPLOAD DE NOTÍCIA ===');

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
        $user = Auth::user();
        
        // Admin global pode editar qualquer notícia
        // Coordenadores podem editar apenas suas próprias notícias
        if ($user->role->value !== 'admin_global' && $news->user_id !== $user->id) {
            abort(403, 'Você não tem permissão para editar esta notícia.');
        }

        return view('admin.global.news.edit', compact('news'));
    }

    public function newsUpdate(UpdateNewsRequest $request, News $news)
    {
        $user = Auth::user();
        
        // Admin global pode atualizar qualquer notícia
        // Coordenadores podem atualizar apenas suas próprias notícias
        if ($user->role->value !== 'admin_global' && $news->user_id !== $user->id) {
            abort(403, 'Você não tem permissão para editar esta notícia.');
        }

        $validated = $request->validated();

        // Processar upload da imagem se houver
        if ($request->hasFile('featured_image')) {
            // Deletar imagem antiga se existir
            if ($news->featured_image && Storage::disk('public')->exists($news->featured_image)) {
                Storage::disk('public')->delete($news->featured_image);
            }
            
            $validated['featured_image'] = $request->file('featured_image')->store('news', 'public');
        }

        $news->update($validated);

        return redirect()->route('admin.global.news.index')
            ->with('success', 'Notícia atualizada com sucesso!');
    }

    public function newsDestroy(News $news)
    {
        $user = Auth::user();
        
        // Admin global pode deletar qualquer notícia
        // Coordenadores podem deletar apenas suas próprias notícias
        if ($user->role->value !== 'admin_global' && $news->user_id !== $user->id) {
            abort(403, 'Você não tem permissão para excluir esta notícia.');
        }

        // Deletar imagem se existir
        if ($news->featured_image && Storage::disk('public')->exists($news->featured_image)) {
            Storage::disk('public')->delete($news->featured_image);
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

    public function eventsStore(StoreEventRequest $request)
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        $validated = $request->validated();

        $validated['user_id'] = Auth::id();

        // Upload de imagem
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

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

    public function eventsUpdate(UpdateEventRequest $request, Event $event)
    {
        if (Auth::user()->role->value !== 'admin_global') {
            abort(403, 'Acesso negado.');
        }

        $validated = $request->validated();

        // Remover imagem se solicitado
        if ($request->has('remove_image') && $request->remove_image) {
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
                $validated['image'] = null;
            }
        }

        // Upload de nova imagem
        if ($request->hasFile('image')) {
            // Remove imagem antiga se existir
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

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
            'coordinator_name' => 'nullable|string|max:255',
            'coordinator_phone' => 'nullable|string|max:20',
            'coordinator_email' => 'nullable|email|max:255',
            'meeting_info' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_image' => 'nullable|boolean',
            'is_active' => 'boolean',
        ]);

        // Remover imagem se solicitado
        if ($request->has('remove_image') && $request->remove_image) {
            if ($group->image) {
                Storage::disk('public')->delete($group->image);
                $validated['image'] = null;
            }
        }

        // Upload de nova imagem
        if ($request->hasFile('image')) {
            // Remover imagem antiga se existir
            if ($group->image) {
                Storage::disk('public')->delete($group->image);
            }
            $validated['image'] = $request->file('image')->store('groups', 'public');
        }

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
            'day_of_week' => 'required|in:sunday,monday,tuesday,wednesday,thursday,friday,saturday',
            'time' => 'required|date_format:H:i',
            'location' => 'required|string|max:255',
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
            'day_of_week' => 'required|in:sunday,monday,tuesday,wednesday,thursday,friday,saturday',
            'time' => 'required|date_format:H:i',
            'location' => 'required|string|max:255',
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
