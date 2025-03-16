<x-layouts.app :title="$election->title . ' - Voting Confirmation'" :header="'Voting Confirmation'">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6 text-center">
        <div class="mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-green-500" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <h2 class="text-2xl font-bold mb-4">Thank You!</h2>

        <p class="text-gray-600 mb-6 text-left">
            Your vote has been successfully recorded for this position.
            Thank you for participating in the election process.<br /><br />
            လူကြီးမင်း၏ ဆန္ဒမဲကို မှတ်တမ်းတင်ပြီးပါပြီ။ ဝင်ရောက်မဲပေးခြင်းအတွက် ကျေးဇူးတင်ပါသည်။
        </p>

        @if(isset($completedPositions) && $completedPositions->count() > 0)
        <div class="mt-4 text-left">
            <h3 class="text-lg font-medium mb-3">Elected Positions</h3>

            <div class="bg-gray-50 rounded-lg p-4">
                <ul class="space-y-2">
                    @foreach($completedPositions as $position)
                    <li class="flex justify-between items-center">
                        <span>
                            <span class="font-medium">{{ $position->title }}:</span>
                            {{ $position->electedRepresentative->name }}
                        </span>
                        <span class="text-sm text-gray-500">
                            {{ $position->electedRepresentative->organization->abbreviation }}
                        </span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <div class="mt-6">
            <a href="{{ route('results.index') }}"
                class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-medium px-6 py-2 rounded mr-2">
                View Results
            </a>

            <a href="{{ route('vote.index') }}"
                class="inline-block bg-gray-500 hover:bg-gray-600 text-white font-medium px-6 py-2 rounded">
                Return to Voting
            </a>
        </div>
    </div>
</x-layouts.app>
