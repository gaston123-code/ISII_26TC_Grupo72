@extends('layouts.app')
@section('title', __('Registro'))

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <h1>{{ __('AutoRent') }}</h1>
        <p>{{ __('Crea tu cuenta de usuario') }}</p>
    </div>

    <!-- Cambia la ruta al registrar, ej: action="{{ route('register') }}" -->
    <form method="POST" action="/register">
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">{{ __('Nombre Completo') }}</label>
            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Tu nombre">
            @error('name')
                <span class="error-message" role="alert" aria-live="polite">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email" class="form-label">{{ __('Correo Electrónico') }}</label>
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" placeholder="ejemplo@correo.com">
            @error('email')
                <span class="error-message" role="alert" aria-live="polite">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="form-label">{{ __('Contraseña') }}</label>
            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password" placeholder="********">
            @error('password')
                <span class="error-message" role="alert" aria-live="polite">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation" class="form-label">{{ __('Confirmar Contraseña') }}</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required autocomplete="new-password" placeholder="********">
        </div>

        <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary w-full">
                {{ __('Registrarse') }}
            </button>
        </div>

        <div class="text-center mt-2">
            <p class="text-sm">
                {{ __('¿Ya tienes cuenta?') }} 
                <a href="/login" class="text-primary">{{ __('Inicia sesión aquí') }}</a> <!-- Ej: route('login') -->
            </p>
        </div>
    </form>
</div>
@endsection
