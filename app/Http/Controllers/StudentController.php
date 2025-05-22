<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Exception;

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
}
