

<?php $__env->startSection('title', 'Dashboard — AutoRent'); ?>
<?php $__env->startSection('page-title', '📊 Dashboard'); ?>

<?php $__env->startSection('content'); ?>

<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px,1fr)); gap:20px; margin-bottom:28px;">

    <div class="card" style="text-align:center; padding:28px 20px;">
        <div style="font-size:36px; margin-bottom:8px;">🚗</div>
        <div style="font-size:28px; font-weight:700; color:#2563eb;">
            <?php echo e(\App\Models\Auto::count()); ?>

        </div>
        <div style="font-size:13px; color:#64748b; margin-top:4px;">Autos registrados</div>
    </div>

    <div class="card" style="text-align:center; padding:28px 20px;">
        <div style="font-size:36px; margin-bottom:8px;">✅</div>
        <div style="font-size:28px; font-weight:700; color:#16a34a;">
            <?php echo e(\App\Models\Auto::whereHas('estadoAuto', fn($q) => $q->where('estado_auto', 'Disponible'))->count()); ?>

        </div>
        <div style="font-size:13px; color:#64748b; margin-top:4px;">Disponibles</div>
    </div>

    <div class="card" style="text-align:center; padding:28px 20px;">
        <div style="font-size:36px; margin-bottom:8px;">👥</div>
        <div style="font-size:28px; font-weight:700; color:#7c3aed;">
            <?php echo e(\App\Models\Cliente::count()); ?>

        </div>
        <div style="font-size:13px; color:#64748b; margin-top:4px;">Clientes</div>
    </div>

    <div class="card" style="text-align:center; padding:28px 20px;">
        <div style="font-size:36px; margin-bottom:8px;">📋</div>
        <div style="font-size:28px; font-weight:700; color:#d97706;">
            <?php echo e(\App\Models\Alquiler::count()); ?>

        </div>
        <div style="font-size:13px; color:#64748b; margin-top:4px;">Reservas totales</div>
    </div>

</div>


<div class="card">
    <h3 style="font-size:15px; font-weight:700; margin-bottom:16px;">Acciones rápidas</h3>
    <div style="display:flex; gap:12px; flex-wrap:wrap;">
        <a href="<?php echo e(route('admin.autos.create')); ?>" class="btn btn-primary">＋ Registrar auto</a>
        <a href="<?php echo e(route('admin.autos.index')); ?>" class="btn btn-outline">🚘 Ver flota completa</a>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ISII_26TC_Grupo72\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>