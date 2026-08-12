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
            let newContent = content.replace(/\bfont-serif(-heading)?\b/g, 'font-sans');
            if (content !== newContent) {
                fs.writeFileSync(fullPath, newContent, 'utf8');
                console.log(`Updated: ${fullPath}`);
            }
        }
    });
}

walkDir(adminDir);
console.log("Done.");
