import os

try:
    with open('dump_header.html', 'r', encoding='utf-8') as f:
        header = f.read()
    with open('dump_footer.html', 'r', encoding='utf-8') as f:
        footer = f.read()
except FileNotFoundError:
    header = ""
    footer = ""

app_blade_content = f"""<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Écho & Culture — Association Artistique')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Cinzel:wght@500;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#FAF7F2] text-[#2C221E] antialiased selection:bg-[#D4A373] selection:text-white">
    {header}
    @yield('content')
    {footer}
</body>
</html>"""

with open('resources/views/layouts/app.blade.php', 'w', encoding='utf-8') as f:
    f.write(app_blade_content)

try:
    with open('dump_main.html', 'r', encoding='utf-8') as f:
        main_content = f.read()
except FileNotFoundError:
    main_content = ""

welcome_content = f"""@extends('layouts.app')
@section('content')
{main_content}
@endsection"""

with open('resources/views/welcome.blade.php', 'w', encoding='utf-8') as f:
    f.write(welcome_content)
    
print('Blades updated successfully!')
