<x-layouts.app>
    <x-slot:title>Executive Voting</x-slot:title>
    <x-slot:header>Executive Voting System</x-slot:header>

    <div class="max-w-3xl mx-auto text-center">
        <p class="text-lg text-gray-600 mb-8">
            Welcome to the Executive Voting System. This platform enables transparent, fair, and inclusive election
            processes for executive member positions.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
            <div class="bg-white p-8 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-blue-500 mb-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="text-xl font-bold mb-2">Cast Your Vote</h3>
                <p class="text-gray-600 mb-4">Participate in the election by casting your vote for executive positions.
                </p>
                <a href="{{ route('vote.index') }}"
                    class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-medium px-6 py-2 rounded">
                    Vote Now
                </a>
            </div>

            <div class="bg-white p-8 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-green-500 mb-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <h3 class="text-xl font-bold mb-2">View Results</h3>
                <p class="text-gray-600 mb-4">Monitor election results in real-time with live updates.</p>
                <a href="{{ route('results.index') }}"
                    class="inline-block bg-green-500 hover:bg-green-600 text-white font-medium px-6 py-2 rounded">
                    See Results
                </a>
            </div>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h2 class="text-xl font-bold text-blue-800 mb-3">About the Voting System</h2>
            <p class="text-blue-700">
                This application ensures transparent, fair, and inclusive election processes. The five executive members
                must be from different organizations, and voting follows a one-person-one-vote procedure. Results are
                tabulated in real-time.
            </p>
        </div>
    </div>
</x-layouts.app>
