<!--

    endeudamiento.php
    Ranking específico al endeudamiento

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
    $rankingEndeudamiento = new ranking($empresas, "calificación de endeudamiento", "razones->endeudamiento->calificacion", true, "Puntaje", "puntos");
    $ranking1 = new ranking($empresas, "apalancamiento", "razones->endeudamiento->apalancamiento", true, "Porcentaje", "%");
    $ranking2 = new ranking($empresas, "cobertura de intereses", "razones->endeudamiento->coberturaIntereses", true, "Número de veces", "veces");
?>

<!DOCTYPE html>
<html>

    <head>
        <title>Índices de endeudamiento - Rankings</title>
        <?php  include("../php/linksR.html"); ?>
    </head>
    <body class="conImagen">
        <div class="pantalla">
        <?php include("../php/encabezadoR.php"); ?>
        <div class="container" style="margin-top: 50px">
            <h1 id="titulo">Índices de endeudamiento <small>Rankings</small><small class="cantidad linkTitulo"><a target="_self" href="../informacion/endeudamiento.php">Información</a></small></h1>
            <?php
                $rankingEndeudamiento->tabla();
                $rankingEndeudamiento->grafica();
            ?>
            <h2>Apalancamiento</h2>
            <?php
                $ranking1->tabla();
                $ranking1->grafica();
            ?>
            <h2>Cobertura de intereses</h2>
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
