import re

with open('resources/views/layouts/app.blade.php', 'r', encoding='utf-8') as f:
    html = f.read()

replacements = {
    'href="#hero"': 'href="{{ url(\'/#hero\') }}"',
    'href="#about"': 'href="{{ url(\'/#about\') }}"',
    'href="#actions"': 'href="{{ url(\'/#actions\') }}"',
    'href="#talents"': 'href="{{ url(\'/#talents\') }}"',
    'href="#events"': 'href="{{ url(\'/#events\') }}"',
    'href="#courses"': 'href="{{ url(\'/#courses\') }}"',
    'href="#gallery"': 'href="{{ url(\'/#gallery\') }}"',
    'href="#news"': 'href="{{ url(\'/#news\') }}"',
    'href="#contact"': 'href="{{ url(\'/#contact\') }}"',
    'href="#donation"': 'href="{{ url(\'/#donation\') }}"',
}

for old, new in replacements.items():
    html = html.replace(old, new)

# Fix Espace membre, Réserver un cours, Faire un don buttons if needed
html = html.replace('title="Espace Apprenant / Professeur"', 'onclick="window.location=\'{{ route(\'login\') }}\'" title="Espace Apprenant / Professeur" style="cursor:pointer;"')

with open('resources/views/layouts/app.blade.php', 'w', encoding='utf-8') as f:
    f.write(html)

print("Navbar links updated in app.blade.php")
