@extends('layouts.app')

@section('content')
    <div class="mx-auto h-full flex justify-center items-center bg-gray-300">
        <div class="w-96 bg-blue-900 rounded-lg shadow-xl p-6">

            <h1 class="text-white text-3xl pt-2">{{ __('Welcome!') }}</h1>

            <form method="POST" action="{{ route('password.update') }}" class="pt-8">

                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="relative">
                    <label for="email" class="uppercase text-blue-500 text-xs font-bold absolute pl-3 pt-2">{{ __('E-mail') }}</label>

                    <div>
                        <input id="email" type="email" class="pt-8 w-full rounded p-3 bg-blue-800 text-gray-100 outline-none focus:bg-blue-700" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="text-red-600 text-sm pt-1" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="relative pt-3">
                    <label for="password" class="text-blue-500 text-xs font-bold pl-3 pt-2 absolute uppercase">{{ _('Password') }}</label>

                    <input id="password" type="password" class="w-full p-3 pt-8 rounded focus:outline-none focus:bg-blue-700 bg-blue-800 text-gray-100 @error('password') border border-red-600 @enderror" name="password" required autocomplete="current-password" placeholder="Password">

                    @error('password')
                    <span class="text-red-600 text-xs" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="relative pt-3">
                    <label for="password-confirm" class="text-blue-500 text-xs font-bold pl-3 pt-2 absolute uppercase">{{ _('Re-enter Password') }}</label>

                    <input id="password-confirm" type="password" class="w-full p-3 pt-8 rounded focus:outline-none focus:bg-blue-700 bg-blue-800 text-gray-100" name="password_confirmation" required placeholder="Confirm">
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full rounded py-2 px-3 uppercase text-left bg-gray-400 text-blue-800 text-gray-100 font-bold">{{ __('Reset Password') }}</button>
                </div>
            </form>

        </div>
    </div>
@endsection
