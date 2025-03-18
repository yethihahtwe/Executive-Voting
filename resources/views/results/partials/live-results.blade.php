@foreach($results as $positionId => $positionData)
<div class="position-results mb-8" id="position-{{ $positionId }}">
    <div class="flex items-center mb-3">
        <h3 class="text-xl font-semibold">{{ $positionData['position']->title }}</h3>

        @if($positionData['is_active'])
        <span class="ml-3 px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
            Active Voting
        </span>
        @elseif($positionData['is_completed'])
        <span class="ml-3 px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
            Completed
        </span>
        @else
        <span class="ml-3 px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">
            Pending
        </span>
        @endif
    </div>

    @if($positionData['is_completed'] && $positionData['elected_representative'])
    <div class="winner-box bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
        <h4 class="text-lg font-semibold text-green-800">Elected Representative</h4>
        <div class="flex items-center mt-2">
            <div>
                <div class="text-lg font-medium">{{ $positionData['elected_representative']->name }}</div>
                <div class="text-sm text-gray-600">
                    {{ $positionData['elected_representative']->organization_name }}
                    ({{ $positionData['elected_representative']->organization_abbreviation }})
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="total-votes text-sm mb-2">
        Total votes: <span class="font-medium">{{ $positionData['total_votes'] }}</span>
    </div>

    @if($positionData['has_tie'] && $positionData['is_active'])
    <div class="tie-alert bg-yellow-100 border-l-4 border-yellow-500 p-3 mb-3">
        <p class="text-yellow-700">
            There is currently a tie for this position. If this persists until the end of the election, a second round
            of voting may be required.
        </p>
    </div>
    @endif

    @if(count($positionData['results']) > 0)
    <div class="results-table">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b border-gray-400 text-left">Representative</th>
                    <th class="py-2 px-4 border-b border-gray-400 text-left">Organization</th>
                    <th class="py-2 px-4 border-b border-gray-400 text-right">Votes</th>
                    <th class="py-2 px-4 border-b border-gray-400 text-right">Percentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($positionData['results'] as $result)
                <tr
                    class="{{ ($positionData['is_completed'] && $positionData['elected_representative'] && $result['representative']->id == $positionData['elected_representative']->id) ? 'bg-green-50' : '' }}">
                    <td
                        class="py-2 px-4 border-b border-gray-400 {{ ($positionData['is_completed'] && $positionData['elected_representative'] && $result['representative']->id == $positionData['elected_representative']->id) ? 'font-semibold' : '' }}">
                        {{ $result['representative']->name }}
                        @if($positionData['is_completed'] && $positionData['elected_representative'] &&
                        $result['representative']->id == $positionData['elected_representative']->id)
                        <span class="ml-2 text-xs text-green-700">✓ Elected</span>
                        @endif
                    </td>
                    <td class="py-2 px-4 border-b border-gray-400">
                        {{ $result['organization']->name }} ({{ $result['organization']->abbreviation }})
                    </td>
                    <td class="py-2 px-4 border-b text-right border-gray-400 ">
                        {{ $result['vote_count'] }}
                    </td>
                    <td class="py-2 px-4 border-b text-right border-gray-400 ">
                        @if($positionData['total_votes'] > 0)
                        {{ number_format(($result['vote_count'] / $positionData['total_votes']) * 100, 1) }}%
                        @else
                        0%
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="progress-bars mt-3">
        @foreach($positionData['results'] as $result)
        <div class="mb-2">
            <div class="flex items-center">
                <div class="w-32 truncate text-sm">{{ $result['representative']->name }}</div>
                <div class="flex-1 ml-2">
                    <div class="bg-gray-200 rounded-full h-4 overflow-hidden">
                        @if($positionData['total_votes'] > 0)
                        <div class="h-full {{ ($positionData['is_completed'] && $positionData['elected_representative'] && $result['representative']->id == $positionData['elected_representative']->id) ? 'bg-green-500' : 'bg-blue-500' }} rounded-full"
                            style="width: {{ ($result['vote_count'] / $positionData['total_votes']) * 100 }}%">
                        </div>
                        @else
                        <div class="h-full bg-blue-500 rounded-full" style="width: 0%"></div>
                        @endif
                    </div>
                </div>
                <div class="ml-2 text-sm w-16 text-right">
                    @if($positionData['total_votes'] > 0)
                    {{ number_format(($result['vote_count'] / $positionData['total_votes']) * 100, 1) }}%
                    @else
                    0%
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @elseif($positionData['is_active'])
    <div class="text-center py-4 bg-gray-50 rounded-lg border border-zinc-400">
        <p class="text-gray-500">Voting in progress. No votes recorded yet.</p>
    </div>
    @elseif(!$positionData['is_completed'])
    <div class="text-center py-4 bg-gray-50 rounded-lg border">
        <p class="text-gray-500">Voting for this position has not started yet.</p>
    </div>
    @endif
</div>
@endforeach

<div class="text-center text-sm text-gray-500 mt-4">
    Live results - updates automatically every 10 seconds
</div>
