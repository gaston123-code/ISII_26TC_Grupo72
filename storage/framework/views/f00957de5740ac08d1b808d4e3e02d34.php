<?php $__env->startSection('title', __('Mis Reservas')); ?>

<?php $__env->startSection('content'); ?>
<div class="reservation-wrapper mt-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title" style="margin: 0;"><?php echo e(__('Mis Reservas')); ?></h1>
        <a href="<?php echo e(route('catalogo')); ?>" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> <?php echo e(__('Nueva Reserva')); ?>

        </a>
    </div>

    <?php if($reservas->isEmpty()): ?>
        <div class="reservation-card text-center" style="padding: 5rem 2rem;">
            <div style="font-size: 4rem; color: #e2e8f0; margin-bottom: 1.5rem;">
                <i class="fa-solid fa-calendar-xmark"></i>
            </div>
            <h3 style="color: #64748b;">Aún no tienes reservas</h3>
            <p style="color: #94a3b8; margin-bottom: 2rem;">Cuando reserves un auto, aparecerá listado aquí.</p>
            <a href="<?php echo e(route('catalogo')); ?>" class="btn btn-primary" style="padding: 0.75rem 2rem;">Explorar Catálogo</a>
        </div>
    <?php else: ?>
        <div class="reservation-grid" style="display: grid; gap: 1.5rem;">
            <?php $__currentLoopData = $reservas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reserva): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="reservation-card" style="padding: 1.5rem; display: flex; flex-wrap: wrap; gap: 2rem; align-items: center; justify-content: space-between; border-left: 5px solid #2563eb;">
                    
                    <div style="display: flex; gap: 1.5rem; align-items: center; flex: 1; min-width: 300px;">
                        <img src="<?php echo e($reserva->auto->imagen_url); ?>" style="width: 100px; height: 70px; object-fit: cover; border-radius: 0.5rem;" alt="Auto">
                        <div>
                            <h4 style="margin: 0; font-size: 1.125rem;"><?php echo e($reserva->auto->modelo->nombre_modelo); ?></h4>
                            <p style="margin: 0; color: #64748b; font-size: 0.875rem;"><?php echo e($reserva->auto->modelo->marca->nombre_marca); ?> — <?php echo e($reserva->auto->anio); ?></p>
                        </div>
                    </div>

                    <div style="display: flex; gap: 3rem; flex: 2; justify-content: center; min-width: 300px;">
                        <div class="text-center">
                            <span style="font-size: 0.7rem; text-transform: uppercase; color: #94a3b8; font-weight: 700; display: block; margin-bottom: 0.25rem;">Retiro</span>
                            <span style="font-weight: 600; font-size: 1rem;"><?php echo e($reserva->fecha_retiro->format('d/m/Y')); ?></span>
                        </div>
                        <div style="color: #cbd5e1; display: flex; align-items: center;">
                            <i class="fa-solid fa-arrow-right"></i>
                        </div>
                        <div class="text-center">
                            <span style="font-size: 0.7rem; text-transform: uppercase; color: #94a3b8; font-weight: 700; display: block; margin-bottom: 0.25rem;">Devolución</span>
                            <span style="font-weight: 600; font-size: 1rem;"><?php echo e($reserva->fecha_devolucion->format('d/m/Y')); ?></span>
                        </div>
                    </div>

                    <div style="text-align: right; min-width: 150px;">
                        <span style="font-size: 0.7rem; text-transform: uppercase; color: #94a3b8; font-weight: 700; display: block; margin-bottom: 0.25rem;">Total</span>
                        <span style="font-weight: 800; font-size: 1.25rem; color: #1e293b;">$<?php echo e(number_format($reserva->precioTotal, 0, ',', '.')); ?></span>
                    </div>

                    <div style="min-width: 120px;">
                        <?php
                            $statusColor = '#64748b';
                            $bgColor = '#f1f5f9';
                            if(isset($reserva->estadoAlquiler)){
                                if($reserva->id_estadoAlquiler == 1) { $statusColor = '#d97706'; $bgColor = '#fef3c7'; } // Pendiente
                                if($reserva->id_estadoAlquiler == 2) { $statusColor = '#059669'; $bgColor = '#d1fae5'; } // Confirmado
                            }
                        ?>
                        <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; color: <?php echo e($statusColor); ?>; background: <?php echo e($bgColor); ?>;">
                             <?php echo e($reserva->estadoAlquiler->estado_alquiler ?? 'Sin estado'); ?>

                        </span>
                    </div>

                    <div style="min-width: 50px;">
                        <a href="<?php echo e(route('cliente.reserva.exitosa', $reserva->id_reserva)); ?>" class="btn btn-icon" title="Ver Comprobante" style="color: #64748b;">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\car_a\OneDrive\Desktop\bd\ISII_26TC_Grupo72-main\resources\views/mis-reservas.blade.php ENDPATH**/ ?>