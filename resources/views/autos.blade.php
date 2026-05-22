@extends('layouts.app')
@section('title', __('Autos Disponibles'))

@section('content')
    <h1 class="page-title">{{ __('Autos Disponibles') }}</h1>

    <!-- Botón Toggle para el formulario (Tercer Diagrama de Secuencia) -->
    <div class="text-center mb-4">
        <button class="btn btn-outline" id="toggle-search-btn" onclick="toggleSearchForm()">
            <i class="fa-solid fa-magnifying-glass"></i> <span id="toggle-text">{{ isset($busqueda) ? __('Ocultar Búsqueda') : __('Consultar Disponibilidad') }}</span>
        </button>
    </div>

    <script>
        function toggleSearchForm() {
            const container = document.getElementById('availability-form-container');
            const text = document.getElementById('toggle-text');
            if (container.style.display === 'none') {
                container.style.display = 'block';
                text.innerText = '{{ __("Ocultar Búsqueda") }}';
            } else {
                container.style.display = 'none';
                text.innerText = '{{ __("Consultar Disponibilidad") }}';
            }
        }
    </script>

    <!-- Formulario de Consulta de Disponibilidad (Oculto por defecto) -->
    @php
        $showSearchForm = isset($busqueda) || request('show_search') || $errors->any();
    @endphp
    <style>
        .search-form-visible { display: block; }
        .search-form-hidden { display: none; }
    </style>
    <div id="availability-form-container" class="reservation-card mb-5 {{ $showSearchForm ? 'search-form-visible' : 'search-form-hidden' }}" style="padding: 2rem;">
        <h3 style="margin-bottom: 1.5rem; font-size: 1.25rem;"><i class="fa-solid fa-magnifying-glass"></i> {{ __('Consultar Disponibilidad') }}</h3>
        
        @if ($errors->any())
            <div style="background: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                <ul style="margin: 0; padding-left: 1.5rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('consultar.disponibilidad') }}" method="POST">
            @csrf
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; align-items: end;">
                <div class="form-group">
                    <label style="display: block; margin-bottom: 0.5rem; font-size: 0.875rem; font-weight: 600; color: var(--text-light);">{{ __('Fecha de Retiro') }}</label>
                    <input type="date" name="fecha_retiro" class="form-control" value="{{ old('fecha_retiro', $busqueda['fecha_retiro'] ?? date('Y-m-d')) }}" required>
                </div>
                <div class="form-group">
                    <label style="display: block; margin-bottom: 0.5rem; font-size: 0.875rem; font-weight: 600; color: var(--text-light);">{{ __('Hora Retiro') }}</label>
                    <input type="time" name="hora_retiro" class="form-control" value="{{ old('hora_retiro', $busqueda['hora_retiro'] ?? '09:00') }}" required>
                </div>
                <div class="form-group">
                    <label style="display: block; margin-bottom: 0.5rem; font-size: 0.875rem; font-weight: 600; color: var(--text-light);">{{ __('Fecha de Devolución') }}</label>
                    <input type="date" name="fecha_devolucion" class="form-control" value="{{ old('fecha_devolucion', $busqueda['fecha_devolucion'] ?? date('Y-m-d', strtotime('+1 day'))) }}" required>
                </div>
                <div class="form-group">
                    <label style="display: block; margin-bottom: 0.5rem; font-size: 0.875rem; font-weight: 600; color: var(--text-light);">{{ __('Hora Devolución') }}</label>
                    <input type="time" name="hora_devolucion" class="form-control" value="{{ old('hora_devolucion', $busqueda['hora_devolucion'] ?? '09:00') }}" required>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary w-full" style="height: 45px;">
                        {{ __('Buscar Disponibles') }}
                    </button>
                </div>
            </div>
        </form>
        @if(isset($busqueda) && !$errors->any())
            <div style="margin-top: 1rem; font-size: 0.875rem; color: var(--success-color);">
                <i class="fa-solid fa-check-circle"></i> Mostrando resultados para el periodo seleccionado. 
                <a href="{{ route('catalogo') }}" style="color: var(--primary-color); text-decoration: underline; margin-left: 0.5rem;">Limpiar filtro</a>
            </div>
        @endif
    </div>

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
