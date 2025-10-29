<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mass;
use Illuminate\Http\Request;

class MassController extends Controller
{
    public function index(Request $request)
    {
        $query = Mass::query();

        // Filter by day
        if ($request->filled('day_of_week')) {
            $query->where('day_of_week', $request->day_of_week);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        // Search in name and description
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        $masses = $query->orderBy('day_of_week')->orderBy('time')->paginate(10);
        
        return view('admin.masses.index', compact('masses'));
    }

    public function create()
    {
        return view('admin.masses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'day_of_week' => 'required|in:sunday,monday,tuesday,wednesday,thursday,friday,saturday',
            'time' => 'required|date_format:H:i',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Mass::create($validated);

        return redirect()->route('admin.masses.index')
            ->with('success', 'Horário de missa criado com sucesso!');
    }

    public function show(Mass $mass)
    {
        return view('admin.masses.show', compact('mass'));
    }

    public function edit(Mass $mass)
    {
        return view('admin.masses.edit', compact('mass'));
    }

    public function update(Request $request, Mass $mass)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'day_of_week' => 'required|in:sunday,monday,tuesday,wednesday,thursday,friday,saturday',
            'time' => 'required|date_format:H:i',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $mass->update($validated);

        return redirect()->route('admin.masses.edit', $mass)
            ->with('success', 'Horário de missa atualizado com sucesso!');
    }

    public function destroy(Mass $mass)
    {
        $mass->delete();

        return redirect()->route('admin.masses.index')
            ->with('success', 'Horário de missa excluído com sucesso!');
    }
}
