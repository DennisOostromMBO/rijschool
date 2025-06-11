<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstructorController extends Controller
{
    public function index()
    {
        try {
            $instructors = DB::select('CALL SPGetAllInstructors()');
            return view('instructors.index', ['instructors' => $instructors]);
        } catch (Exception $e) {
            return back()->with('error', 'Er is een fout opgetreden bij het ophalen van de instructeurs.');
        }
    }

    public function create()
    {
        return view('instructors.create');
    }

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
        ]);

        try {
            $result = DB::select('CALL SPCreateInstructeur(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $request->first_name,
                $request->middle_name ?: null,  // Convert empty string to null
                $request->last_name,
                $request->birth_date,
                $request->street_name,
                $request->house_number,
                $request->addition ?: null,     // Convert empty string to null
                $request->postal_code,
                $request->city,
                $request->email
            ]);

            if (!$result) {
                throw new Exception('Geen resultaat van stored procedure');
            }

            return redirect()->route('instructors.index')
                ->with('success', 'Instructeur is succesvol toegevoegd.');
        } catch (Exception $e) {
            report($e); // Log de error
            return back()->withInput()
                ->with('error', 'Er is een fout opgetreden bij het toevoegen van de instructeur: ' . $e->getMessage());
        }
    }
}
