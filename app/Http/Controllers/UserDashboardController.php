<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Mass;
use App\Models\News;
use App\Models\Scale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // Pegar últimas notícias
        $recentNews = News::where('status', 'published')
            ->latest('published_at')
            ->take(6)
            ->get();

        // Pegar próximos eventos
        $upcomingEvents = Event::where('start_date', '>=', now())
            ->orderBy('start_date')
            ->take(5)
            ->get();

        // Pegar horários de missas
        $masses = Mass::orderBy('day_of_week')
            ->orderBy('time')
            ->get();

        return view('user.dashboard', compact('user', 'recentNews', 'upcomingEvents', 'masses'));
    }

    /**
     * Listar escalas do grupo do usuário
     */
    public function scalesIndex()
    {
        $user = Auth::user();

        // Verificar se o usuário pertence ao grupo Coroinhas
        if (!$user->parishGroup || $user->parishGroup->id != 5) {
            return redirect()->route('user.dashboard')
                ->with('error', 'Você não tem acesso a esta seção.');
        }

        // Buscar apenas escalas ATIVAS do grupo Coroinhas para usuários comuns
        // Ordenar por data de criação (mais recente primeiro)
        $scales = Scale::where('group_id', 5)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->orderBy('valid_from', 'desc')
            ->paginate(10);

        return view('user.scales.index', compact('scales', 'user'));
    }

    /**
     * Download de escala (apenas visualização)
     */
    public function scalesDownload(Scale $scale)
    {
        $user = Auth::user();

        // Verificar se o usuário pertence ao grupo da escala
        if (!$user->parishGroup || $user->parishGroup->id != $scale->group_id) {
            return redirect()->route('user.dashboard')
                ->with('error', 'Você não tem acesso a este arquivo.');
        }

        // Usuários comuns só podem baixar escalas ativas
        if (!$scale->is_active) {
            return redirect()->route('user.scales.index')
                ->with('error', 'Esta escala não está mais disponível.');
        }

        $filePath = storage_path('app/public/' . $scale->file_path);

        if (!file_exists($filePath)) {
            return back()->with('error', 'Arquivo não encontrado.');
        }

        $downloadName = $scale->original_filename ?? basename($scale->file_path ?? '') ?: 'arquivo.pdf';
        return response()->download($filePath, $downloadName);
    }
}
