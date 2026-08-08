import os

with open('resources/views/pages/talents.blade.php', 'r', encoding='utf-8') as f:
    blade_content = f.read()

with open('modal.html', 'r', encoding='utf-8') as f:
    modal_content = f.read()

# Append modal right before @endsection
if '@endsection' in blade_content:
    blade_content = blade_content.replace('@endsection', modal_content + '\n@endsection')

# First button
btn1_target = 'class="px-5 py-2.5 rounded-none bg-[#C85A32] hover:bg-[#A84223] text-white font-bold text-xs shadow-lg transition-transform hover:scale-105 flex items-center gap-2"'
btn1_replace = 'onclick="document.getElementById(\'candidature-modal\').classList.remove(\'hidden\')" ' + btn1_target
blade_content = blade_content.replace(btn1_target, btn1_replace)

# Second button
btn2_target = 'class="px-6 py-3 rounded-none bg-[#2C221E] hover:bg-[#C85A32] text-white font-bold text-xs whitespace-nowrap transition-colors flex items-center gap-2 shadow"'
btn2_replace = 'onclick="document.getElementById(\'candidature-modal\').classList.remove(\'hidden\')" ' + btn2_target
blade_content = blade_content.replace(btn2_target, btn2_replace)


with open('resources/views/pages/talents.blade.php', 'w', encoding='utf-8') as f:
    f.write(blade_content)

print('Updated talents.blade.php with modal!')
