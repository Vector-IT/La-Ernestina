<?php
namespace VectorForms;

class Caja extends Tabla
{
    public function customFunc($post)
    {
        global $config;

        switch ($post['field']) {
            case "NumeEsta":
                return $config->ejecutarCMD("UPDATE ". $this->tabladb ." SET NumeEsta = NOT NumeEsta WHERE NumeCaja = ". $post["dato"]["NumeCaja"]);
                break;
        }
    }

    public function listar($strFiltro = "", $conBotones = true, $btnList = [], $order = '', $pagina = 1, $strFiltroSQL = '', $conCheckboxes = false)
    {
        global $config, $crlf, $nombSistema;

        $filtro = "";

        $strSQL = "SELECT c.NumeCaja, c.FechCaja, c.NombCaja, c.NumeTipoCaja, c.ImpoCaja, c.NumeEsta, c.NumeUser, u.NombPers, tc.NombTipoCaja, tc.NumeTipoOper, e.NombEsta";
        $strSQL.= $crlf."FROM (SELECT * FROM ". $this->tabladb;
        if ($strFiltro == "") {
            $strSQL.= $crlf."WHERE FechCaja > DATE_ADD(SYSDATE(), INTERVAL -30 DAY)";
        } else {
            if (isset($strFiltro["FechCaja"])) {
                if ($strFiltro["FechCaja"]["value"] != 'TODOS') {
                    if ($filtro != "") {
                        $filtro.= $crlf." AND ";
                    }
                    $filtro.= "DATE_FORMAT(FechCaja, '%Y-%m-%d') = '{$strFiltro["FechCaja"]["value"]}'";
                }
            }

            if (isset($strFiltro["NombCaja"])) {
                if ($filtro != "") {
                    $filtro.= $crlf." AND ";
                }
                $filtro.= "NombCaja LIKE '%{$strFiltro["NombCaja"]["value"]}%'";
            }

            if (isset($strFiltro["NumeTipoCaja"])) {
                if ($filtro != "") {
                    $filtro.= $crlf." AND ";
                }
                $filtro.= "NumeTipoCaja = {$strFiltro["NumeTipoCaja"]["value"]}";
            }

            if ($filtro != '') {
                $strSQL.= $crlf." WHERE ". $filtro;
            }
        }
        $strSQL.= $crlf.") c";
        $strSQL.= $crlf."INNER JOIN usuarios u ON c.NumeUser = u.NumeUser";
        $strSQL.= $crlf."INNER JOIN tiposcaja tc ON c.NumeTipoCaja = tc.NumeTipoCaja";
        $strSQL.= $crlf."INNER JOIN estados e ON c.NumeEsta = e.NumeEsta";

		if ($this->name == 'caja') {
			$strSQL.= $crlf."UNION ALL";
			$strSQL.= $crlf."SELECT 0, cp.FechPago, 'INGRESO CUOTA', 1, cp.ImpoPago, cp.NumeEsta, cp.NumeUser, u.NombPers, tc.NombTipoCaja, tc.NumeTipoOper, e.NombEsta";
			$strSQL.= $crlf."FROM cuotaspagos cp";
			$strSQL.= $crlf."INNER JOIN usuarios u ON cp.NumeUser = u.NumeUser";
			$strSQL.= $crlf."INNER JOIN tiposcaja tc ON 1 = tc.NumeTipoCaja";
			$strSQL.= $crlf."INNER JOIN estados e ON cp.NumeEsta = e.NumeEsta";
			$strSQL.= $crlf."WHERE cp.NumeTipoPago = 1";
			if ($strFiltro == "") {
				$strSQL.= $crlf."AND cp.FechPago > DATE_ADD(SYSDATE(), INTERVAL -30 DAY)";
			} else {
				if (isset($strFiltro["FechPago"])) {
					if ($strFiltro["FechPago"]["value"] != 'TODOS') {
						$strSQL.= $crlf."AND DATE_FORMAT(cp.FechPago, '%Y-%m-%d') = '{$strFiltro["FechCaja"]["value"]}'";
					}
				}
			}
		}

        $strSQL.= $crlf."ORDER BY 2 DESC";

		$tabla = $config->cargarTabla($strSQL);

		if (isset($_SESSION[$nombSistema. "_debug"])) {
			$resultado["sql"] = $strSQL;
		}

        $strSalida = '';

		if ($this->name == 'caja') {
			$strSQL2 = "SELECT SUM(Credito) FROM (";
			$strSQL2.= $crlf."SELECT SUM(ImpoCaja) Credito FROM ". $this->tabladb;
			$strSQL2.= $crlf."WHERE NumeEsta = 1 AND NumeTipoCaja IN (SELECT NumeTipoCaja FROM tiposcaja WHERE NumeTipoOper = 1)";
			$strSQL2.= $crlf."UNION ALL ";
			$strSQL2.= $crlf."SELECT SUM(ImpoPago) FROM cuotaspagos";
			$strSQL2.= $crlf."WHERE NumeEsta = 1 AND NumeTipoPago = 1";
			$strSQL2.= $crlf.") tabla";

			$credito = $config->buscarDato($strSQL2);
		}
		else {
			$credito = $config->buscarDato("SELECT SUM(ImpoCaja) FROM ". $this->tabladb ." WHERE NumeEsta = 1 AND NumeTipoCaja IN (SELECT NumeTipoCaja FROM tiposcaja WHERE NumeTipoOper = 1)");
		}
        $debito = $config->buscarDato("SELECT SUM(ImpoCaja) FROM ". $this->tabladb ." WHERE NumeEsta = 1 AND NumeTipoCaja IN (SELECT NumeTipoCaja FROM tiposcaja WHERE NumeTipoOper = 2)");
        $saldo = floatval($credito) - floatval($debito);

        if ($saldo >= 0) {
            $strSalida.= $crlf.'<h4 id="txtSaldo" class="well well-sm text-right">Saldo: $ '.$saldo.'</h4>';
        } else {
            $strSalida.= $crlf.'<h4 id="txtSaldo" class="well well-sm text-right">Saldo: <span class="txtRojo">$ '.$saldo.'</span></h4>';
        }

        if ($tabla) {
            if ($tabla->num_rows > 0) {
                $strSalida.= $crlf.'<table class="table table-striped table-bordered table-hover table-condensed table-sm">';

                $strSalida.= $crlf.'<tr>';
                // $strSalida.= $crlf.'<th>Número</th>';
                $strSalida.= $crlf.'<th>Fecha</th>';
                $strSalida.= $crlf.'<th>Usuario</th>';
                $strSalida.= $crlf.'<th>Descripción</th>';
                $strSalida.= $crlf.'<th>Tipo de operación</th>';
                $strSalida.= $crlf.'<th class="text-right">Crédito</th>';
                $strSalida.= $crlf.'<th class="text-right">Débito</th>';
                $strSalida.= $crlf.'<th>Estado</th>';
                $strSalida.= $crlf.'<th></th>';
                $strSalida.= $crlf.'</tr>';

                while ($fila = $tabla->fetch_assoc()) {
                    $col = 0;

                    $strSalida.= $crlf.'<tr class="'.($fila["NumeEsta"] != "1"?'txtTachado':'').'">';

                    $strSalida.= $crlf.'<input type="hidden" id="NumeCaja'. $fila[$this->IDField].'" value="'.$fila['NumeCaja'].'" />';
                    $strSalida.= $crlf.'<td id="FechCaja'. $fila[$this->IDField].'">'.$fila['FechCaja'].'</td>';

                    $strSalida.= $crlf.'<td class="ucase">'.$fila["NombPers"];
                    $strSalida.= $crlf.'<input type="hidden" id="NumeUser'. $fila[$this->IDField].'" value="'.$fila["NumeUser"].'" />';
                    $strSalida.= $crlf.'</td>';

                    $strSalida.= $crlf.'<td id="NombCaja'. $fila[$this->IDField].'" class="ucase">'.$fila['NombCaja'].'</td>';

                    $strSalida.= $crlf.'<td class="ucase">'.$fila["NombTipoCaja"];
                    $strSalida.= $crlf.'<input type="hidden" id="NumeTipoCaja'. $fila[$this->IDField].'" value="'.$fila["NumeTipoCaja"].'" />';
                    $strSalida.= $crlf.'</td>';

                    if ($fila["NumeTipoOper"] == "1") {
                        $strSalida.= $crlf.'<td class="txtBold text-right">$ '.$fila['ImpoCaja'].'<span class="d-none" id="ImpoCaja'. $fila[$this->IDField].'">'.$fila['ImpoCaja'].'</span></td>';
                        $strSalida.= $crlf.'<td></td>';
                    } else {
                        $strSalida.= $crlf.'<td></td>';
                        $strSalida.= $crlf.'<td class="txtBold txtRojo text-right">$ '.$fila['ImpoCaja'].'<span class="d-none" id="ImpoCaja'. $fila[$this->IDField].'">'.$fila['ImpoCaja'].'</span></td>';
                    }

                    $strSalida.= $crlf.'<td id="NombEsta'.$fila[$this->IDField].'" class="ucase">'.$fila["NombEsta"];
                    $strSalida.= $crlf.'<input type="hidden" id="NumeEsta'.$fila[$this->IDField].'" value="'.$fila["NumeEsta"].'" />';
                    $strSalida.= $crlf.'</td>';

					//Botones
					if ($fila["NumeCaja"] != '0') {
						if ($fila["NumeEsta"] == "1") {
							$strSalida.= $crlf.'<td class="text-center"><button class="btn btn-sm btn-danger" onclick="cambiarEstado(\''.$fila[$this->IDField].'\')">INACTIVAR</button></td>';
						} else {
							$strSalida.= $crlf.'<td class="text-center"><button class="btn btn-sm btn-success" onclick="cambiarEstado(\''.$fila[$this->IDField].'\')">ACTIVAR</button></td>';
						}
					}
					else {
						$strSalida.= $crlf.'<td class="text-center"></td>';
					}

                    $strSalida.= $crlf.'</tr>';
                }

				$strSalida.= $crlf.'</table>';

				$tabla->data_seek(0);
            } else {
                $resultado["num_rows"] = 0;
				$strSalida.= "<h3>".gral_nodata."</h3>";
            }
        } else {
            $resultado["num_rows"] = 0;
			$strSalida.= "<h3>".gral_nodata."</h3>";
        }

		$resultado["tabla"] = $tabla;
		$resultado["html"] = $strSalida;

		return $resultado;
    }

