<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AutoRent') — Panel de Administración</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary:   #2563eb;
            --primary-d: #1d4ed8;
            --danger:    #dc2626;
            --success:   #16a34a;
            --warning:   #d97706;
            --bg:        #f1f5f9;
            --sidebar:   #1e293b;
            --sidebar-t: #94a3b8;
            --card:      #ffffff;
            --text:      #0f172a;
            --text-m:    #475569;
            --border:    #e2e8f0;
            --radius:    10px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            display: flex;
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: 240px;
            background: var(--sidebar);
            display: flex;
            flex-direction: column;
            padding: 24px 0;
            position: fixed;
            top: 0; left: 0;
            height: 100vh;
            z-index: 100;
        }
        .sidebar-logo {
            padding: 0 24px 24px;
            border-bottom: 1px solid #334155;
        }
        .sidebar-logo span {
            font-size: 22px;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.5px;
        }
        .sidebar-logo small {
            display: block;
            color: var(--sidebar-t);
            font-size: 11px;
            margin-top: 2px;
        }
        .sidebar nav { flex: 1; padding: 20px 12px; }
        .sidebar nav a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            color: var(--sidebar-t);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: background 0.15s, color 0.15s;
            margin-bottom: 4px;
        }
        .sidebar nav a:hover,
        .sidebar nav a.active {
            background: #334155;
            color: #fff;
        }
        .sidebar-footer {
            padding: 16px 24px;
            border-top: 1px solid #334155;
        }
        .sidebar-footer form button {
            width: 100%;
            padding: 8px;
            background: transparent;
            border: 1px solid #475569;
            border-radius: 8px;
            color: var(--sidebar-t);
            font-size: 13px;
            cursor: pointer;
            transition: background 0.15s;
        }
        .sidebar-footer form button:hover {
            background: #334155;
            color: #fff;
        }

        /* ── Main content ── */
        .main-wrapper {
            margin-left: 240px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .topbar {
            background: var(--card);
            border-bottom: 1px solid var(--border);
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .topbar h1 { font-size: 20px; font-weight: 600; color: var(--text); }
        .topbar .admin-badge {
            background: #eff6ff;
            color: var(--primary);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }
        .page-content { padding: 32px; flex: 1; }

        /* ── Cards ── */
        .card {
            background: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            padding: 24px;
        }

        /* ── Alerts ── */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: var(--success); }
        .alert-error   { background: #fef2f2; border: 1px solid #fecaca; color: var(--danger); }

        /* ── Forms ── */
        .form-group { margin-bottom: 18px; }
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;
            color: var(--text);
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            color: var(--text);
            background: #fff;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        .form-error { font-size: 12px; color: var(--danger); margin-top: 4px; }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: opacity 0.15s, transform 0.1s;
        }
        .btn:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-primary  { background: var(--primary);  color: #fff; }
        .btn-danger   { background: var(--danger);   color: #fff; }
        .btn-outline  { background: transparent; border: 1px solid var(--border); color: var(--text); }

        /* ── Table ── */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th { padding: 10px 14px; text-align: left; font-size: 12px; font-weight: 600;
             text-transform: uppercase; color: var(--text-m); border-bottom: 2px solid var(--border); }
        td { padding: 12px 14px; border-bottom: 1px solid var(--border); }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: var(--bg); }

        /* ── Badge estados ── */
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-disponible   { background: #dcfce7; color: #15803d; }
        .badge-alquilado    { background: #dbeafe; color: #1d4ed8; }
        .badge-mantenimiento{ background: #fef9c3; color: #92400e; }

        /* ── Form grid ── */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        @media (max-width: 700px) { .form-grid { grid-template-columns: 1fr; } }
    </style>

    @stack('styles')
</head>
<body>

{{-- Sidebar --}}
<aside class="sidebar">
    <div class="sidebar-logo">
        <span>🚗 AutoRent</span>
        <small>Panel Administración</small>
    </div>
    <nav>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            📊 Dashboard
        </a>
        <a href="{{ route('admin.autos.index') }}" class="{{ request()->routeIs('admin.autos.*') ? 'active' : '' }}">
            🚘 Gestión de Autos
        </a>
        {{-- Gastón agregará aquí: Reservas, Clientes, etc. --}}
        <a href="#" style="opacity:.4; pointer-events:none;">📋 Reservas <small>(próximamente)</small></a>
        <a href="#" style="opacity:.4; pointer-events:none;">👥 Clientes <small>(próximamente)</small></a>
    </nav>
    <div class="sidebar-footer">
        <p style="font-size:12px; color:#64748b; margin-bottom:8px;">
            {{ auth('admin')->user()->nombre ?? 'Admin' }}
        </p>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit">Cerrar sesión</button>
        </form>
    </div>
</aside>

{{-- Contenido principal --}}
<div class="main-wrapper">
    <div class="topbar">
        <h1>@yield('page-title', 'Panel')</h1>
        <span class="admin-badge">👤 Administrador</span>
    </div>

    <div class="page-content">
        {{-- Mensajes flash --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</div>

@stack('scripts')
</body>
</html>
