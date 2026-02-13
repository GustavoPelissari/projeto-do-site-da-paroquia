<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\News;
use App\Models\Event;
use App\Models\Group;
use App\Models\GroupRequest;
use App\Models\Mass;
use App\Models\Scale;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CoordinatorController extends Controller
{
    private function currentGroupId($user): ?int
    {
        return $user->group_id ?? $user->parish_group_id;
    }

    private function ensureCoordinatorGroup()
    {
        $user = Auth::user();
        $groupId = $this->currentGroupId($user);

        if (!$groupId) {
            return [null, null, redirect()->route('admin.coordenador.dashboard')
                ->with('error', 'Você precisa estar associado a um grupo para acessar este módulo.')];
        }

        return [$user, $groupId, null];
    }

    public function dashboard()
    {
        $user = Auth::user();

        if (($user->role->value ?? $user->role) !== 'coordenador_de_pastoral') {
            abort(403, 'Acesso negado.');
        }

        $groupId = $this->currentGroupId($user);
        $group = $groupId ? Group::find($groupId) : null;

        if (!$groupId) {
            $stats = [
                'total_coroinhas' => 0,
                'coroinhas_ativos' => 0,
                'solicitacoes_pendentes' => 0,
                'escalas_ativas' => 0,
            ];

            return view('admin.coordenador.dashboard', [
                'stats' => $stats,
                'group' => null,
                'recent_news' => collect(),
                'upcoming_events' => collect(),
            ])->with('warning', 'Você precisa estar associado a um grupo para acessar todos os recursos.');
        }

        $stats = [
            'total_coroinhas' => User::where('parish_group_id', $groupId)->count(),
            'coroinhas_ativos' => User::where('parish_group_id', $groupId)->whereNotNull('email_verified_at')->count(),
            'solicitacoes_pendentes' => GroupRequest::where('group_id', $groupId)->where('status', GroupRequest::STATUS_PENDING)->count(),
            'escalas_ativas' => Scale::where('group_id', $groupId)->where('is_active', true)->count(),
        ];

        $recent_news = News::where('group_id', $groupId)->latest()->take(5)->get();

        $upcoming_events = Event::where('group_id', $groupId)
            ->where('start_date', '>=', now())
            ->orderBy('start_date')
            ->take(5)
            ->get();

        return view('admin.coordenador.dashboard', compact('stats', 'recent_news', 'upcoming_events', 'group'));
    }

    public function newsIndex()
    {
        [, $groupId, $redirect] = $this->ensureCoordinatorGroup();
        if ($redirect) {
            return $redirect;
        }

        $news = News::where('group_id', $groupId)->latest()->paginate(10);

        return view('admin.coordenador.news.index', compact('news'));
    }

    public function newsCreate()
    {
        return redirect()->route('admin.coordenador.news.index')
            ->with('warning', 'Formulário de criação ainda não está disponível.');
    }

    public function newsStore(Request $request)
    {
        [, $groupId, $redirect] = $this->ensureCoordinatorGroup();
        if ($redirect) {
            return $redirect;
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'status' => 'required|in:published,draft,archived',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['group_id'] = $groupId;
        $validated['published_at'] = $validated['status'] === 'published' ? now() : null;

        News::create($validated);

        return redirect()->route('admin.coordenador.news.index')->with('success', 'Notícia criada com sucesso!');
    }

    public function newsShow(News $news)
    {
        return redirect()->route('admin.coordenador.news.index');
    }

    public function newsEdit(News $news)
    {
        return redirect()->route('admin.coordenador.news.index')
            ->with('warning', 'Edição detalhada ainda não está disponível.');
    }

    public function newsUpdate(Request $request, News $news)
    {
        return redirect()->route('admin.coordenador.news.index')
            ->with('warning', 'Edição detalhada ainda não está disponível.');
    }

    public function newsDestroy(News $news)
    {
        $groupId = $this->currentGroupId(Auth::user());

        if ($news->group_id !== $groupId) {
            abort(403, 'Você só pode excluir notícias do seu grupo.');
        }

        $news->delete();

        return redirect()->route('admin.coordenador.news.index')->with('success', 'Notícia excluída com sucesso!');
    }

    public function eventsIndex()
    {
        [, $groupId, $redirect] = $this->ensureCoordinatorGroup();
        if ($redirect) {
            return $redirect;
        }

        $events = Event::where('group_id', $groupId)
            ->orderByDesc('start_date')
            ->paginate(10);

        return view('admin.coordenador.events.index', compact('events'));
    }

    public function eventsCreate() { return redirect()->route('admin.coordenador.events.index')->with('warning', 'Criação de eventos pelo coordenador será liberada em breve.'); }
    public function eventsStore(Request $request) { return $this->eventsCreate(); }
    public function eventsShow(Event $event) { return redirect()->route('admin.coordenador.events.index'); }
    public function eventsEdit(Event $event) { return redirect()->route('admin.coordenador.events.index')->with('warning', 'Edição de eventos pelo coordenador será liberada em breve.'); }
    public function eventsUpdate(Request $request, Event $event) { return $this->eventsEdit($event); }
    public function eventsDestroy(Event $event) { return redirect()->route('admin.coordenador.events.index')->with('warning', 'Exclusão de eventos pelo coordenador será liberada em breve.'); }

    public function requestsIndex()
    {
        [, $groupId, $redirect] = $this->ensureCoordinatorGroup();
        if ($redirect) {
            return $redirect;
        }

        $requests = GroupRequest::with(['user', 'group'])
            ->where('group_id', $groupId)
            ->latest()
            ->paginate(10);

        return view('admin.coordenador.requests.index', compact('requests'));
    }

    public function approveRequest(GroupRequest $request)
    {
        $request->approve(Auth::user(), 'Aprovado pelo coordenador');
        return back()->with('success', 'Solicitação aprovada com sucesso!');
    }

    public function rejectRequest(Request $httpRequest, GroupRequest $request)
    {
        $httpRequest->validate(['message' => 'nullable|string|max:500']);
        $request->reject(Auth::user(), $httpRequest->message ?? 'Solicitação rejeitada pelo coordenador');
        return back()->with('success', 'Solicitação rejeitada.');
    }

    public function schedulesIndex()
    {
        [, $groupId, $redirect] = $this->ensureCoordinatorGroup();
        if ($redirect) {
            return $redirect;
        }

        $schedules = Schedule::with('user')
            ->where('group_id', $groupId)
            ->latest()
            ->paginate(10);

        return view('admin.coordenador.schedules.index', compact('schedules'));
    }

    public function schedulesCreate() { return redirect()->route('admin.coordenador.schedules.index')->with('warning', 'Cadastro de escala legado será liberado em breve.'); }
    public function schedulesStore(Request $request) { return $this->schedulesCreate(); }
    public function schedulesEdit($schedule) { return redirect()->route('admin.coordenador.schedules.index')->with('warning', 'Edição de escala legado será liberada em breve.'); }
    public function schedulesUpdate(Request $request, $schedule) { return $this->schedulesEdit($schedule); }
    public function schedulesDestroy($schedule) { return redirect()->route('admin.coordenador.schedules.index')->with('warning', 'Exclusão de escala legado será liberada em breve.'); }

    public function massesIndex()
    {
        $masses = Mass::orderByRaw("FIELD(day_of_week, 'sunday','monday','tuesday','wednesday','thursday','friday','saturday')")
            ->orderBy('time')
            ->paginate(20);

        return view('admin.coordenador.masses.index', compact('masses'));
    }

    public function massesShow(Mass $mass)
    {
        return redirect()->route('admin.coordenador.masses.index');
    }

    public function scalesIndex()
    {
        [, $groupId, $redirect] = $this->ensureCoordinatorGroup();
        if ($redirect) {
            return $redirect;
        }

        $group = Group::find($groupId);
        $scales = Scale::where('group_id', $groupId)->with(['uploader'])->latest()->paginate(10);

        return view('admin.coordenador.scales.index', compact('scales', 'group'));
    }

    public function scalesUpload(Request $request)
    {
        [, $groupId, $redirect] = $this->ensureCoordinatorGroup();
        if ($redirect) {
            return $redirect;
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf|max:10240',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
            'description' => 'nullable|string|max:1000',
        ]);

        $file = $request->file('file');
        $path = $file->store('scales', 'public');

        Scale::create([
            'title' => $validated['title'],
            'group_id' => $groupId,
            'file_path' => $path,
            'original_filename' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'uploaded_by' => Auth::id(),
            'valid_from' => $validated['valid_from'] ?? null,
            'valid_until' => $validated['valid_until'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('admin.coordenador.scales.index')->with('success', 'Escala PDF enviada com sucesso!');
    }

    public function scalesDownload(Scale $scale)
    {
        $groupId = $this->currentGroupId(Auth::user());

        if (!$groupId || $scale->group_id !== $groupId) {
            abort(403, 'Você não tem permissão para baixar esta escala.');
        }

        if (!Storage::disk('public')->exists($scale->file_path)) {
            abort(404, 'Arquivo não encontrado.');
        }

        return response()->download(storage_path('app/public/' . $scale->file_path), $scale->original_filename);
    }

    public function scalesDestroy(Scale $scale)
    {
        $groupId = $this->currentGroupId(Auth::user());

        if (!$groupId || $scale->group_id !== $groupId) {
            abort(403, 'Você não tem permissão para deletar esta escala.');
        }

        if (Storage::disk('public')->exists($scale->file_path)) {
            Storage::disk('public')->delete($scale->file_path);
        }

        $scale->delete();

        return redirect()->route('admin.coordenador.scales.index')->with('success', 'Escala removida com sucesso!');
    }
}
