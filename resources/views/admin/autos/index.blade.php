@extends('layouts.admin')

@section('title', 'Gestión de Autos — AutoRent')
@section('page-title', '🚘 Gestión de Flota')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <div>
        <p style="color:#64748b; font-size:14px;">Total: <strong>{{ $autos->total() }} autos</strong> registrados</p>
    </div>
    <a href="{{ route('admin.autos.create') }}" class="btn btn-primary">
        ＋ Registrar nuevo auto
    </a>
</div>

@if($autos->isEmpty())
    <div class="card" style="text-align:center; padding:60px;">
        <p style="font-size:48px; margin-bottom:12px;">🚗</p>
        <h3 style="color:#64748b; font-weight:500;">No hay autos registrados todavía</h3>
        <p style="color:#94a3b8; margin:8px 0 20px; font-size:14px;">Comenzá agregando el primer vehículo a la flota.</p>
        <a href="{{ route('admin.autos.create') }}" class="btn btn-primary">Registrar primer auto</a>
    </div>
@else
    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Vehículo</th>
                        <th>Año</th>
                        <th>Precio/día</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($autos as $auto)
                    <tr>
                        <td style="color:#94a3b8; font-size:12px;">#{{ $auto->id_auto }}</td>
                        <td>
                            <div style="display:flex; align-items:center; gap:12px;">
                                @if($auto->imagen)
                                    <img src="{{ asset('storage/'.$auto->imagen) }}"
                                         alt="Foto del auto"
                                         style="width:50px; height:38px; object-fit:cover; border-radius:6px; border:1px solid #e2e8f0;">
                                @else
                                    <div style="width:50px; height:38px; background:#f1f5f9; border-radius:6px; display:flex; align-items:center; justify-content:center; font-size:20px;">🚗</div>
                                @endif
                                <div>
                                    <div style="font-weight:600; font-size:14px;">
                                        {{ $auto->modelo->marca->nombre_marca ?? '—' }}
                                        {{ $auto->modelo->nombre_modelo ?? '—' }}
                                    </div>
                                    @if($auto->descripcion)
                                        <div style="font-size:12px; color:#94a3b8;">{{ Str::limit($auto->descripcion, 40) }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>{{ $auto->anio }}</td>
                        <td style="font-weight:600; color:#2563eb;">${{ number_format($auto->precio, 2, ',', '.') }}</td>
                        <td>
                            @php
                                $estado = $auto->estadoAuto->estado_auto ?? '';
                                $badgeClass = match($estado) {
                                    'Disponible'    => 'badge-disponible',
                                    'Alquilado'     => 'badge-alquilado',
                                    'Mantenimiento' => 'badge-mantenimiento',
                                    default         => '',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $estado }}</span>
                        </td>
                        <td>
                            <div style="display:flex; gap:8px; flex-wrap:wrap;">
                                <a href="{{ route('admin.autos.show', $auto->id_auto) }}" class="btn btn-outline" style="padding:6px 12px; font-size:12px;">👁 Ver</a>
                                <a href="{{ route('admin.autos.edit', $auto->id_auto) }}" class="btn btn-outline" style="padding:6px 12px; font-size:12px;">✏️ Editar</a>
                                <form method="POST" action="{{ route('admin.autos.destroy', $auto->id_auto) }}"
                                      onsubmit="return confirm('¿Eliminar este auto de la flota?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding:6px 12px; font-size:12px;">🗑</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        @if($autos->hasPages())
            <div style="margin-top:20px; display:flex; justify-content:flex-end;">
                {{ $autos->links() }}
            </div>
        @endif
    </div>
@endif

@endsection
