<?php
   /*
    * encabezado.php
    * Html de encabezado de todas las páginas del sitio.
    * 
	* Copyright (C) 2017 Ricardo Quezada Figueroa
	*
	*	This program is free software: you can redistribute it and/or modify
	*	it under the terms of the GNU General Public License as published by
	*	the Free Software Foundation, either version 3 of the License, or
	*	(at your option) any later version.
	*
	*	This program is distributed in the hope that it will be useful,
	*	but WITHOUT ANY WARRANTY; without even the implied warranty of
	*	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	*	GNU General Public License for more details.
	*
	*	You should have received a copy of the GNU General Public License
	*	along with this program.  If not, see <http://www.gnu.org/licenses/>.
	*/
?>

<nav class="navbar navbar-fixed-top navbar-inverse barraEncabezado">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">INICIO</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <li><a style="color: white; font-size: 12pt" href="ranking.php#empresasRanking">Ranking general</a></li>
                <li class="dropdown">
                    <a style="color: white; font-size: 12pt" class="dropdown-toggle" data-toggle="dropdown" href="#">Rankings<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a target="_self" href="rankings/rentabilidad.php">Índices de rentabilidad</a></li>
                        <li><a target="_self" href="rankings/liquidez.php">Índices de liquidez</a></li>
                        <li><a target="_self" href="rankings/endeudamiento.php">Índices de endeudamiento</a></li>
                        <li><a target="_self" href="rankings/rotacion.php">Índices de rotación</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a style="color: white; font-size: 12pt" class="dropdown-toggle" data-toggle="dropdown" href="#">Información<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a target="_self" href="informacion/rentabilidad.php">Rentabilidad</a></li>
                        <li><a target="_self" href="informacion/liquidez.php">Liquidez</a></li>
                        <li><a target="_self" href="informacion/endeudamiento.php">Endeudamiento</a></li>
                        <li><a target="_self" href="informacion/rotacion.php">Rotación</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a style="color: white; font-size: 12pt" class="dropdown-toggle" data-toggle="dropdown" href="#">Empresas<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php
							if(array_key_exists('indice', $_SESSION)) {
								$indiceAux = json_decode($_SESSION['indice']);
								foreach($indiceAux as $i => $elemento){
									echo "<li><a target='_self' href='empresa.php?id={$elemento->nombre}'>{$elemento->nombre}</a></li>\n";
								}
							}
                        ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
