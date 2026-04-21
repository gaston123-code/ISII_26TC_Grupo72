@extends('layouts.app')
@section('title', __('Confirmar Renta de Auto'))

@section('content')
<div class="reservation-wrapper mt-4 mb-4">
    <h1 class="page-title text-center">{{ __('Confirmar Renta de Auto') }}</h1>

    <div class="reservation-card">
        <!-- Resumen del auto seleccionado -->
        <div class="reservation-summary">
            @if(isset($auto))
                <img src="{{ $auto->imagen_url }}" 
                     onerror="this.src='https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?q=80&w=300&auto=format&fit=crop'" 
                     alt="{{ $auto->modelo->nombre_modelo ?? 'Auto' }}" 
                     class="reservation-auto-img">
                <div>
                    <h3 style="margin-bottom: 0.25rem; color: var(--text-color);">{{ $auto->modelo->nombre_modelo ?? 'Auto' }} ({{ $auto->anio }})</h3>
                    <p style="font-weight: 700; color: var(--primary-color); margin-bottom: 0.25rem;">
                        ${{ number_format($auto->precio, 0, ',', '.') }} <small style="font-weight: 400; color: var(--text-light);">/ {{ __('día') }}</small>
                    </p>
                    <p class="text-sm text-light" style="font-style: italic;">{{ $auto->descripcion ?? __('Sin descripción adicional.') }}</p>
                </div>
            @endif
        </div>

        <!-- Formulario -->
        <form method="POST" action="{{ route('cliente.reserva.store') }}" id="reservation-form"> 
            @csrf
            
            <!-- ID Oculto del Auto -->
            <input type="hidden" name="id_auto" value="{{ $auto->id_auto }}">

            <div class="date-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                <!-- Fecha y Hora de Inicio -->
                <div class="form-group">
                    <label for="fecha_retiro" class="form-label">{{ __('Fecha de entrega') }}</label>
                    <input type="date" id="fecha_retiro" name="fecha_retiro" class="form-control @error('fecha_retiro') is-invalid @enderror" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label for="hora_retiro" class="form-label">{{ __('Horario de entrega') }}</label>
                    <input type="time" id="hora_retiro" name="hora_retiro" class="form-control @error('hora_retiro') is-invalid @enderror" value="09:00" required>
                </div>

                <!-- Fecha y Hora de Fin -->
                <div class="form-group">
                    <label for="fecha_devolucion" class="form-label">{{ __('Fecha de devolución') }}</label>
                    <input type="date" id="fecha_devolucion" name="fecha_devolucion" class="form-control @error('fecha_devolucion') is-invalid @enderror" value="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                </div>
                <div class="form-group">
                    <label for="hora_devolucion" class="form-label">{{ __('Horario de devolución') }}</label>
                    <input type="time" id="hora_devolucion" name="hora_devolucion" class="form-control @error('hora_devolucion') is-invalid @enderror" value="18:00" required>
                </div>
            </div>

            <!-- Forma de Pago -->
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="medio_pago" class="form-label">{{ __('Forma de pago') }}</label>
                <select id="medio_pago" name="medio_pago" class="form-control @error('medio_pago') is-invalid @enderror" required>
                    <option value="" disabled selected>{{ __('Seleccione una forma de pago') }}</option>
                    <option value="Tarjeta de Crédito">{{ __('Tarjeta de Crédito') }}</option>
                    <option value="Tarjeta de Débito">{{ __('Tarjeta de Débito') }}</option>
                    <option value="Efectivo">{{ __('Efectivo') }}</option>
                    <option value="Transferencia">{{ __('Transferencia Bancaria') }}</option>
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 0; margin-top: 1rem;">
                <button type="submit" class="btn btn-primary w-full" style="font-size: 1.125rem;">
                    <i class="fa-solid fa-calendar-check" style="margin-right: 0.5rem;"></i> {{ __('Confirmar Reserva') }}
                </button>
            </div>
            
            <p class="text-center text-sm" style="color: var(--text-light); margin-top: 1.5rem;">
                {{ __('Al confirmar, los datos de esta reserva serán guardados en nuestro registro seguro de AutoRent.') }}
            </p>
        </form>
    </div>
</div>
@endsection
