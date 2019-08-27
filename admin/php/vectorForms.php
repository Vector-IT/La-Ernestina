<?php
namespace VectorForms;

/**
 * Archivo de configuracion general
 *
 * @author Vector-IT
 * @package vectorAdmin
 *
 */
require_once 'tabla.php';

/**
 * Clase de configuracions de vForms
 *
 * @author Vector-IT
 *
 */
class VectorForms {
	private $dbhost;          // String - Host de servidor de base de datos
	private $db;              // String - Esquema de base de datos
	private $dbuser;          // String - Usuario de base de datos
	private $dbpass;          // String - Contraseña de acceso de usuario de base de datos

	public $raiz;             // String - Ruta de instalacion del sistema
	public $titulo;           // String - Titulo del sistema
	public $logo;	          // String - Ruta relativa del logo del sistema
	public $showTitulo;       // Boolean - Se muestra el titulo?

	public $tbLogin;          // String - Tabla de base de datos utilizada para el login de usuarios

	public $tablas;           // Array de objetos Tabla
	public $menuItems;        // Array de objetos de Menu

	public $cssFiles;         // Array de rutas de archivos css
	public $jsFiles;          // Array de rutas de archivos js

	public $imgCKEditor;      // String - Ruta de almacenamiento de archivos de CKEditor

	public $theme;            // String - Tema de colores de bootstrap

	public $numeCargReportes; // Integer - Cargo para ver reportes

	public $showLangs;        // Boolean - Mostrar radios de selección de idioma

	/**
	 * Constructor de la clase Configuracion
	 *
	 * @param string $dbhost
	 * @param string $db
	 * @param string $dbuser
	 * @param string $dbpass
	 * @param string $raiz
	 * @param string $title
	 * @param string $logo
	 */
	public function __construct($dbhost='', $db='', $dbuser='', $dbpass='', $raiz='', $titulo='', $logo='', $showTitulo=true, $tbLogin = 'usuarios') {
		$this->dbhost = $dbhost;
		$this->db = $db;
		$this->dbuser = $dbuser;
		$this->dbpass = $dbpass;
		$this->raiz = $raiz;
		$this->titulo = $titulo;
		$this->logo = $logo;
		$this->showTitulo = $showTitulo;
		$this->tbLogin = $tbLogin;
		$this->tablas = [];
		$this->menuItems = [];
		$this->cssFiles = [];
		$this->jsFiles = [];
		$this->imgCKEditor = $raiz. 'admin/ckeditor/imgup';
		$this->theme = '';
		$this->numeCargReportes = '';
		$this->showLangs = true;
	}

	/**
	 * Nueva conexión a la BD
	 *
	 * @return mysqli
	 */
	private function newConn() {
		$conn = new \mysqli($this->dbhost, $this->dbuser, $this->dbpass, $this->db);
		$conn->set_charset("utf8");

		return $conn;
	}

	/**
	 * Ejecutar comando en la BD
	 *
	 * @param string $strSQL
	 * @return boolean|string
	 */
	public function ejecutarCMD($strSQL, $returnID = false) {
		$conn = $this->newConn();
		$strError = "";

		if (!$conn->query($strSQL))
			$strError = $conn->error;
			if ($returnID) {
				$id = $conn->insert_id;
			}
			$conn->close();

			if ($strError == "") {
                if (!$returnID) {
                    return true;
                }
				else {
					return $id;
				}
			}
			else {
				return $strError;
			}
	}

	/**
	 * Ejecutar query en la BD y devolver el valor del primer campo
	 *
	 * @param string $strSQL
	 * @return string
	 */
	public function buscarDato($strSQL) {

		$conn = $this->newConn();

		$strSalida = "";

		if (!($tabla = $conn->query($strSQL))) {
			$strSalida = gral_queryerror;
		}
		else {
			if ($tabla->num_rows > 0) {
				if ($tabla->field_count == 1) {
					$fila = $tabla->fetch_row();
					$strSalida = $fila[0];
				}
				else {
					$strSalida = $tabla->fetch_assoc();
				}
				$tabla->free();
			}
			else {
				$strSalida = '';
			}
		}

		if (is_resource($conn)) {
			$conn->close();
		}

		return $strSalida;
	}

