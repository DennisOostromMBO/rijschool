<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:255', 'exists:users,username'],
            'password' => ['required', 'string', 'min:8'],
            'remember' => ['boolean'],
        ];
    }
    
    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'username.required' => 'Voer een gebruikersnaam in.',
            'username.string' => 'Gebruikersnaam moet tekst zijn.',
            'username.exists' => 'Deze gebruikersnaam bestaat niet.',
            'password.required' => 'Voer een wachtwoord in.',
            'password.string' => 'Wachtwoord moet tekst zijn.',
            'password.min' => 'Wachtwoord moet minimaal :min tekens bevatten.',
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // First check if the account exists and is active before attempting authentication
        $user = \App\Models\User::where('username', $this->username)->first();
        if ($user && !$user->is_active) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'username' => 'Dit account is niet actief. Neem contact op met een beheerder.',
            ]);
        }

        if (! Auth::attempt($this->only('username', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'username' => 'De opgegeven inloggegevens komen niet overeen met onze gegevens.',
            ]);
        }

        // Update the user's login status
        Auth::user()->update([
            'is_logged_in' => true,
            'logged_in_at' => now(),
        ]);

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 3)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'username' => 'Te veel inlogpogingen. Probeer het opnieuw na ' . ceil($seconds / 60) . 
                         ' ' . (ceil($seconds / 60) == 1 ? 'minuut' : 'minuten') . '.',
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('username')).'|'.$this->ip());
    }
}
