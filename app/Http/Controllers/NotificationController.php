<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the notifications.
     */
    public function index()
    {
        $notifications = Notification::latest()->paginate(10);
        return view('notifications.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new notification.
     */
    public function create()
    {
        $users = User::all();
        return view('notifications.create', compact('users'));
    }

    /**
     * Store a newly created notification in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'type' => ['required', 'string', 'in:info,warning,success,danger'],
            'recipient_id' => ['nullable', 'exists:users,id'],
            'is_broadcast' => ['boolean'],
            'scheduled_at' => ['nullable', 'date'],
        ]);

        $notification = Notification::create($validated);

        return redirect()->route('notifications.index')
            ->with('success', 'Notification created successfully.');
    }

    /**
     * Display the specified notification.
     */
    public function show(Notification $notification)
    {
        return view('notifications.show', compact('notification'));
    }

    /**
     * Show the form for editing the specified notification.
     */
    public function edit(Notification $notification)
    {
        $users = User::all();
        return view('notifications.edit', compact('notification', 'users'));
    }

    /**
     * Update the specified notification in storage.
     */
    public function update(Request $request, Notification $notification)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'type' => ['required', 'string', 'in:info,warning,success,danger'],
            'recipient_id' => ['nullable', 'exists:users,id'],
            'is_broadcast' => ['boolean'],
            'scheduled_at' => ['nullable', 'date'],
        ]);

        $notification->update($validated);

        return redirect()->route('notifications.index')
            ->with('success', 'Notification updated successfully.');
    }

    /**
     * Remove the specified notification from storage.
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();

        return redirect()->route('notifications.index')
            ->with('success', 'Notification deleted successfully.');
    }

    /**
     * Send the specified notification.
     */
    public function send(Notification $notification)
    {
        // Here you would implement the logic to actually send the notification
        // This could involve using Laravel's notification system

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
        $notifications = Notification::where('recipient_id', $user->id)
            ->orWhere('is_broadcast', true)
            ->latest()
            ->paginate(10);

        return view('notifications.user', compact('notifications', 'user'));
    }
}
