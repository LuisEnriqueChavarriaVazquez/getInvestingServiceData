#Este programa sirve para obtener los archivos JSON de los archivos HTML que hemos obtenido de la pagina de investing

from bs4 import BeautifulSoup
import os
import json

# Ruta de la carpeta que contiene los archivos HTML
html_folder = "generatedFiles"

# Ruta de la carpeta donde se guardarán los archivos JSON
json_folder = "generatedJsons"

# Crear la carpeta json_folder si no existe
os.makedirs(json_folder, exist_ok=True)

# Función para organizar los valores de las celdas en un diccionario
def organize_values(table):
    data = []
    headers = []
    
    # Encontrar los títulos de la tabla
    header_row = table.find('tr', class_='alignBottom')
    if header_row:
        headers = [header.get_text(strip=True) for header in header_row.find_all(['th', 'span'], class_=['bold', 'lightgrayFont'])]
    
    # Encontrar los datos de las celdas
    for row in table.find_all('tr'):
        row_data = [cell.get_text(strip=True) for cell in row.find_all('td')]
        if row_data:
            data.append(row_data)
    
    return headers, data

# Procesar cada archivo HTML en la carpeta
for html_filename in os.listdir(html_folder):
    if html_filename.endswith(".html"):
        # Construir la ruta completa del archivo HTML
        html_path = os.path.join(html_folder, html_filename)
        
        # Crear un objeto BeautifulSoup para analizar el HTML
        with open(html_path, 'r', encoding='utf-8') as html_file:
            html_string = html_file.read()
            soup = BeautifulSoup(html_string, 'html.parser')
        
        # Encontrar todas las tablas con la clase 'genTbl' y 'reportTbl'
        tables = soup.find_all('table', class_='genTbl reportTbl')
        
        # Crear un diccionario que almacena los valores de las celdas por tabla
        json_data = {}
        for table in tables:
            table_name = None
            
            # Encontrar el título de la tabla
            table_name_element = table.find('span', class_='bold')
            if table_name_element:
                table_name = table_name_element.get_text(strip=True)
            
            # Organizar los valores de las celdas
            headers, data = organize_values(table)
            
            # Agregar los datos al diccionario
            if table_name:
                json_data[table_name] = {
                    "headers": headers,
                    "data": data
                }
        
        # Crear el nombre del archivo JSON correspondiente
        json_filename = os.path.splitext(html_filename)[0] + ".json"
        json_path = os.path.join(json_folder, json_filename)
        
        # Guardar el JSON en el archivo correspondiente
        with open(json_path, 'w') as json_file:
            json.dump(json_data, json_file, indent=2)

        print(f"Archivo JSON '{json_filename}' generado.")
