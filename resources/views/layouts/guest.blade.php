<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TurnoPro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body.bg-light { background-color: #e2e5ea !important; }
        .bg-dark { background-color: #334a6e !important; }
        .card { background-color: #f6f7f9; }
        .form-control { background-color: #fafbfc; }
    </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">
    <main class="container flex-grow-1 d-flex flex-column justify-content-center align-items-center py-5">
        <h1 class="display-5 text-center mb-4" style="color: #334a6e;">TurnoPro</h1>

        <div class="card shadow-sm w-100" style="max-width: 400px;">
            <div class="card-body p-4">
                {{ $slot }}
            </div>
        </div>
    </main>

    <footer class="bg-dark text-white-50 text-center py-3 mt-auto">
        TurnoPro Laravel App
    </footer>
</body>
</html>
