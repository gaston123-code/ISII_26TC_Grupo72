<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AutoRent - Vista Previa Estática</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #0f766e; --primary-hover: #115e59; --secondary-color: #1e3a8a;
            --bg-color: #f3f4f6; --text-color: #1f2937; --text-light: #6b7280;
            --border-color: #e5e7eb; --white: #ffffff; --danger: #ef4444;
            --success: #10b981; --warning: #f59e0b; --sidebar-width: 250px; --transition: 0.3s ease;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-color); color: var(--text-color); line-height: 1.5; }
        
        /* Sidebar y Layout */
        .dashboard-layout { display: flex; min-height: 100vh; }
        .sidebar { width: var(--sidebar-width); background-color: var(--secondary-color); color: var(--white); flex-shrink: 0; display: flex; flex-direction: column; transition: var(--transition); }
        .sidebar-brand { padding: 1.5rem; font-size: 1.25rem; font-weight: 700; text-align: center; border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
        .sidebar-nav { flex: 1; padding: 1rem 0; }
        .nav-item { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1.5rem; color: rgba(255, 255, 255, 0.8); text-decoration: none; transition: var(--transition); }
        .nav-item:hover, .nav-item.active { background-color: rgba(255, 255, 255, 0.1); color: var(--white); }
        
        /* Contenido Principal */
        .main-content { flex: 1; display: flex; flex-direction: column; min-width: 0; }
        .top-header { background-color: var(--white); height: 4rem; padding: 0 2rem; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--border-color); }
        .mobile-toggle { display: none; background: none; border: none; font-size: 1.25rem; cursor: pointer; color: var(--text-color); }
        .user-menu { display: flex; align-items: center; gap: 1rem; }
        .avatar { width: 2.2rem; height: 2.2rem; border-radius: 50%; background-color: var(--primary-color); color: var(--white); display: flex; align-items: center; justify-content: center; font-weight: 600; }
        .btn-link { background: none; border: none; color: var(--text-light); cursor: pointer; font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem; }
        
        /* Área Dinámica */
        .content-area { padding: 2rem; flex: 1; overflow-y: auto; }
        .page-title { margin-bottom: 1.5rem; font-size: 1.5rem; color: var(--text-color); }
        .btn { padding: 0.75rem 1.5rem; font-weight: 500; border: none; border-radius: 0.375rem; cursor: pointer; text-decoration: none; }
        .btn-primary { background-color: var(--primary-color); color: var(--white); }
        .dashboard-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .card { background-color: var(--white); border-radius: 0.5rem; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); border: 1px solid var(--border-color); }
        .card-title { color: var(--text-light); font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; }
        .card-value { font-size: 1.75rem; font-weight: 700; color: var(--text-color); }
        .text-sm { font-size: 0.875rem; }

        /* Responsive */
        @media (min-width: 1200px) { .dashboard-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 991px) { .sidebar { position: fixed; left: -250px; height: 100vh; z-index: 1000; } .sidebar.open { left: 0; } .main-content { margin-left: 0; } .mobile-toggle { display: block; } }
        @media (max-width: 767px) { .dashboard-layout { flex-direction: column; } .top-header { padding: 0 1rem; } .user-name { display: none; } .content-area { padding: 1rem; } }
        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.5); z-index: 999; }
        .sidebar-overlay.active { display: block; }
    </style>
</head>
<body>
    <div class="dashboard-layout">
        <!-- Overlay Mobile -->
        <div class="sidebar-overlay" id="sidebar-overlay"></div>

        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand"><i class="fa-solid fa-car"></i> <span class="brand-text">AutoRent</span></div>
            <nav class="sidebar-nav">
                <a href="#" class="nav-item active"><i class="fa-solid fa-house"></i> <span>Panel Principal</span></a>
                <a href="#" class="nav-item"><i class="fa-solid fa-calendar-check"></i> <span>Reservar</span></a>
                <a href="#" class="nav-item"><i class="fa-solid fa-car-side"></i> <span>Inventario</span></a>
                <a href="#" class="nav-item"><i class="fa-solid fa-users"></i> <span>Clientes</span></a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="top-header">
                <button class="mobile-toggle" id="mobile-toggle-btn"><i class="fa-solid fa-bars"></i></button>
                <div class="header-right"></div>
                <div class="user-menu">
                    <span class="user-name">Carlos A</span>
                    <div class="avatar">C</div>
                    <button class="btn-link"><i class="fa-solid fa-right-from-bracket"></i> Salir</button>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="content-area">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h1 class="page-title" style="margin-bottom: 0;">Resumen General</h1>
                    <button class="btn btn-primary"><i class="fa-solid fa-plus"></i> Nueva Reserva</button>
                </div>

                <div class="dashboard-grid">
                    <div class="card">
                        <h3 class="card-title">Reservas Activas</h3>
                        <div class="card-value">12</div>
                        <p class="text-sm mt-1" style="color: var(--success);"><i class="fa-solid fa-arrow-up"></i> 15% esta semana</p>
                    </div>
                    <div class="card">
                        <h3 class="card-title">Autos Disponibles</h3>
                        <div class="card-value">34 / 50</div>
                        <p class="text-sm mt-1" style="color: var(--text-light);">68% de la flota lista</p>
                    </div>
                    <div class="card">
                        <h3 class="card-title">Notificaciones</h3>
                        <div class="card-value">5</div>
                        <p class="text-sm mt-1" style="color: var(--warning);"><i class="fa-solid fa-envelope"></i> Soporte clientes</p>
                    </div>
                </div>

                <div class="card" style="padding: 0;">
                    <h3 class="card-title" style="margin: 1.5rem 1.5rem 1rem 1.5rem;">Próximas Reservas de Hoy</h3>
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; text-align: left;">
                            <thead>
                                <tr style="border-bottom: 2px solid var(--border-color); background-color: var(--bg-color);">
                                    <th style="padding: 1rem 1.5rem; color: var(--text-light); font-size: 0.875rem;">CLIENTE</th>
                                    <th style="padding: 1rem 1.5rem; color: var(--text-light); font-size: 0.875rem;">VEHÍCULO ASIGNADO</th>
                                    <th style="padding: 1rem 1.5rem; color: var(--text-light); font-size: 0.875rem;">HORARIO</th>
                                    <th style="padding: 1rem 1.5rem; color: var(--text-light); font-size: 0.875rem;">ESTADO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid var(--border-color);">
                                    <td style="padding: 1rem 1.5rem; font-weight: 500;">Juan Pérez</td>
                                    <td style="padding: 1rem 1.5rem;">Toyota Corolla - 2022</td>
                                    <td style="padding: 1rem 1.5rem; color: var(--text-light);">14:00 hrs</td>
                                    <td style="padding: 1rem 1.5rem;"><span style="background-color: #fef3c7; color: #92400e; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">Pendiente Confirmación</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.getElementById('mobile-toggle-btn').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebar-overlay').classList.toggle('active');
        });
        document.getElementById('sidebar-overlay').addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('open');
            this.classList.remove('active');
        });
    </script>
</body>
</html>
