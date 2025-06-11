<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        try {
            $students = DB::select('CALL SPGetAllStudents()');
            return view('students.index', ['students' => $students]);
        } catch (Exception $e) {
            return back()->with('error', 'Er is een fout opgetreden bij het ophalen van de leerlingen.');
        }
    }

    public function create()
    {
        return view('students.create');
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
            'mobile' => 'required|string|max:255|unique:contacts,mobile',
            'email' => 'required|email|max:255|unique:contacts,email'
        ], [
            'email.unique' => 'Let op! Dit e-mailadres is al in gebruik door een andere student!',
            'mobile.unique' => 'Let op! Dit mobiel nummer is al in gebruik door een andere student!'
        ]);

        try {
            $result = DB::select('CALL SPCreateStudent(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $request->first_name,
                $request->middle_name ?: null,
                $request->last_name,
                $request->birth_date,
                $request->street_name,
                $request->house_number,
                $request->addition ?: null,
                $request->postal_code,
                $request->city,
                $request->mobile,
                $request->email
            ]);

            return redirect()->route('students.index')
                ->with('success', 'Student is succesvol toegevoegd.');
        } catch (Exception $e) {
            report($e);
            return back()->withInput()
                ->withErrors(['email' => 'Let op! Dit e-mailadres is al in gebruik door een andere student!']);
        }
    }
}
