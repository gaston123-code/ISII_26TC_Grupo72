

<?php $__env->startSection('title', 'Gestión de Autos — AutoRent'); ?>
<?php $__env->startSection('page-title', '🚘 Gestión de Flota'); ?>

<?php $__env->startSection('content'); ?>

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <div>
        <p style="color:#64748b; font-size:14px;">Total: <strong><?php echo e($autos->total()); ?> autos</strong> registrados</p>
    </div>
    <a href="<?php echo e(route('admin.autos.create')); ?>" class="btn btn-primary">
        ＋ Registrar nuevo auto
    </a>
</div>

<?php if($autos->isEmpty()): ?>
    <div class="card" style="text-align:center; padding:60px;">
        <p style="font-size:48px; margin-bottom:12px;">🚗</p>
        <h3 style="color:#64748b; font-weight:500;">No hay autos registrados todavía</h3>
        <p style="color:#94a3b8; margin:8px 0 20px; font-size:14px;">Comenzá agregando el primer vehículo a la flota.</p>
        <a href="<?php echo e(route('admin.autos.create')); ?>" class="btn btn-primary">Registrar primer auto</a>
    </div>
<?php else: ?>
    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Vehículo</th>
                        <th>Año</th>
                        <th>Precio/día</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $autos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td style="color:#94a3b8; font-size:12px;">#<?php echo e($auto->id_auto); ?></td>
                        <td>
                            <div style="display:flex; align-items:center; gap:12px;">
                                <?php if($auto->imagen): ?>
                                    <img src="<?php echo e(asset('storage/'.$auto->imagen)); ?>"
                                         alt="Foto del auto"
                                         style="width:50px; height:38px; object-fit:cover; border-radius:6px; border:1px solid #e2e8f0;">
                                <?php else: ?>
                                    <div style="width:50px; height:38px; background:#f1f5f9; border-radius:6px; display:flex; align-items:center; justify-content:center; font-size:20px;">🚗</div>
                                <?php endif; ?>
                                <div>
                                    <div style="font-weight:600; font-size:14px;">
                                        <?php echo e($auto->modelo->marca->nombre_marca ?? '—'); ?>

                                        <?php echo e($auto->modelo->nombre_modelo ?? '—'); ?>

                                    </div>
                                    <?php if($auto->descripcion): ?>
                                        <div style="font-size:12px; color:#94a3b8;"><?php echo e(Str::limit($auto->descripcion, 40)); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td><?php echo e($auto->anio); ?></td>
                        <td style="font-weight:600; color:#2563eb;">$<?php echo e(number_format($auto->precio, 2, ',', '.')); ?></td>
                        <td>
                            <?php
                                $estado = $auto->estadoAuto->estado_auto ?? '';
                                $badgeClass = match($estado) {
                                    'Disponible'    => 'badge-disponible',
                                    'Alquilado'     => 'badge-alquilado',
                                    'Mantenimiento' => 'badge-mantenimiento',
                                    default         => '',
                                };
                            ?>
                            <span class="badge <?php echo e($badgeClass); ?>"><?php echo e($estado); ?></span>
                        </td>
                        <td>
                            <div style="display:flex; gap:8px; flex-wrap:wrap;">
                                <a href="<?php echo e(route('admin.autos.show', $auto->id_auto)); ?>" class="btn btn-outline" style="padding:6px 12px; font-size:12px;">👁 Ver</a>
                                <a href="<?php echo e(route('admin.autos.edit', $auto->id_auto)); ?>" class="btn btn-outline" style="padding:6px 12px; font-size:12px;">✏️ Editar</a>
                                <form method="POST" action="<?php echo e(route('admin.autos.destroy', $auto->id_auto)); ?>"
                                      onsubmit="return confirm('¿Eliminar este auto de la flota?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger" style="padding:6px 12px; font-size:12px;">🗑</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        
        <?php if($autos->hasPages()): ?>
            <div class="custom-pagination" style="margin-top:24px; display:flex; justify-content:center;">
                <?php echo e($autos->links('pagination::bootstrap-4')); ?>

            </div>
            <style>
                .custom-pagination nav { width: 100%; display: flex; justify-content: center; }
                .custom-pagination ul.pagination {
                    display: flex;
                    list-style: none;
                    padding: 0;
                    margin: 0;
                    gap: 6px;
                }
                .custom-pagination .page-item .page-link {
                    padding: 8px 14px;
                    border: 1px solid #e2e8f0;
                    border-radius: 6px;
                    color: #0f172a;
                    text-decoration: none;
                    font-size: 14px;
                    transition: all 0.2s;
                    display: inline-block;
                }
                .custom-pagination .page-item.active .page-link {
                    background: #2563eb;
                    color: #fff;
                    border-color: #2563eb;
                }
                .custom-pagination .page-item.disabled .page-link {
                    color: #94a3b8;
                    background: #f8fafc;
                    pointer-events: none;
                }
                .custom-pagination .page-item:not(.disabled):not(.active) .page-link:hover {
                    background: #f1f5f9;
                }
            </style>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ISII_26TC_Grupo72\resources\views/admin/autos/index.blade.php ENDPATH**/ ?>