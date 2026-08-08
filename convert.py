from bs4 import BeautifulSoup
with open('extracted_full.html', 'r', encoding='utf-8') as f:
    html = f.read()
soup = BeautifulSoup(html, 'html.parser')
header = soup.find('header')
main = soup.find('main')
footer = soup.find('footer')
with open('dump_header.html', 'w', encoding='utf-8') as f:
    f.write(header.prettify() if header else '')
with open('dump_main.html', 'w', encoding='utf-8') as f:
    f.write(main.prettify() if main else '')
with open('dump_footer.html', 'w', encoding='utf-8') as f:
    f.write(footer.prettify() if footer else '')
