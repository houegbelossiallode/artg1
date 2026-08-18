import re

def undo_colors(path):
    with open(path, 'r', encoding='utf-8') as f:
        content = f.read()

    # Restore Green colors
    content = content.replace('#C85A32', '#0BA20B')
    content = content.replace('#A04828', '#087A08')

    with open(path, 'w', encoding='utf-8') as f:
        f.write(content)
        
    print(f"Reverted {path}")

if __name__ == '__main__':
    undo_colors('resources/views/welcome.blade.php')
    undo_colors('resources/views/pages/talents.blade.php')
    undo_colors('resources/views/pages/talent-details.blade.php')
