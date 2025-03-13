<header class="bg-slate-600 text-white shadow-md">
    <div class="container mx-auto py-4 px-4 flex justify-between items-center">
        <div class="flex items-center">
            <div class="bg-slate-700 rounded-full p-2 flex items-center justify-center mr-3">
                <img src="{{ asset('images/voting-logo.svg') }}" alt="Voting Logo" class="h-8 w-8">
            </div>
            <h1 class="text-2xl font-bold">
                <a href="{{ url('/') }}">Executive Voting System</a>
            </h1>
        </div>
        <nav class="space-x-4">
            <a href="{{ route('vote.index') }}" class="hover:text-blue-200 transition">Vote</a>
            <a href="{{ route('results.index') }}" class="hover:text-blue-200 transition">Results</a>
            @if(request()->is('admin*'))
            <a href="{{ url('/admin') }}"
                class="bg-white text-blue-600 px-3 py-1 rounded hover:bg-blue-100 transition">Admin</a>
            @endif
        </nav>
    </div>
</header>
