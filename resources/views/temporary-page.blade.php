<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page A</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex justify-center items-center">
<div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-3xl mx-4">
    <!-- Page Header -->
    <header class="mb-8">
        <h1 class="text-3xl font-extrabold text-center text-gray-900">Page A</h1>
    </header>

    <!-- Active or Not Active Section -->
    <section id="linkStatus" class="bg-gray-50 p-6 rounded-lg border border-gray-300 shadow-sm mb-8">
        <p class="text-sm font-medium text-gray-700">
            <strong>Status:</strong> {{$link->active ? "Active" : "Not Active"}},
            <strong>User Name:</strong> {{$user->name}},
            <strong>User Phone:</strong> {{$user->phone}}
        </p>
    </section>

    <!-- Generate New Link -->
    <section class="mb-8">
        <form action="/create-link" method="POST">
            @csrf
            <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
            <button
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg focus:ring focus:ring-blue-300"
            >
                Generate New Unique Link
            </button>
        </form>

        <!-- Success Message -->
        @if(session('successCreateLink'))
            <div class="bg-green-100 border border-green-300 text-green-800 font-medium rounded-lg p-4 mt-4">
                <p class="text-sm">
                    <strong>Your new link:</strong>
                    <a
                        target="_blank"
                        class="text-blue-600 underline hover:text-blue-800"
                        href="{{ session('successCreateLink') }}"
                    >
                        {{ session('successCreateLink') }}
                    </a>
                </p>
            </div>
        @endif
        <!-- Error Message -->
        @if(session('errorCreateLink'))
            <div class="bg-red-100 border border-red-300 text-red-800 font-medium rounded-lg p-4 mt-4">
                {{ session('errorCreateLink') }}
            </div>
        @endif
    </section>

    <!-- Deactivate Current Link -->
    <section class="mb-8">
        <form id="deactivateForm" method="POST" action="{{ route('temporary-link.deactivate') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $link->token }}">
            <button type="submit" id="deactivateLink"
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-red-300 transition duration-200">
                Deactivate Current Link
            </button>
        </form>

        @if(session('successDeactivateLink'))
            <div class="bg-green-100 border border-green-300 text-green-800 font-medium rounded-lg p-4 mt-4">
                Link Deactivated
            </div>
        @endif
        <!-- Error Message -->
        @if(session('errorDeactivateLink'))
            <div class="bg-red-100 border border-red-300 text-red-800 font-medium rounded-lg p-4 mt-4">
                Deactivate Link Failed.
            </div>
        @endif
    </section>

    <!-- I'm Feeling Lucky -->
    <section class="mb-8">
        <form method="POST" action="{{ route('lucky.play') }}" class="space-y-4">
            <!-- Submit Button -->
            @csrf
            <input type="hidden" name="link_id" value="{{ $link->id }}">
            <input type="hidden" name="token" value="{{ $link->token }}">
            <div>
                <button type="submit" id="imFeelingLucky"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg focus:ring focus:ring-green-300">
                    I’m Feeling Lucky
                </button>
            </div>
        </form>

        @if(session('winResult'))
            <div class="bg-green-100 border border-green-300 text-green-800 font-medium rounded-lg p-4 mt-4">
                {{ session('winResult') }}
            </div>
        @endif
        <!-- Error Message -->
        @if(session('loseResult'))
            <div class="bg-red-100 border border-red-300 text-red-800 font-medium rounded-lg p-4 mt-4">
                {{ session('loseResult') }}
            </div>
        @endif
        @if(session('linkNotActive'))
            <div class="bg-red-100 border border-red-300 text-red-800 font-medium rounded-lg p-4 mt-4">
                Link Not Active. Please generate a new link.
            </div>
        @endif

    </section>

    <section class="mb-8">
        <input type="hidden" id="linkId" value="{{ $link->id }}">
        <button id="showHistory" type="button"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">
            Show History
        </button>

        <div id="historySection" class="mt-4 hidden">
            <h2 class="text-xl font-bold">Last 3 Results</h2>
            <ul id="historyList" class="mt-2 space-y-2"></ul>
        </div>
    </section>

</div>
</body>
</html>

<script>
    document.getElementById('showHistory').addEventListener('click', function () {
        const linkId = document.getElementById('linkId').value;
        fetch(`/last-history?link_id=${linkId}`)
            .then(response => response.json()) // Parse the JSON response
            .then(results => {
                const historySection = document.getElementById('historySection');
                const historyList = document.getElementById('historyList');
                historyList.innerHTML = '';
                if (results.length > 0) {
                    results.forEach(result => {
                        const li = document.createElement('li');
                        li.textContent = `Number: ${result.number}, Result: ${result.result}, Prize: $${result.prize}`;
                        historyList.appendChild(li);
                    });
                } else {
                    const li = document.createElement('li');
                    li.textContent = 'No history available for this user.';
                    historyList.appendChild(li);
                }
                historySection.classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error fetching history:', error);
                alert('Unable to fetch the history. Please try again later.');
            });
    });
</script>

