
<?php $__env->startSection('title', __('Autos Disponibles')); ?>

<?php $__env->startSection('content'); ?>
    <h1 class="page-title"><?php echo e(__('Autos Disponibles')); ?></h1>

    <!-- Botón Toggle para el formulario (Tercer Diagrama de Secuencia) -->
    <div class="text-center mb-4">
        <button class="btn btn-outline" id="toggle-search-btn" onclick="toggleSearchForm()">
            <i class="fa-solid fa-magnifying-glass"></i> <span id="toggle-text"><?php echo e(isset($busqueda) ? __('Ocultar Búsqueda') : __('Consultar Disponibilidad')); ?></span>
        </button>
    </div>

    <script>
        function toggleSearchForm() {
            const container = document.getElementById('availability-form-container');
            const text = document.getElementById('toggle-text');
            if (container.style.display === 'none') {
                container.style.display = 'block';
                text.innerText = '<?php echo e(__("Ocultar Búsqueda")); ?>';
            } else {
                container.style.display = 'none';
                text.innerText = '<?php echo e(__("Consultar Disponibilidad")); ?>';
            }
        }
    </script>

    <!-- Formulario de Consulta de Disponibilidad (Oculto por defecto) -->
    <?php
        $showSearchForm = isset($busqueda) || request('show_search') || $errors->any();
    ?>
    <style>
        .search-form-visible { display: block; }
        .search-form-hidden { display: none; }
    </style>
    <div id="availability-form-container" class="reservation-card mb-5 <?php echo e($showSearchForm ? 'search-form-visible' : 'search-form-hidden'); ?>" style="padding: 2rem;">
        <h3 style="margin-bottom: 1.5rem; font-size: 1.25rem;"><i class="fa-solid fa-magnifying-glass"></i> <?php echo e(__('Consultar Disponibilidad')); ?></h3>
        
        <?php if($errors->any()): ?>
            <div style="background: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                <ul style="margin: 0; padding-left: 1.5rem;">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('consultar.disponibilidad')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; align-items: end;">
                <div class="form-group">
                    <label style="display: block; margin-bottom: 0.5rem; font-size: 0.875rem; font-weight: 600; color: var(--text-light);"><?php echo e(__('Fecha de Retiro')); ?></label>
                    <input type="date" name="fecha_retiro" class="form-control" value="<?php echo e(old('fecha_retiro', $busqueda['fecha_retiro'] ?? date('Y-m-d'))); ?>" required>
                </div>
                <div class="form-group">
                    <label style="display: block; margin-bottom: 0.5rem; font-size: 0.875rem; font-weight: 600; color: var(--text-light);"><?php echo e(__('Hora Retiro')); ?></label>
                    <input type="time" name="hora_retiro" class="form-control" value="<?php echo e(old('hora_retiro', $busqueda['hora_retiro'] ?? '09:00')); ?>" required>
                </div>
                <div class="form-group">
                    <label style="display: block; margin-bottom: 0.5rem; font-size: 0.875rem; font-weight: 600; color: var(--text-light);"><?php echo e(__('Fecha de Devolución')); ?></label>
                    <input type="date" name="fecha_devolucion" class="form-control" value="<?php echo e(old('fecha_devolucion', $busqueda['fecha_devolucion'] ?? date('Y-m-d', strtotime('+1 day')))); ?>" required>
                </div>
                <div class="form-group">
                    <label style="display: block; margin-bottom: 0.5rem; font-size: 0.875rem; font-weight: 600; color: var(--text-light);"><?php echo e(__('Hora Devolución')); ?></label>
                    <input type="time" name="hora_devolucion" class="form-control" value="<?php echo e(old('hora_devolucion', $busqueda['hora_devolucion'] ?? '09:00')); ?>" required>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary w-full" style="height: 45px;">
                        <?php echo e(__('Buscar Disponibles')); ?>

                    </button>
                </div>
            </div>
        </form>
        <?php if(isset($busqueda) && !$errors->any()): ?>
            <div style="margin-top: 1rem; font-size: 0.875rem; color: var(--success-color);">
                <i class="fa-solid fa-check-circle"></i> Mostrando resultados para el periodo seleccionado. 
                <a href="<?php echo e(route('catalogo')); ?>" style="color: var(--primary-color); text-decoration: underline; margin-left: 0.5rem;">Limpiar filtro</a>
            </div>
        <?php endif; ?>
    </div>

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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ISII_26TC_Grupo72\resources\views/autos.blade.php ENDPATH**/ ?>