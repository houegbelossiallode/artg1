const puppeteer = require('puppeteer');

(async () => {
    const browser = await puppeteer.launch({ headless: 'new' });
    const page = await browser.newPage();
    
    page.on('console', msg => console.log('PAGE LOG:', msg.text()));
    page.on('pageerror', error => console.log('PAGE ERROR:', error.message));

    await page.goto('http://127.0.0.1:8000/', { waitUntil: 'networkidle0' });
    
    console.log("Page loaded. Clicking first news item...");
    await page.evaluate(() => {
        const item = document.querySelector('#news article .cursor-pointer');
        if(item) {
            console.log("Found item with dataset:", JSON.stringify(item.dataset));
            item.click();
        } else {
            console.log("No news item found!");
        }
    });

    await new Promise(r => setTimeout(r, 1000)); // wait for modal
    
    const modalText = await page.evaluate(() => {
        const title = document.querySelector('#news h3[x-text="showTitle"]');
        return title ? title.innerText : 'Modal not found';
    });
    console.log("Modal title says:", modalText);

    await browser.close();
})();
