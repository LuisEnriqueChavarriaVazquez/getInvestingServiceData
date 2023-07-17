<?php

   /*
    * borrar.php
    * Script para borrar e iniciar un nuevo índice.
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


    session_start();
    $nuevoIndice = array();
    if(!isset($_GET['indice'])){
        $indice = json_decode($_SESSION['indice']);
        $j = 0;
        foreach($indice as $i => $empresas){
            if($empresas->nombre == $_GET['nombre']){
                continue;
            }
            $nuevoIndice[$j]->nombre = $empresas->nombre;
            $nuevoIndice[$j]->archivo = $empresas->archivo;
            $j++;
        }
    }
    $nuevoIndice= json_encode($nuevoIndice);
    //file_put_contents('../datos/indice.json', $nuevoIndice);
    $_SESSION["indice"] = $nuevoIndice;
    header("Location: ../ranking.php");
?>