	/**
	 * Carga un control de tipo select o selectmultiple
	 */
	public function cargarCombo($tabla, $CampoNumero, $CampoTexto, $filtro = "", $orden = "", $seleccion = "", $itBlank = false, $itBlankText = gral_select, $tablaAlias = "")
	{
		global $crlf;

		$strSQL = "SELECT ". $CampoNumero;
		if ($CampoTexto != "") {
			$strSQL.= ",". $CampoTexto;
		}
		$strSQL.= " FROM ". $tabla ." ". $tablaAlias;

		if ($filtro != "") {
			$strSQL.= " WHERE $filtro";
		}

		if ($orden != "") {
			$strSQL.= " ORDER BY $orden";
		}

		$tabla = $this->cargarTabla($strSQL);

		$strSalida = "";

		if ($itBlank) {
			$strSalida.= $crlf.'<option value="">'.$itBlankText.'</option>';
		}

        if ($tabla) {
            while ($fila = $tabla->fetch_assoc()) {
                if ($CampoTexto != "") {
                    if (strcmp($fila[$CampoNumero], $seleccion) != "0") {
                        $strSalida.= $crlf.'<option value="'.$fila[$CampoNumero].'">'.htmlentities($fila[$CampoTexto]).'</option>';
                    } else {
                        $strSalida.= $crlf.'<option value="'.$fila[$CampoNumero].'" selected>'.htmlentities($fila[$CampoTexto]).'</option>';
                    }
                } else {
                    if (strcmp($fila[$CampoNumero], $seleccion) != "0") {
                        $strSalida.= $crlf.'<option value="'.$fila[$CampoNumero].'" />';
                    } else {
                        $strSalida.= $crlf.'<option value="'.$fila[$CampoNumero].'" selected />';
                    }
                }
            }
        }
		return $strSalida;
	}

	/**
	 * Ejecutar query en la BD y devolver el resultado
	 *
	 * @param string $strSQL
	 * @return boolean|mysqli_result
	 */
	public function cargarTabla($strSQL) {
		$conn = $this->newConn();

		$tabla = $conn->query($strSQL);

		$conn->close();

		return $tabla;
	}

	/**
	 * Sumar tiempos
	 */
	public function sum_time($time1, $time2) {
		$times = array($time1, $time2);
		$seconds = 0;
		foreach ($times as $time) {
			list($hour,$minute,$second) = explode(':', $time);
			$seconds += $hour*3600;
			$seconds += $minute*60;
			$seconds += $second;
		}
		$hours = floor($seconds/3600);
		$seconds -= $hours*3600;
		$minutes  = floor($seconds/60);
		$seconds -= $minutes*60;
		// return "{$hours}:{$minutes}:{$seconds}";
		return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
	}

	/**
	 * Tiempo a decimal
	 */
	function time_to_decimal($time) {
		if ($time != '') {
			$hms = explode(":", $time);
			return ($hms[0] + ($hms[1]/60) + ($hms[2]/3600));
		}
		else {
			return '0';
		}
	}

