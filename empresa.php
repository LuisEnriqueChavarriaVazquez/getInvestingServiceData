<!--

    empresa.php
    Plantilla para páginas de empresas.

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

<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <?php
            include("nucleo.php");
            $indice = json_decode($_SESSION['indice']);
            $nombre = urldecode($_GET['id']);
            $empresa = null;
            foreach($indice as $i => $elemento){
                if($elemento->nombre == $nombre){
                    $empresa = new empresa($elemento->archivo);
                    break;
                }
            }
            echo "<title>{$empresa->nombre}</title>\n";
            include("php/links.html");
        ?>
    </head>
    <body class="conImagen">
        <div class="pantalla">
        <?php include("php/encabezado.php"); ?>
        <div class="container" style="margin-top: 50px">
            <?php
                echo "<h1 id='tituloEmpresa' align='center'>{$empresa->datos->nombre}</h1>\n";
                echo "<div class='text-center' id='contenedorLogo'>\n";
                //echo "  <img alt='Logo' class='img-rounded' src=''><br>\n";
                $request = urlencode($empresa->datos->nombre);
                echo "  <button type='button' class='btn btn-default' ><a href='agregar.php?nombre={$request}'>Editar registro</a></button>";
                echo "</div>\n";
            ?>
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <h2 class="izquierda">Datos financieros</h2>
                    <h4>Principales cuentas del estado de situación financiera al <?php $fecha = date("d/m/Y"); echo "<em>$fecha</em>"; ?></h4>
                    <div class="panel panel-default">
                        <div class="panel-heading"><b>Activos</b></div>
                        <div class="panel-body">
                            <dl>
                                <dt>Circulante</dt>
                                <?php
                                    if(!function_exists('formato')){
                                        function formato($numero, $decimales){
                                            if($numero<0){
                                                $numero*=-1;
                                                $formato=number_format($numero, $decimales);
                                                $formato="({$formato})";
                                                return $formato;
                                            }
                                            else{
                                                $formato=number_format($numero, $decimales);
                                                return $formato;
                                            }
                                        }
                                    }
                                    $num_formato = formato($empresa->datos->activo->circulante->cuentas_por_cobrar->final,2);
                                    echo "<dd class='nivel1'>Cuentas por cobrar <span class='cantidad'><em>{$num_formato}</em></span></dd>";
                                    $num_formato = formato($empresa->datos->activo->circulante->inventarios->final,2);
                                    echo "<dd class='nivel1'>Inventarios <span class='cantidad'><em>{$num_formato}</em></span></dd>";
                                    $num_formato = formato($empresa->datos->activo->circulante->total,2);
                                    echo "<dd class='nivel1 fin'>Total activo circulante <span class='cantidad'><em>{$num_formato}</em></span></dd>";
                                    echo "<dt>No circulante</dt>";
                                    $num_formato = formato($empresa->datos->activo->no_circulante->total,2);
                                    echo "<dd class='nivel1 fin'>Total activo no circulante <span class='cantidad'><em>{$num_formato}</em></span></dd>";
                                    $num_formato = formato($empresa->datos->activo->total,2);
                                    echo "<dt>Total activo <span class='cantidad'><em>{$num_formato}</em></span></dt>";
                                ?>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2"></div>
            </div>
            <div class="row">
                <div class="col-lg-2"></div>
                <div class='col-lg-8'>
                    <div class='panel panel-default'>
                        <div class='panel-heading'><b>Pasivos</b></div>
                        <div class='panel-body'>
                            <dl>
                                <?php
                                    echo "<dt>A corto plazo</dt>";
                                    $num_formato = formato($empresa->datos->pasivo->a_corto_plazo->cuentas_por_pagar->final,2);
                                    echo "    <dd class='nivel1'>Cuentas por pagar <span class='cantidad'><em>{$num_formato}</em></span></dd>";
                                    $num_formato = formato($empresa->datos->pasivo->a_corto_plazo->total,2);
                                    echo "    <dd class='nivel1 fin'>Total pasivo a corto plazo <span class='cantidad'><em>{$num_formato}</em></span></dd>";
                                    echo "<dt>A largo plazo</dt>";
                                    $num_formato = formato($empresa->datos->pasivo->a_largo_plazo->total,2);
                                    echo "    <dd class='nivel1 fin'>Total pasivo a largo plazo <span class='cantidad'><em>{$num_formato}</em></span></dd>";
                                    $num_formato = formato($empresa->datos->pasivo->total,2);
                                    echo "<dt>Total pasivo <span class='cantidad'><em>{$num_formato}</em></span></dt>";
                                ?>
                            </dl>
                        </div>
                    </div>
                    <div class='panel panel-default'>
                        <div class='panel-heading'><b>Capital contable</b></div>
                        <div class='panel-body'>
                            <dl>
                                <?php
                                    $num_formato = formato($empresa->datos->capital_contable->total,2);
                                    echo "<dt>Total capital contable <span class='cantidad'><em>{$num_formato}</em></span></dt>";
                                ?>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class='col-lg-2'></div>
            </div>
            <div class="row" style="margin-top: 25px">
                <div class='col-lg-2'></div>
                <div class='col-lg-8'>
                    <h4>Principales cuentas del estado de resultados integral del <?php $fecha = date("Y"); echo "<em>01/01/$fecha</em>"; ?> al <?php $fecha = date("d/m/Y"); echo "<em>$fecha</em>"; ?></h4>
                    <div class='panel panel-default'>
                        <div class='panel-heading'><b>Resultados Integrales</b></div>
                        <div class='panel-body'>
                            <dl>
                                <?php
                                    $num_formato = formato($empresa->datos->ventas_netas,2);
                                    echo "<dd>Ventas netas <span class='cantidad'><em>{$num_formato}</em></span></dd>";
                                    $num_formato = formato($empresa->datos->costo_de_ventas,2);
                                    echo "<dd>Costo de ventas <span class='cantidad'><em>({$num_formato})</em></span></dd>";
                                    $num_formato = formato($empresa->datos->utilidad_de_operacion,2);
                                    echo "<dd>Utilidad de operacion <span class='cantidad'><em>{$num_formato}</em></span></dd>";
                                    $num_formato = formato($empresa->datos->intereses,2);
                                    echo "<dd>Intereses devengados <span class='cantidad'><em>{$num_formato}</em></span></dd>";
                                    $num_formato = formato($empresa->datos->utilidad_neta,2);
                                    echo "<dt>Utilidad neta <span class='cantidad'><em>{$num_formato}</em></span></dt>";
                                ?>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class='col-lg-2'></div>
            </div>

            <!-- Sección de Razónes -->
            <div class="row" style="margin-top: 50px">
                <div class='col-sm-2'></div>
                <div class='col-sm-8'><h2>Razones simples</h2></div>
                <div class='col-sm-2'></div>
            </div>

            <!-- Rentabilidad -->
            <div class="row">
                <div class='col-sm-2'></div>
                <div class="col-sm-8">
                    <h3 class="grupoIndices">Índices de Rentabilidad <small class="cantidad parche"><a target="_self" href="informacion/rentabilidad.php">Información</a> | <a target="_self" href="rankings/rentabilidad.php">Ranking</a></small></h3>
                    <ul class="list-group listaIndices">
                        <li class="list-group-item"><span class="badge"><?php echo "{$empresa->datos->razones->rentabilidad->margenUtilidad} %"; ?></span> Margen de utilidad:</li>
                        <li class="list-group-item"><span class="badge"><?php echo "{$empresa->datos->razones->rentabilidad->retornoSobreActivos} %"; ?></span> Rendimiento sobre activos totales:</li>
                        <li class="list-group-item"><span class="badge"><?php echo "{$empresa->datos->razones->rentabilidad->retornoSobreCC} %"; ?></span> Rendimiento sobre el capital contable:</li>
                        <li class="list-group-item"><span class="badge"><?php echo "{$empresa->datos->razones->rentabilidad->calificacion} puntos"; ?></span><b>Calificación de rentabilidad:</b></li>
                    </ul>
                </div>
                <div class='col-sm-2'></div>
            </div>

            <!-- Liquidez -->
            <div class="row">
                <div class='col-sm-2'></div>
                <div class="col-sm-8">
                    <h3>Índices de Liquidez <small class="cantidad parche"><a target="_self" href="informacion/liquidez.php">Información</a> | <a target="_self" href="rankings/liquidez.php">Ranking</a></small></h3>
                    <ul class="list-group listaIndices">
                        <li class="list-group-item"><span class="badge"><?php echo "{$empresa->datos->razones->liquidez->razonLiquidez} veces"; ?></span> Razón de liquidez:</li>
                        <li class="list-group-item"><span class="badge"><?php echo "{$empresa->datos->razones->liquidez->pruebaAcido} veces"; ?></span> Prueba del ácido:</li>
                        <li class="list-group-item"><span class="badge"><?php echo "{$empresa->datos->razones->liquidez->calificacion} puntos"; ?></span> <b>Calificación de liquidez:</b></li>
                    </ul>
                </div>
                <div class='col-sm-2'></div>
            </div>

            <!-- Endeudamiento -->
            <div class="row">
                <div class='col-sm-2'></div>
                <div class="col-sm-8">
                    <h3>Índices de Endeudamiento <small class="cantidad parche"><a target="_self" href="informacion/endeudamiento.php">Información</a> | <a target="_self" href="rankings/endeudamiento.php">Ranking</a></small></h3>
                    <ul class="list-group listaIndices">
                        <li class="list-group-item"><span class="badge"><?php echo "{$empresa->datos->razones->endeudamiento->apalancamiento} %"; ?></span> Apalancamiento:</li>
                        <li class="list-group-item"><span class="badge"><?php echo "{$empresa->datos->razones->endeudamiento->coberturaIntereses} veces"; ?></span> Razón de cobertura de intereses:</li>
                        <li class="list-group-item"><span class="badge"><?php echo "{$empresa->datos->razones->endeudamiento->calificacion} puntos"; ?></span> <b>Calificación de endeudamiento: </b></li>
                    </ul>
                </div>
                <div class='col-sm-2'></div>
            </div>

            <!-- Rotación -->
            <div class="row">
                <div class='col-sm-2'></div>
                <div class="col-sm-8">
                    <h3>Rotación de activos <small class="cantidad parche"><a target="_self" href="informacion/rotacion.php">Información</a> | <a target="_self" href="rankings/rotacion.php">Ranking</a></small></h3>
                    <ul class="list-group listaIndices">
                        <li class="list-group-item"><span class="badge"><?php echo "{$empresa->datos->razones->rotaciones->rotacionCuentasPorCobrar} días"; ?></span> Rotación de cuentas por cobrar:</li>
                        <li class="list-group-item"><span class="badge"><?php echo "{$empresa->datos->razones->rotaciones->rotacionCuentasPorPagar} días"; ?></span> Rotación de cuentas por pagar:</li>
                        <li class="list-group-item"><span class="badge"><?php echo "{$empresa->datos->razones->rotaciones->rotacionInventarios} días"; ?></span> Rotación de inventarios:</li>
                        <li class="list-group-item"><span class="badge"><?php echo "{$empresa->datos->razones->rotaciones->rotacionActivosFijos} veces"; ?></span> Rotación de activos fijos:</li>
                        <li class="list-group-item"><span class="badge"><?php echo "{$empresa->datos->razones->rotaciones->rotacionActivosTotales} veces"; ?></span> Rotación de activos totales:</li>
                        <li class="list-group-item"><span class="badge"><?php echo "{$empresa->datos->razones->rotaciones->calificacion} puntos"; ?></span> <b>Calificación de rotaciones: </b></li>
                    </ul>
                </div>
                <div class='col-sm-2'></div>
            </div>
        </div>
        <?php
            include("php/pie.html");
        ?>
    </div>
    </body>
</html>
