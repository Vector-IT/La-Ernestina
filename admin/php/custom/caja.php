<?php
namespace VectorForms;

class Caja extends Tabla {
    public function listar($strFiltro = "", $conBotones = true, $btnList = [], $order = '')
    {
        global $config, $crlf;

        $strSQL = "SELECT NumeCaja, FechCaja, NombCaja, NumeTipoCaja, ImpoCaja, NumeEsta FROM caja";

        $tabla = $config->cargarTabla($strSQL);

        $strSalida = '';

        if ($tabla) {
            if ($tabla->num_rows > 0) {
                $strSalida.= $crlf.'<table class="table table-striped table-bordered table-hover table-condensed table-responsive">';

                $strSalida.= $crlf.'<tr>';
                $strSalida.= $crlf.'<th>Número</th>';
                $strSalida.= $crlf.'<th>Fecha</th>';
                $strSalida.= $crlf.'<th>Nombre</th>';
                $strSalida.= $crlf.'<th>Tipo de operación</th>';
                $strSalida.= $crlf.'<th>Estado</th>';
                $strSalida.= $crlf.'<th></th>';
                $strSalida.= $crlf.'</tr>';

                while ($fila = $tabla->fetch_assoc()) {
                    $col = 0;
                    
                    $strSalida.= $crlf.'<tr>';
                    
                    $strSalida.= $crlf.'<td id="NumeCaja'. $fila[$this->IDField].'">'.$fila['NumeCaja'].'</td>';
                    $strSalida.= $crlf.'<td id="FechCaja'. $fila[$this->IDField].'">'.$fila['FechCaja'].'</td>';
                    $strSalida.= $crlf.'<td id="NombCaja'. $fila[$this->IDField].'">'.$fila['NombCaja'].'</td>';
                    $strSalida.= $crlf.'<td id="NumeTipoCaja'. $fila[$this->IDField].'">'.$fila['NumeTipoCaja'].'</td>';
                    $strSalida.= $crlf.'<td id="NumeEsta'. $fila[$this->IDField].'">'.$fila['NumeEsta'].'</td>';

                    //Botones
                    if ($conBotones) {
                        //De clase
                        if (count($this->btnList) > 0) {
                            for ($I = 0; $I < count($this->btnList); $I++) {
                                $strSalida.= $crlf.'<td class="text-center"><button class="btn btn-sm '. $this->btnList[$I]['class'] .'" onclick="'. $this->btnList[$I]['onclick'] .'(\''.$fila[$this->IDField].'\')">'. $this->btnList[$I]['titulo'] .'</button></td>';
                            }
                        }

                        //Editar
                        if ($this->allowEdit) {
                            $strSalida.= $crlf.'<td class="text-center"><button class="btn btn-sm btn-info" onclick="editar'. $this->tabladb .'(\''.$fila[$this->IDField].'\')"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i> Editar</button></td>';
                        }
                        //Borrar
                        if ($this->allowDelete) {
                            $strSalida.= $crlf.'<td class="text-center"><button class="btn btn-sm btn-danger" onclick="borrar'. $this->tabladb .'(\''.$fila[$this->IDField].'\')"><i class="fa fa-trash-o fa-fw" aria-hidden="true"></i> Borrar</button></td>';
                        }
                    }

                    //Botones del método
                    if (count($btnList) > 0) {
                        for ($I = 0; $I < count($btnList); $I++) {
                            $strSalida.= $crlf.'<td class="text-center"><button class="btn btn-sm '. $btnList[$I]['class'] .'" onclick="'. $btnList[$I]['onclick'] .'(\''.$fila[$this->IDField].'\')">'. $btnList[$I]['titulo'] .'</button></td>';
                        }
                    }

                    $strSalida.= $crlf.'</tr>';
                }

                $strSalida.= $crlf.'</table>';
            } else {
                $strSalida.= "<h3>No hay datos para mostrar</h3>";
            }
            $tabla->free();
        } else {
            $strSalida.= "<h3>No hay datos para mostrar</h3>";
        }
            
        echo $strSalida;
    }
}
?>