	/**
	 * Crear menu de opciones
	 */
	public function crearMenu() {
		global $crlf, $config;

		$strSalida = '';
		$strSeparador = $crlf.'<div class="separator"></div>';

		$strItem = $crlf.'<div class="item" data-toggle="tooltip" data-placement="right" title="#titulo#">';
		$strItem.= $crlf.'<a href="#url#">';
		$strItem.= $crlf.'#titulo#';
		$strItem.= $crlf.'<div class="flRight"><i class="fa #icono# fa-fw"></i></div>';
		$strItem.= $crlf.'</a>';
		$strItem.= $crlf.'</div>';

		$strSubMenuInicio = $crlf.'<div class="item submenu" data-toggle="tooltip" data-placement="top" title="#titulo#">';
		$strSubMenuInicio.= $crlf.'<a href="#url#">';
		$strSubMenuInicio.= $crlf.'#titulo#';
		$strSubMenuInicio.= $crlf.'<div class="flRight"><i class="fa #icono# fa-fw"></i></div>';
		$strSubMenuInicio.= $crlf.'</a>';
		$strSubMenuInicio.= $crlf.'<ul class="dropdown-menu">';

		$strSubMenuFin = $crlf.'</ul>';
		$strSubMenuFin.= $crlf.'</div>';

		$strSubItem = $crlf.'<li data-url="#url#">';
		$strSubItem.= $crlf.'<a href="#url#">';
		$strSubItem.= $crlf.'#titulo#';
		$strSubItem.= $crlf.'<div class="flRight"><i class="fa #icono# fa-fw"></i></div>';
		$strSubItem.= $crlf.'</a>';
		$strSubItem.= $crlf.'</li>';

		$strSalida.= $crlf.'<div id="sidebar" class="menuVector">';
		$strSalida.= $crlf.'<div class="absolute top5 right3">';
		$strSalida.= $crlf.'<button class="btnMenu btn btn-light btn-sm noMobile" data-toggle="tooltip" data-placement="right" title="'. gral_menu .'"><i class="fa fa-bars"></i></button>';
		$strSalida.= $crlf.'</div>';
		$strSalida.= $crlf.'<div id="sidebar-content" class="menuVector-content">';

		$strSalida.= str_replace("#titulo#", gral_home, str_replace("#icono#", "fa-home", str_replace("#url#", $this->raiz."admin/", $strItem)));
		$strSalida.= $strSeparador;

		$I = 1;
		$submenu = false;
		foreach ($this->menuItems as $item) {
			$item->Used = false;
		}

		foreach ($this->tablas as $tabla) {
			//Items de menu adicionales
			$strSalida.= $this->crearItemMenuAdic($I, $submenu, true, $strItem, $strSubMenuInicio, $strSubMenuFin, $strSubItem, $strSeparador);

			//Tablas
			if ($tabla->showMenu) {
				if ($tabla->numeCarg !== '') {
					$numeCarg = intval($this->buscarDato("SELECT NumeCarg FROM ".$config->tbLogin." WHERE NumeUser = ". $_SESSION["NumeUser"]));

					if (intval($tabla->numeCarg) < $numeCarg) {
						continue;
					}
				}

				$strSalida.= $this->crearItemMenuTabla($I, $submenu, $tabla, $strItem, $strSubMenuInicio, $strSubMenuFin, $strSubItem, $strSeparador);
			}
		}

		//Items adicionales no usados que no tienen indice
		$I = '';
		$strSalida.= $this->crearItemMenuAdic($I, $submenu, false, $strItem, $strSubMenuInicio, $strSubMenuFin, $strSubItem, $strSeparador);

		if ($submenu) {
			$strSalida.= $strSubMenuFin;
			$strSalida.= $strSeparador;
		}

		$strSalida.= $crlf.'</div>';
		$strSalida.= $crlf.'</div>';

		$strSalida.= $crlf.'<button class="btnMenu btn btn-light btn-sm fixed top5 left5 noDesktop" title="'. gral_menu .'"><i class="fa fa-bars"></i></button>';

		echo $strSalida;
	}

	/**
	 * Crea un item de menu proveniente de un objeto Tabla
	 */
	protected function crearItemMenuTabla(&$I, &$submenu, $tabla, $strItem, $strSubMenuInicio, $strSubMenuFin, $strSubItem, $strSeparador) {
		global $config, $crlf;

		$strSalida = '';

		if ($tabla->isSubMenu) {
			if ($submenu) {
				$strSalida.= $strSubMenuFin;
				$strSalida.= $strSeparador;
			}

			$submenu = true;

			$strAux = str_replace("#titulo#", $tabla->titulo, $strSubMenuInicio);
			$strAux = str_replace("#icono#", $tabla->icono, $strAux);
			if ($tabla->url != '') {
				$strAux = str_replace("#url#", $tabla->url, $strAux);
			}
			else {
				$strAux = str_replace('href="#url#"', '', $strAux);
			}

			$strSalida.= $strAux;

			$I++;
		}
		else {
			if ($tabla->isSubItem) {
				if ($tabla->menuIndex != 0 && $tabla->menuIndex != $I) {
					$I++;
					$strSalida.= $this->crearItemMenuAdic($I, $submenu, $strItem, true, $strSubMenuInicio, $strSubMenuFin, $strSubItem, $strSeparador);
				}

				$strAux = str_replace("#titulo#", $tabla->titulo, $strSubItem);
				$strAux = str_replace("#icono#", $tabla->icono, $strAux);
				if ($tabla->url != '') {
					$strAux = str_replace("#url#", $tabla->url, $strAux);
				}
				else {
					$strAux = str_replace('href="#url#"', '', $strAux);
				}

				$strSalida.= $strAux;
				$strSalida.= $strSeparador;

			}
			else {
				if ($submenu) {
					$strSalida.= $strSubMenuFin;
					$strSalida.= $strSeparador;
					$submenu = false;
				}

				$strAux = str_replace("#titulo#", $tabla->titulo, $strItem);
				$strAux = str_replace("#icono#", $tabla->icono, $strAux);
				if ($tabla->url != '') {
					$strAux = str_replace("#url#", $tabla->url, $strAux);
				}
				else {
					$strAux = str_replace('href="#url#"', '', $strAux);
				}

				$strSalida.= $strAux;
				$strSalida.= $strSeparador;

				$I++;
			}
		}

		return $strSalida;
	}

