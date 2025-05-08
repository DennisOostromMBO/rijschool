<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use App\Models\User;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstructorController extends Controller
{
    /**
     * Display a listing of instructors.
     */
    public function index()
    {
        $instructors = Instructor::with('user', 'car')->paginate(10);
        return view('instructors.index', compact('instructors'));
    }

    /**
     * Show the form for creating a new instructor.
     */
    public function create()
    {
        $cars = Car::where('status', 'available')->get();
        return view('instructors.create', compact('cars'));
    }

    /**
     * Store a newly created instructor in storage.
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
            'license_number' => ['required', 'string', 'max:50'],
            'car_id' => ['required', 'exists:cars,id'],
            'bio' => ['nullable', 'string'],
            'specialization' => ['nullable', 'string', 'max:100'],
            'hourly_rate' => ['required', 'numeric', 'min:0'],
        ]);

        DB::transaction(function () use ($validated, &$instructor) {
            // Create user account first
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'role_id' => 2, // Assuming 2 is instructor role
            ]);

            // Create instructor profile
            $instructor = Instructor::create([
                'user_id' => $user->id,
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'],
                'license_number' => $validated['license_number'],
                'car_id' => $validated['car_id'],
                'bio' => $validated['bio'] ?? null,
                'specialization' => $validated['specialization'] ?? null,
                'hourly_rate' => $validated['hourly_rate'],
                'status' => 'active',
            ]);
        });

        return redirect()->route('instructors.index')
            ->with('success', 'Instructor created successfully.');
    }

    /**
     * Display the specified instructor.
     */
    public function show(Instructor $instructor)
    {
        $instructor->load('user', 'car', 'lessons.student');
        return view('instructors.show', compact('instructor'));
    }

    /**
     * Show the form for editing the specified instructor.
     */
    public function edit(Instructor $instructor)
    {
        $instructor->load('user');
        $cars = Car::where('status', 'available')
            ->orWhere('id', $instructor->car_id)
            ->get();
        return view('instructors.edit', compact('instructor', 'cars'));
    }

    /**
     * Update the specified instructor in storage.
     */
    public function update(Request $request, Instructor $instructor)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $instructor->user_id],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'postal_code' => ['required', 'string', 'max:20'],
            'license_number' => ['required', 'string', 'max:50'],
            'car_id' => ['required', 'exists:cars,id'],
            'bio' => ['nullable', 'string'],
            'specialization' => ['nullable', 'string', 'max:100'],
            'hourly_rate' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:active,inactive,vacation'],
        ]);

        DB::transaction(function () use ($validated, $instructor) {
            // Update user account
            $instructor->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            // Update instructor profile
            $instructor->update([
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'],
                'license_number' => $validated['license_number'],
                'car_id' => $validated['car_id'],
                'bio' => $validated['bio'] ?? null,
                'specialization' => $validated['specialization'] ?? null,
                'hourly_rate' => $validated['hourly_rate'],
                'status' => $validated['status'],
            ]);
        });

        return redirect()->route('instructors.index')
            ->with('success', 'Instructor updated successfully.');
    }

    /**
     * Remove the specified instructor from storage.
     */
    public function destroy(Instructor $instructor)
    {
        DB::transaction(function () use ($instructor) {
            $user = $instructor->user;
            $instructor->delete();
            $user->delete();
        });

        return redirect()->route('instructors.index')
            ->with('success', 'Instructor deleted successfully.');
    }

    /**
     * Display the instructor's schedule.
     */
    public function schedule(Instructor $instructor)
    {
        $instructor->load('lessons.student');
        return view('instructors.schedule', compact('instructor'));
    }

    /**
     * Update the instructor's schedule.
     */
    public function updateSchedule(Request $request, Instructor $instructor)
    {
        $validated = $request->validate([
            'available_days' => ['required', 'array'],
            'available_days.*' => ['in:monday,tuesday,wednesday,thursday,friday,saturday,sunday'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'lunch_start' => ['nullable', 'date_format:H:i'],
            'lunch_end' => ['nullable', 'date_format:H:i', 'after:lunch_start'],
        ]);

        $instructor->update([
            'available_days' => json_encode($validated['available_days']),
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'lunch_start' => $validated['lunch_start'] ?? null,
            'lunch_end' => $validated['lunch_end'] ?? null,
        ]);

        return redirect()->route('instructors.schedule', $instructor)
            ->with('success', 'Schedule updated successfully.');
    }

    /**
     * Show all students assigned to this instructor.
     */
    public function students(Instructor $instructor)
    {
        $students = $instructor->students()->with('user')->paginate(10);
        return view('instructors.students', compact('instructor', 'students'));
    }
}
