import re, urllib.request

with open('resources/views/welcome.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

urls = re.findall(r'src=["\']([^"\']+)["\']', content)

print(f"Checking {len(urls)} URLs...")
broken = []
for u in set(urls):
    if u.startswith('/assets/'):
        full_u = 'http://127.0.0.1:8000' + u
    elif u.startswith('http'):
        full_u = u
    else:
        continue
    try:
        req = urllib.request.Request(full_u, headers={'User-Agent': 'Mozilla/5.0'})
        res = urllib.request.urlopen(req, timeout=5)
        if res.status != 200:
            broken.append((u, res.status))
    except Exception as e:
        broken.append((u, str(e)))

print("Broken URLs:", broken)
