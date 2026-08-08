import re

with open('bundle.js', 'r', encoding='utf-8') as f:
    js = f.read()

# Find header element class string variations
matches = [m for m in re.findall(r'header[^}]*className:[^}]*', js) if 'isScrolled' in m or 'bg-' in m]
for m in matches[:10]:
    print(m)

# Find header text in bundle
idx = js.find('ÉCHO & CULTURE')
if idx != -1:
    print("Found near idx:", js[max(0, idx-500):min(len(js), idx+500)])
