@extends('layouts.app')
@section('title', __('Pasarela de Pago'))

@section('content')
<div class="reservation-wrapper mt-5 mb-5" style="max-width: 600px; margin: 0 auto;">
    <div class="reservation-card" style="padding: 2.5rem; box-shadow: 0 15px 35px rgba(0,0,0,0.1); border: none;">
        
        <div class="text-center mb-4">
            <h1 style="font-size: 2rem; font-weight: 800; color: var(--text-color);">{{ __('Finalizar Pago') }}</h1>
            <p style="color: var(--text-light);">{{ __('Ingresa los detalles para confirmar tu reserva.') }}</p>
        </div>

        <!-- Resumen rápido -->
        <div style="background: #f8fafc; border-radius: 0.75rem; padding: 1.5rem; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; border: 1px solid #e2e8f0;">
            <div>
                <span style="font-size: 0.875rem; color: #64748b; display: block;">{{ __('Monto a pagar') }}</span>
                <strong style="font-size: 1.5rem; color: var(--primary-color);">${{ number_format($alquiler->precioTotal, 0, ',', '.') }}</strong>
            </div>
            <div style="text-align: right;">
                <span style="font-size: 0.875rem; color: #64748b; display: block;">{{ __('Método elegido') }}</span>
                <strong style="font-size: 1.125rem; color: var(--text-color);">{{ $medio_pago }}</strong>
            </div>
        </div>

        <form method="POST" action="{{ route('cliente.pago.procesar') }}" id="payment-form">
            @csrf
            <input type="hidden" name="id_reserva" value="{{ $alquiler->id_reserva }}">
            <input type="hidden" name="medio_pago" value="{{ $medio_pago }}">

            @if(str_contains(strtolower($medio_pago), 'tarjeta'))
                <!-- Campos para Tarjeta -->
                <div class="form-group mb-4">
                    <label class="form-label">{{ __('Número de Tarjeta') }}</label>
                    <div style="position: relative;">
                        <input type="text" class="form-control" placeholder="0000 0000 0000 0000" maxlength="19" required>
                        <i class="fa-solid fa-credit-card" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;" class="mb-4">
                    <div class="form-group">
                        <label class="form-label">{{ __('Vencimiento') }}</label>
                        <input type="text" class="form-control" placeholder="MM/AA" maxlength="5" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ __('CVV') }}</label>
                        <input type="password" class="form-control" placeholder="***" maxlength="4" required>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label class="form-label">{{ __('Titular de la Tarjeta') }}</label>
                    <input type="text" class="form-control" placeholder="Nombre como figura en la tarjeta" required>
                </div>
            @elseif(str_contains(strtolower($medio_pago), 'transferencia'))
                <!-- Campos para Transferencia -->
                <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 0.5rem; padding: 1rem; margin-bottom: 2rem;">
                    <p style="margin-bottom: 0.5rem; font-weight: 600; color: #1e40af;">{{ __('Datos de nuestra cuenta:') }}</p>
                    <p style="margin: 0; font-size: 0.875rem; color: #1e3a8a;"><strong>Alias:</strong> autorent.oficial.pago</p>
                    <p style="margin: 0; font-size: 0.875rem; color: #1e3a8a;"><strong>CBU:</strong> 0000003100012345678901</p>
                </div>
                <div class="form-group mb-4">
                    <label class="form-label">{{ __('Número de Comprobante / Transacción') }}</label>
                    <input type="text" class="form-control" placeholder="Ej: 98234123" required>
                    <small style="color: #64748b;">{{ __('Ingresa el número que figura en tu comprobante de transferencia.') }}</small>
                </div>
            @endif

            <button type="submit" class="btn btn-primary w-full" style="font-size: 1.125rem; padding: 1rem;">
                <i class="fa-solid fa-lock" style="margin-right: 0.5rem;"></i> {{ __('Finalizar Proceso de Pago') }}
            </button>

            <p style="text-align: center; font-size: 0.875rem; color: #94a3b8; margin-top: 1.5rem;">
                <i class="fa-solid fa-shield-halved"></i> {{ __('Tu transacción está protegida por encriptación SSL de 256 bits.') }}
            </p>
        </form>
    </div>
</div>
@endsection
