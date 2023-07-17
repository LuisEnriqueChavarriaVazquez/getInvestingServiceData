<!--

    rentabilidad.php
    Página informativa sobre la medida de rentabilidad

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

<!DOCTYPE html>
<html lang="es-la">

<head>
    <?php  include("../php/linksR.html"); ?>
	<link rel="stylesheet" href="../bibliotecas/mathscribe/jqmath-0.4.3.css">
	<script src="../bibliotecas/mathscribe/jquery-1.4.3.min.js"></script>
	<script src="../bibliotecas/mathscribe/jqmath-etc-0.4.3.min.js" charset="utf-8"></script>
	<title>Índices de rentabilidad</title>
    <script>
        function calcularMU(){
            var MU=Number(document.getElementById("UN1").value)/Number(document.getElementById("VN").value)*100;
            document.getElementById("MU").innerHTML="Margen de utilidad = "+MU+"%";
        }
        function calcularRAT(){

            var MU=Number(document.getElementById("UN2").value)/Number(document.getElementById("AT").value)*100;
            document.getElementById("RAT1").innerHTML="Rendimiento sobre activos totales = "+MU+"%";
        }
        function calcularCC(){

            var MU=Number(document.getElementById("UN3").value)/Number(document.getElementById("CC2").value)*100;
            document.getElementById("CC1").innerHTML="Rendimiento sobre capital contable = "+MU+"%";
        }
        function mostrar(esto)
        {
            vista=document.getElementById(esto).style.display;
            if (vista=='none')
                vista='block';
            else
                vista='none';

            document.getElementById(esto).style.display = vista;
        }

    </script>
</head>
<body class="conImagen">
    <div class="pantalla">
    <?php include("../php/encabezadoR.php"); ?>
    <div class="container" style="margin-top: 50px">
        <h1>Índices de rentabilidad</h1>
        <p>La rentabilidad se define como la capacidad que tiene la empresa para generar rendimiento sobre las ventas, los activos totales y el patrimonio (capital contable). A continuación se muestran los índices de rentabilidad más usados.</p>
        <h2>Margen de utilidad <small class="cantidad linkTitulo"><a onClick="mostrar('margenUtilidad');">Calculadora de margen de utilidad</a></small></h2>
            <p>También llamado margen de rentabilidad, indica el porcentaje de utilidad en relación con las ventas.</p>
            \[\text"Margen de utilidad" = \text"Utilidad neta" / \text"Ventas netas"\]
            <p>Puede leerse como: por cada unidad monetaria que entra por concepto de ventas, X unidades son de utilidad.</p>
            <div id="margenUtilidad" style="display: none;">
                Utilidad neta= <input id="UN1"/>
                Ventas netas = <input id="VN"/>
                <button value="Calcular" onClick="calcularMU();">Calcular</button>
               <p id="MU"></p>
            </div>
        <h2>Rendimiento sobre activos totales (RAT)<small class="cantidad linkTitulo"><a onClick="mostrar('RAT');">Calculadora de rendimiento sobre activos totales</a></small></h2>
            <p>También conocido como rendimiento sobre la inversión, o por sus siglas en inglés ROA, indica el porcentaje de utilidad que se obtiene con el empleo de todos los recursos (activos) propios y ajenos de la empresa.</p>

            \[\text"Rendimiento sobre activos totales" = \text"Utilidad neta" / \text"Activo total"\]

            <p>Por cada unidad monetaria invertida en activos, la empresa obtiene X unidades monetarias de utilidad neta.</p>
            <p>A mayor rendimiento, mayores beneficios ha generado el activo total, por lo tanto, un valor más alto significa una situación más prospera para la empresa.</p>
            <div id="RAT" style="display: none;">
                Utilidad neta= <input id="UN2"/>
                Activo total = <input id="AT"/>
                <button value="Calcular" onClick="calcularRAT();">Calcular</button>
               <p id="RAT1"></p>
            </div>
        <h2>Rendimiento sobre el capital contable<small class="cantidad linkTitulo"><a onClick="mostrar('CC');">Calculadora de rendimiento sobre el capital contable</a></small></h2>
            <p>Mide el rendimiento que obtiene una empresa sobre el capital de los accionistas.</p>
            \[\text"Rendimiento sobre capital contable" = \text"Utilidad neta" / \text"Capital contable"\]
            <p>Se puede interpretar de la siguiente manera: por cada unidad monetaria invertida en patrimonio, se obtienen X unidades de la utilidad.</p>
        <div id="CC" style="display: none;">
                Utilidad neta= <input id="UN3"/>
                Capital contable = <input id="CC2"/>
                <button value="Calcular" onClick="calcularCC();">Calcular</button>
               <p id="CC1"></p>
            </div>
    </div>
    <?php include("../php/pie.html"); ?>
    </div>
</body>
</html>
