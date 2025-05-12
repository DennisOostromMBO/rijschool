<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $roles = \App\Models\Role::select('name')->distinct()->pluck('name');

        return view('account.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('account.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id'],
        ]);

        return redirect()->route('accounts.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('account.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('account.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role_id' => ['required', 'exists:roles,id'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role_id = $validated['role_id'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('accounts.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('accounts.index')
            ->with('success', 'User deleted successfully.');
    }
}
