

<?php $__env->startSection('title', 'Registrar Auto — AutoRent'); ?>
<?php $__env->startSection('page-title', '➕ Registrar nuevo auto'); ?>

<?php $__env->startSection('content'); ?>

<div style="margin-bottom:16px;">
    <a href="<?php echo e(route('admin.autos.index')); ?>" class="btn btn-outline" style="font-size:13px;">← Volver a la lista</a>
</div>

<div class="card" style="max-width:720px;">
    <h2 style="font-size:16px; font-weight:700; margin-bottom:20px; color:#0f172a;">
        Datos del vehículo
    </h2>

    <form method="POST"
          action="<?php echo e(route('admin.autos.store')); ?>"
          enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <div class="form-grid">

            
            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="id_modelo">Marca y Modelo *</label>
                <select id="id_modelo" name="id_modelo" required>
                    <option value="">— Seleccioná un modelo —</option>
                    <?php $__currentLoopData = $modelos->groupBy(fn($m) => $m->marca->nombre_marca ?? 'Sin marca'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $marcaNombre => $modelosGrupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <optgroup label="<?php echo e($marcaNombre); ?>">
                            <?php $__currentLoopData = $modelosGrupo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $modelo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($modelo->id_modelo); ?>"
                                        <?php echo e(old('id_modelo') == $modelo->id_modelo ? 'selected' : ''); ?>>
                                    <?php echo e($modelo->nombre_modelo); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </optgroup>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['id_modelo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="form-group">
                <label for="anio">Año del vehículo *</label>
                <input type="number"
                       id="anio"
                       name="anio"
                       value="<?php echo e(old('anio', date('Y'))); ?>"
                       min="2000"
                       max="<?php echo e(date('Y') + 1); ?>"
                       required
                       placeholder="Ej: 2023">
                <?php $__errorArgs = ['anio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="form-group">
                <label for="precio">Precio por día ($ ARS) *</label>
                <input type="number"
                       id="precio"
                       name="precio"
                       value="<?php echo e(old('precio')); ?>"
                       min="0.01"
                       step="0.01"
                       required
                       placeholder="Ej: 15000.00">
                <?php $__errorArgs = ['precio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="form-group">
                <label for="id_estadoAuto">Estado *</label>
                <select id="id_estadoAuto" name="id_estadoAuto" required>
                    <option value="">— Seleccioná el estado —</option>
                    <?php $__currentLoopData = $estadosAuto; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($estado->id_estadoAuto); ?>"
                                <?php echo e(old('id_estadoAuto') == $estado->id_estadoAuto ? 'selected' : ''); ?>>
                            <?php echo e($estado->estado_auto); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['id_estadoAuto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="descripcion">Descripción breve</label>
                <input type="text"
                       id="descripcion"
                       name="descripcion"
                       value="<?php echo e(old('descripcion')); ?>"
                       maxlength="255"
                       placeholder="Ej: Aire acond., dirección asistida, 5 puertas">
                <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="imagen">Imagen del auto</label>
                <input type="file"
                       id="imagen"
                       name="imagen"
                       accept="image/jpg,image/jpeg,image/png,image/webp">
                <p style="font-size:12px; color:#94a3b8; margin-top:4px;">JPG, PNG o WebP — máx. 2MB</p>
                <?php $__errorArgs = ['imagen'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                
                <div id="preview-container" style="display:none; margin-top:12px;">
                    <img id="preview-img"
                         src=""
                         alt="Preview"
                         style="max-width:200px; max-height:140px; border-radius:8px; border:1px solid #e2e8f0; object-fit:cover;">
                </div>
            </div>

        </div>

        
        <div style="display:flex; gap:12px; margin-top:8px;">
            <button type="submit" class="btn btn-primary">✓ Registrar auto</button>
            <a href="<?php echo e(route('admin.autos.index')); ?>" class="btn btn-outline">Cancelar</a>
        </div>

    </form>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ISII_26TC_Grupo72\resources\views/admin/autos/create.blade.php ENDPATH**/ ?>