<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Plastiquería System')</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #0d6efd;
            --dark-sidebar: #1e2125; /* Un tono más oscuro y elegante */
            --sidebar-width: 260px;
        }

        body {
            display: none;
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
        }

        /* Estructura del Layout */
        .wrapper {
            display: flex;
            align-items: stretch;
        }

        /* Sidebar Estilizado */
        #sidebar {
            min-width: var(--sidebar-width);
            max-width: var(--sidebar-width);
            background: var(--dark-sidebar);
            color: #fff;
            min-height: 100vh;
            transition: all 0.3s;
            position: fixed; /* Se queda fijo al hacer scroll */
        }

        #sidebar .sidebar-header {
            padding: 20px;
            background: #15181b;
            text-align: center;
        }

        #sidebar ul.components {
            padding: 20px 0;
        }

        #sidebar ul li a {
            padding: 12px 20px;
            font-size: 0.95rem;
            display: block;
            color: #adb5bd;
            text-decoration: none;
            transition: 0.3s;
            border-left: 4px solid transparent;
        }

        #sidebar ul li a:hover {
            color: #fff;
            background: #2c3136;
            border-left: 4px solid var(--primary-color);
        }

        #sidebar ul li.active > a {
            color: #fff;
            background: #2c3136;
            border-left: 4px solid var(--primary-color);
        }

        /* Contenido Principal */
        #content {
            width: calc(100% - var(--sidebar-width));
            margin-left: var(--sidebar-width); /* Espacio para el sidebar fijo */
            transition: all 0.3s;
        }

        .top-navbar {
            padding: 15px 30px;
            background: #fff;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Cards y Tablas Pro */
        .card { border-radius: 12px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .btn { border-radius: 8px; font-weight: 600; }
        
        /* Ajuste para móviles */
        @media (max-width: 768px) {
            #sidebar { margin-left: calc(-1 * var(--sidebar-width)); }
            #content { width: 100%; margin-left: 0; }
            #sidebar.active { margin-left: 0; }
        }
    </style>
</head>
<body>

<div class="wrapper">
    <nav id="sidebar">
        <div class="sidebar-header">
            <h4 class="mb-0"><i class="fas fa-store me-2 text-primary"></i>SAS</h4>
        </div>
        <ul class="list-unstyled components">
    <li class="{{ request()->routeIs('home.*') ? 'active' : '' }}">
        <a href="{{ route('home.index') }}">
            <i class="fas fa-chart-line me-2 text-info"></i> Resumen General
        </a>
    </li>

    <hr class="border-secondary mx-3 my-2">

    <li class="{{ request()->routeIs('ventas.*') ? 'active' : '' }}">
        <a href="{{ route('ventas.index') }}">
            <i class="fas fa-cash-register me-2 text-primary"></i> Nueva Venta
        </a>
    </li>
    <li class="{{ request()->routeIs('compras.*') ? 'active' : '' }}">
        <a href="{{ route('compras.index') }}">
            <i class="fas fa-shopping-bag me-2 text-success"></i> Compras / Entradas
        </a>
    </li>
    <li class="{{ request()->routeIs('gastos.*') ? 'active' : '' }}">
        <a href="{{ route('gastos.index') }}">
            <i class="fas fa-file-invoice-dollar me-2 text-danger"></i> Gastos Extras
        </a>
    </li>

    <hr class="border-secondary mx-3 my-2">

    <li>
        <a href="#inventarioSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <i class="fas fa-boxes me-2 text-warning"></i> Inventario
        </a>
        <ul class="collapse list-unstyled shadow-sm" id="inventarioSubmenu" style="background: #2c3136;">
            <li>
                <a href="{{ route('producto.index') }}" class="ps-5 small">
                    <i class="fas fa-box me-2"></i> Productos Activos
                </a>
            </li>
            <li>
                <a href="{{route('producto.desactivados')}}" class="ps-5 small text-info">
                    <i class="fas fa-eye-slash me-2"></i> Productos Ocultos
                </a>
            </li>
            <li>
                <a href="{{ route('categoria.index') }}" class="ps-5 small">
                    <i class="fas fa-tags me-2"></i> Categorías
                </a>
            </li>
            <li>
                <a href="{{ route('lista.index') }}" class="ps-5 small">
                    <i class="fas fa-clipboard-list me-2"></i> Stock Crítico
                </a>
            </li>
            <li>
                <a href="{{ route('movimientos.index') }}" class="ps-5 small">
                    <i class="fas fa-exchange-alt me-2"></i> Kardex / Movimientos
                </a>
            </li>
        </ul>
    </li>

    <li>
        <a href="#proveedorSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <i class="fas fa-truck me-2 text-secondary"></i> Proveedores
        </a>
        <ul class="collapse list-unstyled shadow-sm" id="proveedorSubmenu" style="background: #2c3136;">
            <li>
                <a href="{{ route('proveedor.index') }}" class="ps-5 small">
                    <i class="fas fa-address-book me-2"></i> Proveedores Activos
                </a>
            </li>
            <li>
                <a href="{{route('proveedor.inactivos')}}" class="ps-5 small text-info">
                    <i class="fas fa-user-slash me-2"></i> No Visibles / Inactivos
                </a>
            </li>
        </ul>
    </li>

    <hr class="border-secondary mx-3 my-2">

    <li>
        <a href="#personalSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <i class="fas fa-user-tie me-2 text-light"></i> Gestión Personal
        </a>
        <ul class="collapse list-unstyled shadow-sm" id="personalSubmenu" style="background: #2c3136;">
            <li>
                <a href="{{ route('personal.index') }}" class="ps-5 small">
                    <i class="fas fa-users me-2"></i> Lista de Personal
                </a>
            </li>
            <li>
                <a href="{{ route('personal.desactivados') }}" class="ps-5 small text-warning">
                    <i class="fas fa-user-lock me-2"></i> Personal Desactivado
                </a>
            </li>
        </ul>
    </li>

    <li>
        <a href="#datosSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <i class="fas fa-cogs me-2 text-secondary"></i> Configuración
        </a>
        <ul class="collapse list-unstyled shadow-sm" id="datosSubmenu" style="background: #2c3136;">
            <li>
                <a href="{{ route('datos.index') }}" class="ps-5 small">
                    <i class="fas fa-building me-2"></i> Datos de Empresa
                </a>
            </li>
            <li>
                <a href="#" class="ps-5 small text-danger">
                    <i class="fas fa-trash-alt me-2"></i> Papelera de Reciclaje
                </a>
            </li>
        </ul>
    </li>
</ul>
    </nav>

    <div id="content">
        <div class="top-navbar">
            <h5 class="mb-0">Panel de Administración</h5>
            
        </div>

        <div class="container-fluid p-4">
            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script>
    window.onload = function() {
        document.body.style.display = "block";
    }
</script>
@stack('scripts')
</body>
</html>