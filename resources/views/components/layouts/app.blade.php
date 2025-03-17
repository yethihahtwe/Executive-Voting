@props([
'title' => null,
'header' => null,
'start_date' => null,
'end_date' => null,
'election' => null,
])
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Executive Voting App' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{ $styles ?? '' }}
</head>

<body class="bg-gray-100 min-h-screen font-sans">
    <x-header />

    <div class="container mx-auto py-8 px-4">
        <main>
            @if(isset($election))
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold mb-2 text-center">{{ $title }}</h1>
                <p class="text-gray-600">
                    {{ \Carbon\Carbon::parse($start_date)->format('M d, Y') }} -
                    {{ \Carbon\Carbon::parse($end_date)->format('M d, Y') }}
                </p>
            </div>
            @elseif(isset($header))
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold mb-2">{{ $header }}</h1>
            </div>
            @endif

            {{ $slot }}
        </main>

        <footer class="mt-8 text-center text-gray-500 text-sm">
            <p>&copy; Ethnic Health System Strengthening Group {{ date('Y') }} Executive Voting System</p>
        </footer>
    </div>

    {{ $scripts ?? '' }}
</body>

</html>
