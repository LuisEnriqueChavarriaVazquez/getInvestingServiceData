<!--

    index.php
    Página inicial de aplicación.

	Copyright (C) 2017 Ricardo Quezada Figueroa

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.

-->

<?php
    libxml_use_internal_errors(true);
	error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="es">
    <head>

        <title>Análisis financiero - Inicio</title>
        <?php include("php/links.html"); ?>
        <script>

			/* Contexto de electron */
			if (typeof module === 'object')
				var ipc = require('electron').ipcRenderer;

			var contador = 0;
			var peticiones = 0;

			function limpiar()
			{
				/* Limpia cualquier selección de la lista principal */

				var elementos = document.getElementsByTagName('input');
				for(var i=0; i<elementos.length; i++){
					if(elementos[i].checked){
						elementos[i].checked = false;
					}
				}
			}

            function todos()
			{
				/* Selecciona todos los checkboxs de la lista principal */

                var elementos = document.getElementsByTagName('input');
                for(var i=0; i<elementos.length; i++){
                    elementos[i].checked = true;
                }
            }

            function filtro(palabra)
			{
				/* Se llama cada que se escribe en la barra de filtro.
				 * Oculta las entradas que no coinciden con el texto. */

                var lista = document.getElementById("lista");
                var elementos = lista.getElementsByTagName("input");
                for(var i=0; i<elementos.length; i++) {
                    if((elementos[i].value).toLowerCase().search(palabra.toLowerCase()) === -1){
                        elementos[i].parentElement.parentElement.className = "checkbox oculto";
                    }else{
                        elementos[i].parentElement.parentElement.className = "checkbox";
                    }
                }
            }

            function enviar()
			{
				/* Se llama al presionar botón de enviar.
				 * Muestra gif de carga en lo que se reecolecta la información
				 * necesaria. Llama a nuevaPeticion() ara cada empresa seleccionada. */

                var cargando = document.getElementById('cargando');
                cargando.className = "text-center";
                var elementos = document.getElementsByTagName('input');
                borrarIndice();

                for(var i=0; i<elementos.length; i++) {
                    if(elementos[i].checked){
                        peticiones++;
                    }
                }

                for(var i=0; i<elementos.length; i++) {
                    if(elementos[i].checked){
                        nuevaPeticion(elementos[i].value, elementos[i].parentElement.innerText);
                    }
                }
            }

            function nuevaPeticion(empresa, nombre)
			{
				/* Llama al script enlace.php para la empresa solicitada.
				 * Las consultas se hacen de manera asíncrona con ajax. */

                var empresa = encodeURI(empresa);
                var nombre = encodeURI(nombre);
                var ajax = new XMLHttpRequest();

                ajax.onreadystatechange = function () {
                    if (ajax.readyState === 4 && ajax.status === 200) {
                        contador++;
                        if(contador === peticiones){
                            var cargando = document.getElementById('cargando');
                            cargando.className = "text-center oculto";
                            if (typeof module === 'object')
                                ipc.send('load-page', 'http://localhost:7050/ranking.php');
                            else
                                window.open('ranking.php',
											'_self',
											'resizable,location,menubar,toolbar,scrollbars,status');
                        }
                    }
                };

                ajax.open("GET", "php/enlace.php?empresa=" + empresa + "&nombre=" + nombre, true);
                ajax.send();
            }

            function borrarIndice()
			{
				/* Llama al script borrar.php para eliminar la selección anterior */

                var ajax = new XMLHttpRequest();
                ajax.open("GET", "php/borrar.php?indice=true", true);
                ajax.send();
            }

            $(document).ready(function()
			{
				/* Se activa cada que se hace scroll sobre la página. */

                if($('.navbar').length > 0){
                    $(window).on("scroll load resize", function(){
                        checkScroll();
                    });
                }

            });

            function checkScroll()
			{
				/* Verifica la posición del scroll. De ser el caso cambia el css
				 * del encabezado. */

                var startY = $('.navbar').height() * 5;
                if($(window).scrollTop() > startY){
                    $('.navbar').addClass("scrolled");
                }else{
                    $('.navbar').removeClass("scrolled");
                }
            }

        </script>
    <head>
    <body>

        <div id="cargando" class="text-center oculto">
            <img src="imagenes/ajax-loader (3).gif" style="margin-top: 300px; margin-bottom: 10px">
            <p>Obteniendo información...</p>
        </div>

        <?php include("php/encabezado.php"); ?>
        <div class="jumbotron text-center  encabezado">
            <h1>Programa de cómputo didáctico <br>"Análisis Financiero" <br>basado en razones financieras</h1>
            <p><b>Autores:</b></p>
            <p>Josefina Hernández Jaime</p>
            <p>Eduardo Rodríguez Flores</p>
            <p>Yasmín Ivette Jiménez Galán</p>
        </div>

        <div class="container">
            <p class="fuente">Imágen: Grupo inteleka - www.inteleka.com</p>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h1>Selección de empresas para el ranking</h1>
                    <p>Marca las empresas que quieras comparar.</p>
                </div>
            </div>
            <div class="row">

                <form class="form-inline text-center" style="margin-top: 30px; margin-bottom: 30px">
                    <input onkeyup="filtro(this.value)" id="empresa" type="text" class="form-control" size="50" placeholder="Filtro">
                    <input type="button" class="btn btn-default" value="Enviar" onclick="enviar()" style="margin-right: 10px"><br>
                    <input type="button" class="btn btn-default" value="Seleccionar todos" onclick="todos()" style="margin-top: 5px">
                    <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()" style="margin-top: 5px">
                </form>

                <div id="lista">
                    <div class="col-sm-4">
                        <form>
                            <?php

    /* Las ligas se obtienen cada día */
    $errores = json_decode(file_get_contents("datos/errores.json"));

    //if (filemtime("datos/lista.json") <= time() - 86400) {
	if(True){

        $registro = array();
		$encabezado = array(
			'http'=>array(
				'protocol_version'=>'1.1',
				'method'=>"GET",
				'header'=>"Connection: close\r\n" .
					"User-Agent: m\r\n" .
					"Accept-Encoding: identity\r\n" .
					"Accept: */*\r\n" .
					"X-Requested-With: XMLHttpRequest\r\n" .
					"Referer: http://mx.investing.com/equities/mexico\r\n" .
					"Accept-Encoding: gzip, deflate, sdch\r\n" .
					"Accept-Language: en-US,en;q=0.8,es;q=0.6\r\n"
			)
		);

		$contexto = stream_context_create($encabezado);
		$html = file_get_contents("https://mx.investing.com/equities/StocksFilter?noconstruct=1&smlID=612&sid=&tabletype=price&index_id=all", false, $contexto);

        $documento = new DOMDocument('1.1','UTF-8');
        $documento->loadHTML($html);
        $tabla = transformarArray(
			$documento->getElementById('cross_rate_markets_stocks_1')
			->getElementsByTagName('tbody'))[0];
        $filas = transformarArray($tabla->getElementsByTagName('tr'));
        $total = count($filas);
        $i = 0;

        foreach($filas as $fila){
            if(($i == round($total/3,0) | $i == round(($total*2)/3,0)) & $i != 0 & $i != 1){
                echo "</form>\n</div>\n<div class='col-sm-4'>\n<form>";
            }
            $celda = transformarArray(
				transformarArray($fila->getElementsByTagName('td'))[1]
				->getElementsByTagName('a'))[0];
            if(!in_array($celda->textContent, $errores)){
                $link = $celda->getAttribute('href');
                echo "<div class='checkbox'><label><input type = 'checkbox' value='{$link}'>{$celda->textContent}</label></div>\n";
                array_push($registro, array($link, $celda->textContent));
                $i++;
            }
        }

        file_put_contents("datos/lista.json", json_encode($registro));

    } else {

        $registro = json_decode(file_get_contents("datos/lista.json"));
        $total = count($registro);
        $i = 0;

        foreach($registro as $reg){
            if(($i == round($total/3,0) | $i == round(($total*2)/3,0)) & $i != 0 & $i != 1){
                echo "</form>\n</div>\n<div class='col-sm-4'>\n<form>";
            }
            if(!in_array($reg[1], $errores)){
                echo "<div class='checkbox'><label><input type = 'checkbox' value='{$reg[0]}'>{$reg[1]}</label></div>\n";
                $i++;
            }
        }

    }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php
            include("php/pie.html");
            function transformarArray($listaNodos){
                $regreso = array();
                foreach($listaNodos as $nodo){
                    $regreso[] = $nodo;
                }
                return $regreso;
            }
        ?>

<style rel="stylesheet">

/* CSS esclusivo a index */

.encabezado{
    background-image: url(imagenes/finanzas3.png);
    background-repeat: no-repeat;
    background-position: top center;
    background-size: 100%;
}

.barraEncabezado{
    background-color: rgba(2,2,2,0);
}

.navbar {
    -webkit-transition: all 0.6s ease-out;
    -moz-transition: all 0.6s ease-out;
    -o-transition: all 0.6s ease-out;
    -ms-transition: all 0.6s ease-out;
    transition: all 0.6s ease-out;
}

.navbar.scrolled {
    background: rgba(2, 2, 2, 0.9);
}

.oculto{
    display: none;
}

#cargando{
    position: fixed;
    top: 0px;
    bottom: 0px;
    left: 0px;
    right: 0px;
    background-color: rgba(0,0,0,0.8);
    z-index: 10000;
}

#cargando p{
    color: white;
}

</style>

    <body>
</html>
