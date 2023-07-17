<?php

   /*
    * nucleo.php
    * Clase de empresa. Datos obtenidos de investing.com
    * Operaciones de graficación y tabulación sobre las
    * distintas páginas.
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

    class empresa{

        public $nombre;
        public $datos;

        public function __construct($archivo){
            $this->datos = json_decode(file_get_contents($archivo));
            $this->nombre = $this->datos->nombre;
        }

        public function graficaHistorial($cuenta, $etiqueta, $unidad){

            $contenido = array();
            foreach($this->datos->datos as $i => $periodo){
                eval('$contenido[$i] = $periodo->' . $cuenta . ";");
            }

            $r = rand(0,255);
            $g = rand(0,255);
            $b = rand(0,255);

            echo "<h4 align='center'>Gráfica de $etiqueta de todos los periodos</h4>";
            echo "<canvas id='grafica$cuenta' class='graficaIndice'></canvas>\n<script>\n";
            echo "var ctx = document.getElementById('grafica$cuenta');\nvar data = {\nlabels: [";
            foreach(array_reverse($this->datos->datos) as $i => $periodo){
                if($i == 0){
                    echo "'$periodo->periodo'";
                }else{
                    echo ", '$periodo->periodo'";
                }
            }
            echo "],\n";
            echo "datasets: [{\nlabel: '$etiqueta',\nfill: false,\nlineTension: 0.1,\n";
            echo "backgroundColor: 'rgba($r,$g,$b,0.7)',\nborderColor: 'rgba($r,$g,$b,1.0)',\n";
            echo "borderCapStyle: 'butt',\nborderDash: [],\nborderDashOffset: 0.0,\nborderJoinStyle: 'miter',\n";
            echo "pointBorderColor: 'rgba($r,$g,$b,1.0)',\npointBackgroundColor: '#fff',\n";
            echo "pointBorderWidth: 1,\npointHoverRadius: 5,\n";
            echo "pointHoverBackgroundColor: 'rgba($r,$g,$b,0.8)',\npointHoverBorderColor: 'rgba($r,$g,$b,1.0)',\n";
            echo "pointHoverBorderWidth: 2,\npointRadius: 1,\npointHitRadius: 10,\ndata: [";
            foreach(array_reverse($contenido) as $i => $valor){
                if($i == 0){
                    echo "$valor";
                }else{
                    echo ", $valor";
                }
            }
            echo "]\n}\n]\n};\nnew Chart(ctx, {\ntype: 'line',\ndata: data,\noptions: {\n";
            echo "scales: {\nxAxes: [{\nscaleLabel: {\ndisplay: true,\nlabelString: 'Periodo'\n}\n}],\n";
            echo "yAxes: [{\nscaleLabel: {\ndisplay: true,\nlabelString: '$unidad'\n}\n}]\n}\n}\n});\n</script>\n";
        }

    }

    class ranking{

        public $nombre;
        public $datos;
        public $lista;
        public $unidad1;
        public $unidad2;

        public function __construct($empresas, $nombre, $datos, $sentido, $unidad1, $unidad2){
            $this->lista = array();
            $this->nombre = $nombre;
            $this->datos = $datos;
            $this->unidad1 = $unidad1;
            $this->unidad2 = $unidad2;
            foreach($empresas as $i => $empresa){
                eval('$this->lista["$empresa->nombre"] = $empresa->datos->' . $datos . ';');
            }
            if($sentido){
                arsort($this->lista);
            }else{
                asort($this->lista);
            }
        }

        public function tabla(){

            echo "<div class='table-responsive'>\n";
            echo "    <table class='table'>\n";
            echo "    <thead>\n";
            echo "        <tr>\n";
            echo "            <th>#</th>\n";
            echo "            <th>Empresa</th>\n";
            echo "            <th>$this->unidad1</th>\n";
            echo "        </tr>\n";
            echo "    </thead>\n";
            echo "    <tbody>\n";

            $j=1;
            foreach($this->lista as $i => $valor){
                echo "<tr>\n";
                echo "  <td>$j</td>\n";
                echo "  <td>$i</td>\n";
                if($this->unidad2 == "$"){
                    $temp = number_format($valor);
                    echo "  <td>$ $temp</td>\n";
                }else{
                    echo "  <td>$valor $this->unidad2</td>\n";
                }
                echo "</tr>\n";
                $j++;
            }

            echo "    </tbody>\n";
            echo "    </table>\n";
            echo "</div>\n";

        }

        public function grafica(){
            $r = rand(0,255);
            $g = rand(0,255);
            $b = rand(0,255);
            echo "<h4 align='center'>Gráfica de $this->nombre</h4>\n";
            echo "<canvas id='grafica{$this->datos}'></canvas>\n";
            echo "<script>\n";
            echo "var contenedor = document.getElementById('grafica{$this->datos}');\n";
            echo "var data = {\n";
            echo "labels: [";
            $j = 0;
            foreach($this->lista as $nombre => $valor){
                if($j == 0){
                    echo "'$nombre'";
                }else{
                    echo ", '$nombre'";
                }
                $j++;
            }
            echo "],\n";
            echo "datasets: [\n{\n";
            echo "label: '$this->nombre',\n";
            echo "scaleLabel: 'Prueba',\n";
            echo "backgroundColor: 'rgba($r, $g, $b, 0.8)',\n";
            echo "borderColor: 'rgb($r, $g, $b)',\n";
            echo "borderWidth: 1,\n";
            echo "hoverBackgroundColor: 'rgba($r, $g, $b, 1)',\n";
            echo "hoverBorderColor: 'rgb($r, $g, $b)' ,\n";
            echo "data: [";
            $j = 0;
            foreach($this->lista as $nombre => $valor){
                if($j == 0){
                    echo "$valor";
                }else{
                    echo ", $valor";
                }
                $j++;
            }
            echo "],\n}\n]\n};\n";
            echo "    new Chart(contenedor, {\n";
            echo "        type: 'bar',\n";
            echo "        data: data,\n";
            echo "        options: {\n";
            echo "            scales: {\n";
            echo "                    xAxes: [{\n";
            echo "                            stacked: true\n";
            echo "                    }],\n";
            echo "                    yAxes: [{\n";
            echo "                            stacked: true,\n";
            echo "                            scaleLabel: {\n";
            echo "                                display: true,\n";
            echo "                                labelString: '$this->unidad1'\n";
            echo "                            }\n";
            echo "                    }]\n";
            echo "                },\n";
            echo "                categoryPercentage: 0.3,\n";
            echo "                barPercentage: 0.3\n";
            echo "            }\n";
            echo "    });\n";
            echo "</script>\n";
        }

    }

?>
