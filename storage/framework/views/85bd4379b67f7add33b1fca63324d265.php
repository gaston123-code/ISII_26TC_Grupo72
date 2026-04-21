<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>AutoRent - <?php echo $__env->yieldContent('title', 'Bienvenido'); ?></title>

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CSS del proyecto -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
</head>
<body>

        <!-- Layout principal para usuarios autenticados -->
        <div class="dashboard-layout">
            <!-- Overlay para mobile -->
            <div class="sidebar-overlay" id="sidebar-overlay"></div>

            <!-- Sidebar (Navegación principal) -->
            <aside class="sidebar" id="sidebar" aria-label="Navegación lateral">
                <div class="sidebar-brand">
                    <i class="fa-solid fa-car"></i> <span class="brand-text">AutoRent</span>
                </div>
                <nav class="sidebar-nav">
                    <!-- Vistas básicas disponibles para Clientes (Y también visibles para Admins) -->
                    <a href="<?php echo e(route('catalogo')); ?>" class="nav-item">
                        <i class="fa-solid fa-car-side"></i> <span class="nav-text"><?php echo e(__('Ver Flota')); ?></span>
                    </a>
                    <a href="<?php echo e(route('cliente.reserva.index')); ?>" class="nav-item">
                        <i class="fa-solid fa-calendar-check"></i> <span class="nav-text"><?php echo e(__('Mis Reservas')); ?></span>
                    </a>

                    <!-- Bloque exclusivo para Administradores -->
                    
                    <?php if(Auth::check() && isset(Auth::user()->rol) && Auth::user()->rol === 'admin'): ?>
                        <hr style="margin: 1rem 0; border: none; border-top: 1px solid var(--border-color); opacity: 0.5;">
                        <span style="font-size: 0.75rem; text-transform: uppercase; color: var(--text-light); padding: 0 1.5rem; margin-bottom: 0.5rem; display: block; font-weight: 600;">Administración</span>
                        
                        <a href="/dashboard" class="nav-item active">
                            <i class="fa-solid fa-house"></i> <span class="nav-text"><?php echo e(__('Panel Principal')); ?></span>
                        </a>
                        <a href="#" class="nav-item">
                            <i class="fa-solid fa-users"></i> <span class="nav-text"><?php echo e(__('Gestión de Clientes')); ?></span>
                        </a>
                        <a href="#" class="nav-item">
                            <i class="fa-solid fa-chart-line"></i> <span class="nav-text"><?php echo e(__('Reportes')); ?></span>
                        </a>
                    <?php endif; ?>
                </nav>
            </aside>

            <!-- Contenido principal interactivo -->
            <main class="main-content">
                <!-- Header Superior -->
                <header class="top-header">
                    <button class="mobile-toggle" id="mobile-toggle-btn" aria-label="Abrir menú">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    
                    <div class="header-right"></div>

                    <div class="user-menu">
                        <?php if(Auth::check()): ?>
                            <div class="user-info">
                                <span class="user-name"><?php echo e(Auth::user()->nombre ?? Auth::user()->name); ?></span>
                                <div class="avatar">
                                    <?php echo e(substr(Auth::user()->nombre ?? Auth::user()->name ?? 'U', 0, 1)); ?>

                                </div>
                            </div>
                            <form method="POST" action="<?php echo e(route('cliente.logout')); ?>" class="logout-form">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn-link" title="Cerrar Sesión">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                </button>
                            </form>
                        <?php else: ?>
                            <div class="auth-buttons">
                                <a href="<?php echo e(route('cliente.login')); ?>" class="btn btn-primary btn-sm">Iniciar Sesión</a>
                                <a href="<?php echo e(route('cliente.register')); ?>" class="btn btn-outline btn-sm">Registro</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </header>

                <!-- Área Dinámica -->
                <div class="content-area">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
                
                <!-- Footer -->
                <footer class="footer-minimal text-center">
                    <small>&copy; <?php echo e(date('Y')); ?> AutoRent. <?php echo e(__('Operando de forma segura.')); ?></small>
                </footer>
            </main>
        </div>


    <!-- Scripts básicos para UI -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('mobile-toggle-btn');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            if (toggleBtn && sidebar && overlay) {
                // Abre el sidebar en modo responsive
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('open');
                    overlay.classList.toggle('active');
                });

                // Cierra el sidebar al hacer click fuera
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('active');
                });
            }
        });
    </script>
</body>
</html>
<?php /**PATH C:\xampp1\htdocs\ISII_26TC_Grupo72-main\resources\views/layouts/app.blade.php ENDPATH**/ ?>