

<?php $__env->startSection('title', 'Detalle Auto — AutoRent'); ?>
<?php $__env->startSection('page-title', '🚗 Detalle del vehículo'); ?>

<?php $__env->startSection('content'); ?>

<div style="margin-bottom:16px; display:flex; gap:10px;">
    <a href="<?php echo e(route('admin.autos.index')); ?>" class="btn btn-outline" style="font-size:13px;">← Volver</a>
    <a href="<?php echo e(route('admin.autos.edit', $auto->id_auto)); ?>" class="btn btn-primary" style="font-size:13px;">✏️ Editar</a>
</div>

<div style="display:grid; grid-template-columns:300px 1fr; gap:20px; align-items:start;">

    
    <div class="card" style="padding:16px; text-align:center;">
        <?php if($auto->imagen): ?>
            <img src="<?php echo e(asset('storage/'.$auto->imagen)); ?>"
                 alt="Foto del auto"
                 style="width:100%; border-radius:8px; object-fit:cover; max-height:200px;">
        <?php else: ?>
            <div style="height:180px; background:#f1f5f9; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:60px;">🚗</div>
        <?php endif; ?>
        <p style="margin-top:12px; font-size:18px; font-weight:700; color:#0f172a;">
            $<?php echo e(number_format($auto->precio, 2, ',', '.')); ?>

            <small style="font-size:12px; color:#64748b; font-weight:400;">/día</small>
        </p>
    </div>

    
    <div class="card">
        <h2 style="font-size:20px; font-weight:700; margin-bottom:20px;">
            <?php echo e($auto->modelo->marca->nombre_marca ?? '—'); ?> <?php echo e($auto->modelo->nombre_modelo ?? '—'); ?>

        </h2>

        <table style="font-size:14px;">
            <tr><td style="padding:8px 0; color:#64748b; width:140px;">ID Auto</td><td style="font-weight:500;">#<?php echo e($auto->id_auto); ?></td></tr>
            <tr><td style="padding:8px 0; color:#64748b;">Año</td><td style="font-weight:500;"><?php echo e($auto->anio); ?></td></tr>
            <tr><td style="padding:8px 0; color:#64748b;">Modelo</td><td style="font-weight:500;"><?php echo e($auto->modelo->nombre_modelo ?? '—'); ?></td></tr>
            <tr><td style="padding:8px 0; color:#64748b;">Marca</td><td style="font-weight:500;"><?php echo e($auto->modelo->marca->nombre_marca ?? '—'); ?></td></tr>
            <tr>
                <td style="padding:8px 0; color:#64748b;">Estado</td>
                <td>
                    <?php $estado = $auto->estadoAuto->estado_auto ?? ''; ?>
                    <span class="badge <?php echo e(match($estado) { 'Disponible' => 'badge-disponible', 'Alquilado' => 'badge-alquilado', 'Mantenimiento' => 'badge-mantenimiento', default => '' }); ?>">
                        <?php echo e($estado); ?>

                    </span>
                </td>
            </tr>
            <tr><td style="padding:8px 0; color:#64748b;">Descripción</td><td><?php echo e($auto->descripcion ?? '—'); ?></td></tr>
            <tr><td style="padding:8px 0; color:#64748b;">Registrado</td><td><?php echo e($auto->created_at->format('d/m/Y H:i')); ?></td></tr>
        </table>

        
        <?php if($auto->alquileres->count() > 0): ?>
            <hr style="border:none; border-top:1px solid #e2e8f0; margin:20px 0;">
            <h3 style="font-size:14px; font-weight:700; margin-bottom:12px;">Historial de alquileres (<?php echo e($auto->alquileres->count()); ?>)</h3>
            <?php $__currentLoopData = $auto->alquileres->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alquiler): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="padding:8px 12px; background:#f8fafc; border-radius:6px; margin-bottom:6px; font-size:13px;">
                    📅 <?php echo e($alquiler->fecha_retiro->format('d/m/Y')); ?> → <?php echo e($alquiler->fecha_devolucion->format('d/m/Y')); ?>

                    &nbsp;|&nbsp; Cliente: <?php echo e($alquiler->cliente->nombre ?? '—'); ?> <?php echo e($alquiler->cliente->apellido ?? ''); ?>

                    &nbsp;|&nbsp; $<?php echo e(number_format($alquiler->precioTotal, 2, ',', '.')); ?>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ISII_26TC_Grupo72\resources\views/admin/autos/show.blade.php ENDPATH**/ ?>