<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cinema Site')</title>
    <link rel="stylesheet" href="https://unpkg.com/modern-normalize/modern-normalize.css">
    <style>
        /* Минимальные стили для читабельности */
        body {
            font-family: sans-serif;
            max-width: 480px;
            margin: 40px auto;
            background: #eee;
            padding: 32px;
            border-radius: 12px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        input,
        button {
            padding: 8px 10px;
            border-radius: 6px;
            border: 1px solid #888;
        }

        button {
            background: #1647ff;
            color: #fff;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    @yield('content')
</body>

</html>
