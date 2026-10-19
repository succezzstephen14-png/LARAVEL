<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Site Settings')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    @stack('styles')
    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #1d4ed8;
            --secondary: #6c757d;
            --bg: #f8f9fa;
            --text: #333333;
            --border: #dee2e6;
            --shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        * {
            box-sizing: border-box;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background: white;
            border-bottom: 1px solid var(--border);
            box-shadow: var(--shadow);
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary) !important;
        }

        .nav-link {
            color: var(--text) !important;
        }

        .nav-link:hover {
            color: var(--primary) !important;
        }

        .navbar .container-fluid {
            flex-wrap: wrap;
        }

        @media (max-width: 992px) {
            .navbar-collapse {
                width: 100%;
                margin-top: 0.75rem;
            }

            .navbar-nav {
                flex-direction: column !important;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .navbar-nav .nav-item {
                width: 100%;
            }

            .navbar-nav .nav-link,
            .navbar-nav .btn {
                width: 100%;
                padding-left: 0;
            }

            .settings-sidebar {
                position: static;
                max-height: none;
                width: 100%;
            }

            .dashboard-shell {
                padding: 1.5rem 1rem 2rem;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 0.75rem 0.75rem;
            }

            .page-intro {
                padding: 1.5rem;
            }

            .card-header {
                padding: 1.25rem;
            }
        }

        .dashboard-shell {
            min-height: calc(100vh - 76px);
            padding: 2rem 0 3rem;
        }

        .settings-sidebar {
            background: white;
            border: 1px solid var(--border);
            border-radius: 1.25rem;
            box-shadow: var(--shadow);
            padding: 1.5rem;
            position: sticky;
            top: 1.5rem;
            max-height: calc(100vh - 3rem);
        }

        .settings-sidebar h2 {
            font-size: 1rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--secondary);
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .settings-sidebar .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            margin-bottom: 0.75rem;
            padding: 0.85rem 1rem;
            border-radius: 0.85rem;
            color: var(--text);
            transition: all 0.2s ease;
            text-decoration: none;
            border: 1px solid transparent;
            background: #fafbfc;
            font-weight: 600;
        }

        .settings-sidebar .sidebar-link:hover,
        .settings-sidebar .sidebar-link:focus {
            transform: translateX(2px);
            background: #ffffff;
            border-color: rgba(59, 130, 246, 0.15);
            color: var(--primary);
        }

        .settings-sidebar .sidebar-link.active {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border-color: transparent;
            box-shadow: 0 0.5rem 1rem rgba(59, 130, 246, 0.15);
        }

        .settings-sidebar .sidebar-link .icon {
            width: 1.5rem;
            text-align: center;
            font-size: 1rem;
        }

        .page-intro {
            background: linear-gradient(180deg, rgba(59, 130, 246, 0.08), rgba(255, 255, 255, 0.9));
            border: 1px solid rgba(59, 130, 246, 0.12);
            border-radius: 1.5rem;
            padding: 1.7rem 1.6rem;
            margin-bottom: 1.75rem;
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.8);
        }

        .page-intro h1 {
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
        }

        .page-intro p {
            color: var(--secondary);
            margin-bottom: 0;
        }

        .card {
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
        }

        .card-header {
            background: var(--primary);
            color: white;
            border: none;
            padding: 1.5rem;
        }

        .card-title {
            margin: 0;
            font-size: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        }

        .btn-primary {
            background: var(--primary);
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 0.375rem;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(59, 130, 246, 0.3);
        }

        .alert {
            border: none;
            border-radius: 0.375rem;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }


        .user-info {
            position: fixed;
            top: 1rem;
            right: 1rem;
            background: white;
            padding: 1rem;
            border-radius: 0.375rem;
            box-shadow: var(--shadow);
        }

        .user-info .user-name {
            font-weight: 600;
            color: var(--primary);
        }

        .user-info .user-role {
            font-size: 0.875rem;
            color: var(--secondary);
        }

        @media (max-width: 768px) {
            .user-info {
                position: static;
                margin-top: 1rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-cog"></i> Site Settings
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item me-3">
                        <span class="nav-link">Welcome, {{ Auth::user()->name }}</span>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button class="btn btn-sm btn-outline-danger" type="submit">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid dashboard-shell">
        <div class="row gx-4">
            <aside class="col-12 col-lg-3 col-xl-2 mb-4">
                @include('admin.website.sidebar')
            </aside>

            <main class="col-12 col-lg-9 col-xl-10">
                <div class="page-intro">
                    <h1>Website Control Center</h1>
                    <p>Customize branding, navigation, layout, and global options from one clean and responsive dashboard.</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Please fix the following errors:
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "4000"
        };
    </script>
    @stack('scripts')
</body>
</html>
