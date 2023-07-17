#pip install beautifulsoup4
#pip install requests

import requests
from bs4 import BeautifulSoup
import json

def scrape_and_save_html(url):
    # Making a GET request
    r = requests.get(url)

    # check status code for response received
    # success code - 200
    print(r)

    # Parse HTML content with BeautifulSoup
    soup = BeautifulSoup(r.content, 'html.parser')

    # Find the table with class "genTbl reportTbl"
    table = soup.find('table', class_='genTbl reportTbl')

    if table:
        # Extract filename from URL
        filename = url.split('/')[-1]

        # Save table HTML to a file
        with open('generatedFiles/' + filename + '.html', 'w', encoding='utf-8') as file:
            file.write(str(table))
        print(f"Table HTML content saved to '{filename}.html' file.")
    else:
        print("Table not found in the HTML.")


# Abrir el archivo JSON
with open('datos/balance-sheet.json', 'r') as file:
    data = json.load(file)

with open('datos/income-statement.json', 'r') as file:
    data_two = json.load(file)

# Acceder a los valores dentro del JSON
urls = data['href_attributes']
urls_two = data_two['href_attributes']

# Imprimir los valores obtenidos
for url in urls:
    scrape_and_save_html(url)

for url_two in urls_two:
    scrape_and_save_html(url_two)


