<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use App\Models\Student;
use App\Models\Lesson;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Constructor to set up middleware
     */
    public function __construct()
    {
        // Middleware is now applied in the routes file or using route middleware groups
        // The middleware('auth') call has been removed from the controller
    }

    /**
     * Check if the current user has permission to access the given action
     */
    private function checkPermission(Request $request)
    {
        $user = Auth::user();

        // If user is not authenticated, redirect to login
        if (!$user) {
            abort(401, 'Unauthenticated.');
        }

        // If user is a student, they can only access index and show
        if ($user->isStudent()) {
            $route = $request->route()->getName();
            if (!in_array($route, ['notifications.index', 'notifications.show'])) {
                abort(403, 'Unauthorized action.');
            }
        }

        return true;
    }

    /**
     * Display a listing of the notifications.
     */
    public function index(Request $request)
    {
        $this->checkPermission($request);

        $query = Notification::query();
        $user = auth()->user();
        $viewType = 'default';

        // Different behavior based on role
        if ($user->isAdmin()) {
            // Admin can see all notifications
            $viewType = 'admin';

            // Apply search filter if provided
            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where('message', 'like', "%{$search}%")
                      ->orWhere('remark', 'like', "%{$search}%");
            }

            // Apply notification type filter if provided
            if ($request->filled('notification_type')) {
                $query->where('notification_type', $request->input('notification_type'));
            }

            // Apply target group filter if provided
            if ($request->filled('target_group')) {
                $query->where('target_group', $request->input('target_group'));
            }
        }
        elseif ($user->isInstructor()) {
            // Instructors see their notifications and ones targeted to instructors
            $viewType = 'instructor';

            // Get the list of students assigned to this instructor
            $assignedStudents = [];
            if ($user->instructor) {
                $assignedStudents = $user->instructor->students->pluck('id')->toArray();
            }

            // Apply search filter if provided
            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where(function($q) use ($search) {
                    $q->where('message', 'like', "%{$search}%")
                      ->orWhere('remark', 'like', "%{$search}%");
                });
            }

            $query->where(function($q) use ($user) {
                $q->where('target_group', 'Instructor')
                  ->orWhere('target_group', 'Both')
                  ->orWhere('user_id', $user->id);
            });
        }
        elseif ($user->isStudent()) {
            // Students only see notifications targeted to them
            $viewType = 'student';

            // Apply search filter if provided
            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where(function($q) use ($search) {
                    $q->where('message', 'like', "%{$search}%")
                      ->orWhere('remark', 'like', "%{$search}%");
                });
            }

            $query->where(function($q) use ($user) {
                $q->where('target_group', 'Student')
                  ->orWhere('target_group', 'Both');
            });
        }

        // Apply sorting if provided
        $sortBy = $request->input('sort_by', 'date');
        $sortDirection = $request->input('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        // Get paginated results
        $perPage = $request->input('per_page', 10);
        $notifications = $query->paginate($perPage)->withQueryString();

        return view('notifications.index', compact('notifications', 'viewType'));
    }

    /**
     * Show the form for creating a new notification.
     */
    public function create(Request $request)
    {
        $this->checkPermission($request);

        // Students cannot access this method (already restricted by checkPermission)
        $user = auth()->user();

        if ($user->isAdmin()) {
            // Admin can send notifications to all users
            $users = User::all();
        } else {
            // Instructors can only send notifications to their assigned students
            $users = collect();
            if ($user->instructor) {
                $studentIds = $user->instructor->students()->pluck('student_id')->toArray();
                $users = User::whereHas('student', function($query) use ($studentIds) {
                    $query->whereIn('id', $studentIds);
                })->get();
            }
        }

        return view('notifications.create', compact('users'));
    }

    /**
     * Store a newly created notification in storage.
     */
    public function store(Request $request)
    {
        $this->checkPermission($request);

        $validated = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'message' => ['required', 'string', 'min:10'],
            'notification_type' => ['required', 'string', 'in:Sick,LessonChange,LessonCancellation,PickupAddressChange,LessonGoalChange,LessonAssignment'],
            'target_group' => ['required', 'string', 'in:Student,Instructor,Both'],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'is_active' => ['nullable', 'boolean'],
            'remark' => ['nullable', 'string', 'max:500'],
            'recipient_id' => ['nullable', 'exists:users,id'],
        ], [
            'title.required' => 'Een titel is verplicht.',
            'title.min' => 'De titel moet minimaal 3 karakters bevatten.',
            'message.required' => 'Een bericht is verplicht.',
            'message.min' => 'Het bericht moet minimaal 10 karakters bevatten.',
            'notification_type.required' => 'Een type notificatie is verplicht.',
            'notification_type.in' => 'Ongeldige notificatie type.',
            'target_group.required' => 'Een doelgroep is verplicht.',
            'target_group.in' => 'Ongeldige doelgroep.',
            'date.required' => 'Een datum is verplicht.',
            'date.date' => 'Geen geldige datum.',
            'date.after_or_equal' => 'Datum moet vandaag of in de toekomst zijn.',
            'recipient_id.exists' => 'De geselecteerde ontvanger bestaat niet.',
        ]);

        // Set default user_id to current authenticated user
        $validated['user_id'] = auth()->id();
        // Set is_active default to true if not provided
        $validated['is_active'] = $request->has('is_active') ? true : false;

        $notification = Notification::create($validated);

        return redirect()->route('notifications.index')
            ->with('success', 'Notification created successfully.');
    }

    /**
     * Display the specified notification.
     */
    public function show(Notification $notification, Request $request)
    {
        $this->checkPermission($request);

        $user = auth()->user();

        // Automatically mark as read for students
        if ($user && $user->isStudent() && !$notification->is_read) {
            $notification->is_read = true;
            $notification->read_at = now();
            $notification->save();
        }

        return view('notifications.show', compact('notification'));
    }

    /**
     * Show the form for editing the specified notification.
     */
    public function edit(Notification $notification, Request $request)
    {
        $this->checkPermission($request);

        $user = auth()->user();

        // Instructors can only edit their own notifications
        if ($user->isInstructor() && $notification->user_id != $user->id) {
            return redirect()->route('notifications.index')
                ->with('error', 'You do not have permission to edit this notification.');
        }

        $users = User::all();
        return view('notifications.edit', compact('notification', 'users'));
    }

    /**
     * Update the specified notification in storage.
     */
    public function update(Request $request, Notification $notification)
    {
        $this->checkPermission($request);

        $user = auth()->user();

        // Instructors can only update their own notifications
        if ($user->isInstructor() && $notification->user_id != $user->id) {
            return redirect()->route('notifications.index')
                ->with('error', 'You do not have permission to update this notification.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'message' => ['required', 'string', 'min:10'],
            'notification_type' => ['required', 'string', 'in:Sick,LessonChange,LessonCancellation,PickupAddressChange,LessonGoalChange,LessonAssignment'],
            'target_group' => ['required', 'string', 'in:Student,Instructor,Both'],
            'date' => ['required', 'date'],
            'is_active' => ['nullable', 'boolean'],
            'remark' => ['nullable', 'string', 'max:500'],
        ], [
            'title.required' => 'Een titel is verplicht.',
            'title.min' => 'De titel moet minimaal 3 karakters bevatten.',
            'message.required' => 'Een bericht is verplicht.',
            'message.min' => 'Het bericht moet minimaal 10 karakters bevatten.',
            'notification_type.required' => 'Een type notificatie is verplicht.',
            'notification_type.in' => 'Ongeldige notificatie type.',
            'target_group.required' => 'Een doelgroep is verplicht.',
            'target_group.in' => 'Ongeldige doelgroep.',
            'date.required' => 'Een datum is verplicht.',
            'date.date' => 'Geen geldige datum.',
            'remark.max' => 'Opmerking mag maximaal 500 karakters bevatten.',
        ]);

        // Set is_active to true if checkbox is checked, false otherwise
        $validated['is_active'] = $request->has('is_active') ? true : false;

        $notification->update($validated);

        return redirect()->route('notifications.index')
            ->with('success', 'Notification updated successfully.');
    }

    /**
     * Remove the specified notification from storage.
     */
    public function destroy(Notification $notification, Request $request)
    {
        $this->checkPermission($request);

        $user = auth()->user();

        // Instructors can only delete their own notifications
        if ($user->isInstructor() && $notification->user_id != $user->id) {
            return redirect()->route('notifications.index')
                ->with('error', 'You do not have permission to delete this notification.');
        }

        $notification->delete();

        return redirect()->route('notifications.index')
            ->with('success', 'Notification deleted successfully.');
    }

    /**
     * Send the specified notification.
     */
    public function send(Notification $notification, Request $request)
    {
        $this->checkPermission($request);

        $user = auth()->user();

        // Only admins and instructors can send notifications
        if (!$user->isAdmin() && !$user->isInstructor()) {
            return redirect()->route('notifications.index')
                ->with('error', 'You do not have permission to send notifications.');
        }

        // Instructors can only send notifications to their students or ones they created
        if ($user->isInstructor() && $notification->user_id != $user->id &&
            !in_array($notification->target_group, ['Student', 'Both'])) {
            return redirect()->route('notifications.index')
                ->with('error', 'You do not have permission to send this notification.');
        }

        // Here you would implement the logic to actually send the notification
        // This could involve using Laravel's notification system, emails, or SMS

        $notification->is_sent = true;
        $notification->sent_at = now();
        $notification->save();

        return redirect()->route('notifications.index')
            ->with('success', 'Notification sent successfully.');
    }

    /**
     * Get notifications for a specific user.
     */
    public function userNotifications(User $user)
    {
        $currentUser = auth()->user();

        // Students can only view their own notifications
        if ($currentUser->isStudent() && $currentUser->id != $user->id) {
            return redirect()->route('notifications.index')
                ->with('error', 'You do not have permission to view other users\' notifications.');
        }

        // Instructors can only view their own or their students' notifications
        if ($currentUser->isInstructor() && $currentUser->id != $user->id) {
            // Check if the user is one of the instructor's students
            $isMyStudent = false;
            if ($currentUser->instructor) {
                $studentIds = $currentUser->instructor->students()->pluck('student_id')->toArray();
                $isMyStudent = in_array($user->id, $studentIds);
            }

            if (!$isMyStudent) {
                return redirect()->route('notifications.index')
                    ->with('error', 'You do not have permission to view this user\'s notifications.');
            }
        }

        $notifications = Notification::where(function($query) use ($user) {
                if ($user->isStudent()) {
                    $query->where('target_group', 'Student')
                          ->orWhere('target_group', 'Both');
                } else if ($user->isInstructor()) {
                    $query->where('target_group', 'Instructor')
                          ->orWhere('target_group', 'Both');
                }
            })
            ->orWhere('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('notifications.user', compact('notifications', 'user'));
    }

    /**
     * Get instructor's students for sending targeted notifications
     */
    public function instructorStudents(Request $request)
    {
        $this->checkPermission($request);

        $user = auth()->user();

        if (!$user->isInstructor()) {
            return redirect()->route('notifications.index')
                ->with('error', 'Only instructors can access this page.');
        }

        $students = collect();
        if ($user->instructor) {
            // First get a list of registrations for this instructor's lessons
            $registrationIds = Lesson::where('instructor_id', $user->instructor->id)
                ->distinct('registration_id')
                ->pluck('registration_id');

            // Then get the student IDs from those registrations
            $studentIds = Registration::whereIn('id', $registrationIds)
                ->pluck('student_id');

            // Get User objects for those students
            $students = User::whereHas('student', function($query) use ($studentIds) {
                $query->whereIn('id', $studentIds);
            })->get();
        }

        return view('notifications.instructor_students', compact('students'));
    }

    /**
     * Create a notification for a specific student (for instructors)
     */
    public function createForStudent(User $student, Request $request)
    {
        $this->checkPermission($request);

        $user = auth()->user();

        if (!$user->isInstructor()) {
            return redirect()->route('notifications.index')
                ->with('error', 'Only instructors can access this page.');
        }

        // Check if the student is assigned to this instructor
        if ($user->instructor) {
            // First get a list of registrations for this instructor's lessons
            $registrationIds = Lesson::where('instructor_id', $user->instructor->id)
                ->distinct('registration_id')
                ->pluck('registration_id');

            // Then check if any of these registrations belong to the student
            $isMyStudent = Registration::whereIn('id', $registrationIds)
                ->where('student_id', $student->student->id)
                ->exists();

            if (!$isMyStudent) {
                return redirect()->route('notifications.instructor-students')
                    ->with('error', 'This student is not assigned to you.');
            }
        } else {
            return redirect()->route('notifications.index')
                ->with('error', 'You do not have an instructor profile.');
        }

        return view('notifications.create_for_student', compact('student'));
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead(Request $request, Notification $notification)
    {
        try {
            $this->checkPermission($request);

            $user = $request->user();
            if (!$user) {
                throw new \Exception('User not authenticated');
            }

            $hasPermission = false;
            $isDirect = $notification->recipient_id == $user->id;
            $isStudentGroup = $user->isStudent() && $notification->isForStudents();
            $isInstructorGroup = $user->isInstructor() && $notification->isForInstructors();

            if ($isDirect) {
                $hasPermission = true;
            } elseif ($isStudentGroup || $isInstructorGroup) {
                $hasPermission = true;
            }

            if (!$hasPermission) {
                throw new \Exception('U heeft geen toegang tot deze notificatie.');
            }

            // Mark as read for both direct and group notifications
            if (!$notification->is_read && ($isDirect || $isStudentGroup || $isInstructorGroup)) {
                try {
                    // Use direct property assignment instead of mass assignment
                    $notification->is_read = true;
                    $notification->read_at = now();
                    $notification->save();
                } catch (\Exception $e) {
                    \Log::error('Failed to mark notification as read: ' . $e->getMessage());
                    throw $e;
                }
            }

            $message = 'Notificatie gemarkeerd als gelezen';
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message
                ]);
            }

            return back()->with('success', $message);

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Er is een fout opgetreden bij het markeren van de notificatie als gelezen: ' . $e->getMessage()
                ], 400);
            }

            return back()->with('error', 'Er is een fout opgetreden bij het markeren van de notificatie als gelezen: ' . $e->getMessage());
        }
    }

    /**
     * Mark all notifications as read for the current user.
     */
    public function markAllAsRead(Request $request)
    {
        try {
            $this->checkPermission($request);

            $user = $request->user();
            if (!$user) {
                throw new \Exception('User not authenticated');
            }

            // Mark all relevant notifications as read for this user
            $notificationsQuery = Notification::where('is_read', false);

            if ($user->isStudent()) {
                // For students, mark both direct notifications and student group notifications
                $notificationsQuery->where(function($query) use ($user) {
                    $query->where('recipient_id', $user->id)
                          ->orWhere(function($q) {
                              $q->where('target_group', 'Student')
                                ->orWhere('target_group', 'Both');
                          });
                });
            } else {
                // For other users, only mark direct notifications
                $notificationsQuery->where('recipient_id', $user->id);
            }

            $count = $notificationsQuery->count();
            if ($count === 0) {
                throw new \Exception('Geen ongelezen notificaties gevonden');
            }

            // Get the notifications first, then update them individually to avoid mass assignment issues
            $notifications = $notificationsQuery->get();
            foreach ($notifications as $notification) {
                $notification->is_read = true;
                $notification->read_at = now();
                $notification->save();
            }

            $message = 'Alle notificaties gemarkeerd als gelezen';
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'count' => $count
                ]);
            }

            return back()->with('success', $message);

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Er is een fout opgetreden bij het markeren van alle notificaties als gelezen: ' . $e->getMessage()
                ], 400);
            }

            return back()->with('error', 'Er is een fout opgetreden bij het markeren van alle notificaties als gelezen: ' . $e->getMessage());
        }
    }
}
