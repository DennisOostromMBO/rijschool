<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Handles all instructor-related operations
 */
class InstructorController extends Controller
{
    /**
     * Display a listing of all instructors
     */
    public function index()
    {
        try {
            $instructors = DB::select('CALL SPGetAllInstructors()');
            $page = request()->get('page', 1);
            $perPage = 5;

            $pagedData = array_slice($instructors, ($page - 1) * $perPage, $perPage);

            $paginatedInstructors = new \Illuminate\Pagination\LengthAwarePaginator(
                $pagedData,
                count($instructors),
                $perPage,
                $page,
                ['path' => request()->url()]
            );

            return view('instructors.index', ['instructors' => $paginatedInstructors]);
        } catch (Exception $e) {
            return back()->with('error', 'Er is een fout opgetreden bij het ophalen van de instructeurs.');
        }
    }

    /**
     * Show the form for creating a new instructor
     */
    public function create()
    {
        return view('instructors.create');
    }

    /**
     * Store a newly created instructor
     * Validates input and handles unique email constraint
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\- ]+$/u',
            'middle_name' => 'nullable|string|max:255|regex:/^[a-zA-ZÀ-ÿ\- ]+$/u',
            'last_name' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\- ]+$/u',
            'birth_date' => 'required|date|after_or_equal:1900-01-01|before:today',
            'street_name' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\- ]+$/u',
            'house_number' => 'required|regex:/^\d+$/|digits_between:1,4',
            'addition' => 'nullable|string|max:8',
            'postal_code' => 'required|regex:/^[0-9]{4}[A-Z]{2}$/',
            'city' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\- ]+$/u',
            'email' => ['required', 'email', 'max:255', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', 'not_regex:/xn--/', 'unique:contacts,email']
        ], [
            // Algemene validatie messages
            'required' => ':attribute is verplicht.',
            'max' => ':attribute is te lang.',
            'regex' => ':attribute is ongeldig.',
            'email' => ':attribute is ongeldig.',
            'digits_between' => ':attribute is ongeldig.',

            // Naam validatie
            'first_name.required' => 'Voornaam is verplicht.',
            'first_name.max' => 'Voornaam is te lang.',
            'first_name.regex' => 'Voornaam is ongeldig.',

            'middle_name.max' => 'Tussenvoegsel is te lang.',
            'middle_name.regex' => 'Tussenvoegsel is ongeldig.',

            'last_name.required' => 'Achternaam is verplicht.',
            'last_name.max' => 'Achternaam is te lang.',
            'last_name.regex' => 'Achternaam is ongeldig.',

            // Geboortedatum validatie
            'birth_date.required' => 'Geboortedatum is verplicht.',
            'birth_date.date' => 'Geboortedatum is ongeldig.',
            'birth_date.after_or_equal' => 'Geboortedatum is ongeldig.',
            'birth_date.before' => 'Geboortedatum is ongeldig.',

            // Adres validatie
            'street_name.required' => 'Straatnaam is verplicht.',
            'street_name.max' => 'Straatnaam is te lang.',
            'street_name.regex' => 'Straatnaam is ongeldig.',

            'house_number.required' => 'Huisnummer is verplicht.',
            'house_number.regex' => 'Huisnummer is ongeldig.',
            'house_number.digits_between' => 'Huisnummer is ongeldig.',

            'addition.max' => 'Toevoeging is ongeldig.',

            'postal_code.required' => 'Postcode is verplicht.',
            'postal_code.regex' => 'Postcode is ongeldig.',

            'city.required' => 'Plaats is verplicht.',
            'city.max' => 'Plaats is te lang.',
            'city.regex' => 'Plaats is ongeldig.',

            // Contact validatie
            'email.required' => 'E-mailadres is verplicht.',
            'email.email' => 'E-mailadres is ongeldig.',
            'email.max' => 'E-mailadres is te lang.',
            'email.regex' => 'E-mailadres is ongeldig.',
            'email.not_regex' => 'E-mailadres is ongeldig.',
            'email.unique' => 'Let op! Dit e-mailadres is al in gebruik door een andere instructeur!'
        ]);

        try {
            $result = DB::select('CALL SPCreateInstructeur(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $request->first_name,
                $request->middle_name ?: null, 
                $request->last_name,
                $request->birth_date,
                $request->street_name,
                $request->house_number,
                $request->addition ?: null,    
                $request->postal_code,
                $request->city,
                $request->email
            ]);

            return redirect()->route('instructors.index')
                ->with('success', 'Instructeur is succesvol toegevoegd.');
        } catch (Exception $e) {
            return back()->withInput()
                ->withErrors(['email' => 'Let op! Dit e-mailadres is al in gebruik door een andere instructeur!']);
        }
    }
}
