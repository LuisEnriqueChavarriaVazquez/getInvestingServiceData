<!--

    rentabilidad.php
    Ranking específico a la rentabilidad

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
    include("../nucleo.php");
    $indice = json_decode($_SESSION['indice']);
    $empresas = array();
    foreach($indice as $i => $elemento){
        $empresas[$i] = new empresa("../" . $elemento->archivo);
    }
    $rankingRentabilidad = new ranking($empresas, "calificación de rentabilidad", "razones->rentabilidad->calificacion", true, "Puntaje", "puntos");
    $ranking1 = new ranking($empresas, "margen de utilidad", "razones->rentabilidad->margenUtilidad", true, "Porcentaje", "%");
    $ranking2 = new ranking($empresas, "rendimiento sobre activos totales", "razones->rentabilidad->retornoSobreActivos", true, "Porcentaje", "%");
    $ranking3 = new ranking($empresas, "rendimiento sobre el capital contable", "razones->rentabilidad->retornoSobreCC", true, "Porcentaje", "%");

?>

<!DOCTYPE html>
<html>

    <head>
        <title>Índices de rentabilidad - Rankings</title>
        <?php  include("../php/linksR.html"); ?>
    </head>

    <body class="conImagen">
        <div class="pantalla">

        <?php include("../php/encabezadoR.php"); ?>

        <div class="container" style="margin-top: 50px">
            <h1 id="titulo">Índices de rentabilidad <small>Rankings</small><small class="cantidad linkTitulo"><a target="_self" href="../informacion/rentabilidad.php">Información</a></small></h1>
            <?php
                $rankingRentabilidad->tabla();
                $rankingRentabilidad->grafica();
            ?>
            <h2>Margen de utilidad</h2>
            <?php
                $ranking1->tabla();
                $ranking1->grafica();
            ?>
            <h2>Rendimiento sobre activos totales</h2>
            <?php
                $ranking2->tabla();
                $ranking2->grafica();
            ?>
            <h2>Rendimiento sobre el capital contable</h2>
            <?php
                $ranking3->tabla();
                $ranking3->grafica();
            ?>
        </div>
        <?php
            include("../php/pie.html");
        ?>
        </div>
    </body>
</html>
