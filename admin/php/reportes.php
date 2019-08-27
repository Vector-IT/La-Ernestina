<?php
session_start();

require_once 'datos.php';

$strSalida = ['html' => ''];
$controlesFecha = [];

switch ($_REQUEST["operacion"]) {
	case 1: //Solicitar parametros
		$strSQL = "SELECT NombPara, NumeTipoPara, FlagRequ, Tabla, CampoNumero, CampoNombre, FiltroTabla, JSOnChange, Placeholder, NumeCarg";
		$strSQL.= " FROM reportesparametros";
		$strSQL.= " WHERE NumeRepo = ". $_REQUEST["NumeRepo"];
		$strSQL.= " ORDER BY NumeOrde";

		$tabla = $config->cargarTabla($strSQL);

		if ($tabla->num_rows > 0) {
			$I = 0;

			while ($fila = $tabla->fetch_assoc()) {
				$I++;

				if ($fila["NumeCarg"] == '' || $fila["NumeCarg"] >= $numeCarg) {
					$strSalida['html'].= '<div class="form-group row">';

					switch ($fila["NumeTipoPara"]) {
						case '1'://Numero / Texto
						case '5':
							$strSalida['html'].= $crlf.'<label for="param'.$I.'" class="col-form-label col-form-label-sm col-md-2">'. $fila["NombPara"] .':</label>';
							$strSalida['html'].= $crlf.'<div class="col-md-4">';
							$strSalida['html'].= $crlf.'<input type="'. ($fila["NumeTipoPara"] == '1'? 'number': 'text') .'" id="param'.$I.'" class="form-control form-control-sm ucase" '. ($fila['FlagRequ']?'required':'') .' onchange="'. ($fila["JSOnChange"]!=''?$fila["JSOnChange"]:'') .'" placeholder="'. $fila["Placeholder"] .'" />';
							$strSalida['html'].= $crlf.'</div>';
						break;

						case '2'://Fecha
							$strSalida['html'].= $crlf.'<label for="param'.$I.'" class="col-form-label col-form-label-sm col-md-2">'. $fila["NombPara"] .':</label>';
							$strSalida['html'].= $crlf.'<div class="col-md-4">';
							$strSalida['html'].= $crlf.'<div class="input-group date margin-bottom-sm inp'.$I.'">';
							$strSalida['html'].= $crlf.'<input type="text" class="form-control form-control-sm dtpPicker" id="param'.$I.'" size="16" value="" '. ($fila['FlagRequ']?'required':'') .' onchange="'. ($fila["JSOnChange"]!=''?$fila["JSOnChange"]:'') .'" autocomplete="off" placeholder="'. $fila["Placeholder"] .'" />';
							$strSalida['html'].= $crlf.'<div class="input-group-append">';
							$strSalida['html'].= $crlf.'<span class="input-group-text"><i class="fa fa-calendar fa-fw"></i></span>';
							// $strSalida['html'].= $crlf.'<button class="btn btn-sm btn-outline-secondary" type="button" data-toggle onclick="$(\'#param'. $I .'\').datetimepicker(\'show\');"><i class="fa fa-calendar fa-fw"></i></button>';
							// if (!$fila["FlagRequ"] == 'search') {
							// 	$strSalida['html'].= $crlf.'<button class="btn btn-sm btn-outline-secondary" type="button" title="Limpiar" onclick="$(\'#param'. $I .'\').val(\'\');"><i class="fa fa-times fa-fw"></i></button>';
							// }
							$strSalida['html'].= $crlf.'</div>';
							$strSalida['html'].= $crlf.'</div>';
							$strSalida['html'].= $crlf.'</div>';

							array_push($controlesFecha, '#param'. $I);
						break;

						case '3'://Mes
							$strSalida['html'].= $crlf.'<label for="param'.$I.'" class="col-form-label col-form-label-sm col-md-2">'. $fila["NombPara"] .':</label>';
							$strSalida['html'].= $crlf.'<div class="col-md-4">';
							$strSalida['html'].= $crlf.'<select class="form-control form-control-sm ucase" id="param'.$I.'"  '. ($fila['FlagRequ']?'required':'') .' onchange="'. ($fila["JSOnChange"]!=''?$fila["JSOnChange"]:'') .'">';
							if ($fila["FlagRequ"]) {
								$strSalida['html'].= $crlf.'	<option value="">'.gral_select.'</option>';
							}
							else {
								$strSalida['html'].= $crlf.'	<option value="">'.gral_all.'</option>';
							}
							$strSalida['html'].= $crlf.'	<option value="1">ENERO</option>';
							$strSalida['html'].= $crlf.'	<option value="2">FEBRERO</option>';
							$strSalida['html'].= $crlf.'	<option value="3">MARZO</option>';
							$strSalida['html'].= $crlf.'	<option value="4">ABRIL</option>';
							$strSalida['html'].= $crlf.'	<option value="5">MAYO</option>';
							$strSalida['html'].= $crlf.'	<option value="6">JUNIO</option>';
							$strSalida['html'].= $crlf.'	<option value="7">JULIO</option>';
							$strSalida['html'].= $crlf.'	<option value="8">AGOSTO</option>';
							$strSalida['html'].= $crlf.'	<option value="9">SEPTIEMBRE</option>';
							$strSalida['html'].= $crlf.'	<option value="10">OCTUBRE</option>';
							$strSalida['html'].= $crlf.'	<option value="11">NOVIEMBRE</option>';
							$strSalida['html'].= $crlf.'	<option value="12">DICIEMBRE</option>';
							$strSalida['html'].= $crlf.'</select>';
							$strSalida['html'].= $crlf.'</div>';
						break;

						case '4'://Tabla
							$strSalida['html'].= $crlf.'<label for="param'.$I.'" class="col-form-label col-form-label-sm col-md-2">'. $fila["NombPara"] .':</label>';
							$strSalida['html'].= $crlf.'<div class="col-md-4">';
							$strSalida['html'].= $crlf.'<select id="param'.$I.'" class="form-control form-control-sm ucase" '. ($fila['FlagRequ']?'required':'') .' onchange="'. ($fila["JSOnChange"]!=''?$fila["JSOnChange"]:'') .'">';
							if ($fila["FlagRequ"]) {
								$itBlankText = gral_select;
							}
							else {
								$itBlankText = gral_all;
							}
							$strSalida['html'].= $config->cargarCombo($fila["Tabla"], $fila["CampoNumero"], $fila["CampoNombre"], $fila["FiltroTabla"], $fila["CampoNombre"], '', !$fila['FlagRequ'], $itBlankText);
							$strSalida['html'].= $crlf.'</select>';
							$strSalida['html'].= $crlf.'</div>';
						break;
					}

					$strSalida['html'].= '</div>';
				}
			}
		}

		// Cargo los archivos de JavaScript
		$strSQL = "SELECT JSFiles FROM reportes WHERE NumeRepo = ". $_REQUEST["NumeRepo"];
		$jsFiles = $config->buscarDato($strSQL);
		if ($jsFiles != null) {
			$jsFiles = explode($crlf, $jsFiles);

			foreach ($jsFiles as $jsFile) {
				$strSalida['html'].= $crlf.'<script src="'. $jsFile .'"></script>';
			}
		}
	break;

	case 2: //Armar reporte
		$strSQL = "SELECT NombRepo, NumeTipoRepo, SQLRepo, ColumnFoot, FooterEsMoneda";
		$strSQL.= " FROM reportes";
		$strSQL.= " WHERE NumeRepo = ". $_REQUEST["NumeRepo"];

		$tabla = $config->cargarTabla($strSQL);
		$fila = $tabla->fetch_assoc();

		$strSQL2 = $fila["SQLRepo"];

		switch ($fila["NumeTipoRepo"]) {
			case '1': //Por defecto
				$strSQL = "SELECT NombPara, NumeTipoPara, FlagRequ, Tabla, CampoNumero, CampoNombre";
				$strSQL.= " FROM reportesparametros";
				$strSQL.= " WHERE NumeRepo = ". $_REQUEST["NumeRepo"];
				$strSQL.= " ORDER BY NumeOrde";

				$tbParams = $config->cargarTabla($strSQL);

				if ($tbParams->num_rows > 0) {
					$I = 0;

					while ($param = $tbParams->fetch_assoc()) {
						$I++;

						if (isset($_REQUEST["Params"][$I-1]) && $_REQUEST["Params"][$I-1] != '') {
							$strSQL2 = str_ireplace('@param'.$I.'begin', '', $strSQL2);
							$strSQL2 = str_ireplace('@param'.$I.'end', '', $strSQL2);
							$strSQL2 = str_ireplace('@param'.$I, $_REQUEST["Params"][$I-1], $strSQL2);
						}
						else {
							do {
								$inicio = strripos($strSQL2, '@param'.$I.'begin');
								$fin = strripos($strSQL2, '@param'.$I.'end');

								if ($inicio !== false && $fin !== false) {
									$fin = $fin - $inicio + strlen('@param'.$I.'end');

									$aux = substr($strSQL2, $inicio, $fin);
									$strSQL2 = str_ireplace($aux, '', $strSQL2);
								}
							} while ($inicio !== false && $fin !== false);
						}
					}
				}

				try {
					if (isset($_SESSION[$nombSistema. "_debug"])) {
						$strSalida["sql"] = $strSQL2;
					}

					$tabla = $config->cargarTabla($strSQL2);

					$strSalida['html'].= $crlf.'<h4 id="txtTitulo">'.$fila["NombRepo"].'</h4>';

					if ($tabla->num_rows > 0) {
						$strSalida['html'].= $crlf.'<button class="btn btn-sm btn-success" onclick="window.print();"><i class="fa fa-fw fa-print" aria-hidden="true"></i> '.gral_print.'</button>';
						$strSalida['html'].= $crlf.'<button class="btn btn-sm btn-success" onclick="exportarExcel();"><i class="far fa-file-excel fa-fw" aria-hidden="true"></i> '.gral_export.'</button>';

						$strSalida['html'].= $crlf.'<h6 class="mt-3">'.gral_rowcount.': '.$tabla->num_rows.'</h6>';
						$strSalida['html'].= $crlf.'<table id="tblReporte" class="table table-striped table-bordered table-hover table-sm mt-4">';

						$footer = 0;

						for ($I = 0; $I < $tabla->num_rows; $I++) {
							$fila2 = $tabla->fetch_assoc();

							//Armo la fila encabezado
							if ($I == 0) {
								$strSalida['html'].= $crlf.'<tr>';
								foreach ($fila2 as $key => $value) {
									$strSalida['html'].= $crlf.'<th>'. $key .'</th>';
								}
								$strSalida['html'].= $crlf.'</tr>';
							}

							//Cargo los datos
							$strSalida['html'].= $crlf.'<tr>';
							$J = 1;
							foreach ($fila2 as $key => $value) {
								if ($J == $fila["ColumnFoot"]) {
									$strSalida['html'].= $crlf.'<td class="text-right">'.($fila["FooterEsMoneda"]=="1"?"$ ":"").nl2br($value).'</td>';
									if (is_numeric($value)) {
										$footer+= $value;
									}
									else {
										$footer++;
									}
								}
								else {
									$strSalida['html'].= $crlf.'<td>'.nl2br($value).'</td>';
								}
								$J++;
							}
							$strSalida['html'].= $crlf.'</tr>';
						}

						//Cargo el footer
						if ($fila["ColumnFoot"] != "") {
							$strSalida['html'].= $crlf.'<tfoot><tr>';

							if ($fila["ColumnFoot"] != "1") {
								$strSalida['html'].= $crlf.'<th colspan="'.(intval($fila["ColumnFoot"])-1).'" style="visibility: hidden;"></th>';
							}

							$strSalida['html'].= $crlf.'<th class="text-right">';
							$strSalida['html'].= $crlf.'<span class="pull-left">TOTAL: </span>'.($fila["FooterEsMoneda"]=="1"?"$ ":""). number_format($footer, 2);
							$strSalida['html'].= $crlf.'</th>';

							$strSalida['html'].= $crlf.'</tr></tfoot>';
						}
						$strSalida['html'].= $crlf.'</table>';
					}
					else {
						$strSalida['html'].= $crlf.'<h5>'.gral_nodata.'</h5>';
					}
				}
				catch (Exception $e) {
					error_log($e->getMessage());

					$strSalida = '<div class="alert alert-danger" role="alert">';
					$strSalida['html'].= $crlf.reports_error;
					$strSalida['html'].= $crlf.'</div>';
				}
			break;

			case "2": //Archivo
				require_once 'reportes/'.$strSQL2;
				$strSalida['html'] = generarReporte();
			break;
		}
	break;
}

if (count($controlesFecha) > 0) {
	$strSalida['html'].= $crlf.'<script type="text/javascript">';
    foreach ($controlesFecha as $control) {
		$strSalida['html'].= $crlf.'$("'. $control .'").datetimepicker({';
		$strSalida['html'].= $crlf.'	timepicker:false,';
		$strSalida['html'].= $crlf.'	format:"Y-MM-DD",';

		if (isset($_SESSION['Theme'])) {
			$strSalida['html'].= $crlf.'	theme: "dark",';
		}

		$strSalida['html'].= $crlf.'});';
    }
	$strSalida['html'].= $crlf.'</script>';
}

header('Content-Type: application/json');
echo json_encode($strSalida);


?>