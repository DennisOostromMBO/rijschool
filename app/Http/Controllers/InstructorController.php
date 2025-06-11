<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Exception;

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
}