	/**
	 * Crea un item de menu proveniente del objeto VectorForms
	 */
	protected function crearItemMenuAdic(&$I, &$submenu, $blnCheckIndex = true, $strItem, $strSubMenuInicio, $strSubMenuFin, $strSubItem, $strSeparador) {
		global $config, $crlf;

		$strSalida = '';

		foreach ($this->menuItems as $item) {
			if (!$item->Used) {
				if ($item->NumeCarg !== '') {
					$numeCarg = intval($this->buscarDato("SELECT NumeCarg FROM ".$config->tbLogin." WHERE NumeUser = ". $_SESSION["NumeUser"]));

					if (intval($item->NumeCarg) < $numeCarg) {
						continue;
					}
				}

				if (intval($item->Index) == $I || !$blnCheckIndex) {
					if ($item->Submenu) {
						if ($submenu) {
							$strSalida.= $strSubMenuFin;
							$strSalida.= $strSeparador;
						}

						$submenu = true;

						$strAux = str_replace("#titulo#", $item->Titulo, $strSubMenuInicio);
						$strAux = str_replace("#icono#", $item->Icono, $strAux);
						if ($item->Url != '') {
							$strAux = str_replace("#url#", $item->Url, $strAux);
						}
						else {
							$strAux = str_replace('href="#url#"', '', $strAux);
						}

						$strSalida.= $strAux;

						$item->Used = true;
					}
					else {
						if ($item->Subitem) {
							$strAux = str_replace("#titulo#", $item->Titulo, $strSubItem);
							$strAux = str_replace("#icono#", $item->Icono, $strAux);
							if ($item->Url != '') {
								$strAux = str_replace("#url#", $item->Url, $strAux);
							}
							else {
								$strAux = str_replace('href="#url#"', '', $strAux);
							}

							$strSalida.= $strAux;
							$strSalida.= $strSeparador;

							$item->Used = true;
						}
						else {
							if ($submenu) {
								$strSalida.= $strSubMenuFin;
								$strSalida.= $strSeparador;
								$submenu = false;
							}

							$strAux = str_replace("#titulo#", $item->Titulo, $strItem);
							$strAux = str_replace("#icono#", $item->Icono, $strAux);

							if ($item->Url != '') {
								$strAux = str_replace("#url#", $item->Url, $strAux);
							}
							else {
								$strAux = str_replace('href="#url#"', '', $strAux);
							}

							$strSalida.= $strAux;
							$strSalida.= $strSeparador;

							$item->Used = true;

							if ($blnCheckIndex) {
								$I++;
							}
						}
					}
				}
			}
		}

		return $strSalida;
	}

	/**
	 * Obtiene objeto Tabla
	 * @param string $name
	 * @return Tabla|null
	 */
	public function getTabla($name) {
		if (isset($this->tablas[$name])) {
			return $this->tablas[$name];
		}
		else {
			return null;
		}
	}

	/**
	 * Obtiene string aleatorio
	 */
	public function get_random_string($valid_chars, $length)
	{
		// start with an empty random string
		$random_string = "";

		// count the number of chars in the valid chars string so we know how many choices we have
		$num_valid_chars = strlen($valid_chars);

		// repeat the steps until we've created a string of the right length
		for ($i = 0; $i < $length; $i++)
		{
			// pick a random number from 1 up to the number of valid chars
			$random_pick = mt_rand(1, $num_valid_chars);

			// take the random character out of the string of valid chars
			// subtract 1 from $random_pick because strings are indexed starting at 0, and we started picking at 1
			$random_char = $valid_chars[$random_pick-1];

			// add the randomly-chosen char onto the end of our string so far
			$random_string .= $random_char;
		}

		// return our finished random string
		return $random_string;
	}

