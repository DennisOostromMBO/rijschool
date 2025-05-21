@extends('layouts.app')

@section('title', 'Nieuwe Notificatie')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header met titel -->
    <div class="bg-blue-600 dark:bg-blue-800 text-white p-4 flex justify-between items-center rounded-t-lg">
        <h1 class="text-2xl font-semibold text-white">Nieuwe Notificatie</h1>
        <a href="{{ route('notifications.index') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Terug naar overzicht
        </a>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-b-lg shadow-md p-6">
        <form method="POST" action="{{ route('notifications.store') }}" class="space-y-6">
            @csrf

            <!-- Notificatie details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Titel -->
                <div class="col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Titel <span class="text-red-600">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-30" required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bericht -->
                <div class="col-span-2">
                    <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bericht <span class="text-red-600">*</span></label>
                    <textarea name="message" id="message" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-30" required>{{ old('message') }}</textarea>
                    @error('message')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type -->
                <div>
                    <label for="notification_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type <span class="text-red-600">*</span></label>
                    <select name="notification_type" id="notification_type" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-30" required>
                        <option value="">Selecteer een type</option>
                        <option value="Sick" {{ old('notification_type') == 'Sick' ? 'selected' : '' }}>Ziekmelding</option>
                        <option value="LessonChange" {{ old('notification_type') == 'LessonChange' ? 'selected' : '' }}>Leswijziging</option>
                        <option value="LessonCancellation" {{ old('notification_type') == 'LessonCancellation' ? 'selected' : '' }}>Lesannulering</option>
                        <option value="PickupAddressChange" {{ old('notification_type') == 'PickupAddressChange' ? 'selected' : '' }}>Ophaaladres wijziging</option>
                        <option value="LessonGoalChange" {{ old('notification_type') == 'LessonGoalChange' ? 'selected' : '' }}>Lesdoel wijziging</option>
                        <option value="LessonAssignment" {{ old('notification_type') == 'LessonAssignment' ? 'selected' : '' }}>Lestoewijzing</option>
                    </select>
                    @error('notification_type')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Doelgroep -->
                <div>
                    <label for="target_group" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Doelgroep <span class="text-red-600">*</span></label>
                    <select name="target_group" id="target_group" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-30" required>
                        <option value="">Selecteer een doelgroep</option>
                        <option value="Student" {{ old('target_group') == 'Student' ? 'selected' : '' }}>Studenten</option>
                        <option value="Instructor" {{ old('target_group') == 'Instructor' ? 'selected' : '' }}>Instructeurs</option>
                        <option value="Both" {{ old('target_group') == 'Both' ? 'selected' : '' }}>Beide</option>
                    </select>
                    @error('target_group')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Datum -->
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Datum <span class="text-red-600">*</span></label>
                    <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-30" required>
                    @error('date')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="is_active" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <div class="mt-1 flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" class="rounded dark:bg-slate-700 border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                        <label for="is_active" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Actief</label>
                    </div>
                    @error('is_active')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Opmerkingen -->
                <div class="col-span-2">
                    <label for="remark" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Opmerking (optioneel)</label>
                    <textarea name="remark" id="remark" rows="2" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-30">{{ old('remark') }}</textarea>
                    @error('remark')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Button groep -->
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('notifications.index') }}" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-800 dark:text-white rounded-md text-sm font-medium transition">
                    Annuleren
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium transition">
                    Notificatie Opslaan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
