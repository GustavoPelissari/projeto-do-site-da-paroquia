<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $query = Group::query();

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        // Search in name and description
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $groups = $query->latest()->paginate(12);
        
        return view('admin.groups.index', compact('groups'));
    }

    public function create()
    {
        return view('admin.groups.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:liturgy,pastoral,service,formation,youth,family',
            'coordinator_name' => 'nullable|string|max:255',
            'coordinator_phone' => 'nullable|string|max:20',
            'coordinator_email' => 'nullable|email|max:255',
            'meeting_info' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('groups', 'public');
        }

        $group = Group::create($validated);

        return redirect()->route('admin.groups.index')
            ->with('success', 'Grupo criado com sucesso!');
    }

    public function show(Group $group)
    {
        return view('admin.groups.show', compact('group'));
    }

    public function edit(Group $group)
    {
        return view('admin.groups.edit', compact('group'));
    }

    public function update(Request $request, Group $group)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:liturgy,pastoral,service,formation,youth,family',
            'coordinator_name' => 'nullable|string|max:255',
            'coordinator_phone' => 'nullable|string|max:20',
            'coordinator_email' => 'nullable|email|max:255',
            'meeting_info' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'remove_image' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Handle image removal
        if ($request->has('remove_image') && $group->image) {
            Storage::disk('public')->delete($group->image);
            $validated['image'] = null;
        }

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($group->image) {
                Storage::disk('public')->delete($group->image);
            }
            $validated['image'] = $request->file('image')->store('groups', 'public');
        }

        $group->update($validated);

        return redirect()->route('admin.groups.edit', $group)
            ->with('success', 'Grupo atualizado com sucesso!');
    }

    public function destroy(Group $group)
    {
        // Delete image if exists
        if ($group->image) {
            Storage::disk('public')->delete($group->image);
        }

        $group->delete();

        return redirect()->route('admin.groups.index')
            ->with('success', 'Grupo excluído com sucesso!');
    }
}
