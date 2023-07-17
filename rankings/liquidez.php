<!--

    liquidez.php
    Ranking específico a la liquidez

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
    $indice = json_decode($_SESSION['indice']);;
    $empresas = array();
    foreach($indice as $i => $elemento){
        $empresas[$i] = new empresa("../" . $elemento->archivo);
    }

    $rankingLiquidez = new ranking($empresas, "calificación de liquidez", "razones->liquidez->calificacion", true, "Puntaje", "puntos");
    $ranking1 = new ranking($empresas, "razón de liquidez", "razones->liquidez->razonLiquidez", true, "Número de veces", "veces");
    $ranking2 = new ranking($empresas, "prueba del ácido", "razones->liquidez->pruebaAcido", true, "Número de veces", "veces");
    $ranking3 = new ranking($empresas, "capital de trabajo", "razones->liquidez->capitalTrabajo", true, "Monto", "$");
    $ranking4 = new ranking($empresas, "ciclo operativo", "razones->liquidez->cicloOperativo", false, "Tiempo", "días");
?>

<!DOCTYPE html>
<html>

    <head>
        <title>Índices de liquidez - Rankings</title>
        <?php  include("../php/linksR.html"); ?>
    </head>

    <body class="conImagen">
        <div class="pantalla">
        <?php include("../php/encabezadoR.php"); ?>

        <div class="container" style="margin-top: 50px">
            <h1 id="titulo">Índices de Liquidez <small>Rankings</small><small class="cantidad linkTitulo"><a target="_self" href="../informacion/liquidez.php">Información</a></small></h1>
            <?php
                $rankingLiquidez->tabla();
                $rankingLiquidez->grafica();
            ?>
            <h2>Razón de liquidez</h2>
            <?php
                $ranking1->tabla();
                $ranking1->grafica();
            ?>
            <h2>Prueba del ácido</h2>
            <?php
                $ranking2->tabla();
                $ranking2->grafica();
            ?>
        </div>
        <?php
            include("../php/pie.html");
        ?>
        </div>
    </body>

</html>
