<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupRequestController extends Controller
{
    public function __construct()
    {
        // Middleware será aplicado nas rotas
    }

    /**
     * Exibir formulário para solicitar entrada em grupo
     */
    public function create()
    {
        $user = Auth::user();
        
        // Verificar se usuário já está em um grupo
        if ($user->parish_group_id) {
            return redirect()->route('dashboard')
                ->with('error', 'Você já faz parte de um grupo: ' . $user->parishGroup->name);
        }

        // Buscar grupos ativos que o usuário pode solicitar entrada
        $groups = Group::active()
            ->whereDoesntHave('groupRequests', function ($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->where('status', GroupRequest::STATUS_PENDING);
            })
            ->get();

        // Buscar solicitações pendentes do usuário
        $pendingRequests = GroupRequest::where('user_id', $user->id)
            ->where('status', GroupRequest::STATUS_PENDING)
            ->with('group')
            ->get();

        return view('group-requests.create', compact('groups', 'pendingRequests'));
    }

    /**
     * Criar nova solicitação de entrada em grupo
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'message' => 'nullable|string|max:500',
        ]);

        // Verificar se usuário já está em um grupo
        if ($user->parish_group_id) {
            return redirect()->back()
                ->with('error', 'Você já faz parte de um grupo.');
        }

        // Verificar se já existe solicitação pendente para este grupo
        $existingRequest = GroupRequest::where('user_id', $user->id)
            ->where('group_id', $request->group_id)
            ->where('status', GroupRequest::STATUS_PENDING)
            ->first();

        if ($existingRequest) {
            return redirect()->back()
                ->with('error', 'Você já possui uma solicitação pendente para este grupo.');
        }

        $group = Group::findOrFail($request->group_id);

        // Criar a solicitação
        $groupRequest = GroupRequest::create([
            'user_id' => $user->id,
            'group_id' => $request->group_id,
            'status' => GroupRequest::STATUS_PENDING,
            'message' => $request->message,
        ]);

        // Notificar coordenador do grupo (se houver)
        if ($group->coordinator_id) {
            \App\Models\Notification::create([
                'user_id' => $group->coordinator_id,
                'type' => 'new_group_request',
                'title' => 'Nova Solicitação de Entrada',
                'message' => "{$user->name} solicitou entrada em {$group->name}",
                'data' => [
                    'request_id' => $groupRequest->id,
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'group_id' => $group->id,
                    'group_name' => $group->name,
                ]
            ]);
        }

        return redirect()->route('group-requests.create')
            ->with('success', "Solicitação enviada para {$group->name}! Aguarde a aprovação do coordenador.");
    }

    /**
     * Exibir solicitações para coordenadores
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Verificar permissões
        if (!$user->canApproveRequests()) {
            return redirect()->route('dashboard')
                ->with('error', 'Você não tem permissão para visualizar solicitações.');
        }

        $query = GroupRequest::with(['user', 'group']);

        // Filtrar por grupo se for coordenador
        if ($user->isCoordenador()) {
            $query->where('group_id', $user->parish_group_id);
        }

        // Filtros
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->has('group_id') && $request->group_id !== '') {
            $query->where('group_id', $request->group_id);
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Grupos disponíveis para filtro (apenas para admin)
        $groups = collect();
        if ($user->isAdminGlobal()) {
            $groups = Group::active()->orderBy('name')->get();
        }

        return view('group-requests.index', compact('requests', 'groups'));
    }

    /**
     * Exibir detalhes da solicitação
     */
    public function show(GroupRequest $groupRequest)
    {
        $user = Auth::user();
        
        // Verificar permissões
        if (!$user->canApproveRequests()) {
            return redirect()->route('dashboard')
                ->with('error', 'Você não tem permissão para visualizar esta solicitação.');
        }

        // Coordenador só pode ver solicitações do seu grupo
        if ($user->isCoordenador() && $groupRequest->group_id !== $user->parish_group_id) {
            return redirect()->route('group-requests.index')
                ->with('error', 'Você só pode visualizar solicitações do seu grupo.');
        }

        return view('group-requests.show', compact('groupRequest'));
    }

    /**
     * Aprovar solicitação
     */
    public function approve(Request $request, GroupRequest $groupRequest)
    {
        $user = Auth::user();
        
        // Verificar permissões
        if (!$user->canApproveRequests()) {
            return response()->json(['error' => 'Sem permissão'], 403);
        }

        // Coordenador só pode aprovar solicitações do seu grupo
        if ($user->isCoordenador() && $groupRequest->group_id !== $user->parish_group_id) {
            return response()->json(['error' => 'Sem permissão'], 403);
        }

        if (!$groupRequest->isPending()) {
            return response()->json(['error' => 'Solicitação já foi processada'], 400);
        }

        $request->validate([
            'response_message' => 'nullable|string|max:500',
        ]);

        $groupRequest->approve($user, $request->response_message);

        return response()->json([
            'success' => true,
            'message' => 'Solicitação aprovada com sucesso!'
        ]);
    }

    /**
     * Rejeitar solicitação
     */
    public function reject(Request $request, GroupRequest $groupRequest)
    {
        $user = Auth::user();
        
        // Verificar permissões
        if (!$user->canApproveRequests()) {
            return response()->json(['error' => 'Sem permissão'], 403);
        }

        // Coordenador só pode rejeitar solicitações do seu grupo
        if ($user->isCoordenador() && $groupRequest->group_id !== $user->parish_group_id) {
            return response()->json(['error' => 'Sem permissão'], 403);
        }

        if (!$groupRequest->isPending()) {
            return response()->json(['error' => 'Solicitação já foi processada'], 400);
        }

        $request->validate([
            'response_message' => 'required|string|max:500',
        ]);

        $groupRequest->reject($user, $request->response_message);

        return response()->json([
            'success' => true,
            'message' => 'Solicitação rejeitada.'
        ]);
    }

    /**
     * Exibir minhas solicitações (para usuários)
     */
    public function myRequests()
    {
        $user = Auth::user();
        
        $requests = GroupRequest::where('user_id', $user->id)
            ->with(['group', 'approver'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('group-requests.my-requests', compact('requests'));
    }
}
