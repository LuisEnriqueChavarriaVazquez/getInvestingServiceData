<!--

    ranking.php
    Página inicial de ranking.

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
    session_start();
    libxml_use_internal_errors(true);
    include("nucleo.php");
    $indice = json_decode($_SESSION['indice']);
    $empresas = array();
    foreach($indice as $i => $elemento){
        $empresas[$i] = new empresa($elemento->archivo);
    }
    $ranking = new ranking($empresas, "ranking general", "razones->calificacion", true, "Puntaje", "puntos");
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Ranking General</title>
        <?php  include("php/links.html"); ?>
        <script>
            if (typeof module === 'object')
                var ipc = require('electron').ipcRenderer;
            function nuevaVentana(destino){
                if (typeof module === 'object')
                    ipc.send('load-page', 'http://localhost:7050/empresa.php?id=' + destino);
                else
                    var ventana = window.open('empresa.php?id=' + destino, 'empresa', 'menubar=yes,location=yes,resizable=yes,scrollbars=yes,status=yes');
            }

            $(document).ready(function(){
                $("body").on('mouseover','.opciones',function () {
                    $(this).css('cursor','pointer');
                });
                $('[data-toggle="tooltip"]').tooltip();
                if($('.navbar').length > 0){
                    $(window).on("scroll load resize", function(){
                        checkScroll();
                    });
                }
            });
            function buscar(){
                var empresa = document.getElementById('empresa').value;
                var liga;
                for(var i=0; i<indice.length; i++){
                    if(indice[i].nombre == empresa){
                        liga = indice[i].liga;
                        break;
                    }
                }
                var ajax = new XMLHttpRequest();
                ajax.onreadystatechange = function() {
                    if(ajax.readyState == 4 && ajax.status == 200){
                        if(ajax.responseText == "si"){
                            location.reload();
                        }
                    }
                };
                ajax.open("GET", "php/enlace.php?empresa=" + liga + "&nombre=" + empresa, true);
                ajax.send();
            }

            function quitar(empresa){
                var ajax = new XMLHttpRequest();
                ajax.onreadystatechange = function() {
                    if(ajax.readyState == 4 && ajax.status == 200){
                        location.reload();
                    }
                };
                ajax.open("GET", "php/borrar.php?nombre=" + empresa, true);
                ajax.send();
            }

            //encabezado
            function checkScroll(){
                var startY = $('.navbar').height() * 5;
                if($(window).scrollTop() > startY){
                    $('.navbar').addClass("scrolled");
                }else{
                    $('.navbar').removeClass("scrolled");
                }
            }
        </script>
        <style rel="stylesheet">
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
        </style>
    </head>
    <body>
        <?php include("php/encabezado.php"); ?>
        <div class="jumbotron text-center encabezado">
            <h1>Programa de cómputo didáctico <br>"Análisis Financiero" <br>basado en razones financieras</h1>
            <form class="form-inline" style="margin-top: 50px">
                <input id="empresa" type="text" class="form-control" size="50" placeholder="Agregar empresa">
                <button type="button" class="btn btn-default" onclick="buscar()">Buscar</button>
            </form>
        </div>
        <!-- Contenido -->
        <div class="container">
            <p class="fuente">Imágen: Grupo inteleka - www.inteleka.com</p>
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <h1 id="empresasRanking">Empresas <small>Ranking</small></h1>
                    <a href="agregar.php" class="btn btn-default derechaRankingsPrincipal2" role="button">Agregar empresa</a>
                </div>
                <div class="col-sm-1"></div>
            </div>
            <?php
            $i = 1;
                foreach($ranking->lista as $nombre => $monto){
                    echo "<div class='row'>\n";
                    echo "<div class='col-sm-1'></div>";
                    echo "\t\t<div class='col-sm-10'>\n";
                    echo "\t\t  <div class='cuadro'>\n";
                    $id = urlencode($nombre);
                    echo "\t\t<h4><small class='numeracion'>$i - </small> $nombre <span class='opciones'><span onclick='quitar(this.id)' id='$id' class='glyphicon glyphicon-remove-circle quitarE' data-toggle='tooltip' data-placement='bottom' title='Quitar de ranking'></span> <span  onclick='nuevaVentana(this.id)' id='$id' class='glyphicon glyphicon-book verE' data-toggle='tooltip' data-placement='bottom' title='Ver información'></span></span><span class='badge cantidad' style='margin-right: 15px'>$monto puntos</span> </h4>\n";
                    echo "\t\t  </div>\n";
                    echo "\t\t</div>\n";
                    echo "<div class='col-sm-1'></div>";
                    echo "</div>\n";
                    $i++;
                }
            ?>

            <div class='row'>
                <div class='col-sm-1'></div>
                <div class='col-sm-10'>
                    <?php $ranking->grafica(); ?>
                </div>
                <div class='col-sm-1'></div>
            </div>
            <div class='row' style="margin-top: 50px">
                <div class='col-sm-12'>
                    <h4 class="text-center">Gráfica de comparación de calificaciones</h4>
                    <canvas id="graficaRadar"></canvas>
                </div>
            </div>
        </div>
        <?php
            include("php/pie.html");
        ?>
        <script>
        var contenedor = document.getElementById('graficaRadar');
        var data = {
            labels: ["Rentabilidad", "Liquidez", "Endeudamiento", "Rotaciones"],
            datasets: [
                <?php
                    foreach($empresas as $i => $empresa){

                        $r = rand(0,255);
                        $g = rand(0,255);
                        $b = rand(0,255);

                        echo "{\n";
                        echo "    label: '{$empresa->nombre}',\n";
                        echo "    active: false,\n";
                        echo "    backgroundColor: 'rgba($r,$g,$b,0.2)',\n";
                        echo "    borderColor: 'rgba($r,$g,$b,1)',\n";
                        echo "    pointBackgroundColor: 'rgba($r,$g,$b,1)',\n";
                        echo "    pointBorderColor: '#fff',\n";
                        echo "    pointHoverBackgroundColor: '#fff',\n";
                        echo "    pointHoverBorderColor: 'rgba($r,$g,$b,1)',\n";
                        echo "    data: [{$empresa->datos->razones->rentabilidad->calificacion}, {$empresa->datos->razones->liquidez->calificacion}, {$empresa->datos->razones->endeudamiento->calificacion}, {$empresa->datos->razones->rotaciones->calificacion}]\n";
                        if($i == count($empresas) - 1){
                            echo "}\n";
                        }else{
                            echo "},\n";
                        }
                    }
                ?>
            ]
        };
        new Chart(contenedor, {
            type: "radar",
            data: data,
            options: {
                    scale: {
                        reverse: false,
                        ticks: {
                            beginAtZero: true
                        }
                    }
            }
            });
        </script>
    <script>

        $(function() {
            var availableTags = [
                <?php

					$archivo = json_decode(file_get_contents("datos/lista.json"));
					$i = 0;
					$errores = json_decode(file_get_contents("datos/errores.json"));
					$registro = array();
					foreach($archivo as $reg){
						if(!in_array($reg[1], $errores)){
							$registro[] = $reg[1] . "-----" . $reg[0];
							echo "\"{$reg[1]}\",\n";
							$i++;
						}
					}
                ?>
            ];
            $("#empresa").autocomplete({
                source: availableTags
            });
        });
        var indice = new Array();
        <?php
            foreach($registro as $i => $reg){
                $a = explode("-----", $reg);
                echo "indice[$i] = {'nombre':\"$a[0]\", 'liga':\"$a[1]\"};\n";
            }

            function transformarArray($listaNodos){
                $regreso = array();
                foreach($listaNodos as $nodo){
                    $regreso[] = $nodo;
                }
                return $regreso;
            }
        ?>
    </script>
    </body>
</html>
