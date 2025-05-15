<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        $students = DB::select('CALL SPGetAllStudents()');
        return view('students.index', ['students' => $students]);
    }
}
