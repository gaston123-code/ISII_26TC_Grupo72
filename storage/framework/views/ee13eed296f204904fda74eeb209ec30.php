<?php $__env->startSection('title', __('Pasarela de Pago')); ?>

<?php $__env->startSection('content'); ?>
<div class="reservation-wrapper mt-5 mb-5" style="max-width: 600px; margin: 0 auto;">
    <div class="reservation-card" style="padding: 2.5rem; box-shadow: 0 15px 35px rgba(0,0,0,0.1); border: none;">
        
        <div class="text-center mb-4">
            <h1 style="font-size: 2rem; font-weight: 800; color: var(--text-color);"><?php echo e(__('Finalizar Pago')); ?></h1>
            <p style="color: var(--text-light);"><?php echo e(__('Ingresa los detalles para confirmar tu reserva.')); ?></p>
        </div>

        <!-- Resumen rápido -->
        <div style="background: #f8fafc; border-radius: 0.75rem; padding: 1.5rem; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; border: 1px solid #e2e8f0;">
            <div>
                <span style="font-size: 0.875rem; color: #64748b; display: block;"><?php echo e(__('Monto a pagar')); ?></span>
                <strong style="font-size: 1.5rem; color: var(--primary-color);">$<?php echo e(number_format($alquiler->precioTotal, 0, ',', '.')); ?></strong>
            </div>
            <div style="text-align: right;">
                <span style="font-size: 0.875rem; color: #64748b; display: block;"><?php echo e(__('Método elegido')); ?></span>
                <strong style="font-size: 1.125rem; color: var(--text-color);"><?php echo e($medio_pago); ?></strong>
            </div>
        </div>

        <form method="POST" action="<?php echo e(route('cliente.pago.procesar')); ?>" id="payment-form">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="id_reserva" value="<?php echo e($alquiler->id_reserva); ?>">
            <input type="hidden" name="medio_pago" value="<?php echo e($medio_pago); ?>">

            <?php if(str_contains(strtolower($medio_pago), 'tarjeta')): ?>
                <!-- Campos para Tarjeta -->
                <div class="form-group mb-4">
                    <label class="form-label"><?php echo e(__('Número de Tarjeta')); ?></label>
                    <div style="position: relative;">
                        <input type="text" class="form-control" placeholder="0000 0000 0000 0000" maxlength="19" required>
                        <i class="fa-solid fa-credit-card" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;" class="mb-4">
                    <div class="form-group">
                        <label class="form-label"><?php echo e(__('Vencimiento')); ?></label>
                        <input type="text" class="form-control" placeholder="MM/AA" maxlength="5" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?php echo e(__('CVV')); ?></label>
                        <input type="password" class="form-control" placeholder="***" maxlength="4" required>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label class="form-label"><?php echo e(__('Titular de la Tarjeta')); ?></label>
                    <input type="text" class="form-control" placeholder="Nombre como figura en la tarjeta" required>
                </div>
            <?php elseif(str_contains(strtolower($medio_pago), 'transferencia')): ?>
                <!-- Campos para Transferencia -->
                <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 0.5rem; padding: 1rem; margin-bottom: 2rem;">
                    <p style="margin-bottom: 0.5rem; font-weight: 600; color: #1e40af;"><?php echo e(__('Datos de nuestra cuenta:')); ?></p>
                    <p style="margin: 0; font-size: 0.875rem; color: #1e3a8a;"><strong>Alias:</strong> autorent.oficial.pago</p>
                    <p style="margin: 0; font-size: 0.875rem; color: #1e3a8a;"><strong>CBU:</strong> 0000003100012345678901</p>
                </div>
                <div class="form-group mb-4">
                    <label class="form-label"><?php echo e(__('Número de Comprobante / Transacción')); ?></label>
                    <input type="text" class="form-control" placeholder="Ej: 98234123" required>
                    <small style="color: #64748b;"><?php echo e(__('Ingresa el número que figura en tu comprobante de transferencia.')); ?></small>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary w-full" style="font-size: 1.125rem; padding: 1rem;">
                <i class="fa-solid fa-lock" style="margin-right: 0.5rem;"></i> <?php echo e(__('Finalizar Proceso de Pago')); ?>

            </button>

            <p style="text-align: center; font-size: 0.875rem; color: #94a3b8; margin-top: 1.5rem;">
                <i class="fa-solid fa-shield-halved"></i> <?php echo e(__('Tu transacción está protegida por encriptación SSL de 256 bits.')); ?>

            </p>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp1\htdocs\ISII_26TC_Grupo72-main\resources\views/pasarela-pago.blade.php ENDPATH**/ ?>