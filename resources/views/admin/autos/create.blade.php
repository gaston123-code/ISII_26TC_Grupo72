@extends('layouts.admin')

@section('title', 'Registrar Auto — AutoRent')
@section('page-title', '➕ Registrar nuevo auto')

@section('content')

<div style="margin-bottom:16px;">
    <a href="{{ route('admin.autos.index') }}" class="btn btn-outline" style="font-size:13px;">← Volver a la lista</a>
</div>

<div class="card" style="max-width:720px;">
    <h2 style="font-size:16px; font-weight:700; margin-bottom:20px; color:#0f172a;">
        Datos del vehículo
    </h2>

    <form method="POST"
          action="{{ route('admin.autos.store') }}"
          enctype="multipart/form-data">
        @csrf

        <div class="form-grid">

            {{-- Modelo (agrupa marca + modelo) --}}
            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="id_modelo">Marca y Modelo *</label>
                <select id="id_modelo" name="id_modelo" required>
                    <option value="">— Seleccioná un modelo —</option>
                    @foreach($modelos->groupBy(fn($m) => $m->marca->nombre_marca ?? 'Sin marca') as $marcaNombre => $modelosGrupo)
                        <optgroup label="{{ $marcaNombre }}">
                            @foreach($modelosGrupo as $modelo)
                                <option value="{{ $modelo->id_modelo }}"
                                        {{ old('id_modelo') == $modelo->id_modelo ? 'selected' : '' }}>
                                    {{ $modelo->nombre_modelo }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                @error('id_modelo') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            {{-- Año --}}
            <div class="form-group">
                <label for="anio">Año del vehículo *</label>
                <input type="number"
                       id="anio"
                       name="anio"
                       value="{{ old('anio', date('Y')) }}"
                       min="2000"
                       max="{{ date('Y') + 1 }}"
                       required
                       placeholder="Ej: 2023">
                @error('anio') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            {{-- Precio por día --}}
            <div class="form-group">
                <label for="precio">Precio por día ($ ARS) *</label>
                <input type="number"
                       id="precio"
                       name="precio"
                       value="{{ old('precio') }}"
                       min="0.01"
                       step="0.01"
                       required
                       placeholder="Ej: 15000.00">
                @error('precio') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            {{-- Estado --}}
            <div class="form-group">
                <label for="id_estadoAuto">Estado *</label>
                <select id="id_estadoAuto" name="id_estadoAuto" required>
                    <option value="">— Seleccioná el estado —</option>
                    @foreach($estadosAuto as $estado)
                        <option value="{{ $estado->id_estadoAuto }}"
                                {{ old('id_estadoAuto') == $estado->id_estadoAuto ? 'selected' : '' }}>
                            {{ $estado->estado_auto }}
                        </option>
                    @endforeach
                </select>
                @error('id_estadoAuto') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            {{-- Descripción --}}
            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="descripcion">Descripción breve</label>
                <input type="text"
                       id="descripcion"
                       name="descripcion"
                       value="{{ old('descripcion') }}"
                       maxlength="255"
                       placeholder="Ej: Aire acond., dirección asistida, 5 puertas">
                @error('descripcion') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            {{-- Imagen --}}
            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="imagen">Imagen del auto</label>
                <input type="file"
                       id="imagen"
                       name="imagen"
                       accept="image/jpg,image/jpeg,image/png,image/webp">
                <p style="font-size:12px; color:#94a3b8; margin-top:4px;">JPG, PNG o WebP — máx. 2MB</p>
                @error('imagen') <p class="form-error">{{ $message }}</p> @enderror

                {{-- Preview de imagen --}}
                <div id="preview-container" style="display:none; margin-top:12px;">
                    <img id="preview-img"
                         src=""
                         alt="Preview"
                         style="max-width:200px; max-height:140px; border-radius:8px; border:1px solid #e2e8f0; object-fit:cover;">
                </div>
            </div>

        </div>

        {{-- Botones --}}
        <div style="display:flex; gap:12px; margin-top:8px;">
            <button type="submit" class="btn btn-primary">✓ Registrar auto</button>
            <a href="{{ route('admin.autos.index') }}" class="btn btn-outline">Cancelar</a>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
    // Preview de la imagen antes de subir
    document.getElementById('imagen').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(ev) {
            document.getElementById('preview-img').src = ev.target.result;
            document.getElementById('preview-container').style.display = 'block';
        };
        reader.readAsDataURL(file);
    });
</script>
@endpush
