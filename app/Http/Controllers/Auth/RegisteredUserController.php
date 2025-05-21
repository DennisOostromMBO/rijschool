<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-ZÀ-ÿ\s\-\']+$/u'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-ZÀ-ÿ\s\-\']+$/u'],
            'birth_date' => ['required', 'date', 'before:today', 'after_or_equal:' . now()->subYears(100)->format('Y-m-d'), 'before_or_equal:' . now()->subYears(16)->format('Y-m-d')],
            'username' => ['required', 'string', 'min:5', 'max:255', 'unique:'.User::class, 'regex:/^[a-zA-Z0-9_]+$/'],
            'email' => ['nullable', 'string', 'email:rfc,dns', 'max:255', 'unique:'.User::class],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^([+]?[\s0-9]+)?(\d{3}|[(]?[0-9]+[)])?([-]?[\s]?[0-9])+$/'],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_])[A-Za-z\d@$!%*?&_]+$/'
            ],
        ], [
            'first_name.required' => 'Voer een voornaam in.',
            'first_name.regex' => 'Voornaam mag alleen letters, spaties en koppeltekens bevatten.',
            'last_name.required' => 'Voer een achternaam in.',
            'last_name.regex' => 'Achternaam mag alleen letters, spaties en koppeltekens bevatten.',
            'birth_date.required' => 'Voer een geboortedatum in.',
            'birth_date.date' => 'Ongeldige geboortedatum.',
            'birth_date.before' => 'Geboortedatum moet in het verleden liggen.',
            'birth_date.after_or_equal' => 'Geboortedatum kan niet meer dan 100 jaar geleden zijn.',
            'birth_date.before_or_equal' => 'Je moet minimaal 16 jaar oud zijn om te registreren.',
            'username.required' => 'Voer een gebruikersnaam in.',
            'username.min' => 'Gebruikersnaam moet minimaal 5 tekens bevatten.',
            'username.unique' => 'Deze gebruikersnaam is al in gebruik.',
            'username.regex' => 'Gebruikersnaam mag alleen letters, cijfers en underscores bevatten.',
            'password.required' => 'Voer een wachtwoord in.',
            'password.min' => 'Wachtwoord moet minimaal 8 tekens bevatten.',
            'password.confirmed' => 'De wachtwoordbevestiging komt niet overeen.',
            'password.regex' => 'Wachtwoord moet minimaal één hoofdletter, één kleine letter, één cijfer en één speciaal teken bevatten.',
            'email.email' => 'Voer een geldig e-mailadres in.',
            'email.max' => 'E-mailadres mag maximaal 255 tekens bevatten.',
            'email.unique' => 'Dit e-mailadres is al in gebruik.',
            'phone.max' => 'Telefoonnummer mag maximaal 20 tekens bevatten.',
            'phone.regex' => 'Voer een geldig telefoonnummer in.',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'birth_date' => $request->birth_date,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
