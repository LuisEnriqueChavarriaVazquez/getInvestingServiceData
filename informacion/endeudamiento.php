<!--

    endeudamiento.php
    Página informativa sobre la medida de endeudamiento

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
	<meta charset="utf-8">
    <?php  include("../php/linksR.html"); ?>
	<link rel="stylesheet" href="../bibliotecas/mathscribe/jqmath-0.4.3.css">
	<script src="../bibliotecas/mathscribe/jquery-1.4.3.min.js"></script>
	<script src="../bibliotecas/mathscribe/jqmath-etc-0.4.3.min.js" charset="utf-8"></script>
	<title>Índices de endeudamiento</title>
    <script>
        function calcularA(){
            var MU=Number(document.getElementById("PT").value)/Number(document.getElementById("AT").value)*100;
            document.getElementById("A1").innerHTML="Apalancamiento = "+MU+"%";
        }
        function calcularCI(){
            var MU=Number(document.getElementById("UO").value)/Number(document.getElementById("I").value);
            document.getElementById("CI1").innerHTML="Razón de cobertura de intereses = "+MU+" veces";
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
        <h1>Índices de endeudamiento</h1>
        <p>Estos índices miden el grado de utilización que hace una empresa del apalancamiento financiero, es decir, indican el porcentaje de activos que son financiados por proveedores y acreedores. </p>
        <p> Pueden ayudar a establecer el riesgo que incurren los acreedores al otorgar un crédito, el riesgo de los dueños con relación a su inversión en la empresa y la conveniencia o inconveniencia de un determinado nivel de endeudamiento para la empresa.</p>
            <h2>Apalancamiento sobre activo total<small class="cantidad linkTitulo"><a onClick="mostrar('A');">Calculadora de apalancamiento</a></small></h2>
                <p>Indica el porcentaje del activo total que es financiado por proveedores y acreedores.</p>
                \[\text"Apalancamiento sobre activo total" = \text"Pasivo total" / \text"Deuda total"\]
                <p>Cuando la razón de apalancamiento es demasiado elevada, aumenta el riesgo de incumplimiento de las deudas y obligaciones por parte de la empresa.</p>
                <div id="A" style="display: none;">
                    Pasivo total = <input id="PT"/>
                    Activo total = <input id="AT"/>
                    <button value="Calcular" onClick="calcularA();">Calcular</button>
                    <p id="A1"></p>
                </div>
            <h2>Razón de cobertura de intereses<small class="cantidad linkTitulo"><a onClick="mostrar('CI');">Calculadora de razón de cobertura de intereses</a></small></h2>
                <p>Indica el número de veces que con la utilidad de operación la entidad puede pagar los intereses generados en el periodo.</p>
                \[\text"Razón de cobertura de intereses" = \text"Utilidad de operación" / \text"Intereses"\]
                 <p>Cuando la razón de cobertura de intereses cae por debajo de 1.0, la empresa se ve amenazada debido a su incapacidad para pagar los intereses a su vencimiento, lo cual la puede llevar a la bancarrota.</p>
                <div id="CI" style="display: none;">
                    Utilidad de operación = <input id="UO"/>
                    Intereses = <input id="I"/>
                    <button value="Calcular" onClick="calcularCI();">Calcular</button>
                    <p id="CI1"></p>
                </div>
        </div>
        <?php include("../php/pie.html"); ?>
	</div>
</body>
</html>
