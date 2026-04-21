@extends('layouts.app')
@section('title', __('Panel General'))

@section('content')
    <div class="flex-heading" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h1 class="page-title" style="margin-bottom: 0;">{{ __('Resumen General') }}</h1>
        <button class="btn btn-primary"><i class="fa-solid fa-plus"></i> {{ __('Nueva Reserva') }}</button>
    </div>

    <!-- Tarjetas de Estadísticas Simples -->
    <div class="dashboard-grid">
        <!-- Tarjeta: Reservas Activas -->
        <div class="card">
            <h3 class="card-title">{{ __('Reservas Activas') }}</h3>
            <div class="card-value">12</div>
            <p class="text-sm mt-1" style="color: var(--success);"><i class="fa-solid fa-arrow-up"></i> 15% esta semana</p>
        </div>

        <!-- Tarjeta: Disponibilidad de Flota -->
        <div class="card">
            <h3 class="card-title">{{ __('Autos Disponibles') }}</h3>
            <div class="card-value">34 / 50</div>
            <p class="text-sm mt-1" style="color: var(--text-light);">68% de la flota lista para alquiler</p>
        </div>

        <!-- Tarjeta: Nuevos Mensajes -->
        <div class="card">
            <h3 class="card-title">{{ __('Notificaciones y Mensajes') }}</h3>
            <div class="card-value">5</div>
            <p class="text-sm mt-1" style="color: var(--warning);"><i class="fa-solid fa-envelope"></i> Soporte y dudas de clientes</p>
        </div>
    </div>

    <!-- Área de contenido extendida: Una tabla ficticia de ejemplo -->
    <div class="card mt-4" style="padding: 0;">
        <h3 class="card-title" style="margin: 1.5rem 1.5rem 1rem 1.5rem; color: var(--text-color);">
            {{ __('Próximas Reservas de Hoy') }}
        </h3>
        
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--border-color); background-color: var(--bg-color);">
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: var(--text-light); font-size: 0.875rem; text-transform: uppercase;">{{ __('Cliente') }}</th>
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: var(--text-light); font-size: 0.875rem; text-transform: uppercase;">{{ __('Vehículo Asignado') }}</th>
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: var(--text-light); font-size: 0.875rem; text-transform: uppercase;">{{ __('Horario') }}</th>
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: var(--text-light); font-size: 0.875rem; text-transform: uppercase;">{{ __('Estado') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom: 1px solid var(--border-color); transition: background-color 0.2s;">
                        <td style="padding: 1rem 1.5rem; font-weight: 500; display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--border-color); display: flex; align-items: center; justify-content: center; color: var(--text-light);">JP</div>
                            <div>Juan Pérez</div>
                        </td>
                        <td style="padding: 1rem 1.5rem; color: var(--text-color);">Toyota Corolla - 2022</td>
                        <td style="padding: 1rem 1.5rem; color: var(--text-light);">14:00 hrs</td>
                        <td style="padding: 1rem 1.5rem;">
                            <span style="background-color: #fef3c7; color: #92400e; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">Pendiente Confirmación</span>
                        </td>
                    </tr>
                    <tr style="transition: background-color 0.2s;">
                        <td style="padding: 1rem 1.5rem; font-weight: 500; display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--border-color); display: flex; align-items: center; justify-content: center; color: var(--text-light);">MG</div>
                            <div>María García</div>
                        </td>
                        <td style="padding: 1rem 1.5rem; color: var(--text-color);">Ford Explorer - 2023</td>
                        <td style="padding: 1rem 1.5rem; color: var(--text-light);">09:00 hrs</td>
                        <td style="padding: 1rem 1.5rem;">
                            <span style="background-color: #d1fae5; color: #065f46; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">Confirmado</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
