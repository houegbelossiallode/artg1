import re, os, urllib.request

with open('resources/views/welcome.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()
with open('resources/views/layouts/app.blade.php', 'r', encoding='utf-8') as f:
    content += f.read()

assets = set(re.findall(r'src=["\'](/assets/[^"\']+)["\']', content))
print("Assets found:", assets)

os.makedirs('public/assets', exist_ok=True)
base_url = "https://cho-culture-association-cultural-artistique.ai.studio"

for asset_path in assets:
    local_path = os.path.join('public', asset_path.lstrip('/'))
    remote_url = base_url + asset_path
    print(f"Downloading {remote_url} -> {local_path}")
    try:
        urllib.request.urlretrieve(remote_url, local_path)
        print("Success")
    except Exception as e:
        print("Error:", e)
