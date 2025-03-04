<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - Register</title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        input:focus-visible {
            outline: none;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
<div class="bg-white shadow-lg rounded-lg p-6 sm:p-8 w-full max-w-md">
    <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Register</h1>

    <form method="POST" action="{{ url('/register') }}" novalidate>
        @csrf

        <!-- Username -->
        <div class="mb-5">
            <label for="username" class="block text-sm font-medium text-gray-700 mb-1">
                Username
            </label>
            <input
                type="text"
                id="username"
                name="username"
                value="{{ old('username') }}"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg transition-colors
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                           @error('username') border-red-500 bg-red-50 @enderror"
                placeholder="Enter your username"
                required
                autofocus
            >
            @error('username')
            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Phone Number -->
        <div class="mb-6">
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                Phone Number
            </label>
            <input
                type="tel"
                id="phone"
                name="phone"
                value="{{ old('phone') }}"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg transition-colors
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                           @error('phone') border-red-500 bg-red-50 @enderror"
                placeholder="Enter your phone number"
                required
            >
            @error('phone')
            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <button
            type="submit"
            class="w-full bg-blue-500 text-white font-medium py-2.5 px-4 rounded-lg
                       hover:bg-blue-600 focus:bg-blue-600
                       transition-all duration-200
                       focus:ring-2 focus:ring-blue-300 focus:ring-offset-2"
        >
            Register
        </button>
    </form>
</div>
</body>
</html>
