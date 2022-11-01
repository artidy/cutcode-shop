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

            <x-slot:buttons>
                <x-forms.primary-button>
                    Выйти
                </x-forms.primary-button>
            </x-slot:buttons>
        </x-forms.auth-forms>
    @endauth
@endsection
