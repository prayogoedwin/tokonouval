<x-layouts.app>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Dashboard')}}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('Welcome to the dashboard') }}</p>
    </div>

    <div class="">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
            {{ __('Welcome back,') }} {{ auth()->user()->name ?? 'Guest' }}!
        </h1>
    </div>

</x-layouts.app>