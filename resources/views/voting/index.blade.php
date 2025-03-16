<x-layouts.app :title="$election->title . ' - Voter Verification'" :header="$election->title"
    :start_date="$election->start_date" :end_date="$election->end_date">

    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 px-4">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold mb-6 text-center">Voter Verification</h2>
            <div class="mb-6">
                <p class="text-gray-600 mb-4">
                    Please enter your voter ID to proceed with voting for <strong>{{ $activePosition->title
                        }}</strong>.<br /><br />
                    <strong>{{ $activePosition->title }}</strong> နေရာကိုမဲပေးရန်အတွက် မိမိ၏ voter ID ကိုထည့်သွင်းပါ
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

                <div>
                    <a href="{{ route('home') }}"
                        class="block w-full bg-gray-200 text-center hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                        Back to Home
                    </a>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-200 text-center">
                <p class="text-sm text-gray-500">
                    If you haven't received your voter ID, please contact the Election Commission.<br /><br />
                    မိမိ၏ voter ID မရရှိသေးပါက သက်ဆိုင်ရာ ရွေးကောက်ပွဲကော်မရှင်ထံဆက်သွယ်ပါ။
                </p>
            </div>
        </div>

        <!-- Session and device information notice -->
        <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg shadow-md p-8 h-full flex flex-col justify-center">
            <!-- Information icon -->
            <div class="flex items-center justify-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="font-semibold text-blue-800 mb-3">Session Information</h3>

            <div class="text-sm text-gray-700 space-y-3">
                <ul class="list-disc pl-5 space-y-1">
                    <li>Your Voter ID is unique and can be logged in on one device at a time.</li>
                    <li>When the same voter ID is used to log in on a second device, it will display an error.</li>
                    <li>To resolve this, complete your vote on original device or log out first.</li>
                </ul>
            </div>

            <div class="mt-5 text-sm text-gray-700 pt-3 border-t border-blue-100">
                <ul class="list-disc pl-5 space-y-1">
                    <li>Voter ID သည် မဲပေးသူတိုင်းအတွက် သီးသန့်ပြုလုပ်ထားပြီး တစ်ကြိမ်လျှင် စက်ပစ္စည်းတစ်လုံးတွင်သာ
                        ဝင်ရောက်မဲပေးနိုင်ပါသည်။</li>
                    <li>Voter ID တစ်ခုကို စက်ပစ္စည်းတစ်လုံးထက်ပို၍ ဝင်ရောက်မိပါက error ပြပါလိမ့်မည်</li>
                    <li>Error ပြသည့်အခါ မူလစက်ပစ္စည်းတွင်ဆက်လက်မဲပေး၍ဖြစ်စေ၊ log out ထွက်၍
                        နောက်စက်တစ်လုံးတွင်ဆက်လက်မဲပေး၍ဖြစ်စေ ဖြေရှင်းနိုင်ပါသည်</li>
                </ul>
            </div>
        </div>
    </div>
</x-layouts.app>
