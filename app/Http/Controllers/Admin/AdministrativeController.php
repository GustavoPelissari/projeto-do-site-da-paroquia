<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Group;
use App\Models\Mass;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdministrativeController extends Controller
{
    /**
     * Dashboard específico para administrativos
     */
    public function dashboard()
    {
        // Apenas administrativos podem acessar
        $userRole = Auth::user()->role;
        $roleValue = $userRole instanceof \App\Enums\UserRole ? $userRole->value : $userRole;

        if ($roleValue !== 'administrativo') {
            abort(403, 'Acesso negado.');
        }

        // Estatísticas limitadas para administrativo
        $stats = [
            'total_news' => News::count(),
            'total_events' => Event::count(),
            'total_masses' => Mass::count(),
            'my_news' => News::where('created_by', Auth::id())->count(),
            'my_events' => Event::where('created_by', Auth::id())->count(),
        ];

        return view('admin.administrativo.dashboard', compact('stats'));
    }

    /**
     * News Management - Limited (can't edit global news)
     */
    public function newsIndex()
    {
        $news = News::where(function ($query) {
            $query->where('created_by', Auth::id())
                ->orWhere('scope', '!=', 'global');
        })->latest()->paginate(10);

        return view('admin.administrativo.news.index', compact('news'));
    }

    public function newsCreate()
    {
        return view('admin.administrativo.news.create');
    }

    public function newsStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'scope' => 'required|in:parish,group',
            'group_id' => 'nullable|exists:groups,id',
        ]);

        // Administrativos não podem criar notícias globais
        if ($validated['scope'] === 'global') {
            abort(403, 'Você não tem permissão para criar notícias globais.');
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('news', 'public');
        }

        $validated['created_by'] = Auth::id();
        $validated['status'] = 'pending'; // Administrativos precisam de aprovação

        News::create($validated);

        return redirect()->route('admin.administrativo.news.index')
            ->with('success', 'Notícia criada com sucesso e aguardando aprovação.');
    }

    public function newsShow(News $news)
    {
        // Pode ver apenas suas próprias notícias ou não-globais
        if ($news->created_by !== Auth::id() && $news->scope === 'global') {
            abort(403, 'Acesso negado.');
        }

        return view('admin.administrativo.news.show', compact('news'));
    }

    public function newsEdit(News $news)
    {
        // Pode editar apenas suas próprias notícias
        if ($news->created_by !== Auth::id()) {
            abort(403, 'Você só pode editar suas próprias notícias.');
        }

        return view('admin.administrativo.news.edit', compact('news'));
    }

    public function newsUpdate(Request $request, News $news)
    {
        // Pode atualizar apenas suas próprias notícias
        if ($news->created_by !== Auth::id()) {
            abort(403, 'Você só pode editar suas próprias notícias.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'scope' => 'required|in:parish,group',
            'group_id' => 'nullable|exists:groups,id',
        ]);

        // Administrativos não podem definir scope como global
        if ($validated['scope'] === 'global') {
            abort(403, 'Você não tem permissão para criar notícias globais.');
        }

        if ($request->hasFile('image')) {
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $validated['image'] = $request->file('image')->store('news', 'public');
        }

        $validated['status'] = 'pending'; // Volta para aprovação após edição

        $news->update($validated);

        return redirect()->route('admin.administrativo.news.index')
            ->with('success', 'Notícia atualizada com sucesso.');
    }

    public function newsDestroy(News $news)
    {
        // Pode deletar apenas suas próprias notícias
        if ($news->created_by !== Auth::id()) {
            abort(403, 'Você só pode deletar suas próprias notícias.');
        }

        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return redirect()->route('admin.administrativo.news.index')
            ->with('success', 'Notícia deletada com sucesso.');
    }

    /**
     * Events Management - Limited
     */
    public function eventsIndex()
    {
        $events = Event::where(function ($query) {
            $query->where('created_by', Auth::id())
                ->orWhere('category', '!=', 'global');
        })->latest()->paginate(10);

        return view('admin.administrativo.events.index', compact('events'));
    }

    public function eventsCreate()
    {
        return view('admin.administrativo.events.create');
    }

    public function eventsStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required|string|max:255',
            'category' => 'required|in:parish,liturgy,group',
            'group_id' => 'nullable|exists:groups,id',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['status'] = 'pending'; // Administrativos precisam de aprovação

        Event::create($validated);

        return redirect()->route('admin.administrativo.events.index')
            ->with('success', 'Evento criado com sucesso e aguardando aprovação.');
    }

    public function eventsShow(Event $event)
    {
        // Pode ver apenas seus próprios eventos ou não-globais
        if ($event->created_by !== Auth::id() && $event->category === 'global') {
            abort(403, 'Acesso negado.');
        }

        return view('admin.administrativo.events.show', compact('event'));
    }

    public function eventsEdit(Event $event)
    {
        // Pode editar apenas seus próprios eventos
        if ($event->created_by !== Auth::id()) {
            abort(403, 'Você só pode editar seus próprios eventos.');
        }

        return view('admin.administrativo.events.edit', compact('event'));
    }

    public function eventsUpdate(Request $request, Event $event)
    {
        // Pode atualizar apenas seus próprios eventos
        if ($event->created_by !== Auth::id()) {
            abort(403, 'Você só pode editar seus próprios eventos.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required|string|max:255',
            'category' => 'required|in:parish,liturgy,group',
            'group_id' => 'nullable|exists:groups,id',
        ]);

        $validated['status'] = 'pending'; // Volta para aprovação após edição

        $event->update($validated);

        return redirect()->route('admin.administrativo.events.index')
            ->with('success', 'Evento atualizado com sucesso.');
    }

    public function eventsDestroy(Event $event)
    {
        // Pode deletar apenas seus próprios eventos
        if ($event->created_by !== Auth::id()) {
            abort(403, 'Você só pode deletar seus próprios eventos.');
        }

        $event->delete();

        return redirect()->route('admin.administrativo.events.index')
            ->with('success', 'Evento deletado com sucesso.');
    }

    /**
     * Masses Management
     */
    public function massesIndex()
    {
        $masses = Mass::latest()->paginate(10);

        return view('admin.administrativo.masses.index', compact('masses'));
    }

    public function massesCreate()
    {
        return view('admin.administrativo.masses.create');
    }

    public function massesStore(Request $request)
    {
        $validated = $request->validate([
            'day_of_week' => 'required|in:sunday,monday,tuesday,wednesday,thursday,friday,saturday',
            'time' => 'required|date_format:H:i',
            'location' => 'required|in:Paróquia São Paulo Apóstolo,Capela Santo Antônio,Capela Nossa Senhora de Fátima',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Mass::create($validated);

        return redirect()->route('admin.administrativo.masses.index')
            ->with('success', 'Horário de missa criado com sucesso!');
    }

    public function massesShow(Mass $mass)
    {
        return view('admin.administrativo.masses.show', compact('mass'));
    }

    public function massesEdit(Mass $mass)
    {
        return view('admin.administrativo.masses.edit', compact('mass'));
    }

    public function massesUpdate(Request $request, Mass $mass)
    {
        $validated = $request->validate([
            'day_of_week' => 'required|in:sunday,monday,tuesday,wednesday,thursday,friday,saturday',
            'time' => 'required|date_format:H:i',
            'location' => 'required|in:Paróquia São Paulo Apóstolo,Capela Santo Antônio,Capela Nossa Senhora de Fátima',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $mass->update($validated);

        return redirect()->route('admin.administrativo.masses.index')
            ->with('success', 'Horário de missa atualizado com sucesso!');
    }

    public function massesDestroy(Mass $mass)
    {
        $mass->delete();

        return redirect()->route('admin.administrativo.masses.index')
            ->with('success', 'Horário de missa excluído com sucesso!');
    }

    /**
     * Groups Management - Full CRUD
     */
    public function groupsIndex()
    {
        $groups = Group::orderBy('name')->paginate(10);
        return view('admin.administrativo.groups.index', compact('groups'));
    }

    public function groupsCreate()
    {
        return view('admin.administrativo.groups.create');
    }

    public function groupsStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'coordinator_name' => 'nullable|string|max:255',
            'coordinator_phone' => 'nullable|string|max:20',
            'meeting_info' => 'nullable|string|max:255',
            'category' => 'nullable|string|in:catequese,liturgia,familia,juventude,geral',
            'max_members' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('groups', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        Group::create($validated);

        return redirect()->route('admin.administrativo.groups.index')
            ->with('success', 'Grupo criado com sucesso!');
    }

    public function groupsShow(Group $group)
    {
        return view('admin.administrativo.groups.show', compact('group'));
    }

    public function groupsEdit(Group $group)
    {
        return view('admin.administrativo.groups.edit', compact('group'));
    }

    public function groupsUpdate(Request $request, Group $group)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'coordinator_name' => 'nullable|string|max:255',
            'coordinator_phone' => 'nullable|string|max:20',
            'meeting_info' => 'nullable|string|max:255',
            'category' => 'nullable|string|in:catequese,liturgia,familia,juventude,geral',
            'max_members' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($group->image) {
                Storage::disk('public')->delete($group->image);
            }
            $validated['image'] = $request->file('image')->store('groups', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $group->update($validated);

        return redirect()->route('admin.administrativo.groups.index')
            ->with('success', 'Grupo atualizado com sucesso!');
    }

    public function groupsDestroy(Group $group)
    {
        if ($group->image) {
            Storage::disk('public')->delete($group->image);
        }

        $group->delete();

        return redirect()->route('admin.administrativo.groups.index')
            ->with('success', 'Grupo excluído com sucesso!');
    }
}
