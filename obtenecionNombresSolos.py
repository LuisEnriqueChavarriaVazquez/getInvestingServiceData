import json

# Leer el archivo JSON
with open('datos/nombre_extraidos_income_statement.json', 'r') as file:
    data = json.load(file)

# Quitamos la parte "-income-statement" de cada elemento de la lista
result_list = [name.replace("-income-statement", "") for name in data["nombres_extraidos_income_statement"]]

# Crear un nuevo diccionario con el resultado
result_data = {"nombres_extraidos": result_list}

# Escribir el resultado en un nuevo archivo JSON
with open('datos/nombres_extraidos_solos.json', 'w') as outfile:
    json.dump(result_data, outfile, indent=4)

print("Proceso completado. Se ha creado un nuevo archivo 'resultado.json' con los nombres sin '-income-statement'.")
