<x-layouts.app :title="$election->title . ' - No active position'" :header="'No Active Position'">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6 text-center">
        <div class="mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-yellow-500" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <h2 class="text-2xl font-bold mb-4">Voting Paused.</h2>

        <p class="text-gray-600 mb-6 text-left">
            The Election commission is currently preparing the next position for voting. Plese check back in a few
            minutes.<br /><br />
            ရာထူးတာဝန် နောက်ထပ်တစ်နေရာအတွက် ဆန္ဒမဲပေးနိုင်ရန် ရွေးကောက်ပွဲကော်မရှင်က ပြင်ဆင်လျက်ရှိပါသည်။
            မိနစ်အနည်းငယ်အကြာတွင် ထပ်မံလာရောက်စစ်ဆေးပါ။
        </p>

        <!-- Get completed positions -->
        @php
        $completedPositions = \App\Models\Position::where('election_id', $election->id)
        ->where('is_completed', true)
        ->with('electedRepresentative.organization')
        ->get();
        @endphp

        @if($completedPositions->count() > 0)
        <div class="mt-8 text-left">
            <h3 class="text-lg font-medium mb-3">Elected Positions</h3>

            <div class="bg-gray-50 rounded-lg p-4">
                <ul class="space-y-2">
                    @foreach($completedPositions as $position)
                    <li class="flex justify-between items-center">
                        <span>
                            <span class="font-medium">{{ $position->title }}:</span>
                            {{ $position->electedRepresentative->name }}
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

            <a href="{{ url('/') }}"
                class="inline-block bg-gray-500 hover:bg-gray-600 text-white font-medium px-6 py-2 rounded">
                Return to Home
            </a>
        </div>
    </div>
</x-layouts.app>
