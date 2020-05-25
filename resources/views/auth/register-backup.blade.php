@extends('layouts.app')

@section('content')
    <div class="bg-gray-200 mx-auto h-full flex justify-center items-center">
        <div class="w-96 p-6 rounded-lg bg-white shadow-xl">

            <h1 class="text-red-800 text-3xl pt-2">Join 2emotions</h1>

            <form method="POST" action="{{ route('register') }}" class="pt-8">
                @csrf

                <div class="relative">
                    <label for="name" class="text-gray-300 text-xs font-bold pl-3 pt-2 absolute uppercase">Full Name</label>

                    <input id="name" type="text" class="w-full p-3 pt-8 rounded focus:outline-none focus:bg-red-700 bg-red-800 text-gray-100 @error('name') border border-red-600 @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Your Name">

                    @error('name')
                    <span class="text-red-600 text-xs" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="relative pt-3">
                    <label for="email" class="text-gray-300 text-xs font-bold pl-3 pt-2 absolute uppercase">E-Mail</label>

                    <input id="email" type="email" class="w-full p-3 pt-8 rounded focus:outline-none focus:bg-red-700 bg-red-800 text-gray-100 @error('email') border border-red-600 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="your@email.com">

                    @error('email')
                    <span class="text-red-600 text-xs" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="relative pt-3">
                    <label for="password" class="text-gray-300 text-xs font-bold pl-3 pt-2 absolute uppercase">Password</label>

                    <input id="password" type="password" class="w-full p-3 pt-8 rounded focus:outline-none focus:bg-red-700 bg-red-800 text-gray-100 @error('password') border border-red-600 @enderror" name="password" required autocomplete="current-password" placeholder="Password">

                    @error('password')
                    <span class="text-red-600 text-xs" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="relative pt-3">
                    <label for="password-confirm" class="text-gray-300 text-xs font-bold pl-3 pt-2 absolute uppercase">Re-enter Password</label>

                    <input id="password-confirm" type="password" class="w-full p-3 pt-8 rounded focus:outline-none focus:bg-red-700 bg-red-800 text-gray-100" name="password_confirmation" required placeholder="Confirm">
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Register</button>
                </div>

                <div class="pt-8 flex justify-between text-blue-700 text-sm font-bold">
                    <a class="hover:text-blue-500" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                    <a class="hover:text-blue-500" href="{{ route('login') }}">Login</a>
                </div>
            </form>
        </div>
    </div>
@endsection
