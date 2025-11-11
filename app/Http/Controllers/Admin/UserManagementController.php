<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->with('roles');
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qq) use ($q) {
                $qq->where('name', 'like', "%$q%")
                   ->orWhere('email', 'like', "%$q%");
            });
        }
        $users = $query->latest()->paginate(20)->withQueryString();
        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        $roles = Role::whereIn('name', ['producer','equipment_owner','admin'])->pluck('name')->toArray();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','string','min:8','confirmed'],
            'role' => ['required','in:producer,equipment_owner,admin'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        $user->syncRoles([$validated['role']]);
        return redirect()->route('admin.users.index')->with('status', 'Utilisateur créé');
    }

    public function show(User $user)
    {
        $user->load('roles');
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::whereIn('name', ['producer','equipment_owner','admin'])->pluck('name')->toArray();
        return view('admin.users.edit', compact('user','roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email,'.$user->id],
            'role' => ['required','in:producer,equipment_owner,admin'],
            'password' => ['nullable','string','min:8','confirmed'],
            'is_suspended' => ['sometimes','boolean'],
        ]);
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        $user->is_suspended = (bool)($validated['is_suspended'] ?? $user->is_suspended);
        $user->save();
        $user->syncRoles([$validated['role']]);
        return redirect()->route('admin.users.index')->with('status', 'Utilisateur mis à jour');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('status', 'Utilisateur supprimé');
    }
}




