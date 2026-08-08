from bs4 import BeautifulSoup
import os

with open('dump_main.html', 'r', encoding='utf-8') as f:
    soup = BeautifulSoup(f.read(), 'html.parser')

sections = {}
for s in soup.find_all('section'):
    sec_id = s.get('id')
    if sec_id:
        sections[sec_id] = str(s)

mapping = {
    'a-propos.blade.php': ('Écho & Culture — À Propos', ['about']),
    'actions.blade.php': ('Écho & Culture — Nos Actions & Raphia', ['raphia-showcase']),
    'talents.blade.php': ('Écho & Culture — Jeunes Talents', ['talents']),
    'evenements.blade.php': ('Écho & Culture — Événements & Agenda', ['events']),
    'cours.blade.php': ('Écho & Culture — Cours & Formations', ['courses']),
    'galerie.blade.php': ('Écho & Culture — Galerie', ['gallery']),
    'don.blade.php': ('Écho & Culture — Mécénat & Don', ['donation']),
    'actualites.blade.php': ('Écho & Culture — Actualités', ['news']),
    'contact.blade.php': ('Écho & Culture — Contact', ['contact']),
}

os.makedirs('resources/views/pages', exist_ok=True)

for filename, (title, sec_ids) in mapping.items():
    content = f"@extends('layouts.app')\n"
    content += f"@section('title', '{title}')\n\n"
    content += "@section('content')\n"
    
    sec_html_list = []
    for sec_id in sec_ids:
        if sec_id in sections:
            html = sections[sec_id]
            # Ensure top padding if starting with light bg
            if 'py-24' in html:
                html = html.replace('py-24', 'pt-32 pb-24', 1)
            elif 'pt-24' in html:
                html = html.replace('pt-24', 'pt-32', 1)
            sec_html_list.append(html)
            
    content += "\n".join(sec_html_list)
    content += "\n@endsection\n"
    
    file_path = os.path.join('resources/views/pages', filename)
    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(content)
    print(f"Updated {file_path}")

print("All subpages generated cleanly!")
