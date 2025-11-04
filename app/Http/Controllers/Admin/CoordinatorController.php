<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\GroupRequest;
use App\Models\Mass;
use App\Models\News;
use App\Models\Scale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CoordinatorController extends Controller
{
    /**
     * Dashboard específico para coordenadores
     */
    public function dashboard()
    {
        $user = Auth::user();
        $userRole = $user->role;
        $roleValue = $userRole instanceof \App\Enums\UserRole ? $userRole->value : $userRole;

        if ($roleValue !== 'coordenador_de_pastoral') {
            abort(403, 'Acesso negado.');
        }

        // Verificar se o coordenador está associado a um grupo
        if (! $user->parish_group_id) {
            // Mostrar dashboard com aviso, ao invés de redirecionar
            $stats = [
                'grupo_nome' => 'Nenhum grupo associado',
                'membros_grupo' => 0,
                'noticias_grupo' => 0,
                'eventos_grupo' => 0,
                'solicitacoes_pendentes' => 0,
            ];

            $recent_news = collect();
            $upcoming_events = collect();
            $scales = collect();

            return view('admin.coordenador.dashboard', compact('stats', 'recent_news', 'upcoming_events', 'scales'))
                ->with('warning', 'Você precisa estar associado a um grupo para acessar todos os recursos. Entre em contato com o administrador.');
        }

        $userGroup = $user->parishGroup;

        // Estatísticas específicas para o grupo do coordenador
        $stats = [
            'grupo_nome' => $userGroup ? $userGroup->name : 'Nenhum grupo associado',
            'membros_grupo' => $userGroup ? User::where('parish_group_id', $user->parish_group_id)->count() : 0,
            'noticias_grupo' => News::where('group_id', $user->parish_group_id)->count(),
            'eventos_grupo' => Event::where('group_id', $user->parish_group_id)->count(),
            'solicitacoes_pendentes' => GroupRequest::where('parish_group_id', $user->parish_group_id)
                ->where('status', 'pending')->count(),
        ];

        // Notícias recentes do grupo
        $recent_news = News::where('group_id', $user->parish_group_id)
            ->latest()
            ->take(5)
            ->get();

        // Eventos futuros do grupo
        $upcoming_events = Event::where('group_id', $user->parish_group_id)
            ->where('date', '>=', now())
            ->latest()
            ->take(5)
            ->get();

        // Escalas do grupo
        $scales = Scale::where('group_id', $user->parish_group_id)
            ->latest()
            ->take(5)
            ->get();

        return view('admin.coordenador.dashboard', compact('stats', 'recent_news', 'upcoming_events', 'scales'));
    }

    /**
     * Lista notícias do coordenador (apenas do seu grupo)
     */
    public function newsIndex()
    {
        $user = Auth::user();

        if (! $user->parish_group_id) {
            $news = collect(); // Coleção vazia
            return view('admin.coordenador.news.index', compact('news'))
                ->with('warning', 'Você precisa estar associado a um grupo para acessar esta área.');
        }

        $news = News::where('parish_group_id', $user->parish_group_id)
            ->latest()
            ->paginate(10);

        return view('admin.coordenador.news.index', compact('news'));
    }

    /**
     * Criar nova notícia
     */
    public function newsCreate()
    {
        $user = Auth::user();

        if (! $user->parish_group_id) {
            return redirect()->route('admin.coordenador.dashboard')
                ->with('error', 'Você precisa estar associado a um grupo para criar notícias.');
        }

        return view('admin.coordenador.news.create');
    }

    /**
     * Salvar nova notícia (associada ao grupo do coordenador)
     */
    public function newsStore(Request $request)
    {
        $user = Auth::user();

        if (! $user->parish_group_id) {
            return redirect()->route('admin.coordenador.dashboard')
                ->with('error', 'Você precisa estar associado a um grupo para criar notícias.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'status' => 'required|in:published,draft',
        ]);

        News::create([
            'title' => $request->title,
            'content' => $request->content,
            'excerpt' => $request->excerpt,
            'status' => $request->status,
            'user_id' => Auth::id(),
            'parish_group_id' => $user->parish_group_id, // Associar ao grupo do coordenador
            'published_at' => $request->status === 'published' ? now() : null,
        ]);

        return redirect()->route('admin.coordenador.news.index')
            ->with('success', 'Notícia criada com sucesso!');
    }

    /**
     * Editar notícia (apenas do seu grupo)
     */
    public function newsEdit(News $news)
    {
        $user = Auth::user();

        // Verificar se a notícia pertence ao grupo do coordenador
        if ($news->group_id !== $user->parish_group_id) {
            abort(403, 'Você só pode editar notícias do seu grupo.');
        }

        return view('admin.coordenador.news.edit', compact('news'));
    }

    /**
     * Atualizar notícia (apenas do seu grupo)
     */
    public function newsUpdate(Request $request, News $news)
    {
        $user = Auth::user();

        // Verificar se a notícia pertence ao grupo do coordenador
        if ($news->group_id !== $user->parish_group_id) {
            abort(403, 'Você só pode editar notícias do seu grupo.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'status' => 'required|in:published,draft',
        ]);

        $news->update([
            'title' => $request->title,
            'content' => $request->content,
            'excerpt' => $request->excerpt,
            'status' => $request->status,
            'published_at' => $request->status === 'published' ? ($news->published_at ?? now()) : null,
        ]);

        return redirect()->route('admin.coordenador.news.index')
            ->with('success', 'Notícia atualizada com sucesso!');
    }

    /**
     * Excluir notícia (apenas do seu grupo)
     */
    public function newsDestroy(News $news)
    {
        $user = Auth::user();

        // Verificar se a notícia pertence ao grupo do coordenador
        if ($news->group_id !== $user->parish_group_id) {
            abort(403, 'Você só pode excluir notícias do seu grupo.');
        }

        $news->delete();

        return redirect()->route('admin.coordenador.news.index')
            ->with('success', 'Notícia excluída com sucesso!');
    }

    /**
     * Lista eventos do coordenador (apenas do seu grupo)
     */
    public function eventsIndex()
    {
        $user = Auth::user();

        if (! $user->parish_group_id) {
            return redirect()->route('admin.coordenador.dashboard')
                ->with('error', 'Você precisa estar associado a um grupo para gerenciar eventos.');
        }

        $events = Event::where('group_id', $user->parish_group_id)
            ->latest()
            ->paginate(10);

        return view('admin.coordenador.events.index', compact('events'));
    }

    /**
     * Criar novo evento
     */
    public function eventsCreate()
    {
        $user = Auth::user();

        if (! $user->parish_group_id) {
            return redirect()->route('admin.coordenador.dashboard')
                ->with('error', 'Você precisa estar associado a um grupo para criar eventos.');
        }

        return view('admin.coordenador.events.create');
    }

    /**
     * Salvar novo evento (associado ao grupo do coordenador)
     */
    public function eventsStore(Request $request)
    {
        $user = Auth::user();

        if (! $user->parish_group_id) {
            return redirect()->route('admin.coordenador.dashboard')
                ->with('error', 'Você precisa estar associado a um grupo para criar eventos.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:scheduled,draft',
        ]);

        Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'user_id' => Auth::id(),
            'parish_group_id' => $user->parish_group_id, // Associar ao grupo do coordenador
        ]);

        return redirect()->route('admin.coordenador.events.index')
            ->with('success', 'Evento criado com sucesso!');
    }

    /**
     * Editar evento (apenas do seu grupo)
     */
    public function eventsEdit(Event $event)
    {
        $user = Auth::user();

        // Verificar se o evento pertence ao grupo do coordenador
        if ($event->group_id !== $user->parish_group_id) {
            abort(403, 'Você só pode editar eventos do seu grupo.');
        }

        return view('admin.coordenador.events.edit', compact('event'));
    }

    /**
     * Atualizar evento (apenas do seu grupo)
     */
    public function eventsUpdate(Request $request, Event $event)
    {
        $user = Auth::user();

        // Verificar se o evento pertence ao grupo do coordenador
        if ($event->group_id !== $user->parish_group_id) {
            abort(403, 'Você só pode editar eventos do seu grupo.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:scheduled,draft',
        ]);

        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.coordenador.events.index')
            ->with('success', 'Evento atualizado com sucesso!');
    }

    /**
     * Excluir evento (apenas do seu grupo)
     */
    public function eventsDestroy(Event $event)
    {
        $user = Auth::user();

        // Verificar se o evento pertence ao grupo do coordenador
        if ($event->group_id !== $user->parish_group_id) {
            abort(403, 'Você só pode excluir eventos do seu grupo.');
        }

        $event->delete();

        return redirect()->route('admin.coordenador.events.index')
            ->with('success', 'Evento excluído com sucesso!');
    }

    /**
     * Solicitações de ingresso no grupo
     */
    public function requestsIndex()
    {
        $user = Auth::user();

        if (! $user->parish_group_id) {
            return view('admin.coordenador.requests.index')
                ->with('warning', 'Você precisa estar associado a um grupo para gerenciar solicitações.')
                ->with('requests', collect());
        }

        // Solicitações pendentes para o grupo do coordenador
        $requests = GroupRequest::where('parish_group_id', $user->parish_group_id)
            ->where('status', 'pending')
            ->with(['user'])
            ->latest()
            ->paginate(10);

        return view('admin.coordenador.requests.index', compact('requests'));
    }

    /**
     * Aprovar solicitação
     */
    public function approveRequest(GroupRequest $request)
    {
        $approver = Auth::user();
        $request->approve($approver, 'Aprovado pelo coordenador dos coroinhas');

        return back()->with('success', 'Solicitação aprovada com sucesso!');
    }

    /**
     * Rejeitar solicitação
     */
    public function rejectRequest(Request $httpRequest, GroupRequest $request)
    {
        $httpRequest->validate([
            'message' => 'nullable|string|max:500',
        ]);

        $request->reject(Auth::user(), $httpRequest->message ?? 'Solicitação rejeitada pelo coordenador');

        return back()->with('success', 'Solicitação rejeitada.');
    }

    /**
     * Escalas de coroinhas
     */
    public function schedules()
    {
        // Lista arquivos PDF de escalas
        $schedules = collect(Storage::disk('public')->files('schedules/coroinhas'))
            ->filter(function ($file) {
                return pathinfo($file, PATHINFO_EXTENSION) === 'pdf';
            })
            ->map(function ($file) {
                return [
                    'name' => basename($file),
                    'path' => $file,
                    'url' => Storage::url($file),
                    'size' => Storage::size($file),
                    'modified' => Storage::lastModified($file),
                ];
            })
            ->sortByDesc('modified')
            ->values();

        return view('admin.coordenador.schedules', compact('schedules'));
    }

    /**
     * Upload de escala
     */
    public function uploadSchedule(Request $request)
    {
        $request->validate([
            'schedule_file' => 'required|file|mimes:pdf|max:10240', // Max 10MB
            'title' => 'required|string|max:255',
        ]);

        $file = $request->file('schedule_file');
        $filename = time().'_'.$request->title.'.pdf';

        $path = $file->storeAs('schedules/coroinhas', $filename, 'public');

        return back()->with('success', 'Escala enviada com sucesso!');
    }

    /**
     * Horários de missas
     */
    public function masses()
    {
        $masses = Mass::active()->orderBy('day_of_week')->orderBy('time')->get();

        return view('admin.coordenador.masses', compact('masses'));
    }

    /**
     * Criar novo horário de missa
     */
    public function massesCreate()
    {
        return view('admin.coordenador.masses.create');
    }

    /**
     * Salvar horário de missa
     */
    public function massesStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'day_of_week' => 'required|in:sunday,monday,tuesday,wednesday,thursday,friday,saturday',
            'time' => 'required|date_format:H:i',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Mass::create($request->all());

        return redirect()->route('admin.coordenador.masses.index')
            ->with('success', 'Horário de missa criado com sucesso!');
    }

    /**
     * PDF Scales Management
     */
    public function scalesIndex()
    {
        $user = Auth::user();

        if (! $user->parish_group_id) {
            return redirect()->route('admin.coordenador.dashboard')
                ->with('error', 'Você precisa estar associado a um grupo para gerenciar escalas.');
        }

        $group = $user->parishGroup;

        if (!$group || !$group->requires_scale) {
            return redirect()->route('admin.coordenador.dashboard')
                ->with('warning', 'Seu grupo não possui sistema de escalas habilitado.');
        }

        $scales = Scale::where('group_id', $user->parish_group_id)
            ->with(['uploader'])
            ->latest()
            ->paginate(10);

        return view('admin.coordenador.scales.index', compact('scales', 'group'));
    }

    public function scalesUpload(Request $request)
    {
        $user = Auth::user();

        if (! $user->parish_group_id) {
            return redirect()->route('admin.coordenador.dashboard')
                ->with('error', 'Você precisa estar associado a um grupo para enviar escalas.');
        }

        $group = $user->parishGroup;

        if (! $group || ! $group->requires_scale) {
            return redirect()->route('admin.coordenador.dashboard')
                ->with('warning', 'Seu grupo não possui sistema de escalas habilitado.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf|max:10240', // 10MB max
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
            'description' => 'nullable|string|max:1000',
        ]);

        $file = $request->file('file');
        $path = $file->store('scales', 'public');

        Scale::create([
            'title' => $validated['title'],
            'group_id' => $user->parish_group_id,
            'file_path' => $path,
            'original_filename' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'uploaded_by' => Auth::id(),
            'valid_from' => $validated['valid_from'] ? \Carbon\Carbon::parse($validated['valid_from']) : null,
            'valid_until' => $validated['valid_until'] ? \Carbon\Carbon::parse($validated['valid_until']) : null,
            'description' => $validated['description'],
        ]);

        return redirect()->route('admin.coordenador.scales.index')
            ->with('success', 'Escala PDF enviada com sucesso!');
    }

    public function scalesDownload(Scale $scale)
    {
        $user = Auth::user();

        if (! $user->parish_group_id || $scale->group_id !== $user->parish_group_id) {
            abort(403, 'Você não tem permissão para baixar esta escala.');
        }

        if (! Storage::disk('public')->exists($scale->file_path)) {
            abort(404, 'Arquivo não encontrado.');
        }

        return response()->download(storage_path('app/public/'.$scale->file_path), $scale->original_filename);
    }

    public function scalesDestroy(Scale $scale)
    {
        $user = Auth::user();

        if (! $user->parish_group_id || $scale->group_id !== $user->parish_group_id) {
            abort(403, 'Você não tem permissão para deletar esta escala.');
        }

        // Delete file from storage
        if (Storage::disk('public')->exists($scale->file_path)) {
            Storage::disk('public')->delete($scale->file_path);
        }

        $scale->delete();

        return redirect()->route('admin.coordenador.scales.index')
            ->with('success', 'Escala removida com sucesso!');
    }
}
