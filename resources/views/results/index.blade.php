<x-layouts.app :title="'Election Results'" :header="'Executive Elections'">
    <div class="container mx-auto py-8 px-4">

        <div class="flex items-center justify-between mb-8">
            <p class="text-gray-600">
                View election results
            </p>
            <div>
                <a href="{{ route('home') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    Return to Home
                </a>
            </div>
        </div>

        @if($activeElection)
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold text-green-600 mb-4">Active Election</h2>

            <div class="border border-gray-200 rounded-lg p-4">
                <h3 class="text-lg font-medium">{{ $activeElection->title }}</h3>

                <div class="mt-2 text-sm text-gray-600">
                    <div>
                        <span class="font-medium">Start Date:</span>
                        {{ \Carbon\Carbon::parse($activeElection->start_date->setTimezone('Asia/Bangkok'))->format('M d, Y h:i A') }}
                    </div>
                    <div>
                        <span class="font-medium">End Date:</span>
                        {{ \Carbon\Carbon::parse($activeElection->end_date->setTimezone('Asia/Bangkok'))->format('M d, Y h:i A') }}
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('results.show', $activeElection) }}"
                        class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-medium px-4 py-2 rounded">
                        View Live Results
                    </a>

                    <a href="{{ route('vote.index') }}"
                        class="inline-block ml-2 bg-green-500 hover:bg-green-600 text-white font-medium px-4 py-2 rounded">
                        Cast Your Vote
                    </a>
                </div>
            </div>
        </div>
        @endif

        @if($completedElections->count() > 0)
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Past Elections</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($completedElections as $election)
                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                    <h3 class="text-lg font-medium">{{ $election->title }}</h3>

                    <div class="mt-2 text-sm text-gray-600">
                        <div>
                            <span class="font-medium">Date:</span>
                            {{ \Carbon\Carbon::parse($election->start_date)->format('M d, Y') }}
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('results.show', $election) }}"
                            class="inline-block bg-gray-500 hover:bg-gray-600 text-white font-medium px-4 py-2 rounded">
                            View Results
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-500">
            <p>No past elections found.</p>
        </div>
        @endif

    </div>
</x-layouts.app>
