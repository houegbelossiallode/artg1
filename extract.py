from playwright.sync_api import sync_playwright
with sync_playwright() as p:
    browser = p.chromium.launch(channel="msedge", headless=True)
    page = browser.new_page()
    page.goto('https://cho-culture-association-cultural-artistique.ai.studio/')
    page.wait_for_timeout(5000)
    html = page.evaluate('document.documentElement.outerHTML')
    with open('extracted_full.html', 'w', encoding='utf-8') as f:
        f.write(html)
    browser.close()
