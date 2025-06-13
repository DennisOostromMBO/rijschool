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
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'street_name' => 'required|string|max:255',
            'house_number' => 'required|string|max:255',
            'addition' => 'nullable|string|max:255',
            'postal_code' => 'required|string|max:255|regex:/^[0-9]{4}[A-Z]{2}$/',
            'city' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:contacts,email'
        ], [
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
