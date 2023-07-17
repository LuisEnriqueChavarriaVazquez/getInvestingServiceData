<?php

   /*
    * insertar.php
    * Script para insertar una empresa en el ranking.
    *
	* Copyright (C) 2017 Ricardo Quezada Figueroa
	*
	* This program is free software: you can redistribute it and/or modify
	* it under the terms of the GNU General Public License as published by
	* the Free Software Foundation, either version 3 of the License, or
	* (at your option) any later version.
	*
	* This program is distributed in the hope that it will be useful,
	* but WITHOUT ANY WARRANTY; without even the implied warranty of
	* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	* GNU General Public License for more details.
	*
	* You should have received a copy of the GNU General Public License
	* along with this program.  If not, see <http://www.gnu.org/licenses/>.
	*/

    session_start();
	$nuevaEmpresa = new stdClass();
	$nuevaEmpresa->razones = new stdClass();
	$nuevaEmpresa->razones->rentabilidad = new stdClass();
	$nuevaEmpresa->razones->liquidez = new StdClass();
	$nuevaEmpresa->razones->endeudamiento = new StdClass();
	$nuevaEmpresa->razones->rotaciones = new StdClass();
	$nuevaEmpresa->activo = new stdClass();
	$nuevaEmpresa->activo->circulante = new stdClass();
	$nuevaEmpresa->activo->circulante->cuentas_por_cobrar = new StdClass();
	$nuevaEmpresa->activo->circulante->inventarios = new StdClass();
	$nuevaEmpresa->activo->no_circulante = new stdClass();
	$nuevaEmpresa->pasivo = new StdClass();
	$nuevaEmpresa->pasivo->a_corto_plazo = new StdClass();
	$nuevaEmpresa->pasivo->a_largo_plazo = new StdClass();
	$nuevaEmpresa->pasivo->a_corto_plazo->cuentas_por_pagar = New StdClass();
	$nuevaEmpresa->capital_contable = new StdClass();

    if(isset($_POST['nombre'])){
        $nuevaEmpresa->nombre = strtoupper($_POST['nombre']);
        foreach($_POST as $parametro => $valor){
            if($parametro == "nombre"){
                continue;
            }
            eval('$nuevaEmpresa->' . $parametro . '= $valor;');
        }
    }else{
        $nuevaEmpresa->nombre = strtoupper($fragmentos['nombre']);
        foreach($fragmentos as $parametro => $valor){
            if($parametro == "nombre"){
                continue;
            }
			eval('$nuevaEmpresa->' . $parametro . '= $valor;');
        }
    }

    //Cálculo de razones
	$infinito = 1000;
    //Cálculo de rentabilidad
	if ($nuevaEmpresa->ventas_netas != 0)
    	$nuevaEmpresa->razones->rentabilidad->margenUtilidad = round($nuevaEmpresa->utilidad_neta*100/$nuevaEmpresa->ventas_netas, 2);
	else
		$nuevaEmpresa->razones->rentabilidad->margenUtilidad = $infinito;

	if ($nuevaEmpresa->capital_contable->total != 0)
    	$nuevaEmpresa->razones->rentabilidad->retornoSobreCC = round($nuevaEmpresa->utilidad_neta*100/$nuevaEmpresa->capital_contable->total, 2);
	else
		$nuevaEmpresa->razones->rentabilidad->retornoSobreCC = $inifinito;

	if ($nuevaEmpresa->activo->total != 0)
    	$nuevaEmpresa->razones->rentabilidad->retornoSobreActivos = round($nuevaEmpresa->utilidad_neta*100/$nuevaEmpresa->activo->total, 2);
	else
		$nuevaEmpresa->razones->rentabilidad->retornoSobreActivos = $infinito;

    //correcciones
    if($nuevaEmpresa->razones->rentabilidad->retornoSobreCC > 100){
        $nuevaEmpresa->razones->rentabilidad->retornoSobreCC = 100;
    }
    if($nuevaEmpresa->capital_contable->total == 0.00001){
        $nuevaEmpresa->razones->rentabilidad->retornoSobreCC = 0;
    }

    //Cálculo de liquidez
	if ($nuevaEmpresa->pasivo->a_corto_plazo->total != 0){
    	$nuevaEmpresa->razones->liquidez->razonLiquidez = round($nuevaEmpresa->activo->circulante->total/$nuevaEmpresa->pasivo->a_corto_plazo->total, 2);
		$nuevaEmpresa->razones->liquidez->pruebaAcido = round(($nuevaEmpresa->activo->circulante->total - $nuevaEmpresa->activo->circulante->inventarios->final)/$nuevaEmpresa->pasivo->a_corto_plazo->total, 2);
	}else{
		$nuevaEmpresa->razones->liquidez->razonLiquidez = $infinito;
		$nuevaEmpresa->razones->liquidez->pruebaAcido = $infinito;
	}

    //Correcciones
    if($nuevaEmpresa->pasivo->a_corto_plazo->total == 0.00001){
        $nuevaEmpresa->razones->liquidez->razonLiquidez = 1;
        $nuevaEmpresa->razones->liquidez->pruebaAcido = 1;
    }

    //Cálculo de endeudamiento
	if ($nuevaEmpresa->activo->total != 0)
    	$nuevaEmpresa->razones->endeudamiento->apalancamiento = round($nuevaEmpresa->pasivo->total*100/$nuevaEmpresa->activo->total, 2);    //Entre más cerca de 50, mejor.
		else
		$nuevaEmpresa->razones->endeudamiento->apalancamiento = $infinito;

    if($nuevaEmpresa->razones->endeudamiento->apalancamiento > 50){             //apalancamientoAux es
        $nuevaEmpresa->razones->endeudamiento->apalancamientoAux = 100.00 - $nuevaEmpresa->razones->endeudamiento->apalancamiento;                  //el que se compara
    }else{
        $nuevaEmpresa->razones->endeudamiento->apalancamientoAux = $nuevaEmpresa->razones->endeudamiento->apalancamiento;
    }
	if($nuevaEmpresa->intereses == 0){
		$nuevaEmpresa->razones->endeudamiento->coberturaIntereses = $infinito;
	}else{
    	$nuevaEmpresa->razones->endeudamiento->coberturaIntereses = round($nuevaEmpresa->utilidad_de_operacion/$nuevaEmpresa->intereses, 2);
	}

    //Cálculo de rotaciones
	$divisor = $nuevaEmpresa->ventas_netas * 2;
	if ($divisor != 0){
    	$nuevaEmpresa->razones->rotaciones->rotacionCuentasPorCobrar = round(($nuevaEmpresa->activo->circulante->cuentas_por_cobrar->inicio + $nuevaEmpresa->activo->circulante->cuentas_por_cobrar->final)*365/$divisor, 2);
		$nuevaEmpresa->razones->rotaciones->rotacionCuentasPorPagar = round(($nuevaEmpresa->pasivo->a_corto_plazo->cuentas_por_pagar->inicio + $nuevaEmpresa->pasivo->a_corto_plazo->cuentas_por_pagar->final)*365/$divisor, 2);
	}else{
		$nuevaEmpresa->razones->rotaciones->rotacionCuentasPorCobrar = $infinito;
		$nuevaEmpresa->razones->rotaciones->rotacionCuentasPorPagar = $infinito;
	}

    $divisor = $nuevaEmpresa->costo_de_ventas * 2;
	if ($divisor != 0)
    	$nuevaEmpresa->razones->rotaciones->rotacionInventarios = round(($nuevaEmpresa->activo->circulante->inventarios->inicio + $nuevaEmpresa->activo->circulante->inventarios->final)*365/$divisor, 2);
	else
		$nuevaEmpresa->razones->rotaciones->rotacionInventarios = $infinito;

	if ($nuevaEmpresa->activo->total != 0)
    	$nuevaEmpresa->razones->rotaciones->rotacionActivosTotales = round($nuevaEmpresa->ventas_netas/$nuevaEmpresa->activo->total, 2);
	else
		$nuevaEmpresa->razones->rotaciones->rotacionActivosTotales = $infinito;

	if ($nuevaEmpresa->activo->no_circulante->total != 0)
    	$nuevaEmpresa->razones->rotaciones->rotacionActivosFijos = round($nuevaEmpresa->ventas_netas/$nuevaEmpresa->activo->no_circulante->total, 2);
	else
		$nuevaEmpresa->razones->rotaciones->rotacionActivosFijos = $infinito;

    //Calificaciones por grupo
    $nuevaEmpresa->razones->rentabilidad->calificacion = round(($nuevaEmpresa->razones->rentabilidad->margenUtilidad + $nuevaEmpresa->razones->rentabilidad->retornoSobreActivos + $nuevaEmpresa->razones->rentabilidad->retornoSobreCC)/3,2);
    $nuevaEmpresa->razones->liquidez->calificacion = round(($nuevaEmpresa->razones->liquidez->razonLiquidez + $nuevaEmpresa->razones->liquidez->pruebaAcido)/0.2,2);
    $nuevaEmpresa->razones->endeudamiento->calificacion = round(($nuevaEmpresa->razones->endeudamiento->apalancamiento)/10,2);
    $nuevaEmpresa->razones->rotaciones->calificacion = round((((360*3) - $nuevaEmpresa->razones->rotaciones->rotacionCuentasPorCobrar - $nuevaEmpresa->razones->rotaciones->rotacionCuentasPorPagar - $nuevaEmpresa->razones->rotaciones->rotacionInventarios)/100 + $nuevaEmpresa->razones->rotaciones->rotacionActivosFijos + $nuevaEmpresa->razones->rotaciones->rotacionActivosTotales),2);

    //Calificación general
    $nuevaEmpresa->razones->calificacion = (4*$nuevaEmpresa->razones->rentabilidad->calificacion) + (2*$nuevaEmpresa->razones->endeudamiento->calificacion) + (1*$nuevaEmpresa->razones->rotaciones->calificacion)+(3*$nuevaEmpresa->razones->liquidez->calificacion);

    /*Ponderación:
    rentabilidad = 4 --> Había que cambiar el peso de rentabilidad de 5 a 4
    liquidez = 3
    endeudamiento = 2
    rotaciones =1
    */

    //agregar a indice
    //$indice = json_decode(file_get_contents("../datos/indice.json"));
    if(isset($_SESSION['indice'])){
        $indice = json_decode($_SESSION['indice']);
    }else{
        $indice = array();
    }
    $numero = count($indice);
    error_log("Bandera!, antes había $numero empresas\nEstoy insertando a $nuevaEmpresa->nombre");
    $bandera = true; $aux = 0;
    foreach($indice as $i => $elemento){
        if($elemento->nombre == $nuevaEmpresa->nombre){
            $bandera = false;
            $aux = $i;
            break;
        }
    }
    if($bandera){
        $indice[count($indice)]->nombre = $nuevaEmpresa->nombre;
        $indice[count($indice)-1]->archivo = "datos/" . urlencode(strtolower(str_replace(".","",str_replace(",","",str_replace(" ","",$nuevaEmpresa->nombre))))) . ".json";
        $nuevosDatos = json_encode($indice);
        //file_put_contents('../datos/indice.json', $nuevosDatos, LOCK_EX); //Escribir en el índice
        $_SESSION['indice'] = $nuevosDatos;
        $numero = count($indice);
        error_log("Bandera!, ahora hay $numero empresas\n");
    }

    //escribir archivo
    $nuevosDatos = json_encode($nuevaEmpresa, JSON_PRETTY_PRINT);
    if($bandera){
        file_put_contents('../' . $indice[count($indice) - 1]->archivo, $nuevosDatos, LOCK_EX);
    }else{
        file_put_contents('../' . $indice[$aux]->archivo, $nuevosDatos, LOCK_EX);
    }
    if(isset($_POST['nombre'])){
        header('Location: ../ranking.php');
    }

?>
