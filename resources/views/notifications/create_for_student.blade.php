@extends('layouts.app')

@section('title', 'Notificatie voor ' . $student->first_name)

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-md overflow-hidden">
        <!-- Header met titel -->
        <div class="bg-blue-600 dark:bg-blue-800 text-white p-4">
            <h1 class="text-2xl font-semibold text-white">Notificatie voor {{ $student->first_name }} {{ $student->last_name }}</h1>
            <p class="text-blue-100 mt-1">Stuur een persoonlijke notificatie naar deze student</p>
        </div>

        <div class="p-6">
            <form action="{{ route('notifications.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Notificatie Titel -->
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Titel <span class="text-red-600">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:text-white">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notificatie Bericht -->
                    <div class="md:col-span-2">
                        <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bericht <span class="text-red-600">*</span></label>
                        <textarea id="message" name="message" rows="4" required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:text-white">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type Notificatie -->
                    <div>
                        <label for="notification_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type Notificatie <span class="text-red-600">*</span></label>
                        <select id="notification_type" name="notification_type" required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:text-white">
                            <option value="" disabled {{ old('notification_type') ? '' : 'selected' }}>Kies een type</option>
                            <option value="Sick" {{ old('notification_type') == 'Sick' ? 'selected' : '' }}>Ziekmelding</option>
                            <option value="LessonChange" {{ old('notification_type') == 'LessonChange' ? 'selected' : '' }}>Leswijziging</option>
                            <option value="LessonCancellation" {{ old('notification_type') == 'LessonCancellation' ? 'selected' : '' }}>Lesannulering</option>
                            <option value="PickupAddressChange" {{ old('notification_type') == 'PickupAddressChange' ? 'selected' : '' }}>Ophaaladres wijziging</option>
                            <option value="LessonGoalChange" {{ old('notification_type') == 'LessonGoalChange' ? 'selected' : '' }}>Lesdoel wijziging</option>
                            <option value="LessonAssignment" {{ old('notification_type') == 'LessonAssignment' ? 'selected' : '' }}>Lestoewijzing</option>
                        </select>
                        @error('notification_type')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Datum -->
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Datum <span class="text-red-600">*</span></label>
                        <input type="date" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:text-white">
                        @error('date')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>                    <!-- Hidden Doelgroep en Gebruiker -->
                    <input type="hidden" name="target_group" value="Student">
                    <input type="hidden" name="recipient_id" value="{{ $student->id }}">

                    <!-- Opmerkingen -->
                    <div class="md:col-span-2">
                        <label for="remark" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Opmerkingen (optioneel)</label>
                        <textarea id="remark" name="remark" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:text-white">{{ old('remark') }}</textarea>
                        @error('remark')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Actief -->
                    <div class="md:col-span-2">
                        <div class="flex items-center">
                            <input id="is_active" name="is_active" type="checkbox" checked
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-slate-600 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Actief (aangevinkt betekent dat de notificatie zichtbaar is)
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end space-x-3">
                    <a href="{{ route('notifications.instructor-students') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 dark:border-slate-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-slate-700 hover:bg-gray-50 dark:hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Annuleren
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Notificatie Aanmaken
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
