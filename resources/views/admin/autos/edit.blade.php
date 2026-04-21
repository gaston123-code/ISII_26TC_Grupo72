@extends('layouts.admin')

@section('title', 'Editar Auto — AutoRent')
@section('page-title', '✏️ Editar auto')

@section('content')

<div style="margin-bottom:16px;">
    <a href="{{ route('admin.autos.index') }}" class="btn btn-outline" style="font-size:13px;">← Volver a la lista</a>
</div>

<div class="card" style="max-width:720px;">
    <h2 style="font-size:16px; font-weight:700; margin-bottom:20px;">
        Editando: {{ $auto->modelo->marca->nombre_marca ?? '' }} {{ $auto->modelo->nombre_modelo ?? '' }} ({{ $auto->anio }})
    </h2>

    <form method="POST"
          action="{{ route('admin.autos.update', $auto->id_auto) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-grid">

            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="id_modelo">Marca y Modelo *</label>
                <select id="id_modelo" name="id_modelo" required>
                    <option value="">— Seleccioná un modelo —</option>
                    @foreach($modelos->groupBy(fn($m) => $m->marca->nombre_marca ?? 'Sin marca') as $marcaNombre => $modelosGrupo)
                        <optgroup label="{{ $marcaNombre }}">
                            @foreach($modelosGrupo as $modelo)
                                <option value="{{ $modelo->id_modelo }}"
                                    {{ (old('id_modelo', $auto->id_modelo) == $modelo->id_modelo) ? 'selected' : '' }}>
                                    {{ $modelo->nombre_modelo }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                @error('id_modelo') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="anio">Año *</label>
                <input type="number" id="anio" name="anio"
                       value="{{ old('anio', $auto->anio) }}"
                       min="2000" max="{{ date('Y') + 1 }}" required>
                @error('anio') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="precio">Precio por día ($ ARS) *</label>
                <input type="number" id="precio" name="precio"
                       value="{{ old('precio', $auto->precio) }}"
                       min="0.01" step="0.01" required>
                @error('precio') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="id_estadoAuto">Estado *</label>
                <select id="id_estadoAuto" name="id_estadoAuto" required>
                    @foreach($estadosAuto as $estado)
                        <option value="{{ $estado->id_estadoAuto }}"
                            {{ (old('id_estadoAuto', $auto->id_estadoAuto) == $estado->id_estadoAuto) ? 'selected' : '' }}>
                            {{ $estado->estado_auto }}
                        </option>
                    @endforeach
                </select>
                @error('id_estadoAuto') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="descripcion">Descripción</label>
                <input type="text" id="descripcion" name="descripcion"
                       value="{{ old('descripcion', $auto->descripcion) }}" maxlength="255">
                @error('descripcion') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="imagen">Nueva imagen (opcional)</label>

                {{-- Imagen actual --}}
                @if($auto->imagen)
                    <div style="margin-bottom:10px;">
                        <p style="font-size:12px; color:#64748b; margin-bottom:6px;">Imagen actual:</p>
                        <img src="{{ asset('storage/'.$auto->imagen) }}"
                             alt="Imagen actual"
                             style="max-width:180px; border-radius:8px; border:1px solid #e2e8f0;">
                    </div>
                @endif

                <input type="file" id="imagen" name="imagen" accept="image/jpg,image/jpeg,image/png,image/webp">
                <p style="font-size:12px; color:#94a3b8; margin-top:4px;">Si no subís una nueva imagen, se mantiene la actual.</p>
                @error('imagen') <p class="form-error">{{ $message }}</p> @enderror
            </div>

        </div>

        <div style="display:flex; gap:12px; margin-top:8px;">
            <button type="submit" class="btn btn-primary">✓ Guardar cambios</button>
            <a href="{{ route('admin.autos.index') }}" class="btn btn-outline">Cancelar</a>
        </div>

    </form>
</div>

@endsection
