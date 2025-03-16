<x-layouts.app :title="'Election Results'" :header="'Executive Elections'">
    <div class="container mx-auto py-8 px-4">
        <p class="text-center text-gray-600 mb-8">
            View election results
        </p>

        @if($activeElection)
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold text-green-600 mb-4">Active Election</h2>

            <div class="border border-gray-200 rounded-lg p-4">
                <h3 class="text-lg font-medium">{{ $activeElection->title }}</h3>

                <div class="mt-2 text-sm text-gray-600">
                    <div>
                        <span class="font-medium">Start Date:</span>
                        {{ \Carbon\Carbon::parse($activeElection->start_date)->format('M d, Y h:i A') }}
                    </div>
                    <div>
                        <span class="font-medium">End Date:</span>
                        {{ \Carbon\Carbon::parse($activeElection->end_date)->format('M d, Y h:i A') }}
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
