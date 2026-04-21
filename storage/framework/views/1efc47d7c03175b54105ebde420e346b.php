<?php $__env->startSection('title', __('Autos Disponibles')); ?>

<?php $__env->startSection('content'); ?>
    <h1 class="page-title"><?php echo e(__('Autos Disponibles')); ?></h1>

    <?php if(isset($autos) && count($autos) > 0): ?>
        <!-- Grid de Autos -->
        <div class="cars-grid">
            <?php $__currentLoopData = $autos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="car-card">
                    <!-- Imagen del Auto -->
                    <div class="car-img-wrapper" style="background: white;">
                        <img src="<?php echo e($auto->imagen_url); ?>" 
                             onerror="this.src='https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?q=80&w=600&auto=format&fit=crop'" 
                             alt="<?php echo e($auto->modelo->nombre_modelo ?? 'Auto'); ?>" 
                             class="car-img">
                    </div>
                    
                    <div class="car-info">
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <h3 class="car-title"><?php echo e($auto->modelo->nombre_modelo ?? 'Auto'); ?></h3>
                            <span style="font-size: 0.875rem; font-weight: 600; color: var(--primary-color);"><?php echo e($auto->anio); ?></span>
                        </div>
                        
                        <div class="car-details">
                            <p style="margin-top: 0.5rem; font-weight: 700; font-size: 1.1rem;">
                                $<?php echo e(number_format($auto->precio, 0, ',', '.')); ?> <small style="font-weight: 400; color: var(--text-light);">/ <?php echo e(__('día')); ?></small>
                            </p>
                        </div>

                        <?php if(isset($auto->estadoAuto) && strtolower($auto->estadoAuto->estado_auto) == 'disponible'): ?>
                            <div class="car-actions">
                                <a href="<?php echo e(route('cliente.reservar', $auto->id_auto)); ?>" class="btn btn-primary w-full"><?php echo e(__('Reservar Ahora')); ?></a>
                            </div>
                        <?php else: ?>
                            <div class="car-actions">
                                <button class="btn w-full" disabled style="background: var(--border-color); color: var(--text-light); cursor: not-allowed;"><?php echo e(__('No disponible')); ?></button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <!-- Estado Vacío (Empty State) -->
        <div style="background: var(--white); padding: 4rem 2rem; border-radius: 0.5rem; text-align: center; border: 1px dashed var(--border-color);">
            <i class="fa-solid fa-car-side" style="font-size: 3.5rem; color: var(--border-color); margin-bottom: 1.5rem;"></i>
            <h2 style="color: var(--text-color); margin-bottom: 0.5rem; font-size: 1.25rem; font-weight: 600;"><?php echo e(__('Sin Inventario')); ?></h2>
            <p style="color: var(--text-light); font-size: 1rem;">
                <?php echo e(__('No hay autos disponibles en este momento.')); ?>

            </p>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\car_a\OneDrive\Desktop\bd\ISII_26TC_Grupo72-main\resources\views/autos.blade.php ENDPATH**/ ?>