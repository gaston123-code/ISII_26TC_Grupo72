@extends('layouts.app')
@section('title', __('Iniciar Sesión'))

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <h1>{{ __('AutoRent') }}</h1>
        <p>{{ __('Bienvenido de nuevo, ingresa a tu cuenta') }}</p>
    </div>

    <!-- Cambia la ruta según tu estructura, ej: action="{{ route('login') }}" -->
    <form method="POST" action="/login">
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">{{ __('Correo Electrónico') }}</label>
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="ejemplo@correo.com">
            @error('email')
                <span class="error-message" role="alert" aria-live="polite">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="form-label">{{ __('Contraseña') }}</label>
            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password" placeholder="********">
            @error('password')
                <span class="error-message" role="alert" aria-live="polite">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group form-check" style="justify-content: space-between;">
            <label>
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                {{ __('Recordarme') }}
            </label>
            
            <a href="#" class="text-primary text-sm"> <!-- Ej: route('password.request') -->
                {{ __('¿Olvidaste tu contraseña?') }}
            </a>
        </div>

        <div class="form-group mt-2">
            <button type="submit" class="btn btn-primary w-full">
                {{ __('Ingresar') }}
            </button>
        </div>
        
        <div class="text-center mt-2">
            <p class="text-sm">
                {{ __('¿No tienes una cuenta?') }} 
                <a href="/register" class="text-primary">{{ __('Regístrate') }}</a> <!-- Ej: route('register') -->
            </p>
        </div>
    </form>
</div>
@endsection
