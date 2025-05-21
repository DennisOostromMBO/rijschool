<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the users with search and filtering capabilities.
     */
    public function index(Request $request)
    {
        $query = User::with('roles');

        // Zoeken op naam of gebruikersnaam
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('first_name', 'LIKE', $searchTerm)
                  ->orWhere('last_name', 'LIKE', $searchTerm)
                  ->orWhere('username', 'LIKE', $searchTerm);
            });
        }

        // Filteren op rol
        if ($request->has('role') && !empty($request->role)) {
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        // Sorteren
        $sortField = $request->sort_by ?? 'id';
        $sortDirection = $request->sort_direction ?? 'asc';
        $allowedSortFields = ['id', 'first_name', 'username', 'created_at'];

        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->orderBy('id', 'asc');
        }

        // Pagineren met behoud van query parameters
        $perPage = $request->per_page ?? 10;
        $allowedPerPage = [10, 25, 50, 100];

        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        $users = $query->paginate($perPage)->withQueryString();

        // Haal alle unieke rolnamen op voor het filter
        $roles = Role::select('name')->distinct()->pluck('name');

        return view('account.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::all();
        return view('account.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'roles' => ['required', 'array'],
            'roles.*' => ['exists:roles,id'],
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'username' => $validated['username'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        // Koppel de gekozen rollen aan de gebruiker
        $user->roles()->attach($validated['roles']);

        return redirect()->route('accounts.index')
            ->with('success', 'Gebruiker is succesvol aangemaakt.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load('roles');
        return view('account.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $user->load('roles');
        return view('account.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'roles' => ['required', 'array'],
            'roles.*' => ['exists:roles,id'],
        ]);

        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        $user->username = $validated['username'];
        $user->email = $validated['email'] ?? $user->email;
        $user->phone = $validated['phone'] ?? $user->phone;

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        // Synchrooniseer de rollen (verwijdert oude koppelingen en voegt nieuwe toe)
        $user->roles()->sync($validated['roles']);

        return redirect()->route('accounts.index')
            ->with('success', 'Gebruiker is succesvol bijgewerkt.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Ontkoppel alle rollen voordat de gebruiker wordt verwijderd
        $user->roles()->detach();

        // Verwijder de gebruiker
        $user->delete();

        return redirect()->route('accounts.index')
            ->with('success', 'Gebruiker is succesvol verwijderd.');
    }
}
