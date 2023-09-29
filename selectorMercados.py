import requests
from bs4 import BeautifulSoup
import json
import subprocess

#Funcion para generar un JSON con el nombre de la empresa + el pais. 
#Esto es para agregar banderas al buscador de HTML
def get_company_info_from_urls(urls):
    company_info_list = []

    for url in urls:
        response = requests.get(url)
        soup = BeautifulSoup(response.text, 'html.parser')
        
        elements = soup.find_all(class_='inv-link bold datatable_cell--name__link__2xqgx')
        
        for element in elements:
            href = element.get('href')
            if href:
                # Obtener el nombre de la empresa y el país
                #name = element.text.strip() Nombre sin guiones
                name = href.split('/')[2]
                country = url.split('/')[-1]

                company_info = {
                    'name': name,
                    'country': country
                }
                
                company_info_list.append(company_info)
    
    return company_info_list #Solo retorna el objeto que se guarda en datos/company-info.js

#Funcion para obtener solamente el nombre de la empresa en una lista
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
    'https://mx.investing.com/equities/canada',
    'https://mx.investing.com/equities/argentina',
    'https://mx.investing.com/equities/brazil',
    'https://mx.investing.com/equities/spain',
    'https://mx.investing.com/equities/chile',
    'https://mx.investing.com/equities/germany',
    'https://mx.investing.com/equities/switzerland',
    'https://mx.investing.com/equities/venezuela',
    'https://mx.investing.com/equities/peru',
    'https://mx.investing.com/equities/colombia',
    'https://mx.investing.com/equities/china',
    'https://mx.investing.com/equities/india',
    'https://mx.investing.com/equities/russia',
    'https://mx.investing.com/equities/japan'
]

##CODIGO PARA LA FUNCION get_company_info_from_urls

# Obtener información de la empresa, incluyendo nombre y país
company_info_list = get_company_info_from_urls(urls)

# Guardar los resultados en un archivo JSON
with open('datos/company-info.json', 'w') as file:
    json.dump(company_info_list, file)

##CODIGO PARA LA FUNCION get_href_from_urls

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

# Correr el resto del programa
subprocess.run(['python', 'obtencionDatosEmpresa.py'])
subprocess.run(['python', 'obtencionNombresEmpresas.py'])
subprocess.run(['python', 'obtenecionNombresSolos.py'])
subprocess.run(['python', 'htmlToJsonConverterAll.py'])