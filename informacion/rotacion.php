<!--

    rotacion.php
    Página informativa sobre la medida de rotacion

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
	<title>Índices de rotación</title>
    <script>
        function calcularRCC(){
            var MU=((Number(document.getElementById("CCI").value)+Number(document.getElementById("CCF").value))/2) / (Number(document.getElementById("VN").value)/Number(document.getElementById("DP").value));

            document.getElementById("RCC1").innerHTML="Rotación de cuentas por cobrar = "+MU+" días";
        }
        function calcularRI(){
            var MU=((Number(document.getElementById("IIP").value)+Number(document.getElementById("IFP").value))/2) / (Number(document.getElementById("CV").value)/Number(document.getElementById("DP1").value));

            document.getElementById("RI1").innerHTML="Rotación de inventarios = "+MU+" días";
        }
        function calcularRAF(){
            var MU=Number(document.getElementById("VN1").value)/Number(document.getElementById("AFN").value);
            document.getElementById("RAF1").innerHTML="Rotación de activos fijos = "+MU+" veces";
        }
        function calcularRAT(){
            var MU=Number(document.getElementById("VN2").value)/Number(document.getElementById("AT").value);
            document.getElementById("RAT1").innerHTML="Rotación de activos totales = "+MU+" veces";
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
    <div class="container"  style="margin-top: 50px">
        <h1>Índices de rotación</h1>
        <p>Indican cuánto ha invertido una empresa en un determinado activo o grupo de estos, en relación con el ingreso que produce. En general, estas razones miden la eficiencia de una empresa para administrar y utilizar sus activos.</p>

            <h2>Rotación de cuentas por cobrar<small class="cantidad linkTitulo"><a onClick="mostrar('RCC');">Calculadora de rotación de cuentas por cobrar</a></small></h2>
                <p>Demuestra el número de días en promedio que la empresa tarda en cobrar a sus deudores, o sea, el tiempo en el que convierte sus cuentas por cobrar en efectivo.</p>
                \[\text"Rotación de cuentas por cobrar" = (\text"Cuentas por cobrar al incio + Cuentas por cobrar al final del periodo" / \text"2")/(\text"Ventas netas"/\text"Duración del periodo en días")\]
                 <div id="RCC" style="display: none;">
                    Cuentas por cobrar al inicio = <input id="CCI"/>
                    Ventas netas = <input id="VN"/><br />
                    Cuentas por cobrar al final = <input id="CCF"/>
                    Duración del periodo = <input id="DP"/>
                    <button value="Calcular" onClick="calcularRCC();">Calcular</button>
                    <p id="RCC1"></p>
                </div>
            <h2>Rotación de inventarios<small class="cantidad linkTitulo"><a onClick="mostrar('RI');">Calculadora de rotación de inventarios</a></small></h2>
                <p>Permite observar el tiempo que tarda en sustituirse el inventario antiguo por uno nuevo. Esta razón se mide en días.</p>
                \[\text"Rotación de inventarios" = (\text"Inventario inicial del periodo + inventario al final del periodo" / \text"2")/(\text"Costo de ventas"/\text"Duración del periodo en días")\]
                <p>No es conveniente mantener por mucho tiempo los inventarios por los costos que esto implica.</p>
                <p>La actividad que realiza la empresa es un factor determinante para establecer el ciclo y considerarlo adecuado, una empresa dedicada a la fabricación de bienes tendrá un un ciclo económico lento, mientras que una empresa dedicada a la comercialiación de productos de consumo generalizado tendrá una rotación de inventarios ágil.</p>
                <div id="RI" style="display: none;">
                    Inventario al inicio = <input id="IIP"/>
                    Costo de ventas = <input id="CV"/><br />
                    Inventario al final = <input id="IFP"/>
                    Duración del periodo = <input id="DP1"/>
                    <button value="Calcular" onClick="calcularRI();">Calcular</button>
                    <p id="RI1"></p>
                </div>
            <h2>Rotación de activos fijos<small class="cantidad linkTitulo"><a onClick="mostrar('RAF');">Calculadora de rotación de activos fijos</a></small></h2>
                <p>Mide la eficacia de la empresa para utilizar su planta y equipo (activos fijos) y ayudar a generar ventas. Puede utilizarse como índice de orientación para determinar el exceso de inversión en activo fijo o la insuficiencia de ventas.</p>
                \[\text"Rotación de activos fijos" = \text"Ventas netas" / \text"Activo fijo neto"\]
                <p>Puede interpretarse como: por cada unidad monetaria de activo fijo se generan X unidades de ventas.</p>
                <div id="RAF" style="display: none;">
                    Ventas netas = <input id="VN1"/>
                    Activo fijo neto = <input id="AFN"/>
                    <button value="Calcular" onClick="calcularRAF();">Calcular</button>
                    <p id="RAF1"></p>
                </div>
            <h2>Rotación de activos totales<small class="cantidad linkTitulo"><a onClick="mostrar('RAT');">Calculadora de rotación de activos totales</a></small></h2>
                <p>Esta razón financiera es muy útil para la empresa, pues indica si es productiva o no, de acuerdo con los activos que se tienen en la entidad. Esta razón mide la eficacia de la empresa al utilizar su activo total y así contribuir a generar un mayor nivel de ventas.</p>
                \[\text"Rotación de activos totales" = \text"Ventas netas" / \text"Activo total"\]
                <p>Cuando el resultado es menor a 1.0 significa que no se vendió ni siquiera una vez el valor de los activos, lo que quiere decir que la empresa tiene activos subutilizados o que no están generando ningún valor, por lo que debe decidirse qué hacer con ellos, hacerlos productivos o desecharlos y venderlos.</p>
                <p>Es importante considerar que el resultado variará de acuerdo con la actividad que desarrolle la empresa, ya que una unidad económica del ramo industrial tendrá una fuerte inversión en activos fijos y una comercial su mayor inversión radicará en activos circulantes.</p>
                <div id="RAT" style="display: none;">
                    Ventas netas = <input id="VN2"/>
                    Activo total = <input id="AT"/>
                    <button value="Calcular" onClick="calcularRAT();">Calcular</button>
                    <p id="RAT1"></p>
                </div>
        </div>
        <?php include("../php/pie.html"); ?>
	</div>
</body>
</html>
