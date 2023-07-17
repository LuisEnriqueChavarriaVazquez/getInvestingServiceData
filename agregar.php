<!--

    agregar.php
    Página con formularios para agregar empresa al ranking

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
    include("nucleo.php");
    $bandera = false;
    $datos;
    $empresa;
    $indice = json_decode($_SESSION['indice']);
    if(isset($_GET['nombre'])){
        $bandera = true;
        foreach($indice as $i => $empresas){
            if($empresas->nombre == $_GET['nombre']){
                $empresa = new empresa($empresas->archivo);
                break;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="es">

    <head>
        <title>Agregar Empresa</title>
        <?php  include("php/links.html"); ?>
    </head>

    <script>

        function recalcular(){
            //TODO: Campos autorrellenados
        }

    </script>

</html>

 <body>
     <?php include("php/encabezado.php"); ?>
     <div class="container" style="margin-top: 50px">
     <form method="post" action="php/insertar.php" id="formulario">
         <?php
            if($bandera){
                echo "<h1>Editar Empresa</h1>";
                $request = urlencode($empresa->datos->nombre);
                echo "<button type='button' class='btn btn-default' style='margin-bottom: 30px' ><a href='php/borrar.php?nombre={$request}'>Borrar registro</a></button>";
            }else{
                echo "<h1>Agregar Empresa</h1>";
            }
         ?>
         <div class="form-group">
             <label for="usr">Nombre:</label>
             <input onchange="recalcular()" required name="nombre" type="text" class="form-control" id="usr"  <?php if($bandera){ echo "value='{$empresa->datos->nombre}'"; } ?> >
         </div>
         <!-- el logo que se agregue solo -->
         <div class="row">
             <div class="col-sm-4">
                 <h2>Activo</h2>
                 <h3>Circulante</h3>
                 <h4>Cuentas por cobrar</h4>
                 <div class="form-group">
                     <label for="activo->circulante->cuentas_por_cobrar->inicio">Al inicio:</label>
                     <input onchange="recalcular()" required name="activo->circulante->cuentas_por_cobrar->inicio" type="number" class="form-control" <?php if($bandera){ echo "value='{$empresa->datos->activo->circulante->cuentas_por_cobrar->inicio}'"; }else{ echo "value='0'"; } ?>>
                 </div>
                 <div class="form-group">
                     <label for="activo->circulante->cuentas_por_cobrar->final">Al final:</label>
                     <input onchange="recalcular()" required name="activo->circulante->cuentas_por_cobrar->final" type="number" class="form-control" <?php if($bandera){ echo "value='{$empresa->datos->activo->circulante->cuentas_por_cobrar->final}'"; }else{ echo "value='0'"; } ?>>
                 </div>
                 <h4>Inventarios</h4>
                 <div class="form-group">
                     <label for="activo->circulante->inventarios->inicio">Al inicio:</label>
                     <input onchange="recalcular()" required name="activo->circulante->inventarios->inicio" type="number" class="form-control" <?php if($bandera){ echo "value='{$empresa->datos->activo->circulante->inventarios->inicio}'"; }else{ echo "value='0'"; } ?>>
                 </div>
                 <div class="form-group">
                     <label for="activo->circulante->inventarios->final">Al final:</label>
                     <input onchange="recalcular()" required name="activo->circulante->inventarios->final" type="number" class="form-control" <?php if($bandera){ echo "value='{$empresa->datos->activo->circulante->inventarios->final}'"; }else{ echo "value='0'"; } ?>>
                 </div>
                 <div class="form-group">
                     <label for="activo->circulante->total">Total activo circulante:</label>
                     <input onchange="recalcular()" required name="activo->circulante->total" type="number" class="form-control" <?php if($bandera){ echo "value='{$empresa->datos->activo->circulante->total}'"; }else{ echo "value='0'"; } ?>>
                 </div>
                 <h3>No circulante</h3>
                 <div class="form-group">
                     <label for="activo->no_circulante->total">Total activo no circulante:</label>
                     <input onchange="recalcular()" required name="activo->no_circulante->total" type="number" class="form-control" <?php if($bandera){ echo "value='{$empresa->datos->activo->no_circulante->total}'"; }else{ echo "value='0'"; } ?>>
                 </div>
                 <div class="form-group">
                     <label for="activo->total">Total activo:</label>
                     <input onchange="recalcular()" required name="activo->total" type="number" class="form-control" <?php if($bandera){ echo "value='{$empresa->datos->activo->total}'"; }else{ echo "value='0'"; } ?>>
                 </div>
             </div>
             <div class="col-sm-4">
                 <h2>Pasivo</h2>
                 <h3>A corto plazo</h3>
                 <h4>Cuentas por pagar</h4>
                 <div class="form-group">
                     <label for="pasivo->a_corto_plazo->cuentas_por_pagar->inicio">Al inicio:</label>
                     <input onchange="recalcular()" required name="pasivo->a_corto_plazo->cuentas_por_pagar->inicio" type="number" class="form-control" <?php if($bandera){ echo "value='{$empresa->datos->pasivo->a_corto_plazo->cuentas_por_pagar->inicio}'"; }else{ echo "value='0'"; } ?>>
                 </div>
                 <div class="form-group">
                     <label for="pasivo->a_corto_plazo->cuentas_por_pagar->final">Al final:</label>
                     <input onchange="recalcular()" required name="pasivo->a_corto_plazo->cuentas_por_pagar->final" type="number" class="form-control" <?php if($bandera){ echo "value='{$empresa->datos->pasivo->a_corto_plazo->cuentas_por_pagar->final}'"; }else{ echo "value='0'"; } ?>>
                 </div>
                 <div>
                     <label for="pasivo->a_corto_plazo->total">Total pasivo a corto plazo:</label>
                     <input onchange="recalcular()" required name="pasivo->a_corto_plazo->total" type="number" class="form-control" <?php if($bandera){ echo "value='{$empresa->datos->pasivo->a_corto_plazo->total}'"; }else{ echo "value='0'"; } ?>>
                 </div>
                 <h3>A largo plazo</h3>
                 <div class="form-group">
                     <label for="pasivo->a_largo_plazo->total">Total pasivo a largo plazo:</label>
                     <input onchange="recalcular()" required name="pasivo->a_largo_plazo->total" type="number" class="form-control" <?php if($bandera){ echo "value='{$empresa->datos->pasivo->a_largo_plazo->total}'"; }else{ echo "value='0'"; } ?>>
                 </div>
                 <div class="form-group">
                     <label for="pasivo->total">Total pasivo:</label>
                     <input onchange="recalcular()" required name="pasivo->total" type="number" class="form-control" <?php if($bandera){ echo "value='{$empresa->datos->pasivo->total}'"; }else{ echo "value='0'"; } ?>>
                 </div>
                 <h2>Capital contable</h2>
                 <div class="form-group">
                     <label for="capital_contable->total">Total capital contable:</label>
                     <input onchange="recalcular()" required name="capital_contable->total" type="number" class="form-control" <?php if($bandera){ echo "value='{$empresa->datos->capital_contable->total}'"; }else{ echo "value='0'"; } ?>>
                 </div>
             </div>
             <div class="col-sm-4">
                 <h2>Resultados integrales</h2>
                 <div class="form-group">
                     <label for="ventas_netas">Ventas netas:</label>
                     <input onchange="recalcular()" required name="ventas_netas" type="number" class="form-control" <?php if($bandera){ echo "value='{$empresa->datos->ventas_netas}'"; }else{ echo "value='0'"; } ?>>
                 </div>
                 <div class="form-group">
                     <label for="costo_de_ventas">Costo de ventas:</label>
                     <input onchange="recalcular()" required name="costo_de_ventas" type="number" class="form-control" <?php if($bandera){ echo "value='{$empresa->datos->costo_de_ventas}'"; }else{ echo "value='0'"; } ?>>
                 </div>
                 <div class="form-group">
                     <label for="utilidad_de_operacion">Utilidad de operación:</label>
                     <input onchange="recalcular()" required name="utilidad_de_operacion" type="number" class="form-control" <?php if($bandera){ echo "value='{$empresa->datos->utilidad_de_operacion}'"; }else{ echo "value='0'"; } ?>>
                 </div>
                 <div class="form-group">
                     <label for="utilidad_neta">Utilidad neta:</label>
                     <input onchange="recalcular()" required name="utilidad_neta" type="number" class="form-control" <?php if($bandera){ echo "value='{$empresa->datos->utilidad_neta}'"; }else{ echo "value='0'"; } ?>>
                 </div>
                 <div class="form-group">
                     <label for="intereses">Intereses devengados:</label>
                     <input onchange="recalcular()" required name="intereses" type="number" class="form-control" <?php if($bandera){ echo "value='{$empresa->datos->intereses}'"; }else{ echo "value='0'"; } ?>>
                 </div>
             </div>
         </div>
         <input type="submit" class="btn btn-default" value="Enviar">
         </form>
     </div>
     <?php include("php/pie.html"); ?>
</body>
