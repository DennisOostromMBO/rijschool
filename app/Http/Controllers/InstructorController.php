<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class InstructorController extends Controller
{
    public function index()
    {
        $instructors = DB::select('CALL SPGetAllInstructors()');
        return view('instructors.index', ['instructors' => $instructors]);
    }
}
