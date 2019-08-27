<?php
session_start();
/**
 * Archivo de interconexion entre el html y las clases de tabla
 *
 * @author Vector-IT
 *
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	require_once 'datos.php';
	require_once 'upload_file.php';

    $urlLogin = "Location:". $url ."admin/login.php?timeout&returnUrl=" . urlencode($_SERVER['HTTP_REFERER']);

	if (!isset($_SESSION['is_logged_in_'. $nombSistema])) {
		$strSalida = 'Error al actualizar los datos, su sesión a caducado.<br>';
		$strSalida.= $crlf.'Debe ingresar nuevamente.<br>';
		$strSalida.= $crlf.'<button class="btn btn-secondary" onclick="location.href = \''. $urlLogin .'\';">Iniciar Sesión</button>';
	    exit($strSalida);
	}

	$_SESSION['session_time'] = time();

	$operacion = $_POST["operacion"];
	$tabla = $config->getTabla($_POST["tabla"]);

	switch ($operacion) {
		//Insert
		case "0":
		//Update
		case "1":
		//Delete
		case "2":
			$datos = [];
			$idViejo = $_POST["idViejo"];

			//Archivos
			foreach ($_FILES as $name => $val) {
				if (isset($tabla->fields[$name])) {
					if (!is_array($_FILES[$name]["name"])) {
						$temp = explode(".", $_FILES[$name]["name"]);
						$extension = end($temp);

						$strRnd = $config->get_random_string("abcdefghijklmnopqrstuvwxyz1234567890", 5);

						if ($tabla->fields[$name]['processBD']) {
							$archivo_viejo = $config->buscarDato("SELECT {$name} FROM {$tabla->tabladb} WHERE {$tabla->IDField} = '{$_POST[$tabla->IDField]}'");
						} else {
							$archivo_viejo = '';
						}

						if ($archivo_viejo != '') {
							$archivo_viejo = "..".DIRECTORY_SEPARATOR. $archivo_viejo;
						}

						$archivo = $name ."-". $strRnd .".". strtolower($extension);
						$val =  $tabla->fields[$name]['ruta'] ."/". $archivo;

						subir_archivo($_FILES[$name], "..".DIRECTORY_SEPARATOR. $tabla->fields[$name]['ruta'], $archivo, $archivo_viejo);

						$datos[$name] = $val;
					}
					else {
						fixFilesArray($_FILES[$name]);

						$datos[$name] = [];

						for ($I = 0; $I < count($_FILES[$name]); $I++) {
			            	$temp = explode(".", $_FILES[$name][$I]["name"]);
							$extension = end($temp);

							$strRnd = $config->get_random_string("abcdefghijklmnopqrstuvwxyz1234567890", 5);

							$archivo_viejo = $config->buscarDato("SELECT {$name} FROM {$tabla->tabladb} WHERE {$tabla->IDField} = '{$_POST[$tabla->IDField]}'");
							if ($archivo_viejo != '') {
								$archivo_viejo = "..".DIRECTORY_SEPARATOR. $archivo_viejo;
							}

							$archivo = $name ."-". $strRnd .".". strtolower($extension);
							$val =  $tabla->fields[$name]['ruta'] ."/". $archivo;

							subir_archivo($_FILES[$name][$I], "..".DIRECTORY_SEPARATOR. $tabla->fields[$name]['ruta'], $archivo, $archivo_viejo);

							array_push($datos[$name], $val);
		            	}
					}
				}
			}

			//Campos
			foreach ($_POST as $name => $val) {
				//Me fijo si hay que borrar algun archivo
				if (substr($name, 0, 12) == 'vectorClear-') {
					$nameAux = substr($name, 12);

					if ($val == "1") {
						$archivo_viejo = $config->buscarDato("SELECT {$nameAux} FROM {$tabla->tabladb} WHERE {$tabla->IDField} = '{$_POST[$tabla->IDField]}'");
						if ($archivo_viejo != '') {
							$archivo_viejo = "..".DIRECTORY_SEPARATOR. $archivo_viejo;
						}

						if (file_exists($archivo_viejo)) {
							unlink($archivo_viejo);
						}

						$datos[$nameAux] = '';
					}
				} else {
					if (($name != 'operacion') && ($name != 'tabla') && ($name != 'idViejo')) {
						// Me fijo si el tipo de dato es file-url (URL de archivo para descargar)
						if (isset($tabla->fields[$name]) && $tabla->fields[$name]['type'] == 'file-url' && $val != '') {
							// Remote image URL
							$url = $val;

							$temp = explode(".", $url);
							$extension = end($temp);

							$strRnd = $config->get_random_string("abcdefghijklmnopqrstuvwxyz1234567890", 5);

							if ($tabla->fields[$name]['nombFileField'] != '') {
								$archivo_viejo = $config->buscarDato("SELECT {$tabla->fields[$name]['nombFileField']} FROM {$tabla->tabladb} WHERE {$tabla->IDField} = '{$_POST[$tabla->IDField]}'");
							}
							else {
								$archivo_viejo = $config->buscarDato("SELECT {$name} FROM {$tabla->tabladb} WHERE {$tabla->IDField} = '{$_POST[$tabla->IDField]}'");
							}
							if ($archivo_viejo != '') {
								$archivo_viejo = "..".DIRECTORY_SEPARATOR. $archivo_viejo;

								if (file_exists($archivo_viejo)) {
									unlink($archivo_viejo);
								}
							}

							$archivo = $name ."-". $strRnd .".". strtolower($extension);
							$val =  $tabla->fields[$name]['ruta'] .'/'. $archivo;

							// Image path
							$img = '..'.DIRECTORY_SEPARATOR. $tabla->fields[$name]['ruta'] .DIRECTORY_SEPARATOR. $archivo;

							// Save image
							file_put_contents($img, file_get_contents($url));

							if ($tabla->fields[$name]['nombFileField'] != '') {
								$name = $tabla->fields[$name]['nombFileField'];
							}
						}

						$datos[$name] = $val;
					}
				}
			}

			$result = ejecutar($operacion, $tabla, $datos, $idViejo);

			header('Content-Type: application/json');
			echo json_encode($result);
		break;

		//Subir y Bajar de Orden
		case "3":
		case "4":
			$datos = [];
			foreach ($_POST as $name => $val) {
				if (($name != 'operacion') && ($name != 'tabla')) {
					$datos[$name] = $val;
				}
			}

			$result = ejecutar($operacion, $tabla, $datos);

			if ($result["estado"] === true) {
				exit(gral_dataupdated);
			} else {
				exit(gral_updateerror."<br>".$result["estado"]);
			}
		break;

		//Listar
		case "10":
			$strFiltro = (isset($_POST["filtro"])? $_POST["filtro"]: "");
			$conBotones = (isset($_POST["conBotones"])? ($_POST["conBotones"] === 'true'): true);
			$conCheckboxes = (isset($_POST["conCheckboxes"])? ($_POST["conCheckboxes"] === 'true'): false);
			$btnList = (isset($_POST["btnList"])? $_POST["btnList"]: []);
			$order = (isset($_POST["order"])? $_POST["order"]: "");
			$pagina = (isset($_POST["pagina"])? $_POST["pagina"]: 1);
			$strFiltroSQL = (isset($_POST["filtroSQL"])? $_POST["filtroSQL"]: '');

			$resultado = $tabla->listar($strFiltro, $conBotones, $btnList, $order, $pagina, $strFiltroSQL, $conCheckboxes);
			header('Content-Type: application/json');
			echo json_encode($resultado);
		break;

		//Funcion de buscar opciones de combo
		case "99":
			$id = (isset($_POST["strID"])? $_POST["strID"]: '');
			$dato = $_POST["dato"];
			$campo = $_POST["campo"];

			$field = $tabla->fields[$campo];

			$filtro = $field['lookupConditions'];
			if ($filtro != '') {
				$filtro.= ' AND ';
			}

			if ($dato != '') {
				$filtro.=  $field['lookupFieldLabel']. " LIKE '%". $dato ."%'";
			}
			elseif($id != '') {
				$filtro.=  $field['lookupFieldID']. " = '". $id ."'";
			}

			$datos = $config->cargarCombo($field['lookupTable'], $field['lookupFieldID'], $field['lookupFieldLabel'], $filtro, $field['lookupOrder'], '', $field['itBlank'], $field['itBlankText'], $field['lookupTableAlias']);

			// $datos = $config->cargarCombo($strSQL, $cmbValor, $cmbNombre, '', $cmbNombre, $id);

			$array = array(
				"post" => $_POST,
				"valor" => $datos
			);

			header('Content-Type: application/json');
			echo json_encode($array);
		break;

		//Funcion propia de cada clase
		case "100":
			$array = array(
					"post"=>$_POST,
					"valor"=>$tabla->customFunc($_POST)
			);

			header('Content-Type: application/json');
			echo json_encode($array);
		break;
	}
}

function ejecutar($operacion, $tabla, $datos, $idViejo = "")
{
	$result = [];

	switch ($operacion) {
		case "0": //Insert
			$result = $tabla->insertar($datos);
			break;

		case "1": //Update
			$result = $tabla->editar($datos, $idViejo);
			break;

		case "2": //Delete
			if ($tabla->allowDelete) {
				$result = $tabla->borrar($datos);
			} else {
				$result["estado"] = "Operación inválida.";
			}
			break;

		//Subir y bajar el orden
		case "3":
		case "4":
			$result = $tabla->subirBajar($operacion, $datos);
			break;
	}

	return $result;
}
