@extends('layouts.app')

@section('content')
    <App :user="{{ Auth::user()?Auth::user():'0' }}" :is_admin="{{ $isAdmin }}" :lang="'{{ App::getLocale() }}'"></App>
@endsection
