<?php

   /*
    * enlace.php
    * Script para obtener de investing los datps de la empresa solicitada.
    *
	* Copyright (C) 2017 Ricardo Quezada Figueroa
	*
	* This program is free software: you can redistribute it and/or modify
	* it under the terms of the GNU General Public License as published by
	* the Free Software Foundation, either version 3 of the License, or
	* (at your option) any later version.
	*
	* This program is distributed in the hope that it will be useful,
	* but WITHOUT ANY WARRANTY; without even the implied warranty of
	* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	* GNU General Public License for more details.
	*
	* You should have received a copy of the GNU General Public License
	* along with this program.  If not, see <http://www.gnu.org/licenses/>.
	*/

    libxml_use_internal_errors(true);

    $link = explode("?", $_GET['empresa'])[0];
    error_log("Nuevo enlace. Link: $link, para {$_GET['nombre']}");
	$opciones = array(
			'http'=>array(
				'protocol_version'=>'1.1',
				'method'=>"GET",
				'timeout'=>60,
				'header'=>"Connection: close\r\n" .
						  "User-Agent: m\r\n" .
						  "Accept-Encoding: identity\r\n" .
						  "Accept: */*\r\n" .
						  "X-Requested-With: XMLHttpRequest\r\n" .
						  "Referer: https://mx.investing.com\r\n" .
						  "Accept-Encoding: gzip, deflate, sdch\r\n" .
						  "Accept-Language: en-US,en;q=0.8,es;q=0.6\r\n"
			)
		);
    $contexto = stream_context_create($opciones);
    $datos1 = file_get_contents("https://mx.investing.com$link-income-statement", false, $contexto);
    $datos2 = file_get_contents("https://mx.investing.com$link-balance-sheet", false, $contexto);

    if($datos1 == null | $datos2 == null){

        error_log("Error al obtener datos de {$_GET['nombre']}");
        $errores = json_decode(file_get_contents("../datos/errores.json"));
        $errores[] = $_GET['nombre'];
        $errores = json_encode($errores, JSON_PRETTY_PRINT);
        file_put_contents("../datos/errores.json", $errores);

    }else{

        //$fragmentos = array();
        $fragmentos['nombre'] = $_GET['nombre'];

        //Analizar el html
        $documento = new DOMDocument('1.1','UTF-8');
        $documento->loadHTML($datos2);
        $tabla = $documento->getElementById('rrtable');

        if($tabla == null){

            $errores = json_decode(file_get_contents("../datos/errores.json"));
            $errores[] = $_GET['nombre'];
            $errores = json_encode($errores, JSON_PRETTY_PRINT);
            file_put_contents("../datos/errores.json", $errores);
            echo "no";

        }else{

            $filas = transformarArray($tabla->getElementsByTagName('tr'));

            $aux = transformarArray($filas[7]->getElementsByTagName('td'));
            $fragmentos['activo->circulante->cuentas_por_cobrar->inicio'] = $aux[2]->textContent;
			if ($fragmentos['activo->circulante->cuentas_por_cobrar->inicio'] == '-'){
				$fragmentos['activo->circulante->cuentas_por_cobrar->inicio'] = 0;
			}
			
            $fragmentos['activo->circulante->cuentas_por_cobrar->final'] = $aux[1]->textContent;
			if ($fragmentos['activo->circulante->cuentas_por_cobrar->final'] == '-'){
				$fragmentos['activo->circulante->cuentas_por_cobrar->final'] = 0;
			}

            $aux = transformarArray($filas[9]->getElementsByTagName('td'));
            $fragmentos['activo->circulante->inventarios->inicio'] = $aux[2]->textContent;
			if ($fragmentos['activo->circulante->inventarios->inicio'] == '-'){
				$fragmentos['activo->circulante->inventarios->inicio'] = 0;
			}

            $fragmentos['activo->circulante->inventarios->final'] = $aux[1]->textContent;
			if ($fragmentos['activo->circulante->inventarios->final'] == '-'){
				$fragmentos['activo->circulante->inventarios->final'] = 0;
			}

            $aux = transformarArray($filas[1]->getElementsByTagName('td'));
            $fragmentos['activo->circulante->total'] = $aux[1]->textContent;
			if ($fragmentos['activo->circulante->total'] == '-'){
				$fragmentos['activo->circulante->total'] = 0;
			}

            $aux = transformarArray($filas[12]->getElementsByTagName('td'));
            $fragmentos['activo->total'] = $aux[1]->textContent;
			if ($fragmentos['activo->total'] == '-'){
				$fragmentos['activo->total'] = 0;
			}

            $fragmentos['activo->no_circulante->total'] = floatval($fragmentos['activo->total']) - floatval($fragmentos['activo->circulante->total']);

            $aux = transformarArray($filas[25]->getElementsByTagName('td'));
            $fragmentos['pasivo->a_corto_plazo->cuentas_por_pagar->inicio'] = $aux[2]->textContent;
			if ($fragmentos['pasivo->a_corto_plazo->cuentas_por_pagar->inicio'] == '-'){
				$fragmentos['pasivo->a_corto_plazo->cuentas_por_pagar->inicio'] = 0;
			}


            $fragmentos['pasivo->a_corto_plazo->cuentas_por_pagar->final'] = $aux[1]->textContent;
			if ($fragmentos['pasivo->a_corto_plazo->cuentas_por_pagar->final'] == '-'){
				$fragmentos['pasivo->a_corto_plazo->cuentas_por_pagar->final'] = 0;
			}

            $aux = transformarArray($filas[23]->getElementsByTagName('td'));
            $fragmentos['pasivo->a_corto_plazo->total'] = $aux[1]->textContent;
			if ($fragmentos['pasivo->a_corto_plazo->total'] == '-'){
				$fragmentos['pasivo->a_corto_plazo->total'] = 0;
			}

            $aux = transformarArray($filas[31]->getElementsByTagName('td'));
            $fragmentos['pasivo->total'] = $aux[1]->textContent;
			if ($fragmentos['pasivo->total'] == '-'){
				$fragmentos['pasivo->total'] = 0;
			}

            $fragmentos['pasivo->a_largo_plazo->total'] = floatval($fragmentos['pasivo->total']) - floatval($fragmentos['pasivo->a_corto_plazo->total']);

            $aux = transformarArray($filas[40]->getElementsByTagName('td'));
            $fragmentos['capital_contable->total'] = $aux[1]->textContent;
			if ($fragmentos['capital_contable->total'] == '-'){
				$fragmentos['capital_contable->total'] = 0;
			}

            $documento->loadHTML($datos1);
            $tabla = $documento->getElementById('rrtable');
            $filas = transformarArray($tabla->getElementsByTagName('tr'));

            $aux = transformarArray($filas[1]->getElementsByTagName('td'));
            $fragmentos['ventas_netas'] = $aux[1]->textContent;
			if ($fragmentos['ventas_netas'] == '-'){
				$fragmentos['ventas_netas'] = 0;
			}

            $aux = transformarArray($filas[5]->getElementsByTagName('td'));
            $fragmentos['costo_de_ventas'] = $aux[1]->textContent;
			if ($fragmentos['costo_de_ventas'] == '-'){
				$fragmentos['costo_de_ventas'] = 0;
			}

            $aux = transformarArray($filas[15]->getElementsByTagName('td'));
            $fragmentos['utilidad_de_operacion'] = $aux[1]->textContent;
			if ($fragmentos['utilidad_de_operacion'] == '-'){
				$fragmentos['utilidad_de_operacion'] = 0;
			}

            if($filas[27] != null){
                $aux = transformarArray($filas[27]->getElementsByTagName('td'));
                $fragmentos['utilidad_neta'] = $aux[1]->textContent;
            }else{
                $fragmentos['utilidad_neta'] = 0;
            }

            $aux = transformarArray($filas[12]->getElementsByTagName('td'));
            $fragmentos['intereses'] = $aux[1]->textContent;
			if ($fragmentos['intereses'] == '-'){
				$fragmentos['intereses'] = 0;
			}

            include("insertar.php");
            echo "si";

        }

    }

    function transformarArray($listaNodos){
        $regreso = array();
        foreach($listaNodos as $nodo){
            $regreso[] = $nodo;
        }
        return $regreso;
    }

?>
