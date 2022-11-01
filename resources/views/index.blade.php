<?php
$title = 'Главная';
?>

@extends('layouts.auth')

@section('title', $title)

@section('content')
    @auth()
        <x-forms.auth-forms title="{{ $title }}" action="{{ route('logout') }}">
            @csrf
            @method('DELETE')

            <x-forms.primary-button type="submit">
                Выйти
            </x-forms.primary-button>
        </x-forms.auth-forms>
    @endauth
@endsection
