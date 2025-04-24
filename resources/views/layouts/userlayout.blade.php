<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root[data-theme="light"] {
            --bg-primary: #ffffff;
            --bg-secondary: #f8f9fa;
            --text-primary: #212529;
            --text-secondary: #6c757d;
            --border-color: #dee2e6;
            --accent-color: #0d6efd;
            --hover-color: #e9ecef;
        }

        :root[data-theme="dark"] {
            --bg-primary: #212529;
            --bg-secondary: #343a40;
            --text-primary: #f8f9fa;
            --text-secondary: #adb5bd;
            --border-color: #495057;
            --accent-color: #0d6efd;
            --hover-color: #495057;
        }

        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            transition: background-color 0.3s, color 0.3s;
        }

        .navbar {
            background-color: var(--bg-secondary) !important;
            border-bottom: 1px solid var(--border-color);
        }

        .navbar-brand, .nav-link {
            color: var(--text-primary) !important;
        }

        .card {
            background-color: var(--bg-secondary);
            border-color: var(--border-color);
        }

        .card-header {
            background-color: var(--bg-secondary);
            border-bottom-color: var(--border-color);
        }

        .table {
            color: var(--text-primary);
        }

        .table thead th {
            background-color: var(--bg-secondary);
            border-color: var(--border-color);
        }

        .table td {
            border-color: var(--border-color);
        }

        .form-control {
            background-color: var(--bg-primary);
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        .form-control:focus {
            background-color: var(--bg-primary);
            border-color: var(--accent-color);
            color: var(--text-primary);
        }

        .btn-outline-secondary {
            color: var(--text-secondary);
            border-color: var(--border-color);
        }

        .btn-outline-secondary:hover {
            background-color: var(--hover-color);
            color: var(--text-primary);
        }

        .modal-content {
            background-color: var(--bg-primary);
            border-color: var(--border-color);
        }

        .modal-header {
            border-bottom-color: var(--border-color);
        }

        .modal-footer {
            border-top-color: var(--border-color);
        }

        .dropdown-menu {
            background-color: var(--bg-primary);
            border-color: var(--border-color);
        }

        .dropdown-item {
            color: var(--text-primary);
        }

        .dropdown-item:hover {
            background-color: var(--hover-color);
            color: var(--text-primary);
        }

        .alert {
            background-color: var(--bg-secondary);
            border-color: var(--border-color);
            color: var(--text-primary);
        }
    </style>
    @yield('styles')
</head>
<body>
    @yield('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
