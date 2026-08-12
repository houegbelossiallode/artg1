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
            
            // Replace the pale orange/camel (#D4A373) with the main green (#0BA20B)
            let newContent = content.replace(/#D4A373/ig, '#0BA20B');
            
            // Replace the dark gold (#B8860B) with the dark green (#087A08)
            newContent = newContent.replace(/#B8860B/ig, '#087A08');
            
            if (content !== newContent) {
                fs.writeFileSync(fullPath, newContent, 'utf8');
                console.log(`Updated secondary colors in: ${fullPath}`);
            }
        }
    });
}

walkDir(srcDir);
console.log("Secondary color switch done.");
