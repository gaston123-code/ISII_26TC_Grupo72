@extends('layouts.app')
@section('title', __('Mis Reservas'))

@section('content')
<div class="reservation-wrapper mt-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title" style="margin: 0;">{{ __('Mis Reservas') }}</h1>
        <a href="{{ route('catalogo') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> {{ __('Nueva Reserva') }}
        </a>
    </div>

    @if($reservas->isEmpty())
        <div class="reservation-card text-center" style="padding: 5rem 2rem;">
            <div style="font-size: 4rem; color: #e2e8f0; margin-bottom: 1.5rem;">
                <i class="fa-solid fa-calendar-xmark"></i>
            </div>
            <h3 style="color: #64748b;">Aún no tienes reservas</h3>
            <p style="color: #94a3b8; margin-bottom: 2rem;">Cuando reserves un auto, aparecerá listado aquí.</p>
            <a href="{{ route('catalogo') }}" class="btn btn-primary" style="padding: 0.75rem 2rem;">Explorar Catálogo</a>
        </div>
    @else
        <div class="reservation-grid" style="display: grid; gap: 1.5rem;">
            @foreach($reservas as $reserva)
                <div class="reservation-card" style="padding: 1.5rem; display: flex; flex-wrap: wrap; gap: 2rem; align-items: center; justify-content: space-between; border-left: 5px solid #2563eb;">
                    
                    <div style="display: flex; gap: 1.5rem; align-items: center; flex: 1; min-width: 300px;">
                        <img src="{{ $reserva->auto->imagen_url }}" style="width: 100px; height: 70px; object-fit: cover; border-radius: 0.5rem;" alt="Auto">
                        <div>
                            <h4 style="margin: 0; font-size: 1.125rem;">{{ $reserva->auto->modelo->nombre_modelo }}</h4>
                            <p style="margin: 0; color: #64748b; font-size: 0.875rem;">{{ $reserva->auto->modelo->marca->nombre_marca }} — {{ $reserva->auto->anio }}</p>
                        </div>
                    </div>

                    <div style="display: flex; gap: 3rem; flex: 2; justify-content: center; min-width: 300px;">
                        <div class="text-center">
                            <span style="font-size: 0.7rem; text-transform: uppercase; color: #94a3b8; font-weight: 700; display: block; margin-bottom: 0.25rem;">Retiro</span>
                            <span style="font-weight: 600; font-size: 1rem;">{{ $reserva->fecha_retiro->format('d/m/Y') }}</span>
                        </div>
                        <div style="color: #cbd5e1; display: flex; align-items: center;">
                            <i class="fa-solid fa-arrow-right"></i>
                        </div>
                        <div class="text-center">
                            <span style="font-size: 0.7rem; text-transform: uppercase; color: #94a3b8; font-weight: 700; display: block; margin-bottom: 0.25rem;">Devolución</span>
                            <span style="font-weight: 600; font-size: 1rem;">{{ $reserva->fecha_devolucion->format('d/m/Y') }}</span>
                        </div>
                    </div>

                    <div style="text-align: right; min-width: 150px;">
                        <span style="font-size: 0.7rem; text-transform: uppercase; color: #94a3b8; font-weight: 700; display: block; margin-bottom: 0.25rem;">Total</span>
                        <span style="font-weight: 800; font-size: 1.25rem; color: #1e293b;">${{ number_format($reserva->precioTotal, 0, ',', '.') }}</span>
                    </div>

                    <div style="min-width: 120px;">
                        @php
                            $statusColor = '#64748b';
                            $bgColor = '#f1f5f9';
                            if(isset($reserva->estadoAlquiler)){
                                if($reserva->id_estadoAlquiler == 1) { $statusColor = '#d97706'; $bgColor = '#fef3c7'; } // Pendiente
                                if($reserva->id_estadoAlquiler == 2) { $statusColor = '#059669'; $bgColor = '#d1fae5'; } // Confirmado
                            }
                        @endphp
                        <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; color: {{ $statusColor }}; background: {{ $bgColor }};">
                             {{ $reserva->estadoAlquiler->estado_alquiler ?? 'Sin estado' }}
                        </span>
                    </div>

                    <div style="min-width: 50px; display: flex; gap: 0.5rem;">
                        <a href="{{ route('cliente.reserva.exitosa', $reserva->id_reserva) }}" class="btn btn-icon" title="Ver Comprobante" style="color: #64748b;">
                            <i class="fa-solid fa-eye"></i>
                        </a>

                        @if($reserva->id_estadoAlquiler != 5)
                            <form action="{{ route('cliente.reserva.cancel', $reserva->id_reserva) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas cancelar esta reserva? El auto volverá a estar disponible para otros clientes.')" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-icon" title="Cancelar Reserva" style="color: #dc2626;">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
