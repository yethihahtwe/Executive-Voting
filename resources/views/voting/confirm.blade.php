<div id="confirmVoteModal" class="fixed inset-0 bg-blue-200 bg-opacity-10 flex items-center justify-center z-50"
    style="background-color: oklch(0.88 0.06 254.13 / 0.62);">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-800">Confirm Your Vote</h3>
            <button type="button" class="text-gray-500 hover:text-gray-700" hx-get="{{ route('vote.cancel-confirm') }}"
                hx-target="#modal-container">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
        <div class="mb-6">
            <p class="text-gray-700 mb-2">Are you sure you want to submit your vote for:</p>
            <div class="bg-blue-50 p-3 rounded-md">
                <p class="font-medium text-blue-800">{{ $position->title }}</p>
            </div>
            <p class="text-gray-700 mt-4 font-medium">This action cannot be undone.</p>
        </div>
        <div class="flex justify-end space-x-3">
            <button type="button"
                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 font-medium"
                hx-get="{{ route('vote.cancel-confirm') }}" hx-target="#modal-container">
                Cancel
            </button>
            <form action="{{ route('vote.submit', [$voter->id, $position->id]) }}" method="POST">
                @csrf
                <input type="hidden" name="representative_id" value="{{ $representativeId }}">
                <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md font-medium">
                    Confirm Vote
                </button>
            </form>
        </div>
    </div>
</div>
