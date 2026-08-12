const fs = require('fs');
const path = require('path');

const srcDir = path.join(__dirname, '../resources');

function walkDir(dir) {
    fs.readdirSync(dir).forEach(file => {
        let fullPath = path.join(dir, file);
        if (fs.statSync(fullPath).isDirectory()) {
            walkDir(fullPath);
        } else if (fullPath.endsWith('.blade.php') || fullPath.endsWith('.css') || fullPath.endsWith('.js')) {
            let content = fs.readFileSync(fullPath, 'utf8');
            
            // Replace Terracotta with new vibrant Green
            let newContent = content.replace(/#C85A32/ig, '#0BA20B');
            
            // Replace dark Terracotta (hover) with darker Green
            newContent = newContent.replace(/#A84223/ig, '#087A08');
            
            if (content !== newContent) {
                fs.writeFileSync(fullPath, newContent, 'utf8');
                console.log(`Updated colors in: ${fullPath}`);
            }
        }
    });
}

walkDir(srcDir);
console.log("Color switch done.");
