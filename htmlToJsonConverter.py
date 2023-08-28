from bs4 import BeautifulSoup
import json

# Tu string HTML con las tablas
html_string = """
  ... (tu HTML aquí) ...
"""

# Crear un objeto BeautifulSoup para analizar el HTML
soup = BeautifulSoup(html_string, 'html.parser')

# Encontrar todas las tablas con la clase 'genTbl' y 'reportTbl'
tables = soup.find_all('table', class_='genTbl reportTbl')

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

# Mostrar el JSON final
print(json.dumps(json_data, indent=2))

# Guardar el JSON en un archivo
with open('data.json', 'w') as json_file:
    json.dump(json_data, json_file, indent=2)
