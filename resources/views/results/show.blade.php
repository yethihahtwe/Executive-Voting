<x-layouts.app :title="$election->title . ' - Voting Results'" :header="$election->title">
    <!-- Back to home button -->
    <div class="mb-6">
        <a href="{{ route('home') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                    clip-rule="evenodd" />
            </svg>
            Return to Home
        </a>
    </div>

    <x-slot name="scripts">
        <script src="https://unpkg.com/htmx.org@latest"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                setTimeout(function () {
                    const resultsContainer = document.getElementById('results-container');
                    if (resultsContainer) {
                        resultsContainer.setAttribute('hx-get', '{{ route("results.live", $election) }}');
                        resultsContainer.setAttribute('hx-trigger', 'every 10s');
                        resultsContainer.setAttribute('hx-swap', 'innerHTML');

                        // Tell HTMX to process the new attributes
                        if (typeof htmx !== 'undefined') {
                            htmx.process(resultsContainer);
                        } else {
                            console.error('HTMX is not defined. Check that it loaded properly.');
                        }
                    }
                }, 1000);
            });
        </script>
    </x-slot>

    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Voter Participation</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-blue-50 p-4 rounded-lg">
                <div class="text-3xl font-bold text-blue-700">{{ $voterCount }}</div>
                <div class="text-sm text-gray-600">Total Eligible Voters</div>
            </div>

            <div class="bg-green-50 p-4 rounded-lg">
                <div class="text-3xl font-bold text-green-700">{{ $votedCount }}</div>
                <div class="text-sm text-gray-600">Votes Cast</div>
            </div>

            <div class="bg-purple-50 p-4 rounded-lg">
                <div class="text-3xl font-bold text-purple-700">{{ number_format($participationRate, 1) }}%</div>
                <div class="text-sm text-gray-600">Participation Rate</div>
            </div>
        </div>

        <div class="mt-4">
            <div class="w-full bg-gray-200 rounded-full h-6 overflow-hidden">
                <div class="h-full bg-blue-500 rounded-full" style="width: {{ $participationRate }}%"></div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4">Election Results</h2>

        @if($election->is_active && !$election->completed)
        <div class="mb-4 bg-blue-50 border-l-4 border-blue-500 p-4">
            <p class="text-blue-700">
                This election is currently active. Results will be finalized when the election ends on
                {{ \Carbon\Carbon::parse($election->end_date->setTimezone('Asia/Bangkok'))->format('M d, Y \a\t h:i A')
                }}.
            </p>
        </div>
        @endif

        <div id="results-container">
            @include('results.partials.live-results', ['results' => $results, 'election' => $election])
        </div>
    </div>
</x-layouts.app>
