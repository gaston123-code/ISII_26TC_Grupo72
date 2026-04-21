<?php $__env->startSection('title', __('Reserva Exitosa')); ?>

<?php $__env->startSection('content'); ?>
<div class="reservation-wrapper mt-5 mb-5" style="max-width: 650px; margin: 0 auto;">
    <div class="reservation-card text-center" style="padding: 4rem 2rem; box-shadow: 0 20px 50px rgba(0,0,0,0.1); border: none;">
        
        <!-- Icono de Éxito Animado -->
        <div style="width: 100px; height: 100px; background: #ecfdf5; color: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem; font-size: 3rem; animation: pulse 2s infinite;">
            <i class="fa-solid fa-check"></i>
        </div>

        <h1 style="font-size: 2.5rem; font-weight: 800; color: #064e3b; margin-bottom: 1rem;">Reserva confirmada exitosamente</h1>
        <p style="font-size: 1.125rem; color: #374151; margin-bottom: 3rem;">
            Tu auto ha sido reservado con éxito. Hemos guardado todos los detalles en tu cuenta de AutoRent.
        </p>

        <!-- Detalle de la Reserva -->
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 1rem; padding: 2rem; text-align: left; margin-bottom: 3rem;">
            <div style="display: flex; gap: 1.5rem; align-items: center; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px dashed #cbd5e1;">
                <img src="<?php echo e($alquiler->auto->imagen_url); ?>" style="width: 120px; border-radius: 0.5rem;" alt="Auto">
                <div>
                    <h4 style="margin: 0; font-size: 1.25rem;"><?php echo e($alquiler->auto->modelo->nombre_modelo); ?></h4>
                    <p style="margin: 0; color: #64748b;"><?php echo e($alquiler->auto->modelo->marca->nombre_marca); ?> — <?php echo e($alquiler->auto->anio); ?></p>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div>
                    <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 700;">Fecha de Retiro</span>
                    <p style="margin: 0; font-weight: 600; color: #1e293b;"><?php echo e($alquiler->fecha_retiro->format('d/m/Y')); ?></p>
                </div>
                <div>
                    <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 700;">Fecha de Devolución</span>
                    <p style="margin: 0; font-weight: 600; color: #1e293b;"><?php echo e($alquiler->fecha_devolucion->format('d/m/Y')); ?></p>
                </div>
                <div style="grid-column: 1 / -1; background: #fff; padding: 1rem; border-radius: 0.5rem; display: flex; justify-content: space-between; align-items: center; border: 1px solid #f1f5f9;">
                    <span style="font-weight: 600; color: #64748b;">Total Pagado</span>
                    <span style="font-size: 1.5rem; font-weight: 800; color: #2563eb;">$<?php echo e(number_format($alquiler->precioTotal, 0, ',', '.')); ?></span>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 1rem; justify-content: center;">
            <a href="<?php echo e(route('catalogo')); ?>" class="btn btn-outline" style="padding: 0.75rem 2rem;"><?php echo e(__('Volver al Catálogo')); ?></a>
            <button onclick="window.print()" class="btn btn-primary" style="padding: 0.75rem 2rem;">
                <i class="fa-solid fa-print" style="margin-right: 0.5rem;"></i> <?php echo e(__('Imprimir Comprobante')); ?>

            </button>
        </div>
    </div>
</div>

<style>
@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); }
    70% { box-shadow: 0 0 0 20px rgba(16, 185, 129, 0); }
    100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp1\htdocs\ISII_26TC_Grupo72-main\resources\views/reserva-exitosa.blade.php ENDPATH**/ ?>