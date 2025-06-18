<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Student;
use App\Models\Instructor;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LessonController extends Controller
{
    /**
     * Display a listing of the lessons.
     */
    public function index(Request $request)
    {
        $lessons = Lesson::getLessonOverview();

        // Debugging: Uncomment to inspect the data
        // dd($lessons);

        return view('lessons.index', compact('lessons'));
    }

    /**
     * Show the form for creating a new lesson.
     */
    public function create()
    {
        $students = Student::with('user')->get();
        $instructors = Instructor::with(['user', 'car'])->where('status', 'active')->get();

        return view('lessons.create', compact('students', 'instructors'));
    }

    /**
     * Store a newly created lesson in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'instructor_id' => ['required', 'exists:instructors,id'],
            'start_time' => ['required', 'date', 'after:now'],
            'end_time' => ['required', 'date', 'after:start_time'],
            'pickup_location' => ['required', 'string', 'max:255'],
            'dropoff_location' => ['nullable', 'string', 'max:255'],
            'lesson_type' => ['required', 'in:regular,exam,theory,evaluation'],
            'notes' => ['nullable', 'string'],
        ]);

        // Check if instructor is available at the requested time
        $instructor = Instructor::findOrFail($validated['instructor_id']);
        $conflictingLessons = Lesson::where('instructor_id', $instructor->id)
            ->where(function($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhere(function($q) use ($validated) {
                        $q->where('start_time', '<=', $validated['start_time'])
                          ->where('end_time', '>=', $validated['end_time']);
                    });
            })
            ->count();

        if ($conflictingLessons > 0) {
            return redirect()->back()->withInput()
                ->with('error', 'Instructor is not available at the selected time.');
        }

        // Set default values
        $validated['status'] = 'scheduled';
        $validated['dropoff_location'] = $validated['dropoff_location'] ?? $validated['pickup_location'];

        $lesson = Lesson::create($validated);

        return redirect()->route('lessons.index')
            ->with('success', 'Lesson scheduled successfully.');
    }

    /**
     * Display the specified lesson.
     */
    public function show(Lesson $lesson)
    {
        $lesson->load(['student.user', 'instructor.user', 'instructor.car']);
        return view('lessons.show', compact('lesson'));
    }

    /**
     * Show the form for editing the specified lesson.
     */
    public function edit(Lesson $lesson)
    {
        $students = Student::with('user')->get();
        $instructors = Instructor::with(['user', 'car'])->where('status', 'active')->get();

        return view('lessons.edit', compact('lesson', 'students', 'instructors'));
    }

    /**
     * Update the specified lesson in storage.
     */
    public function update(Request $request, Lesson $lesson)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'instructor_id' => ['required', 'exists:instructors,id'],
            'start_time' => ['required', 'date'],
            'end_time' => ['required', 'date', 'after:start_time'],
            'pickup_location' => ['required', 'string', 'max:255'],
            'dropoff_location' => ['nullable', 'string', 'max:255'],
            'lesson_type' => ['required', 'in:regular,exam,theory,evaluation'],
            'status' => ['required', 'in:scheduled,completed,cancelled,no_show'],
            'notes' => ['nullable', 'string'],
            'feedback' => ['nullable', 'string'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
        ]);

        // Check for instructor conflict only if changing time or instructor
        if ($lesson->instructor_id != $validated['instructor_id'] ||
            $lesson->start_time != $validated['start_time'] ||
            $lesson->end_time != $validated['end_time']) {

            // Check if instructor is available at the requested time
            $conflictingLessons = Lesson::where('instructor_id', $validated['instructor_id'])
                ->where('id', '!=', $lesson->id)
                ->where(function($query) use ($validated) {
                    $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                        ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                        ->orWhere(function($q) use ($validated) {
                            $q->where('start_time', '<=', $validated['start_time'])
                              ->where('end_time', '>=', $validated['end_time']);
                        });
                })
                ->count();

            if ($conflictingLessons > 0) {
                return redirect()->back()->withInput()
                    ->with('error', 'Instructor is not available at the selected time.');
            }
        }

        // Set default dropoff location if not provided
        $validated['dropoff_location'] = $validated['dropoff_location'] ?? $validated['pickup_location'];

        $lesson->update($validated);

        return redirect()->route('lessons.index')
            ->with('success', 'Lesson updated successfully.');
    }

    /**
     * Remove the specified lesson from storage.
     */
    public function destroy(Lesson $lesson)
    {
        // Only allow deletion of future lessons
        if ($lesson->start_time <= now()) {
            return redirect()->route('lessons.index')
                ->with('error', 'Cannot delete lessons that have already started or completed.');
        }

        $lesson->delete();

        return redirect()->route('lessons.index')
            ->with('success', 'Lesson deleted successfully.');
    }

    /**
     * Confirm a lesson.
     */
    public function confirm(Lesson $lesson)
    {
        if ($lesson->status !== 'scheduled') {
            return redirect()->route('lessons.show', $lesson)
                ->with('error', 'Only scheduled lessons can be confirmed.');
        }

        $lesson->update([
            'status' => 'confirmed',
            'confirmation_date' => now(),
        ]);

        return redirect()->route('lessons.show', $lesson)
            ->with('success', 'Lesson confirmed successfully.');
    }

    /**
     * Cancel a lesson.
     */
    public function cancel(Request $request, Lesson $lesson)
    {
        if ($lesson->status !== 'scheduled' && $lesson->status !== 'confirmed') {
            return redirect()->route('lessons.show', $lesson)
                ->with('error', 'Only scheduled or confirmed lessons can be cancelled.');
        }

        // Validate cancellation reason
        $validated = $request->validate([
            'cancellation_reason' => ['required', 'string'],
        ]);

        $lesson->update([
            'status' => 'cancelled',
            'cancellation_date' => now(),
            'cancellation_reason' => $validated['cancellation_reason'],
        ]);

        return redirect()->route('lessons.show', $lesson)
            ->with('success', 'Lesson cancelled successfully.');
    }

    /**
     * Show calendar view of lessons.
     */
    public function calendar(Request $request)
    {
        $instructorId = $request->query('instructor_id');
        $studentId = $request->query('student_id');

        $query = Lesson::with(['student.user', 'instructor.user']);

        if ($instructorId) {
            $query->where('instructor_id', $instructorId);
        }

        if ($studentId) {
            $query->where('student_id', $studentId);
        }

        $lessons = $query->orderBy('start_time')->get();
        $instructors = Instructor::with('user')->get();
        $students = Student::with('user')->get();

        return view('lessons.calendar', compact('lessons', 'instructors', 'students', 'instructorId', 'studentId'));
    }

    /**
     * Get lessons for a specific instructor.
     */
    public function instructorLessons(Instructor $instructor)
    {
        $lessons = Lesson::where('instructor_id', $instructor->id)
            ->with(['student.user'])
            ->orderBy('start_time')
            ->paginate(15);

        return view('lessons.instructor', compact('instructor', 'lessons'));
    }

    /**
     * Get lessons for a specific student.
     */
    public function studentLessons(Student $student)
    {
        $lessons = Lesson::where('student_id', $student->id)
            ->with(['instructor.user', 'instructor.car'])
            ->orderBy('start_time')
            ->paginate(15);

        return view('lessons.student', compact('student', 'lessons'));
    }
}
