<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Plastiquería System')</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #0d6efd;
            --dark-sidebar: #212529;
        }

        body {
            display: none;
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f6;
            /* Fondo gris muy claro profesional */
            color: #333;
        }

        /* Navbar elegante */
        .navbar {
            background-color: var(--dark-sidebar) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 0.8rem 1rem;
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: 1px;
            color: #fff !important;
        }

        .nav-link {
            font-weight: 500;
            transition: all 0.3s;
            margin: 0 5px;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
            transform: translateY(-1px);
        }

        /* Cards y Wrappers */
        .card {
            border-radius: 12px;
            border: none;
            transition: transform 0.2s;
        }

        /* Tabla estilizada */
        .table thead th {
            background-color: #f8f9fa;
            color: #6c757d;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #dee2e6;
        }

        /* Botones redondeados */
        .btn {
            border-radius: 8px;
            font-weight: 600;
        }

        .container-main {
            padding: 20px;
            margin-top: 10px;
        }
    </style>
    @stack('styles')
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('ventas.index') }}">
                <i class="fas fa-store me-2 text-primary"></i>PLASTIQUERÍA
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('home.*') ? 'active' : '' }}"
                            href="{{ route('home.index') }}">
                            <i class="fas fa-home me-1"></i> Detalles
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('compras.*') ? 'active' : '' }}"
                            href="{{ route('compras.index') }}">
                            <i class="fas fa-shopping-bag me-1"></i> Compras
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('movimientos.*') ? 'active' : '' }}"
                            href="{{ route('movimientos.index') }}">
                            <i class="fas fa-exchange-alt me-1"></i> Movimientos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('proveedor.*') ? 'active' : '' }}"
                            href="{{ route('proveedor.index') }}">
                            <i class="fas fa-truck me-1"></i> Proveedores
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ request()->routeIs('gasto.*') ? 'active' : '' }}"
                            href="{{ route('gastos.index') }}">
                            <i class="fas fa-money-bill me-1"></i> Gastos
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ request()->routeIs('dato.*') ? 'active' : '' }}"
                            href="{{ route('datos.index') }}">
                            <i class="fas fa-cogs me-1"></i> Configuración
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('categoria.*') ? 'active' : '' }}"
                            href="{{ route('categoria.index') }}">
                            <i class="fas fa-tags me-1"></i> Catergorías
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('producto.*') ? 'active' : '' }}"
                            href="{{ route('producto.index') }}">
                            <i class="fas fa-box me-1"></i> Productos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('personal.*') ? 'active' : '' }}"
                            href="{{ route('personal.index') }}">
                            <i class="fas fa-tags me-1"></i> Personal
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('lista.*') ? 'active' : '' }}"
                            href="{{ route('lista.index') }}">
                            <i class="fas fa-clipboard-list me-1"></i> Inventario
                        </a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-primary btn-sm px-3" href="{{ route('ventas.index') }}">

                            <i class="fas fa-shopping-cart me-1"></i> Nueva Venta
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container-main">
        @yield('content')
    </main>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
