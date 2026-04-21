@extends('layouts.admin')

@section('title', 'Detalle Auto — AutoRent')
@section('page-title', '🚗 Detalle del vehículo')

@section('content')

<div style="margin-bottom:16px; display:flex; gap:10px;">
    <a href="{{ route('admin.autos.index') }}" class="btn btn-outline" style="font-size:13px;">← Volver</a>
    <a href="{{ route('admin.autos.edit', $auto->id_auto) }}" class="btn btn-primary" style="font-size:13px;">✏️ Editar</a>
</div>

<div style="display:grid; grid-template-columns:300px 1fr; gap:20px; align-items:start;">

    {{-- Imagen --}}
    <div class="card" style="padding:16px; text-align:center;">
        @if($auto->imagen)
            <img src="{{ asset('storage/'.$auto->imagen) }}"
                 alt="Foto del auto"
                 style="width:100%; border-radius:8px; object-fit:cover; max-height:200px;">
        @else
            <div style="height:180px; background:#f1f5f9; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:60px;">🚗</div>
        @endif
        <p style="margin-top:12px; font-size:18px; font-weight:700; color:#0f172a;">
            ${{ number_format($auto->precio, 2, ',', '.') }}
            <small style="font-size:12px; color:#64748b; font-weight:400;">/día</small>
        </p>
    </div>

    {{-- Datos --}}
    <div class="card">
        <h2 style="font-size:20px; font-weight:700; margin-bottom:20px;">
            {{ $auto->modelo->marca->nombre_marca ?? '—' }} {{ $auto->modelo->nombre_modelo ?? '—' }}
        </h2>

        <table style="font-size:14px;">
            <tr><td style="padding:8px 0; color:#64748b; width:140px;">ID Auto</td><td style="font-weight:500;">#{{ $auto->id_auto }}</td></tr>
            <tr><td style="padding:8px 0; color:#64748b;">Año</td><td style="font-weight:500;">{{ $auto->anio }}</td></tr>
            <tr><td style="padding:8px 0; color:#64748b;">Modelo</td><td style="font-weight:500;">{{ $auto->modelo->nombre_modelo ?? '—' }}</td></tr>
            <tr><td style="padding:8px 0; color:#64748b;">Marca</td><td style="font-weight:500;">{{ $auto->modelo->marca->nombre_marca ?? '—' }}</td></tr>
            <tr>
                <td style="padding:8px 0; color:#64748b;">Estado</td>
                <td>
                    @php $estado = $auto->estadoAuto->estado_auto ?? ''; @endphp
                    <span class="badge {{ match($estado) { 'Disponible' => 'badge-disponible', 'Alquilado' => 'badge-alquilado', 'Mantenimiento' => 'badge-mantenimiento', default => '' } }}">
                        {{ $estado }}
                    </span>
                </td>
            </tr>
            <tr><td style="padding:8px 0; color:#64748b;">Descripción</td><td>{{ $auto->descripcion ?? '—' }}</td></tr>
            <tr><td style="padding:8px 0; color:#64748b;">Registrado</td><td>{{ $auto->created_at->format('d/m/Y H:i') }}</td></tr>
        </table>

        {{-- Alquileres del auto --}}
        @if($auto->alquileres->count() > 0)
            <hr style="border:none; border-top:1px solid #e2e8f0; margin:20px 0;">
            <h3 style="font-size:14px; font-weight:700; margin-bottom:12px;">Historial de alquileres ({{ $auto->alquileres->count() }})</h3>
            @foreach($auto->alquileres->take(5) as $alquiler)
                <div style="padding:8px 12px; background:#f8fafc; border-radius:6px; margin-bottom:6px; font-size:13px;">
                    📅 {{ $alquiler->fecha_retiro->format('d/m/Y') }} → {{ $alquiler->fecha_devolucion->format('d/m/Y') }}
                    &nbsp;|&nbsp; Cliente: {{ $alquiler->cliente->nombre ?? '—' }} {{ $alquiler->cliente->apellido ?? '' }}
                    &nbsp;|&nbsp; ${{ number_format($alquiler->precioTotal, 2, ',', '.') }}
                </div>
            @endforeach
        @endif
    </div>

</div>

@endsection
