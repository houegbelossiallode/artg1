import os

# 1. Update Layout
with open('resources/views/layouts/app.blade.php', 'r', encoding='utf-8') as f:
    app_blade = f.read()

with open('modal.html', 'r', encoding='utf-8') as f:
    modal_content = f.read()

if 'id="candidature-modal"' not in app_blade:
    app_blade = app_blade.replace('</body>', '\n    <!-- Global Candidature Modal -->\n' + modal_content + '\n</body>')
    with open('resources/views/layouts/app.blade.php', 'w', encoding='utf-8') as f:
        f.write(app_blade)

# 2. Update Welcome.blade.php
with open('resources/views/welcome.blade.php', 'r', encoding='utf-8') as f:
    welcome = f.read()

btn1_target = 'class="px-5 py-2.5 rounded-none bg-[#C85A32] hover:bg-[#A84223] text-white font-bold text-xs shadow-lg transition-transform hover:scale-105 flex items-center gap-2"'
if btn1_target in welcome and 'onclick=' not in welcome.split(btn1_target)[0][-20:]:
    btn1_replace = 'onclick="document.getElementById(\'candidature-modal\').classList.remove(\'hidden\')" ' + btn1_target
    welcome = welcome.replace(btn1_target, btn1_replace)

btn2_target = 'class="px-6 py-3 rounded-none bg-[#2C221E] hover:bg-[#C85A32] text-white font-bold text-xs whitespace-nowrap transition-colors flex items-center gap-2 shadow"'
if btn2_target in welcome and 'onclick=' not in welcome.split(btn2_target)[0][-20:]:
    btn2_replace = 'onclick="document.getElementById(\'candidature-modal\').classList.remove(\'hidden\')" ' + btn2_target
    welcome = welcome.replace(btn2_target, btn2_replace)

with open('resources/views/welcome.blade.php', 'w', encoding='utf-8') as f:
    f.write(welcome)

print("Modal moved to layout and updated welcome.blade.php buttons.")
