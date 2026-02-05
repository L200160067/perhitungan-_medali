<nav class="bg-gradient-to-r from-blue-600 to-blue-800 shadow-lg">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <a href="{{ url('/') }}" class="text-white text-xl font-bold">
                        🥋 Medal System
                    </a>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="{{ url('/') }}" class="rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 transition {{ request()->is('/') ? 'bg-blue-700' : '' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('events.index') }}" class="rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 transition {{ request()->is('events*') ? 'bg-blue-700' : '' }}">
                            Events
                        </a>
                        <a href="{{ route('dojangs.index') }}" class="rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 transition {{ request()->is('dojangs*') ? 'bg-blue-700' : '' }}">
                            Dojangs
                        </a>
                        <a href="{{ route('participants.index') }}" class="rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 transition {{ request()->is('participants*') ? 'bg-blue-700' : '' }}">
                            Participants
                        </a>
                        <a href="{{ route('contingents.index') }}" class="rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 transition {{ request()->is('contingents*') ? 'bg-blue-700' : '' }}">
                            Contingents
                        </a>
                        <a href="{{ route('tournament-categories.index') }}" class="rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 transition {{ request()->is('tournament-categories*') ? 'bg-blue-700' : '' }}">
                            Categories
                        </a>
                        <a href="{{ route('registrations.index') }}" class="rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 transition {{ request()->is('registrations*') ? 'bg-blue-700' : '' }}">
                            Registrations
                        </a>
                        <a href="{{ route('medals.index') }}" class="rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 transition {{ request()->is('medals*') ? 'bg-blue-700' : '' }}">
                            Medals
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div class="md:hidden" id="mobile-menu">
        <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
            <a href="{{ url('/') }}" class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-blue-700 {{ request()->is('/') ? 'bg-blue-700' : '' }}">Dashboard</a>
            <a href="{{ route('events.index') }}" class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-blue-700 {{ request()->is('events*') ? 'bg-blue-700' : '' }}">Events</a>
            <a href="{{ route('dojangs.index') }}" class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-blue-700 {{ request()->is('dojangs*') ? 'bg-blue-700' : '' }}">Dojangs</a>
            <a href="{{ route('participants.index') }}" class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-blue-700 {{ request()->is('participants*') ? 'bg-blue-700' : '' }}">Participants</a>
            <a href="{{ route('contingents.index') }}" class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-blue-700 {{ request()->is('contingents*') ? 'bg-blue-700' : '' }}">Contingents</a>
            <a href="{{ route('tournament-categories.index') }}" class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-blue-700 {{ request()->is('tournament-categories*') ? 'bg-blue-700' : '' }}">Categories</a>
            <a href="{{ route('registrations.index') }}" class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-blue-700 {{ request()->is('registrations*') ? 'bg-blue-700' : '' }}">Registrations</a>
            <a href="{{ route('medals.index') }}" class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-blue-700 {{ request()->is('medals*') ? 'bg-blue-700' : '' }}">Medals</a>
        </div>
    </div>
</nav>
