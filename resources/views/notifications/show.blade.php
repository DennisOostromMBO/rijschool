@extends('layouts.app')

@section('title', 'Notificatie Details')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header met titel -->
    <div class="bg-blue-600 dark:bg-blue-800 text-white p-4 flex justify-between items-center rounded-t-lg">
        <h1 class="text-2xl font-semibold text-white">Notificatie Details</h1>
        <div class="flex space-x-2">
            <a href="{{ route('notifications.index') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Terug
            </a>
            @if(auth()->user()->isAdmin() || (auth()->user()->isInstructor() && $notification->user_id == auth()->id()))
            <a href="{{ route('notifications.edit', $notification) }}" class="text-white bg-amber-600 hover:bg-amber-700 focus:ring-4 focus:ring-amber-300 font-medium rounded-lg text-sm px-3 py-2 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                </svg>
                Bewerken
            </a>
            @endif
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-b-lg shadow-md">
        <!-- Notificatie details -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Bericht en opmerking kolom -->
                <div class="col-span-2 space-y-6">
                    <!-- Titel -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Titel</h3>
                        <div class="bg-gray-50 dark:bg-slate-700 rounded-md p-4 text-gray-800 dark:text-gray-200 font-medium">
                            {{ $notification->title ?? 'Geen titel' }}
                        </div>
                    </div>
                    
                    <!-- Bericht -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Bericht</h3>
                        <div class="bg-gray-50 dark:bg-slate-700 rounded-md p-4 text-gray-800 dark:text-gray-200">
                            {{ $notification->message }}
                        </div>
                    </div>

                    <!-- Opmerking -->
                    @if($notification->remark)
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Opmerking</h3>
                        <div class="bg-gray-50 dark:bg-slate-700 rounded-md p-4 text-gray-800 dark:text-gray-200 italic">
                            {{ $notification->remark }}
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Metadata kolom -->
                <div class="space-y-4">
                    <!-- Type -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Type</h3>
                        @php
                            $typeColors = [
                                'Sick' => 'bg-red-600 dark:bg-red-700',
                                'LessonChange' => 'bg-amber-600 dark:bg-amber-700',
                                'LessonCancellation' => 'bg-red-600 dark:bg-red-700',
                                'PickupAddressChange' => 'bg-blue-600 dark:bg-blue-700',
                                'LessonGoalChange' => 'bg-purple-600 dark:bg-purple-700',
                                'LessonAssignment' => 'bg-green-600 dark:bg-green-700',
                                'default' => 'bg-gray-600 dark:bg-gray-700'
                            ];
                            $typeLabels = [
                                'Sick' => 'Ziekmelding',
                                'LessonChange' => 'Leswijziging',
                                'LessonCancellation' => 'Lesannulering',
                                'PickupAddressChange' => 'Ophaaladres',
                                'LessonGoalChange' => 'Lesdoel',
                                'LessonAssignment' => 'Lestoewijzing',
                                'default' => 'Onbekend'
                            ];
                            $bgColor = $typeColors[$notification->notification_type] ?? $typeColors['default'];
                            $label = $typeLabels[$notification->notification_type] ?? $typeLabels['default'];
                        @endphp
                        <div class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $bgColor }} text-white">
                                {{ $label }}
                            </span>
                        </div>
                    </div>

                    <!-- Doelgroep -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Doelgroep</h3>
                        <div class="mt-1">
                            @if($notification->target_group === 'Student')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-600 dark:bg-orange-700 text-white">
                                    Studenten
                                </span>
                            @elseif($notification->target_group === 'Instructor')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-600 dark:bg-green-700 text-white">
                                    Instructeurs
                                </span>
                            @elseif($notification->target_group === 'Both')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-600 dark:bg-purple-700 text-white">
                                    Allemaal
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-600 dark:bg-gray-700 text-white">
                                    {{ $notification->target_group ?? 'Onbekend' }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Datum -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Datum</h3>
                        <div class="mt-1 text-gray-900 dark:text-gray-100">
                            {{ $notification->date ? $notification->date->format('d-m-Y') : 'N/A' }}
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</h3>
                        <div class="mt-1">
                            @if($notification->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-800/30 text-green-800 dark:text-green-200">
                                    <span class="h-2 w-2 rounded-full bg-green-500 mr-1"></span>
                                    Actief
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-800/30 text-gray-800 dark:text-gray-200">
                                    <span class="h-2 w-2 rounded-full bg-gray-500 mr-1"></span>
                                    Inactief
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Aangemaakt door -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Aangemaakt door</h3>
                        <div class="mt-1 text-gray-900 dark:text-gray-100">
                            {{ $notification->user->full_name ?? 'Onbekend' }}
                        </div>
                    </div>

                    <!-- Aanmaak- en wijzigingsdatum -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Aangemaakt op</h3>
                        <div class="mt-1 text-gray-900 dark:text-gray-100">
                            {{ $notification->created_at->format('d-m-Y H:i') }}
                        </div>
                    </div>

                    @if($notification->created_at != $notification->updated_at)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Laatst bijgewerkt op</h3>
                        <div class="mt-1 text-gray-900 dark:text-gray-100">
                            {{ $notification->updated_at->format('d-m-Y H:i') }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actiebuttons -->
        <div class="px-6 py-4 flex justify-between">
            <div>
                <a href="{{ route('notifications.index') }}" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-800 dark:text-white rounded-md text-sm font-medium transition">
                    Terug naar overzicht
                </a>
            </div>
            @if(auth()->user()->isAdmin() || auth()->user()->isInstructor())
            <div class="flex space-x-2">
                @if(!$notification->is_sent)
                <form action="{{ route('notifications.send', $notification) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md text-sm font-medium transition flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                        </svg>
                        Notificatie Verzenden
                    </button>
                </form>
                @else
                <span class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded-md text-sm font-medium flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Verzonden op {{ $notification->sent_at ? $notification->sent_at->format('d-m-Y H:i') : 'onbekend' }}
                </span>
                @endif
                
                @if(auth()->user()->isAdmin() || (auth()->user()->isInstructor() && $notification->user_id == auth()->id()))
                <form action="{{ route('notifications.destroy', $notification) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md text-sm font-medium transition flex items-center"
                        onclick="return confirm('Weet je zeker dat je deze notificatie wilt verwijderen?')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        Verwijderen
                    </button>
                </form>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
