<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'TurnoPro') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body.bg-light { background-color: #e2e5ea !important; }
        .bg-dark { background-color: #334a6e !important; }
        .table-dark { --bs-table-bg: #334a6e; --bs-table-border-color: #435a80; }
        .bg-white, .card { --bs-card-bg: #f6f7f9; background-color: #f6f7f9 !important; }
        .table { --bs-table-bg: #f6f7f9; }
        .form-control, .form-select { background-color: #fafbfc; }
        .btn-gris { background-color: #d3d7de; border-color: #d3d7de; color: #2b3342; }
        .btn-gris:hover { background-color: #c3c8d1; border-color: #c3c8d1; color: #2b3342; }
    </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">
    @include('layouts.navigation')

    @isset($header)
        <header class="bg-white border-bottom py-4">
            <div class="container">
                {{ $header }}
            </div>
        </header>
    @endisset

    <main class="container py-5 flex-grow-1">
        {{ $slot }}
    </main>

    <footer class="bg-dark text-white-50 text-center py-3 mt-auto">
        TurnoPro Laravel App
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>