    public function createFielda2($field, $prefix = '', $conBuscador = false)
    {
        global $crlf, $config;

        $strSalida = '';

        if ($prefix == '') {
            $fname = $field['name'];
        } else {
            $fname = $prefix  .'-'. $field['name'];
        }

        if ($fname == "search-FechCaja") {
            $strSalida.= $crlf.'<div class="form-group form-group-sm '.$field['cssGroup'].'">';
            $strSalida.= $crlf.'<label for="'.$fname.'" class="control-label col-md-2 col-lg-2">'.$field['label'].':</label>';

            if ($field['size'] <= 20) {
                $strSalida.= $crlf.'<div class="col-md-2 col-lg-2">';
            } elseif ($field['size'] <= 40) {
                $strSalida.= $crlf.'<div class="col-md-3 col-lg-3">';
            } elseif ($field['size'] <= 80) {
                $strSalida.= $crlf.'<div class="col-md-4 col-lg-4">';
            } elseif ($field['size'] <= 160) {
                $strSalida.= $crlf.'<div class="col-md-5 col-lg-5">';
            } elseif ($field['size'] <= 200) {
                $strSalida.= $crlf.'<div class="col-md-6 col-lg-6">';
            } else {
                $strSalida.= $crlf.'<div class="col-md-10 col-lg-10">';
            }

            $strSalida.= $crlf.'<div class="input-group date margin-bottom-sm inp'.$fname.'">';
            $strSalida.= $crlf.'<input type="text" class="form-control input-sm '.$field['cssControl'].'" id="'.$fname.'"size="16" value="'.$field["value"].'" readonly />';
            $strSalida.= $crlf.'<span class="input-group-addon add-on clickable" title="Limpiar"><i class="fa fa-times fa-fw"></i></span>';
            $strSalida.= $crlf.'<span class="input-group-addon add-on clickable"><i class="fa fa-calendar fa-fw"></i></span>';
            $strSalida.= $crlf.'</div>';
            $strSalida.= $crlf.'<script type="text/javascript">';
            $strSalida.= $crlf.'$(".inp'.$fname.'").datetimepicker({';
            $strSalida.= $crlf.'	language: "es",';
            $strSalida.= $crlf.'	format: "yyyy-mm",';
            $strSalida.= $crlf.'	minView: 3,';
            $strSalida.= $crlf.'	startView: 3,';
            $strSalida.= $crlf.'	autoclose: true,';
            $strSalida.= $crlf.'	todayBtn: true,';
            $strSalida.= $crlf.'	todayHighlight: false,';
            $strSalida.= $crlf.'	pickerPosition: "bottom-left"';

            if ($field['mirrorField'] != '') {
                $strSalida.= $crlf.'	linkField: "'. $field['mirrorField'] .'",';
                $strSalida.= $crlf.'	linkFormat: "'. $field['mirrorFormat'] .'",';
            }

            if ($field['dtpOnRender'] != '') {
                $strSalida.= $crlf.'	onRender: function(date) {';
                $strSalida.= $crlf.'			return '. $field['dtpOnRender'];
                $strSalida.= $crlf.'		},';
            }

            if ($field['onChange'] == '') {
                $strSalida.= $crlf.'	});';
            } else {
                $strSalida.= $crlf.'	}).on("changeDate", function(ev){';
                $strSalida.= $crlf.'		'. $field['onChange'];
                $strSalida.= $crlf.'	});';
            }

            $strSalida.= $crlf.'</script>';
            $strSalida.= $crlf.'</div>'; //col-md
            $strSalida.= $crlf.'</div>'; //form-group
        } else {
            $strSalida.= parent::createField($field, $prefix);
        }

        return $strSalida;
    }
}
