<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CMS Dashboard')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    @stack('styles')
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #6c757d;
            --bg: #f8f9fa;
            --text: #333333;
            --border: #dee2e6;
            --shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            --cms-primary: #6366f1;
            --cms-secondary: #8b5cf6;
            --cms-accent: #06b6d4;
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
            color: var(--cms-primary) !important;
        }

        .nav-link {
            color: var(--text) !important;
        }

        .nav-link:hover {
            color: var(--cms-primary) !important;
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

            .cms-sidebar {
                position: static;
                max-height: none;
                width: 100%;
            }

            .cms-shell {
                padding: 1.5rem 1rem 2rem;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 0.75rem 0.75rem;
            }

            .cms-intro {
                padding: 1.5rem;
            }

            .card-header {
                padding: 1.25rem;
            }
        }

        .cms-shell {
            min-height: calc(100vh - 76px);
            padding: 2rem 0 3rem;
        }

        .cms-sidebar {
            background: white;
            border: 1px solid var(--border);
            border-radius: 1.25rem;
            box-shadow: var(--shadow);
            padding: 1.5rem;
            position: sticky;
            top: 1.5rem;
            max-height: calc(100vh - 3rem);
        }

        .cms-sidebar h2 {
            font-size: 1rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--secondary);
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .cms-sidebar .sidebar-link {
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

        .cms-sidebar .sidebar-link:hover,
        .cms-sidebar .sidebar-link:focus {
            transform: translateX(2px);
            background: #ffffff;
            border-color: rgba(99, 102, 241, 0.15);
            color: var(--cms-primary);
        }

        .cms-sidebar .sidebar-link.active {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            color: white;
            border-color: transparent;
            box-shadow: 0 0.5rem 1rem rgba(99, 102, 241, 0.15);
        }

        .cms-sidebar .sidebar-link .icon {
            width: 1.5rem;
            text-align: center;
            font-size: 1rem;
        }

        .cms-intro {
            background: linear-gradient(180deg, rgba(99, 102, 241, 0.08), rgba(255, 255, 255, 0.9));
            border: 1px solid rgba(99, 102, 241, 0.12);
            border-radius: 1.5rem;
            padding: 1.7rem 1.6rem;
            margin-bottom: 1.75rem;
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.8);
        }

        .cms-intro h1 {
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
            color: var(--cms-primary);
        }

        .cms-intro p {
            color: var(--secondary);
            margin-bottom: 0;
        }

        .card {
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
            border-radius: 1rem;
        }

        .card-header {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            border: none;
            padding: 1.5rem;
            border-radius: 1rem 1rem 0 0 !important;
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
            border-color: var(--cms-primary);
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
        }

        .btn-primary {
            background: var(--cms-primary);
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(99, 102, 241, 0.3);
        }

        .alert {
            border: none;
            border-radius: 0.5rem;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }

        /* Modern Stats Cards */
        .stats-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            box-shadow: var(--shadow);
        }

        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }

        .stats-card .stats-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .stats-card .stats-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .stats-card .stats-label {
            color: var(--secondary);
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stats-card.pages .stats-icon { background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; }
        .stats-card.posts .stats-icon { background: linear-gradient(135deg, #06b6d4, #0891b2); color: white; }
        .stats-card.categories .stats-icon { background: linear-gradient(135deg, #10b981, #059669); color: white; }
        .stats-card.media .stats-icon { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }

        .action-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 1.5rem;
            text-decoration: none;
            color: var(--text);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .action-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            border-color: var(--cms-primary);
            color: var(--cms-primary);
        }

        .action-card .action-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            background: var(--cms-primary);
            color: white;
        }

        .action-card .action-content h5 {
            margin: 0 0 0.25rem 0;
            font-weight: 600;
        }

        .action-card .action-content p {
            margin: 0;
            color: var(--secondary);
            font-size: 0.875rem;
        }

        @media (max-width: 768px) {
            .cms-sidebar {
                margin-bottom: 2rem;
            }

            .quick-actions {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-cms"></i> Content Management
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

    <div class="container-fluid cms-shell">
        <div class="row gx-4">
            <aside class="cms-sidebar col-12 col-lg-3 col-xl-2 mb-4">
                <h2>CMS Navigation</h2>
                <a href="{{ route('cms.dashboard') }}" class="sidebar-link {{ request()->routeIs('cms.dashboard') ? 'active' : '' }}">
                    <span class="icon"><i class="fas fa-tachometer-alt"></i></span>
                    Dashboard
                </a>
                <a href="{{ route('cms.pages') }}" class="sidebar-link {{ request()->routeIs('cms.pages*') ? 'active' : '' }}">
                    <span class="icon"><i class="fas fa-file-alt"></i></span>
                    Pages
                </a>
                <a href="{{ route('cms.posts') }}" class="sidebar-link {{ request()->routeIs('cms.posts*') ? 'active' : '' }}">
                    <span class="icon"><i class="fas fa-blog"></i></span>
                    Posts
                </a>
                <a href="{{ route('cms.categories') }}" class="sidebar-link {{ request()->routeIs('cms.categories*') ? 'active' : '' }}">
                    <span class="icon"><i class="fas fa-tags"></i></span>
                    Categories
                </a>
                <a href="{{ route('cms.tags') }}" class="sidebar-link {{ request()->routeIs('cms.tags*') ? 'active' : '' }}">
                    <span class="icon"><i class="fas fa-hashtag"></i></span>
                    Tags
                </a>
                <a href="{{ route('cms.media') }}" class="sidebar-link {{ request()->routeIs('cms.media*') ? 'active' : '' }}">
                    <span class="icon"><i class="fas fa-images"></i></span>
                    Media
                </a>
                <a href="{{ route('cms.blocks') }}" class="sidebar-link {{ request()->routeIs('cms.blocks*') ? 'active' : '' }}">
                    <span class="icon"><i class="fas fa-cubes"></i></span>
                    Blocks
                </a>
                <a href="{{ route('cms.menus') }}" class="sidebar-link {{ request()->routeIs('cms.menus*') ? 'active' : '' }}">
                    <span class="icon"><i class="fas fa-bars"></i></span>
                    Menus
                </a>

                <h2 style="margin-top: 2rem;">Website Settings</h2>
                <a href="{{ route('cms.settings') }}" class="sidebar-link {{ request()->routeIs('cms.settings') ? 'active' : '' }}">
                    <span class="icon"><i class="fas fa-sliders-h"></i></span>
                    Settings
                </a>
                <a href="{{ route('cms.appearance') }}" class="sidebar-link {{ request()->routeIs('cms.appearance') ? 'active' : '' }}">
                    <span class="icon"><i class="fas fa-palette"></i></span>
                    Appearance
                </a>
                <a href="{{ route('cms.header-footer') }}" class="sidebar-link {{ request()->routeIs('cms.header-footer') ? 'active' : '' }}">
                    <span class="icon"><i class="fas fa-file-invoice"></i></span>
                    Header / Footer
                </a>
                <a href="{{ route('cms.global-settings') }}" class="sidebar-link {{ request()->routeIs('cms.global-settings') ? 'active' : '' }}">
                    <span class="icon"><i class="fas fa-globe"></i></span>
                    Global Settings
                </a>
            </aside>

            <main class="col-12 col-lg-9 col-xl-10">
                <div class="cms-intro">
                    <h1>Content Management System</h1>
                    <p>Create, manage, and publish your website content with our powerful and intuitive CMS dashboard.</p>
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