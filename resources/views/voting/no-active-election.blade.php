<x-layouts.app>
    <x-slot:title>No Active Election</x-slot:title>

    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6 text-center">
        <div class="mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-gray-400" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <h2 class="text-2xl font-bold mb-4">No Active Election</h2>

        <p class="text-gray-600 mb-6 text-left">
            There is currently no active election or position available for voting.
            Please check back later or contact the Election Commission for more information.<br /><br />

လတ်တလော ရွေးကောက်ပွဲကျင်းပနေခြင်းမရှိသေးပါ။ (သို့မဟုတ်) ရွေးကောက်တင်မြှောက်ရန် ကိုယ်စားလှယ်များမရှိသေးပါ။ ယခုစာမျက်နှာကို များမကြာမီထပ်မံဖွင့်ကြည့်ပေးပါရန်၊ သို့မဟုတ် ရွေးကောက်ပွဲကော်မရှင်သို့ ဆက်သွယ်မေးမြန်းပေးပါရန် မေတ္တာရပ်ခံအပ်ပါသည်။
        </p>

        <div class="mt-6">
            <a href="{{ url('/') }}"
                class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-medium px-6 py-2 rounded">
                Return to Home
            </a>
        </div>
    </div>
</x-layouts.app>
