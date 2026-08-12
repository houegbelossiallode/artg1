const fs = require('fs');
const path = require('path');

const directoryPath = path.join(__dirname, '../resources/views/admin');

function traverseAndReplace(dir) {
    fs.readdirSync(dir).forEach(file => {
        const fullPath = path.join(dir, file);
        if (fs.statSync(fullPath).isDirectory()) {
            traverseAndReplace(fullPath);
        } else if (fullPath.endsWith('.blade.php')) {
            let content = fs.readFileSync(fullPath, 'utf8');
            let modified = false;

            // Replace old button classes
            const regexes = [
                /class="[^"]*bg-blue-500 hover:bg-blue-600 text-white[^"]*"/g,
                /class="[^"]*bg-slate-900 hover:bg-slate-800 text-amber-500[^"]*"/g,
                /class="[^"]*bg-slate-900 text-amber-500[^"]*hover:bg-slate-800[^"]*"/g,
            ];

            for (const regex of regexes) {
                if (regex.test(content)) {
                    content = content.replace(regex, 'class="btn-primary"');
                    modified = true;
                }
            }

            if (modified) {
                fs.writeFileSync(fullPath, content, 'utf8');
                console.log('Updated buttons in:', fullPath);
            }
        }
    });
}

traverseAndReplace(directoryPath);
console.log('Done replacing old buttons with btn-primary.');
