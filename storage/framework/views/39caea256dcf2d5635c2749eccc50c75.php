<?php $__env->startSection('title', __('Confirmar Renta de Auto')); ?>

<?php $__env->startSection('content'); ?>
<div class="reservation-wrapper mt-4 mb-4">
    <h1 class="page-title text-center"><?php echo e(__('Confirmar Renta de Auto')); ?></h1>

    <div class="reservation-card">
        <!-- Resumen del auto seleccionado -->
        <div class="reservation-summary">
            <?php if(isset($auto)): ?>
                <img src="<?php echo e($auto->imagen_url); ?>" 
                     onerror="this.src='https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?q=80&w=300&auto=format&fit=crop'" 
                     alt="<?php echo e($auto->modelo->nombre_modelo ?? 'Auto'); ?>" 
                     class="reservation-auto-img">
                <div>
                    <h3 style="margin-bottom: 0.25rem; color: var(--text-color);"><?php echo e($auto->modelo->nombre_modelo ?? 'Auto'); ?> (<?php echo e($auto->anio); ?>)</h3>
                    <p style="font-weight: 700; color: var(--primary-color); margin-bottom: 0.25rem;">
                        $<?php echo e(number_format($auto->precio, 0, ',', '.')); ?> <small style="font-weight: 400; color: var(--text-light);">/ <?php echo e(__('día')); ?></small>
                    </p>
                    <p class="text-sm text-light" style="font-style: italic;"><?php echo e($auto->descripcion ?? __('Sin descripción adicional.')); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Formulario -->
        <form method="POST" action="<?php echo e(route('cliente.reserva.store')); ?>" id="reservation-form"> 
            <?php echo csrf_field(); ?>
            
            <!-- ID Oculto del Auto -->
            <input type="hidden" name="id_auto" value="<?php echo e($auto->id_auto); ?>">

            <div class="date-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                <!-- Fecha y Hora de Inicio -->
                <div class="form-group">
                    <label for="fecha_retiro" class="form-label"><?php echo e(__('Fecha de entrega')); ?></label>
                    <input type="date" id="fecha_retiro" name="fecha_retiro" class="form-control <?php $__errorArgs = ['fecha_retiro'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(date('Y-m-d')); ?>" required>
                </div>
                <div class="form-group">
                    <label for="hora_retiro" class="form-label"><?php echo e(__('Horario de entrega')); ?></label>
                    <input type="time" id="hora_retiro" name="hora_retiro" class="form-control <?php $__errorArgs = ['hora_retiro'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="09:00" required>
                </div>

                <!-- Fecha y Hora de Fin -->
                <div class="form-group">
                    <label for="fecha_devolucion" class="form-label"><?php echo e(__('Fecha de devolución')); ?></label>
                    <input type="date" id="fecha_devolucion" name="fecha_devolucion" class="form-control <?php $__errorArgs = ['fecha_devolucion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(date('Y-m-d', strtotime('+1 day'))); ?>" required>
                </div>
                <div class="form-group">
                    <label for="hora_devolucion" class="form-label"><?php echo e(__('Horario de devolución')); ?></label>
                    <input type="time" id="hora_devolucion" name="hora_devolucion" class="form-control <?php $__errorArgs = ['hora_devolucion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="18:00" required>
                </div>
            </div>

            <!-- Forma de Pago -->
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="medio_pago" class="form-label"><?php echo e(__('Forma de pago')); ?></label>
                <select id="medio_pago" name="medio_pago" class="form-control <?php $__errorArgs = ['medio_pago'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                    <option value="" disabled selected><?php echo e(__('Seleccione una forma de pago')); ?></option>
                    <option value="Tarjeta de Crédito"><?php echo e(__('Tarjeta de Crédito')); ?></option>
                    <option value="Tarjeta de Débito"><?php echo e(__('Tarjeta de Débito')); ?></option>
                    <option value="Efectivo"><?php echo e(__('Efectivo')); ?></option>
                    <option value="Transferencia"><?php echo e(__('Transferencia Bancaria')); ?></option>
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 0; margin-top: 1rem;">
                <button type="submit" class="btn btn-primary w-full" style="font-size: 1.125rem;">
                    <i class="fa-solid fa-calendar-check" style="margin-right: 0.5rem;"></i> <?php echo e(__('Confirmar Reserva')); ?>

                </button>
            </div>
            
            <p class="text-center text-sm" style="color: var(--text-light); margin-top: 1.5rem;">
                <?php echo e(__('Al confirmar, los datos de esta reserva serán guardados en nuestro registro seguro de AutoRent.')); ?>

            </p>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp1\htdocs\ISII_26TC_Grupo72-main\resources\views/reservar.blade.php ENDPATH**/ ?>