@props(['mobile' => false, 'active' => false])

@auth
<div class="relative">
    @if($mobile)
        <a href="{{ route('notifications.index') }}"
           class="{{ $attributes->get('class') ?? 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium flex items-center' }} {{ request()->routeIs('notifications.*') ? 'bg-blue-50 dark:bg-slate-800 border-blue-500 text-blue-700 dark:text-white' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            Meldingen
            @php $notificationCount = Auth::user()->getUnreadNotificationsCount(); @endphp
            @if($notificationCount > 0)
                <span class="ml-2 flex items-center justify-center w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full">
                    {{ $notificationCount > 99 ? '99+' : $notificationCount }}
                </span>
            @endif
        </a>

        @if(Auth::user()->isInstructor())
        <a href="{{ route('notifications.instructor-students') }}"
           class="{{ $attributes->get('class') ?? 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium flex items-center' }} {{ request()->routeIs('notifications.instructor-students') ? 'bg-blue-50 dark:bg-slate-800 border-blue-500 text-blue-700 dark:text-white' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            Mijn Studenten
        </a>
        @endif
    @else
        <div class="inline-flex items-center">
            <a href="{{ route('notifications.index') }}"
               class="{{ $attributes->get('class') ?? 'nav-item border-transparent text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white hover:border-gray-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium' }} {{ request()->routeIs('notifications.*') && !request()->routeIs('notifications.instructor-students') ? 'border-blue-500 text-gray-900 dark:text-gray-100' : '' }}">
                <div class="relative flex items-center pt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    @php $notificationCount = Auth::user()->getUnreadNotificationsCount(); @endphp
                    @if($notificationCount > 0)
                        <span class="absolute -top-1 -right-2 flex items-center justify-center w-4 h-4 bg-red-500 text-white text-xs font-bold rounded-full">
                            {{ $notificationCount > 99 ? '99+' : $notificationCount }}
                        </span>
                    @endif
                </div>
            </a>

            @if(Auth::user()->isInstructor())
            <a href="{{ route('notifications.instructor-students') }}"
               class="{{ $attributes->get('class') ?? 'nav-item border-transparent text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white hover:border-gray-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium ml-4' }} {{ request()->routeIs('notifications.instructor-students') ? 'border-blue-500 text-gray-900 dark:text-gray-100' : '' }}">
                <div class="relative flex items-center pt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </a>
            @endif
        </div>
    @endif
</div>
@endauth
