const fs = require('fs');
const path = require('path');

const adminDir = path.join(__dirname, '../resources/views/admin');

function walkDir(dir) {
    fs.readdirSync(dir).forEach(file => {
        let fullPath = path.join(dir, file);
        if (fs.statSync(fullPath).isDirectory()) {
            walkDir(fullPath);
        } else if (fullPath.endsWith('.blade.php')) {
            let content = fs.readFileSync(fullPath, 'utf8');
            
            // 1. Replace the long Tailwind classes with .btn-primary
            let newContent = content.replace(/class=["']inline-flex items-center gap-[0-9.]+ px-[0-9]+ py-[0-9.]+ bg-\[#C85A32\] text-white font-bold text-(?:\[10px\]|xs|sm) uppercase tracking-widest hover:brightness-105 transition shadow-sm cursor-pointer["']/g, 'class="btn-primary"');
            
            // 2. Remove the redundant '+ ' text right after the svg icon
            // It usually looks like: </svg>\n        + CATÉGORIE
            newContent = newContent.replace(/(<\/svg>[\s\n]*)\+\s+/g, '$1');
            
            // 3. For buttons that were already manually changed to btn-primary but still have the '+'
            newContent = newContent.replace(/(<a[^>]*class=["'][^"']*btn-primary[^"']*["'][^>]*>[\s\n]*<svg[^>]*>.*?<\/svg>[\s\n]*)\+\s+/gs, '$1');
            newContent = newContent.replace(/(<button[^>]*class=["'][^"']*btn-primary[^"']*["'][^>]*>[\s\n]*<svg[^>]*>.*?<\/svg>[\s\n]*)\+\s+/gs, '$1');

            if (content !== newContent) {
                fs.writeFileSync(fullPath, newContent, 'utf8');
                console.log(`Updated button in: ${fullPath}`);
            }
        }
    });
}

walkDir(adminDir);
console.log("Button fix done.");
