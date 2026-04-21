@extends('layouts.app')
@section('title', __('Autos Disponibles'))

@section('content')
    <h1 class="page-title">{{ __('Autos Disponibles') }}</h1>

    @if(isset($autos) && count($autos) > 0)
        <!-- Grid de Autos -->
        <div class="cars-grid">
            @foreach($autos as $auto)
                <div class="car-card">
                    <!-- Imagen del Auto -->
                    <div class="car-img-wrapper" style="background: white;">
                        <img src="{{ $auto->imagen_url }}" 
                             onerror="this.src='https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?q=80&w=600&auto=format&fit=crop'" 
                             alt="{{ $auto->modelo->nombre_modelo ?? 'Auto' }}" 
                             class="car-img">
                    </div>
                    
                    <div class="car-info">
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <h3 class="car-title">{{ $auto->modelo->nombre_modelo ?? 'Auto' }}</h3>
                            <span style="font-size: 0.875rem; font-weight: 600; color: var(--primary-color);">{{ $auto->anio }}</span>
                        </div>
                        
                        <div class="car-details">
                            <p style="margin-top: 0.5rem; font-weight: 700; font-size: 1.1rem;">
                                ${{ number_format($auto->precio, 0, ',', '.') }} <small style="font-weight: 400; color: var(--text-light);">/ {{ __('día') }}</small>
                            </p>
                        </div>

                        @if(isset($auto->estadoAuto) && strtolower($auto->estadoAuto->estado_auto) == 'disponible')
                            <div class="car-actions">
                                <a href="{{ route('cliente.reservar', $auto->id_auto) }}" class="btn btn-primary w-full">{{ __('Reservar Ahora') }}</a>
                            </div>
                        @else
                            <div class="car-actions">
                                <button class="btn w-full" disabled style="background: var(--border-color); color: var(--text-light); cursor: not-allowed;">{{ __('No disponible') }}</button>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Estado Vacío (Empty State) -->
        <div style="background: var(--white); padding: 4rem 2rem; border-radius: 0.5rem; text-align: center; border: 1px dashed var(--border-color);">
            <i class="fa-solid fa-car-side" style="font-size: 3.5rem; color: var(--border-color); margin-bottom: 1.5rem;"></i>
            <h2 style="color: var(--text-color); margin-bottom: 0.5rem; font-size: 1.25rem; font-weight: 600;">{{ __('Sin Inventario') }}</h2>
            <p style="color: var(--text-light); font-size: 1rem;">
                {{ __('No hay autos disponibles en este momento.') }}
            </p>
        </div>
    @endif
@endsection
