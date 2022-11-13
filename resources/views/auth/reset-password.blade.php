<?php
    $title = 'Сброс пароля';
?>

@extends('layouts.auth')

@section('title', $title)

@section('content')
    <x-forms.auth-forms title="{{ $title }}" action="{{ route('reset-password.handle') }}">
        @csrf

        <x-forms.text-input
                name="token"
                value="{{ $token }}"
                hidden="true"
        >

        </x-forms.text-input>

        <x-forms.text-input
                name="email"
                type="email"
                value="{{ $email }}"
                placeholder="E-mail"
                readonly="true"
        />

        <x-forms.text-input
                name="password"
                type="password"
                placeholder="Пароль"
                required="true"
                :isError="$errors->has('password')"
        />
        @error('password')
            <x-forms.error>
                {{ $message }}
            </x-forms.error>
        @enderror

        <x-forms.text-input
                name="password_confirmation"
                type="password"
                placeholder="Повторите пароль"
                required="true"
                :isError="$errors->has('password_confirmation')"
        />
        @error('password_confirmation')
            <x-forms.error>
                {{ $message }}
            </x-forms.error>
        @enderror

        <x-forms.primary-button>Обновить пароль</x-forms.primary-button>

    </x-forms.auth-forms>
@endsection
