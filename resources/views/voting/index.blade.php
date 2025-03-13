<x-layouts.app>
    <x-slot:title>{{ $election->title }} - Voter Verification</x-slot:title>
    <x-slot:election>{{ $election }}</x-slot:election>

    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold mb-6 text-center">Voter Verification</h2>

        <div class="mb-6">
            <p class="text-gray-600 mb-4">
                Please enter your voter ID to proceed with voting for <strong>{{ $activePosition->title }}</strong>.
            </p>

            @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                <div class="text-red-700">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>

        <form method="POST" action="{{ route('vote.verify') }}" class="space-y-6">
            @csrf
            <div>
                <label for="voter_id" class="block text-sm font-medium text-gray-700 mb-1">Voter ID</label>
                <input type="text" id="voter_id" name="voter_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Enter your voter ID" required autofocus>
            </div>

            <div>
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                    Verify & Continue
                </button>
            </div>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-200 text-center">
            <p class="text-sm text-gray-500">
                If you haven't received your voter ID, please contact the Election Commission.
            </p>
        </div>
    </div>
</x-layouts.app>