	/**
	 * Insert a value or key/value pair after a specific key in an array.  If key doesn't exist, value is appended
	 * to the end of the array.
	 *
	 * @param array $array
	 * @param string $key
	 * @param array $new
	 *
	 * @return array
	 */
	public function array_insert_after( array $array, $key, array $new ) {
		$keys = array_keys( $array );
		$index = array_search( $key, $keys );
		$pos = false === $index ? count( $array ) : $index + 1;

		return array_merge( array_slice( $array, 0, $pos ), $new, array_slice( $array, $pos ) );
	}

	/**
	 * Leer Configuración
	 *
	 * @param string $nombConf
	 */
	public function getConfig($nombConf) {
		return $this->buscarDato("SELECT ValoConf FROM configuraciones WHERE NombConf = '{$nombConf}'");
	}
}

/**
 * Clase de item de menu
 *
 * @author Vector-IT
 *
 */
class MenuItem {
	public $Titulo;
	public $Url;
	public $NumeCarg;
	public $Icono;
	public $Index;
	public $Submenu;
	public $Subitem;
	public $Used;

	/**
	 * Constructor de items
	 *
	 * @param string $titulo
	 * @param string $url
	 * @param string $NumeCarg
	 * @param string $Icono
	 * @param string $Index
	 * @param string $Submenu
	 */
	public function __construct($titulo, $url, $numeCarg='', $icono='', $index='', $submenu=false, $subitem=false) {
		$this->Titulo = $titulo;
		$this->Url = $url;
		$this->NumeCarg = $numeCarg;
		$this->Icono = $icono;
		$this->Index = $index;
		$this->Submenu = $submenu;
		$this->Subitem = $subitem;
		$this->Used = false;
	}
}

/**
 * Clase btnListItem
 * Item de lista de botones en el registro de una tabla
 */
class btnListItem {
	public $id;
	public $titulo;
	public $texto;
	public $class;
	public $type;
	public $href;
	public $onclick;
	public $numeCarg;
	public $cond;
	public $attribs;

	/**
	 * Constructor
	 *
	 * @param string $id
	 * @param string $titulo - Titulo de la columna
	 * @param string $texto - Texto del botón
	 * @param string $class - clase de css
	 * @param string $type - Tipo de boton (a, button)
	 * @param string $href - URL del link
	 * @param string $onclick - Evento OnClick
	 * @param string $attribs - Atributos
	 */
	public function __construct($id, $titulo, $texto, $class='btn-secondary', $type='button', $href='', $onclick='', $numeCarg = '', $cond = 'return true;', $attribs = '') {
		$this->id = $id;
		$this->titulo = $titulo;
		$this->texto = $texto;
		$this->class = $class;
		$this->type = $type;
		$this->href = $href;
		$this->onclick = $onclick;
		$this->numeCarg = $numeCarg;
		$this->cond = $cond;
		$this->attribs = $attribs;
	}
}

/**
 * Clase de para setear los campos footer
 */
class FooterField {
	public $name;
	public $funcion;
	public $col;
	public $count;
	public $value;
	public $cond;

	/**
	 * Constructor
	 *
	 * @param string $name - Nombre
	 * @param string $funcion - Funcion de agrupamiento (COUNT, SUM, /AVG)
	 * @param boolean $esMoneda - Booleano si el campo es o no moneda
	 */
	public function __construct($name, $funcion = 'SUM', $cond = '') {
		$this->name = $name;
		$this->funcion = $funcion;
		$this->cond = $cond;

		$this->count = 0;
		$this->value = 0;
	}
}

/**
 * Clase de campo busqueda
 *
 * @author Vector-IT
 *
 */
class SearchField {
	public $name;
	public $searchName;
	public $operator;
	public $join;
	public $conBuscador;
	public $label;
	public $value;
	public $controlAlias;
	public $type;

	/**
	 * Constructor
	 *
	 * @param string $name - Nombre
	 * @param string $searchName - Expresion SQL
	 * @param string $operator - Operador de comparación (=)
	 * @param string $join - Operador de encadenamiento con otros filtros (AND)
	 * @param string $type - Tipo de campo de busqueda
	 */
	public function __construct($name, $operator = '=', $join = 'AND', $searchName = '', $conBuscador = false, $label = null, $value = null, $controlAlias = null, $type = null) {
		$this->name = $name;
		$this->operator = $operator;
		$this->join = $join;
		$this->searchName = ($searchName != ''? $searchName: $name);
		$this->conBuscador = $conBuscador;
		$this->label = $label;
		$this->value = $value;
		$this->controlAlias = $controlAlias;
		$this->type = $type;
	}
}
?>