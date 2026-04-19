@extends('layouts.admin')

@section('title', 'Dashboard — AutoRent')
@section('page-title', '📊 Dashboard')

@section('content')

<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px,1fr)); gap:20px; margin-bottom:28px;">

    <div class="card" style="text-align:center; padding:28px 20px;">
        <div style="font-size:36px; margin-bottom:8px;">🚗</div>
        <div style="font-size:28px; font-weight:700; color:#2563eb;">
            {{ \App\Models\Auto::count() }}
        </div>
        <div style="font-size:13px; color:#64748b; margin-top:4px;">Autos registrados</div>
    </div>

    <div class="card" style="text-align:center; padding:28px 20px;">
        <div style="font-size:36px; margin-bottom:8px;">✅</div>
        <div style="font-size:28px; font-weight:700; color:#16a34a;">
            {{ \App\Models\Auto::whereHas('estadoAuto', fn($q) => $q->where('estado_auto', 'Disponible'))->count() }}
        </div>
        <div style="font-size:13px; color:#64748b; margin-top:4px;">Disponibles</div>
    </div>

    <div class="card" style="text-align:center; padding:28px 20px;">
        <div style="font-size:36px; margin-bottom:8px;">👥</div>
        <div style="font-size:28px; font-weight:700; color:#7c3aed;">
            {{ \App\Models\Cliente::count() }}
        </div>
        <div style="font-size:13px; color:#64748b; margin-top:4px;">Clientes</div>
    </div>

    <div class="card" style="text-align:center; padding:28px 20px;">
        <div style="font-size:36px; margin-bottom:8px;">📋</div>
        <div style="font-size:28px; font-weight:700; color:#d97706;">
            {{ \App\Models\Alquiler::count() }}
        </div>
        <div style="font-size:13px; color:#64748b; margin-top:4px;">Reservas totales</div>
    </div>

</div>

{{-- Accesos rápidos --}}
<div class="card">
    <h3 style="font-size:15px; font-weight:700; margin-bottom:16px;">Acciones rápidas</h3>
    <div style="display:flex; gap:12px; flex-wrap:wrap;">
        <a href="{{ route('admin.autos.create') }}" class="btn btn-primary">＋ Registrar auto</a>
        <a href="{{ route('admin.autos.index') }}" class="btn btn-outline">🚘 Ver flota completa</a>
    </div>
</div>

@endsection
