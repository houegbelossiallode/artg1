const fs = require('fs');
const path = require('path');

const dir = path.join(__dirname, '../resources/views/admin/associations');

fs.readdirSync(dir).forEach(file => {
    if (file.endsWith('.blade.php')) {
        const fullPath = path.join(dir, file);
        let content = fs.readFileSync(fullPath, 'utf8');

        // Replace amber colors with #0BA20B
        content = content.replace(/bg-amber-500/g, 'bg-[#0BA20B]');
        content = content.replace(/focus:border-amber-500/g, 'focus:border-[#0BA20B]');
        content = content.replace(/hover:bg-amber-600/g, 'hover:bg-[#0BA20B]/90');
        content = content.replace(/text-amber-500/g, 'text-[#0BA20B]');
        
        // Fix index logo badge
        content = content.replace(/bg-slate-900 text-\[#0BA20B\]/g, 'bg-[#0BA20B]/10 text-[#0BA20B]');
        
        // Fix the submit buttons to use btn-primary if they don't already
        content = content.replace(/class="px-6 py-2 bg-\[#0BA20B\] hover:bg-\[#0BA20B\]\/90 text-white font-bold text-xs uppercase tracking-widest transition shadow-sm flex items-center gap-2"/g, 'class="btn-primary"');
        content = content.replace(/class="px-6 py-2 bg-\[#0BA20B\] hover:brightness-105 text-white font-bold text-xs uppercase tracking-widest transition shadow-sm flex items-center gap-2"/g, 'class="btn-primary"');
        
        fs.writeFileSync(fullPath, content, 'utf8');
        console.log('Fixed colors in', file);
    }
});
