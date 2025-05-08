<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index()
    {
        $students = Student::with('user')->paginate(10);
        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'postal_code' => ['required', 'string', 'max:20'],
            'date_of_birth' => ['required', 'date'],
            'bsn' => ['nullable', 'string', 'max:20'],
            'license_type' => ['required', 'string', 'max:20'],
        ]);

        DB::transaction(function () use ($validated, &$student) {
            // Create user account first
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'role_id' => 3, // Assuming 3 is student role
            ]);

            // Create student profile
            $student = Student::create([
                'user_id' => $user->id,
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'],
                'date_of_birth' => $validated['date_of_birth'],
                'bsn' => $validated['bsn'] ?? null,
                'license_type' => $validated['license_type'],
                'progress' => 0, // Default progress
            ]);
        });

        return redirect()->route('students.index')
            ->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified student.
     */
    public function show(Student $student)
    {
        $student->load('user', 'lessons.instructor', 'registrations.package');
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(Student $student)
    {
        $student->load('user');
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $student->user_id],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'postal_code' => ['required', 'string', 'max:20'],
            'date_of_birth' => ['required', 'date'],
            'bsn' => ['nullable', 'string', 'max:20'],
            'license_type' => ['required', 'string', 'max:20'],
        ]);

        DB::transaction(function () use ($validated, $student) {
            // Update user account
            $student->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            // Update student profile
            $student->update([
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'],
                'date_of_birth' => $validated['date_of_birth'],
                'bsn' => $validated['bsn'] ?? null,
                'license_type' => $validated['license_type'],
            ]);
        });

        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(Student $student)
    {
        DB::transaction(function () use ($student) {
            $user = $student->user;
            $student->delete();
            $user->delete();
        });

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }

    /**
     * Display the student's progress.
     */
    public function progress(Student $student)
    {
        $student->load('lessons');
        return view('students.progress', compact('student'));
    }

    /**
     * Update the student's progress.
     */
    public function updateProgress(Request $request, Student $student)
    {
        $validated = $request->validate([
            'progress' => ['required', 'integer', 'min:0', 'max:100'],
            'notes' => ['nullable', 'string'],
        ]);

        $student->update([
            'progress' => $validated['progress'],
            'progress_notes' => $validated['notes'] ?? null,
            'progress_updated_at' => now(),
        ]);

        return redirect()->route('students.progress', $student)
            ->with('success', 'Student progress updated successfully.');
    }
}
