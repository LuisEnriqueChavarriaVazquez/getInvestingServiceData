import requests
from bs4 import BeautifulSoup
import json
import subprocess

def get_href_from_urls(urls):
    href_list = []

    for url in urls:
        response = requests.get(url)
        soup = BeautifulSoup(response.text, 'html.parser')
        
        elements = soup.find_all(class_='inv-link bold datatable_cell--name__link__2xqgx')
        
        for element in elements:
            href = element.get('href')
            if href:
                href_list.append(href)
    
    return href_list

# Lista de URLs para acceder a mercados concretos
urls = [
    'https://mx.investing.com/equities/americas',
    'https://mx.investing.com/equities/mexico',
    # 'https://mx.investing.com/equities/canada',
    # 'https://mx.investing.com/equities/argentina',
    # 'https://mx.investing.com/equities/brazil',
    # 'https://mx.investing.com/equities/spain',
    # 'https://mx.investing.com/equities/chile',
    # 'https://mx.investing.com/equities/germany',
    # 'https://mx.investing.com/equities/switzerland'
]

# Obtener los atributos href
href_attributes = get_href_from_urls(urls)

# Agregar texto al final de cada elemento de href_attributes
modified_attributes = ['https://mx.investing.com' + href + '-income-statement' for href in href_attributes]
modified_attributes_two = ['https://mx.investing.com' + href + '-balance-sheet' for href in href_attributes]

# Guardar los resultados en un archivo JSON
data = {'href_attributes': modified_attributes}
with open('datos/income-statement.json', 'w') as file:
    json.dump(data, file)

data_two = {'href_attributes': modified_attributes_two}
with open('datos/balance-sheet.json', 'w') as file:
    json.dump(data_two, file)


#Corremos el programa para ejecutar la creación de words/json
# Ejecutar el programa de Python
subprocess.run(['python', 'obtencionDatosEmpresa.py'])

