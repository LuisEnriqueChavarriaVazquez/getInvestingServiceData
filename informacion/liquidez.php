<!--

    liquidez.php
    Página informativa sobre la medida de liquidez

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
	<title>Índices de liquidez</title>
    <script>
        function calcularRL(){

            var MU=Number(document.getElementById("AC1").value)/Number(document.getElementById("PC1").value);
            document.getElementById("RL1").innerHTML="Razón de liquidez = "+MU+" veces";
        }
        function calcularPA(){

            var MU=(Number(document.getElementById("AC2").value)-Number(document.getElementById("I").value))/Number(document.getElementById("PC2").value);
            document.getElementById("PA1").innerHTML="Prueba del ácido = "+MU+" veces";
        }
        function calcularCT(){

            var MU=Number(document.getElementById("AC3").value)-Number(document.getElementById("PC3").value);
            document.getElementById("CT1").innerHTML="Capital de trabajo = "+MU+" unidades monetarias";
        }
         function calcularCO(){

            var MU=(Number(document.getElementById("RI").value)+Number(document.getElementById("RCC").value))-Number(document.getElementById("RCP").value);
            document.getElementById("CO1").innerHTML="Ciclo operativo = "+MU+" días";
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
        <h1>Índices de liquidez</h1>
        <p>Indican la capacidad que tiene la empresa para cumplir con sus obligciones en el corto plazo a medida que se van venciendo, o sea, la capacidad que tienen para convertir el activo circulante en dinero.</p>
        <h2>Razón de liquidez <small class="cantidad linkTitulo"><a onClick="mostrar('RL');">Calculadora de razón de liquidez</a></small></h2>
            <p>También llamada razón circulante o razón corriente, indica el número de veces que con el activo circulante se puede pagar el pasivo circulante.</p>
            \[\text"Razón de liquidez" = \text"Activo circulante" / \text"Pasivo circulante"\]
            <p>Esta razón significa que, por cada unidad monetaria que la empresa debe a corto plazo, se tienen X unidades para pagar.</p>
            <p>Si la razón es mayor a uno, se puede decir que sí hay liquidez.</p>
            <div id="RL" style="display: none;">
                Activo circulante = <input id="AC1"/>
                Pasivo circulante = <input id="PC1"/>
                <button value="Calcular" onClick="calcularRL();">Calcular</button>
               <p id="RL1"></p>
            </div>
        <h2>Prueba del ácido<small class="cantidad linkTitulo"><a onClick="mostrar('PA');">Calculadora de razón de liquidez</a></small></h2>
            <p>También llamda razón de liquidez inmediata, es una medición más estricta de la liquidez de una empresa que la razón circulante. Indica qué tanto se pueden pagar las obligaciones en el corto plazo sin tener que convertir los inventarios en efectivo inmediatamente. </p>
            \[\text"Prueba del ácido" = \text"Activo circulante - Inventario" / \text"Pasivo circulante"\]
            <p>Al activo circulante se le quitan los inventarios por tratarse del activo menos líquido, de esta manera se sabe  que tanta liquidez tiene una empresa sin recurrir a la venta de sus inventarios.</p>
            <div id="PA" style="display: none;">
                Activo circulante = <input id="AC2"/>
                Inventario = <input id="I"/>
                Pasivo circulante = <input id="PC2"/>
                <button value="Calcular" onClick="calcularPA();">Calcular</button>
               <p id="PA1"></p>
            </div>
        <h2>Capital de trabajo<small class="cantidad linkTitulo"><a onClick="mostrar('CT');">Calculadora de capital de trabajo</a></small></h2>
            <p>Se llama capital de trabajo al dinero que tiene la empresa para poder operar adecuadamente.Expresa en términos monetarios el valor que le quedaría a la empresa después de pagar todos sus pasivos a corto plazo, en el caso de que tuvieran que ser pagados de inmediato.</p>
            \[\text"Capital de trabajo" = \text"Activo circulante" - \text"Pasivo circulante"\]
            <p>Si la diferencia da un número positivo, la empresa tiene un superávit e indica un buen funcionamiento; de lo contrario, tiene un déficit e indica un mal funcionamiento.</p>
            <div id="CT" style="display: none;">
                Activo circulante = <input id="AC3"/>
                Pasivo circulante = <input id="PC3"/>
                <button value="Calcular" onClick="calcularCT();">Calcular</button>
               <p id="CT1"></p>
            </div>
        <h2>Ciclo operativo<small class="cantidad linkTitulo"><a onClick="mostrar('CO');">Calculadora de ciclo operativo</a></small></h2>
            <p>También llamado ciclo de conversión de efectivo, demuestra la efectividad en la que la compañía transforma sus inventarios en ventas y las ventas en efectivo para poder pagar a sus proveedores y acreedores</p>
            \[\text"Ciclo operativo" = \text"RI" + \text"RCC" -\text"RCP"\]
            <p>Donde<br />
                &nbsp RI=Rotación de inventarios<br />
                &nbsp RCC= Rotación de cuentas por cobrar<br />
                &nbsp RCP= Rotación de cuentas por pagar</p>
            <div id="CO" style="display: none;">
                Rotación de inventarios = <input id="RI"/>
                Rotación de cuentas por cobrar = <input id="RCC"/>
                Rotación de cuentas por pagar = <input id="RCP"/>
                <button value="Calcular" onClick="calcularCO();">Calcular</button>
               <p id="CO1"></p>
            </div>
    </div>
    <?php include("../php/pie.html"); ?>
    </div>
</body>
