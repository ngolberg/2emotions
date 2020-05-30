@extends('layouts.app')

@section('content')
<div class="mx-auto h-full flex justify-center items-center bg-gray-300">
    <div class="w-96 bg-blue-900 rounded-lg shadow-xl p-6">

        <h1 class="text-white text-3xl pt-2"><a href="/"><img src="/img/logo.png" style="height: 40px;float: left;margin-right: 10px;"/></a>{{ __('Welcome!') }}</h1>

        <form method="POST" action="{{ route('login') }}" class="pt-8">
            @csrf

            <div class="pt-3 mb-4 text-center">
                <script src="//ulogin.ru/js/ulogin.js"></script>
                <div id="uLogin" data-ulogin="display=panel;theme=classic;fields=email,first_name;providers=facebook,twitter,google,vkontakte;hidden=;redirect_uri={{ urlencode(config('app.url')) }}%2Fulogin;mobilebuttons=0;"></div>
            </div>

            <div class="relative">
                <label for="email" class="uppercase text-blue-500 text-xs font-bold absolute pl-3 pt-2">{{ __('E-mail') }}</label>

                <div>
                    <input id="email" type="email" class="pt-8 w-full rounded p-3 bg-blue-800 text-gray-100 outline-none focus:bg-blue-700" name="email" value="{{ old('email') }}" autocomplete="email" autofocus placeholder="your@email.com">

                    @error('email')
                    <span class="text-red-600 text-sm pt-1" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>

            <div class="relative pt-3">
                <label for="password" class="uppercase text-blue-500 text-xs font-bold absolute pl-3 pt-2">{{ __('Password') }}</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="pt-8 w-full rounded p-3 bg-blue-800 text-gray-100 outline-none focus:bg-blue-700" name="password" autocomplete="current-password" placeholder="Password">

                    @error('password')
                    <span class="text-red-600 text-sm pt-1" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>

            <input type="hidden" name="remember" value="1"/>

            <div class="pt-8">
                <button type="submit"
                        class="w-full bg-gray-400 py-2 px-3 text-left uppercase rounded text-blue-800 font-bold">
                    {{ __('Login') }}
                </button>
            </div>

            <div class="flex justify-between pt-8 text-white text-sm font-bold">
                <a class="hover:text-blue-200" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
                <a class="hover:text-blue-200" href="{{ route('register') }}">
                    {{ __('Register') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
