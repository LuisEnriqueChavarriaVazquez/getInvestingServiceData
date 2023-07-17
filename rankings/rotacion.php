<!--

    rotación.php
    Ranking específico a la rotación

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
    $rankingRotacion = new ranking($empresas, "calificación de rotaciones", "razones->rotaciones->calificacion", true, "Puntaje", "puntos");
    $ranking1 = new ranking($empresas, "rotación de cuentas por cobrar", "razones->rotaciones->rotacionCuentasPorCobrar", false, "Tiempo", "días");
    $ranking2 = new ranking($empresas, "rotación de cuentas por pagar", "razones->rotaciones->rotacionCuentasPorPagar", false, "Tiempo", "días");
    $ranking3 = new ranking($empresas, "rotación de inventarios", "razones->rotaciones->rotacionInventarios", false, "Tiempo", "días");
    $ranking4 = new ranking($empresas, "rotación de activos fijos", "razones->rotaciones->rotacionActivosFijos", true, "Número de veces", "veces");
    $ranking5 = new ranking($empresas, "rotación de activos totales", "razones->rotaciones->rotacionActivosTotales", true, "Número de veces", "veces");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Índices de rotación - Rankings</title>
        <?php  include("../php/linksR.html"); ?>
    </head>
    <body class="conImagen">
        <div class="pantalla">
        <?php include("../php/encabezadoR.php"); ?>
        <div class="container" style="margin-top: 50px">
            <h1 id="titulo">Rotación de activos <small>Rankings</small><small class="cantidad linkTitulo"><a target="_self" href="../informacion/rentabilidad.php">Información</a></small></h1>
            <?php
                $rankingRotacion->tabla();
                $rankingRotacion->grafica();
            ?>
            <h2>Rotación de cuentas por cobrar</h2>
            <?php
                $ranking1->tabla();
                $ranking1->grafica();
            ?>
            <h2>Rotación de cuentas por pagar</h2>
            <?php
                $ranking2->tabla();
                $ranking2->grafica();
            ?>
            <h2>Rotación de inventarios</h2>
            <?php
                $ranking3->tabla();
                $ranking3->grafica();
            ?>
            <h2>Rotación de activos fijos</h2>
            <?php
                $ranking4->tabla();
                $ranking4->grafica();
            ?>
            <h2>Rotación de activos totales</h2>
            <?php
                $ranking5->tabla();
                $ranking5->grafica();
            ?>
        </div>
        <?php
            include("../php/pie.html");
        ?>
        </div>
    </body>
</html>
