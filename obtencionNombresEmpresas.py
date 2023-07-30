#
#   Este programa lo que hace es darnos un json con todos los nombres de los archivos del git, para que
#   podamos usarlos en el buscador.
#

import json

def extract_text_after_equities(url_list):
    result_list = []
    for url in url_list:
        # Encuentra la posición de "equities/" y agrega el texto después de esta cadena
        index = url.find("equities/") + len("equities/")
        result_list.append(url[index:])
    return result_list

def main():
    # Lee el archivo JSON original
    with open('datos/income-statement.json', 'r') as file:
        data = json.load(file)
    
    with open('datos/balance-sheet.json', 'r') as file:
        data2 = json.load(file)

    # Extrae el texto después de "equities/" para cada elemento en la lista
    extracted_text = extract_text_after_equities(data["href_attributes"])
    extracted_text2 = extract_text_after_equities(data2["href_attributes"])

    # Crea un nuevo diccionario con la lista resultante
    new_data = {"nombres_extraidos_income_statement": extracted_text}
    new_data2 = {"nombres_extraidos_balance_sheet": extracted_text2}

    # Para verificar que el numero de empresas sea el mismo para el buscador
    print('Longitud de inconme = ' + str(len(new_data['nombres_extraidos_income_statement'])))
    print('Longitud de balance sheet = ' + str(len(new_data2['nombres_extraidos_balance_sheet'])))

    # Escribe el nuevo archivo JSON
    with open('datos/nombre_extraidos_income_statement.json', 'w') as new_file:
        json.dump(new_data, new_file)
    
    with open('datos/nombres_extraidos_balance_sheet.json', 'w') as new_file:
        json.dump(new_data2, new_file)

if __name__ == "__main__":
    main()
