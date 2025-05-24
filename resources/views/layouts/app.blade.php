<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cinema Site')</title>
    <link rel="stylesheet" href="https://unpkg.com/modern-normalize/modern-normalize.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background: #f7f7f7;
            color: #222;
        }
    </style>
</head>

<body>
    @yield('content')
</body>

</html>
