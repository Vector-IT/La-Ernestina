<?php
namespace VectorForms;

class Caja extends Tabla {
    public function customFunc($post) {
        global $config;
		
		switch ($post['field']) {
			case "NumeEsta":
                return $config->ejecutarCMD("UPDATE caja SET NumeEsta = NOT NumeEsta WHERE NumeCaja = ". $post["dato"]["NumeCaja"]);
				break;
		}
    }

    public function listar($strFiltro = "", $conBotones = true, $btnList = [], $order = '')
    {
        global $config, $crlf;

        $strSQL = "SELECT c.NumeCaja, c.FechCaja, c.NombCaja, c.NumeTipoCaja, c.ImpoCaja, c.NumeEsta, c.NumeUser,";
        $strSQL.= $crlf." u.NombPers, tc.NombTipoCaja, tc.NumeTipoOper, e.NombEsta";
        $strSQL.= $crlf." FROM caja c";
        $strSQL.= $crlf." INNER JOIN usuarios u ON c.NumeUser = u.NumeUser";
        $strSQL.= $crlf." INNER JOIN tiposcaja tc ON c.NumeTipoCaja = tc.NumeTipoCaja";
        $strSQL.= $crlf." INNER JOIN estados e ON c.NumeEsta = e.NumeEsta";
        
        if ($strFiltro == "")
            $strSQL.= $crlf." WHERE c.FechCaja > DATE_ADD(SYSDATE(), INTERVAL -8 DAY)";

        $strSQL.= $crlf." ORDER BY c.NumeCaja DESC";

        $tabla = $config->cargarTabla($strSQL);

        $strSalida = '';

        $credito = $config->buscarDato("SELECT SUM(ImpoCaja) FROM caja WHERE NumeEsta = 1 AND NumeTipoCaja IN (SELECT NumeTIpoCaja FROM tiposcaja WHERE NumeTipoOper = 1)");
        $debito = $config->buscarDato("SELECT SUM(ImpoCaja) FROM caja WHERE NumeEsta = 1 AND NumeTipoCaja IN (SELECT NumeTIpoCaja FROM tiposcaja WHERE NumeTipoOper = 2)");
        $saldo = floatval($credito) - floatval($debito);

        if ($saldo >= 0) {
            $strSalida.= $crlf.'<h4 id="txtSaldo" class="well well-sm text-right">Saldo: $ '.$saldo.'</h4>';
        }
        else {
            $strSalida.= $crlf.'<h4 id="txtSaldo" class="well well-sm text-right">Saldo: <span class="txtRojo">$ '.$saldo.'</span></h4>';
        }

        if ($tabla) {
            if ($tabla->num_rows > 0) {
                $strSalida.= $crlf.'<table class="table table-striped table-bordered table-hover table-condensed table-responsive">';

                $strSalida.= $crlf.'<tr>';
                $strSalida.= $crlf.'<th>Número</th>';
                $strSalida.= $crlf.'<th>Fecha</th>';
                $strSalida.= $crlf.'<th>Usuario</th>';
                $strSalida.= $crlf.'<th>Descripción</th>';
                $strSalida.= $crlf.'<th>Tipo de operación</th>';
                $strSalida.= $crlf.'<th>Crédito</th>';
                $strSalida.= $crlf.'<th>Débito</th>';
                $strSalida.= $crlf.'<th>Estado</th>';
                $strSalida.= $crlf.'<th></th>';
                $strSalida.= $crlf.'</tr>';

                while ($fila = $tabla->fetch_assoc()) {
                    $col = 0;
                    
                    $strSalida.= $crlf.'<tr class="'.($fila["NumeEsta"] != "1"?'txtTachado':'').'">';
                    
                    $strSalida.= $crlf.'<td id="NumeCaja'. $fila[$this->IDField].'">'.$fila['NumeCaja'].'</td>';
                    $strSalida.= $crlf.'<td id="FechCaja'. $fila[$this->IDField].'">'.$fila['FechCaja'].'</td>';
                    
                    $strSalida.= $crlf.'<td class="ucase">'.$fila["NombPers"];
                    $strSalida.= $crlf.'<input type="hidden" id="NumeUser'. $fila[$this->IDField].'" value="'.$fila["NumeUser"].'" />';
                    $strSalida.= $crlf.'</td>';
                    
                    $strSalida.= $crlf.'<td id="NombCaja'. $fila[$this->IDField].'" class="ucase">'.$fila['NombCaja'].'</td>';

                    $strSalida.= $crlf.'<td class="ucase">'.$fila["NombTipoCaja"];
                    $strSalida.= $crlf.'<input type="hidden" id="NumeTipoCaja'. $fila[$this->IDField].'" value="'.$fila["NumeTipoCaja"].'" />';
                    $strSalida.= $crlf.'</td>';

                    if ($fila["NumeTipoOper"] == "1") {
                        $strSalida.= $crlf.'<td class="txtBold">$ '.$fila['ImpoCaja'].'<span class="hide" id="ImpoCaja'. $fila[$this->IDField].'">'.$fila['ImpoCaja'].'</span></td>';
                        $strSalida.= $crlf.'<td></td>';
                    }
                    else {
                        $strSalida.= $crlf.'<td></td>';
                        $strSalida.= $crlf.'<td class="txtBold txtRojo">$ '.$fila['ImpoCaja'].'<span class="hide" id="ImpoCaja'. $fila[$this->IDField].'">'.$fila['ImpoCaja'].'</span></td>';
                    }

                    $strSalida.= $crlf.'<td id="NombEsta'.$fila[$this->IDField].'" class="ucase">'.$fila["NombEsta"];
                    $strSalida.= $crlf.'<input type="hidden" id="NumeEsta'.$fila[$this->IDField].'" value="'.$fila["NumeEsta"].'" />';
                    $strSalida.= $crlf.'</td>';

                    //Botones
                    if ($fila["NumeEsta"] == "1") {
                        $strSalida.= $crlf.'<td class="text-center"><button class="btn btn-sm btn-danger" onclick="cambiarEstado(\''.$fila[$this->IDField].'\')">INACTIVAR</button></td>';
                    }
                    else {
                        $strSalida.= $crlf.'<td class="text-center"><button class="btn btn-sm btn-success" onclick="cambiarEstado(\''.$fila[$this->IDField].'\')">ACTIVAR</button></td>';
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

    public function insertar($datos) {
        global $config;

        $datos["FechCaja"] = $config->buscarDato("SELECT SYSDATE()");
        $datos["NumeUser"] = $_SESSION["NumeUser"];

        return parent::insertar($datos);
    }
}
?>