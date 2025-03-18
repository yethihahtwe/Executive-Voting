<x-layouts.app :title="$position->title . ' - Vote'" :header="$position->title . ' - Vote'">
    <div class="max-w-3xl mx-auto">
        <!-- Current Position Information -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
            <h2 class="text-xl font-bold text-blue-800">
                Vote for: {{ $position->title }}
            </h2>
            <p class="text-blue-700 mt-1">
                {{ $position->description }}
            </p>
        </div>

        @if($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4">
            <ul class="list-disc pl-5 text-red-700">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Already Elected Positions -->
        @if(count($electedPositions) > 0)
        <div class="bg-gray-50 border rounded-lg p-4 mb-6">
            <h3 class="font-semibold text-lg mb-2">Previously Elected Positions</h3>
            <ul class="space-y-2">
                @foreach($electedPositions as $electedPosition)
                <li class="flex justify-between items-center">
                    <span>
                        <span class="font-medium">{{ $electedPosition->title }}:</span>
                        {{ $electedPosition->electedRepresentative->name }}
                    </span>
                    <span class="text-sm text-gray-500">
                        {{ $electedPosition->electedRepresentative->organization->abbreviation }}
                    </span>
                </li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Voting Form -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <h2 class="text-lg font-semibold mb-4">Select One Representative</h2>

                <!-- Validation errors -->
                <div id="vote-form-errors"></div>

                <form id="vote-form" hx-include="this">
                    @csrf

                    @if($representatives->count() > 0)
                    <div class="space-y-3">
                        @foreach($representatives as $representative)
                        <div class="border rounded-lg p-3 hover:bg-gray-50">
                            <label class="flex items-start space-x-3 cursor-pointer">
                                <input type="radio" name="representative_id" value="{{ $representative->id }}"
                                    class="mt-1" required>
                                <div>
                                    <div class="font-medium">{{ $representative->name }}</div>
                                    <div class="text-sm text-gray-600">
                                        {{ $representative->organization->name }}
                                        ({{ $representative->organization->abbreviation }})
                                    </div>
                                    @if($representative->position)
                                    <div class="text-sm text-gray-500 mt-1">
                                        Position: {{ $representative->position }}
                                    </div>
                                    @endif
                                </div>
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="button"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-medium px-6 py-2 rounded"
                            hx-get="{{ route('vote.confirm', [$voter->id, $position->id]) }}" hx-include="#vote-form"
                            hx-target="#modal-container" hx-target-error="#vote-form-errors">
                            Submit Vote
                        </button>
                    </div>
                    @else
                    <div class="text-center py-6 text-gray-500">
                        <p>There are no eligible representatives for this position.</p>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
    <div id="modal-container"></div>
</x-layouts.app>
