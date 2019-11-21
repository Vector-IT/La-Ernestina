<?php
namespace VectorForms;

/**
 * Archivo de clase de tabla generica
 *
 * @author Vector-IT
 *
 */
class Tabla
{
	public $name;                 // String - Nombre del objeto
	public $tabladb;              // String - Nombre en la BD
	public $titulo;               // String - Titulo en la página
	public $tituloSingular;       // String - Titulo para utilizar en alerts

	public $headerFiles;          // Array de rutas de archivos php para cargar en el <head>

	public $showMenu;             // Bool - Muestra el objeto en el menu
	public $isSubMenu;            // Bool - El item en el menú es un submenu
	public $isSubItem;            // Bool - El item en el menú es un subitem
	public $menuIndex;            // Int - Indice dentro del menú

	public $url;                  // String - URL para el link en el menú
	public $icono;                // String - Clase de Font Awesome
	public $fields;               // Array - Array de campos

	public $order;                // String - Nombre del campo para ordenar
	public $orderColumns;         // Bool - Activa el orden personalizado haciendo click en las columnas
	public $orderField;           // String - Campo que se utiliza para las funciones de orden
	public $orderFieldAppend;     // Bool - Todo item nuevo va al principio

	public $paginacion;           // Bool - Activa la paginación
	public $pageRows;             // Int - Cantidad de items por página

	public $IDField;              // String - Campo ID
	public $IDFieldAutoIncrement; // Boolean
	public $labelField;           // String - Campo utilizado para nombre

	public $allowNew;             // Bool - Permitir crear items
	public $allowEdit;            // Bool - Permitir editar items
	public $allowDelete;          // Bool - Permitir borrar items

	public $masterTable;          // String - Nombre de tabla maestra
	public $masterFieldId;        // String - Nombre de campo id en tabla local
	public $masterFieldIdMaster;  // String - Nombre de campo id en tabla maestra
	public $masterFieldName;      // String - Nombre de campo titulo en tabla maestra

	public $numeCarg;             // Int - Numero de cargo de acceso al objeto
	public $numeCargNew;          // Int - Numero de cargo para crear items
	public $numeCargEdit;         // Int - Numero de cargo para editar items
	public $numeCargDelete;       // Int - Numero de cargo para borrar items

	public $condEdit;			  // Bool - Condición en código PHP para mostrar o no el botón de editar;
	public $condDelete;			  // Bool - Condición en código PHP para mostrar o no el botón de borrar;

	public $jsFiles;              // Array - Ruta de archivos javascript para cargar
	public $jsFilesFicha;         // Array - Ruta de archivos javascript para cargar en la ficha
	public $jsOnLoad;             // String - Código JavaScript para ejecutar al cargar la página
	public $jsOnLoadFicha;        // String - Código JavaScript para ejecutar al cargar la página de ficha
	public $jsBeforeList;         // String - Código JavaScript para ejecutar antes de listar
	public $jsOnList;             // String - Código JavaScript para ejecutar al listar
	public $jsOnNew;              // String - Código JavaScript para ejecutar al inicio de hacer clic en Nuevo
	public $jsAfterNew;           // String - Código JavaScript para ejecutar al final de hacer clic en Nuevo
	public $jsOnEdit;             // String - Código JavaScript para ejecutar al editar un item
	public $jsBeforeSubmit;       // String - Código JavaScript para ejecutar al incio de aceptar
	public $jsAfterSubmit;        // String - Código JavaScript para ejecutar al final de aceptar

	public $cssFiles;             // Array - Ruta de archivos css para cargar

	public $modalForm;            // Bool - Determina si el formulario es modal o no

	public $btnList;              // Array de btnListItem - Array de objetos de botones para mostrar en el listado
	public $btnForm;              // Array de btnListItem - Array de objetos de botones para mostrar en el formulario
	public $btnFicha;             // Array de btnListItem - Array de objetos de botones para mostrar en la ficha

	public $footerFields;         // Array de FooterField - Lista de campos que se usan como footer

	public $gmaps;                // Bool - Activa los scripts de carga del mapa
	public $gmapsApiKey;          // String - API Key de Google Maps
	public $gmapsCenterLat;       // String - Latitud del centro
	public $gmapsCenterLng;       // String - Longitud del centro

	public $listarOnLoad;         // Bool - Listar al cargar la página
	public $showRowCount;         // Bool - Mostrar cantidad de filas al listar
	public $searchFields;         // Array de objetos SearchField - Array de campos de búsqueda

	public $includeList;          // Array - Ruta de archivos php que se agregan al final del documento

	public $regUser;              // Bool - Registrar usuario en cada ABM en la tabla

	public $exportToXLS;          // Bool - Exportar lista a Excel

	public $filterSQL;		  	  // String - Código SQL para filtrar al listar
	public $filterxCargo;		  // Array asociativo - Lista de números de cargos (key) y código SQL (value) para filtrar al listar

	public $overridePreview;      // Bool - Esquiva el chequeo si existe un campo de tipo imagen

	/**
	 * Constructor de la clase Tabla
	 * @param string $tabladb
	 * @param string $titulo
	 * @param string $tituloSingular
	 * @param boolean $showMenu
	 * @param string $url
	 * @param string $icono
	 * @param string $order
	 */
	public function __construct($name, $tabladb, $titulo, $tituloSingular = '', $showMenu = true, $url = '', $icono = '', $order = '', $allowEdit = true, $allowDelete = true, $allowNew = true)
	{
		$this->name                 = $name;
		$this->tabladb              = $tabladb;
		$this->titulo               = $titulo;
		$this->tituloSingular       = $tituloSingular;

		$this->headerFiles          = [];

		$this->showMenu             = $showMenu;
		$this->isSubMenu            = false;
		$this->isSubItem            = false;
		$this->menuIndex            = 0;

		$this->url                  = $url;
		$this->icono                = $icono;
		$this->order                = $order;
		$this->orderColumns         = true;

		$this->orderField           = '';
		$this->orderFieldAppend     = true;

		$this->paginacion           = false;
		$this->pageRows             = 25;

		$this->IDField              = '';
		$this->IDFieldAutoIncrement = false;
		$this->labelField           = '';

		$this->allowNew             = $allowNew;
		$this->allowEdit            = $allowEdit;
		$this->allowDelete          = $allowDelete;

		$this->numeCarg             = '';
		$this->numeCargNew          = PHP_INT_MAX;
		$this->numeCargEdit         = PHP_INT_MAX;
		$this->numeCargDelete       = PHP_INT_MAX;

		$this->condEdit			    = 'return true;';
		$this->condDelete		    = 'return true;';

		$this->jsFiles              = [];
		$this->jsFilesFicha         = [];
		$this->jsOnLoad             = '';
		$this->jsOnLoadFicha        = '';
		$this->jsBeforeList         = '';
		$this->jsOnList             = '';
		$this->jsOnNew              = '';
		$this->jsAfterNew           = '';
		$this->jsOnEdit             = '';
		$this->jsBeforeSubmit       = '';
		$this->jsAfterSubmit        = '';

		$this->cssFiles             = [];

		$this->modalForm            = false;

		$this->btnList              = [];
		$this->btnForm              = [];
		$this->btnFicha             = [];

		$this->footerFields         = [];

		$this->masterTable          = '';
		$this->masterFieldId        = '';
		$this->masterFieldIdMaster  = '';
		$this->masterFieldName      = '';

		$this->gmaps                = false;
		$this->gmapsApiKey          = '';
		$this->gmapsCenterLat       = '0';
		$this->gmapsCenterLng       = '0';

		$this->listarOnLoad         = true;
		$this->showRowCount         = false;
		$this->searchFields         = [];

		$this->includeList          = [];

		$this->regUser              = false;

		$this->exportToXLS          = false;

		$this->filterSQL            = '';
		$this->filterxCargo         = [];

		$this->overridePreview      = false;
	}

	/**
	 * Agrega un campo a la tabla
	 * @param string $name: nombre del campo
	 * @param string $type: tipo de control al crear en un form
	 * @param number $size: tamaño del campo
	 * @param string $label: etiqueta del control al crear en un form
	 * @param boolean $required: requerido
	 * @param string $value: valor por defecto
	 * @param string $cssGrp: clases css del control al crear en un form
	 */
	public function addField($name, $type = 'text', $size = 0, $label = '', $required = true, $readOnly = false, $isID = false, $showOnList = true, $value = '', $cssGroup = '', $lookupTable = '', $lookupFieldID = '', $lookupFieldLabel = '', $lookupConditions = '', $lookupOrder = '', $isHiddenInForm = false, $isHiddenInList = false, $isMasterID = false, $onChange = '', $showOnForm = true, $itBlank = false) {

		$this->fields[$name] = array (
			'name'             => $name,               				//String: Nombre
			'nameAlias'        => '',                  				//String: Alias del nombre en consulta sql
			'controlAlias'     => '',                  				//String: Si se especifica es el nombre del control en el formulario
			'type'             => $type,               				//String: Tipo de control
			'size'             => $size,               				//Int: Tamaño de width del control TODO:Mejorar tratamiento
			'label'            => ($label != ''? $label: $name),	//String: Nombre a mostrar en listado y en control
			'required'         => $required,           				//Boolean: Requerido
			'readOnly'         => $readOnly,           				//Boolean: Solo lectura
			'isID'             => $isID,               				//Boolean: Es campo clave (PK)
			'showOnList'       => $showOnList,         				//Boolean: Se muestra en el listado
			'showOnForm'       => $showOnForm,         				//Boolean: Se muestra en el form
			'showOnFicha'      => true,                				//Boolean: Se muestra en la ficha
			'value'            => $value,              				//String: Valor por defecto
			'cssControl'       => '',                  				//String: Clases de estilo en control
			'cssList'          => '',                  				//String: Clases de estilo en listado
			'cssGroup'         => $cssGroup,           				//String: Clases de estilo en el grupo del control (form-group)
			'lookupTable'      => $lookupTable,        				//String: Tabla lookup para campos que son referencia
			'lookupTableAlias' => '',                  				//String: Alias de tabla lookup
			'lookupFieldID'    => $lookupFieldID,      				//String: Campo referencia en tabla lookup
			'lookupFieldLabel' => $lookupFieldLabel,   				//String: Campo descripción en tabla lookup
			'lookupConditions' => $lookupConditions,   				//String: Condiciones de tabla lookup para llenar el combo en el formulario
			'joinConditions'   => '',                  				//String: Condiciones de tabla lookup para el listado
			'lookupOrder'      => $lookupOrder,        				//String: Orden en tabla lookup
			'isHiddenInForm'   => $isHiddenInForm,     				//String: Es hidden en el form? Igual que el tipo de campo "hidden"
			'isHiddenInList'   => $isHiddenInList,     				//String: Se oculta en el listado
			'isMasterID'       => $isMasterID,         				//Boolean: FIXME: Sin uso
			'onChange'         => $onChange,           				//String: Sentencia js para el evento onChange del control
			'itBlank'          => $itBlank,            				//Boolean: Si el combo se llena con un valor vacío
			'itBlankText'      => gral_select,	     				//String: Texto por defecto del valor vacío del combo
			'itBlankTextList'  => '',                  				//String: Texto por defecto del valor vacío en el listado
			'hoursDisabled'    => '',                  				//String: Lista separada por comas de horasa deshabilitadas en el control de seleccion de horas
			'dtpOnRender'      => '',                  				//String: Sentencia js para el evento onRender del control de tipo date, time, datetime, month
			'txtAlign'         => 'left',              				//String: Alineación del texto
			'ruta'             => '',                  				//String: Ruta donde se guarda el archivo, sirve para campos de tipo file e image
			'nombFileField'    => '',                  				//String: Nombre del campo adicional cuando el tipo de dato es file-url (sirve para cuando hay un campo de carga de imagen y otro de URL)
			'mirrorField'      => '',                  				//String: Campo espejo del control de tipo date, time, datetime, month
			'mirrorFormat'     => '',                  				//String: Formato del campo espejo del control de tipo date, time, datetime, month
			'formatDb'         => '',                  				//String: Sentencia de consulta SQL del campo (reemplaza al campo name)
			'isMD5'            => false,               				//Boolean: Se encripta al guardar en la base de datos
			'step'             => 1,                   				//Int: Valor escalon para campos de tipo number y time
			// 'min'              => '',                  				//String: Valor mínimo para campos de tipo number
			'condFormat'       => '',                  				//String: Condición en código PHP para evaluar si se cumple y aplicar clases de estilo al listado
			'classFormat'      => '',                  				//String: Clases de estilo a aplicar en el listado si se cumple condFormat
			'print'            => true,                				//Boolean: Se muestra al imprimir
			'txtBefore'        => '',                  				//String: Texto a colocar en listado antes del dato(Ej: en campos de tipo moneda se pone '$ ')
			'txtAfter'         => '',                  				//String: Texto a colocar en listado despues del dato(Ej: en campos de tipo porcentaje se pone '%')
			'processAnyway'    => false,               				//Boolean: Se procesa de todas formas (es un hack para campos que no se muestran en el form)
			'processBD'        => true,                				//Boolean: Se procesa en la base de datos
			'evalData'         => '',                  				//String: Para campos de tipo "eval", condición en código PHP que se evalua y debe devolver algún dato
			'numeCarg'         => '',                  				//String: Numero de cargo del usuario logueado (Se muestra para aquellos que tengan cargo menor o igual al nro ingresado)
			'attrList'         => [],                  				//Array: Array asociativo de atributos en listado
			'attrControl'      => [],                  				//Array: Array asociativo de atributos en control
			'conBuscador'      => false                				//Boolean: Para campos de tipo select, activa un buscador de valores
		);

		if ($isID) {
			$this->IDField = $name;
		}
	}

	/**
	 * Agrega un campo a la tabla de tipo primary key
	 * @param string $name: nombre del campo
	 * @param string $label: etiqueta del control al crear en un form
	 */
	public function addFieldId($name, $label = '', $isHiddenInList = false, $isHiddenInForm = false, $readOnly = true, $IDFieldAutoIncrement = false)
	{
		$this->fields[$name] = array (
			'name'             => $name,
			'nameAlias'        => '',
			'controlAlias'     => '',
			'type'             => 'number',
			'size'             => 0,
			'label'            => ($label != ''? $label: $name),
			'required'         => false,
			'readOnly'         => $readOnly,
			'isID'             => true,
			'showOnList'       => true,
			'showOnForm'       => true,
			'showOnFicha'      => true,
			'value'            => '',
			'cssControl'       => '',
			'cssList'          => '',
			'cssGroup'         => '',
			'lookupTable'      => '',
			'lookupTableAlias' => '',
			'lookupFieldID'    => '',
			'lookupFieldLabel' => '',
			'lookupConditions' => '',
			'joinConditions'   => '',
			'lookupOrder'      => '',
			'isHiddenInForm'   => $isHiddenInForm,
			'isHiddenInList'   => $isHiddenInList,
			'isMasterID'       => false,
			'onChange'         => '',
			'itBlank'          => false,
			'itBlankText'      => gral_select,
			'itBlankTextList'  => '',
			'hoursDisabled'    => '',
			'dtpOnRender'      => '',
			'txtAlign'         => 'left',
			'ruta'             => '',
			'nombFileField'    => '',
			'mirrorField'      => '',
			'mirrorFormat'     => '',
			'formatDb'         => '',
			'isMD5'            => false,
			'step'             => 1,
			// 'min'              => '',
			'condFormat'       => '',
			'classFormat'      => '',
			'print'            => true,
			'txtBefore'        => '',
			'txtAfter'         => '',
			'processAnyway'    => false,
			'processBD'        => true,
			'evalData'         => '',
			'numeCarg'         => '',
			'attrList'         => [],
			'attrControl'      => [],
			'conBuscador'      => false
		);

		$this->IDField = $name;
		$this->IDFieldAutoIncrement = $IDFieldAutoIncrement;
	}

	/**
	 * Agrega un campo a la tabla de tipo archivo o imagen
	 * @param string $name: nombre del campo
	 * @param string $label: etiqueta del control al crear en un form
	 * @param string $ruta: ruta de guardado
	 * @param number $type: 'file' o 'image'
	 * @param number $size: tamaño del campo
	 * @param boolean $required: requerido
	 */
	public function addFieldFileImage($name, $label, $ruta, $type = 'image', $size = 80, $required = true, $isHiddenInList = false)
	{

		$this->fields[$name] = array (
			'name'             => $name,
			'nameAlias'        => '',
			'controlAlias'     => '',
			'type'             => $type,
			'size'             => $size,
			'label'            => ($label != ''? $label: $name),
			'required'         => $required,
			'readOnly'         => false,
			'isID'             => false,
			'showOnList'       => true,
			'showOnForm'       => true,
			'showOnFicha'      => true,
			'value'            => '',
			'cssControl'       => '',
			'cssList'          => '',
			'cssGroup'         => '',
			'lookupTable'      => '',
			'lookupTableAlias' => '',
			'lookupFieldID'    => '',
			'lookupFieldLabel' => '',
			'lookupConditions' => '',
			'joinConditions'   => '',
			'lookupOrder'      => '',
			'isHiddenInForm'   => false,
			'isHiddenInList'   => $isHiddenInList,
			'isMasterID'       => false,
			'onChange'         => '',
			'itBlank'          => false,
			'itBlankText'      => gral_select,
			'itBlankTextList'  => '',
			'hoursDisabled'    => '',
			'dtpOnRender'      => '',
			'txtAlign'         => 'left',
			'ruta'             => $ruta,
			'nombFileField'    => '',
			'mirrorField'      => '',
			'mirrorFormat'     => '',
			'formatDb'         => '',
			'isMD5'            => false,
			'step'             => 1,
			// 'min'              => '',
			'condFormat'       => '',
			'classFormat'      => '',
			'print'            => true,
			'txtBefore'        => '',
			'txtAfter'         => '',
			'processAnyway'    => false,
			'processBD'        => true,
			'evalData'         => '',
			'numeCarg'         => '',
			'attrList'         => [],
			'attrControl'      => [],
			'conBuscador'      => false
		);
	}

	public function addFieldSelect($name, $size, $label, $required, $value, $lookupTable, $lookupTableAlias = '', $lookupFieldID, $lookupFieldLabel, $lookupConditions = '', $joinConditions = '', $lookupOrder = '', $itBlank = false, $itBlankText = gral_select, $itBlankTextList = '')
	{
		$this->fields[$name] = array (
			'name'             => $name,
			'nameAlias'        => '',
			'controlAlias'     => '',
			'type'             => 'select',
			'size'             => $size,
			'label'            => ($label != ''? $label: $name),
			'required'         => $required,
			'readOnly'         => false,
			'isID'             => false,
			'showOnList'       => true,
			'showOnForm'       => true,
			'showOnFicha'      => true,
			'value'            => $value,
			'cssControl'       => '',
			'cssList'          => '',
			'cssGroup'         => '',
			'lookupTable'      => $lookupTable,
			'lookupTableAlias' => $lookupTableAlias,
			'lookupFieldID'    => $lookupFieldID,
			'lookupFieldLabel' => $lookupFieldLabel,
			'lookupConditions' => $lookupConditions,
			'joinConditions'   => $joinConditions,
			'lookupOrder'      => $lookupOrder,
			'isHiddenInForm'   => '',
			'isHiddenInList'   => '',
			'isMasterID'       => '',
			'onChange'         => '',
			'itBlank'          => $itBlank,
			'itBlankText'      => $itBlankText,
			'itBlankTextList'  => $itBlankTextList,
			'hoursDisabled'    => '',
			'dtpOnRender'      => '',
			'txtAlign'         => 'left',
			'ruta'             => '',
			'nombFileField'    => '',
			'mirrorField'      => '',
			'mirrorFormat'     => '',
			'formatDb'         => '',
			'isMD5'            => false,
			'step'             => 1,
			// 'min'              => '',
			'condFormat'       => '',
			'classFormat'      => '',
			'print'            => true,
			'txtBefore'        => '',
			'txtAfter'         => '',
			'processAnyway'    => false,
			'processBD'        => true,
			'evalData'         => '',
			'numeCarg'         => '',
			'attrList'         => [],
			'attrControl'      => [],
			'conBuscador'      => false
		);
	}

	public function createForm()
	{
		global $config, $crlf;

		$numeCarg = intval($config->buscarDato("SELECT NumeCarg FROM ".$config->tbLogin." WHERE NumeUser = ". $_SESSION["NumeUser"]));

		$strSalida = '';

		if (isset($this->fields)) {
			if ($this->allowNew && $this->numeCargNew >= $numeCarg) {
				$strSalida.= $crlf.'<button id="btnNuevo" type="button" class="btn btn-sm btn-primary" onclick="editar'. $this->tabladb .'(false, true);"><i class="far fa-plus-square fa-fw" aria-hidden="true"></i> '.gral_new.'</button>';
			}
			//Botones opcionales
			if (count($this->btnForm) > 0) {
				foreach ($this->btnForm as $btn) {
					if (($btn->numeCarg === '' || $btn->numeCarg >= $numeCarg) && eval($btn->cond)) {
						$strSalida.= $crlf.'<'.$btn->type.' role="button" id="'.$btn->id.'" title="'.$btn->titulo.'" class="btn btn-sm '. $btn->class .'" ';
						if ($btn->onclick != '') {
							$strSalida.= 'onclick="'. $btn->onclick .'" ';
						}

						if ($btn->href != '') {
							$strSalida.= 'href="'. $btn->href .'" ';
						}

						if ($btn->attribs != '') {
							$strSalida.= ' '.$btn->attribs;
						}

						$strSalida.= '>'. $btn->texto .'</'.$btn->type.'>';
					}
				}
			}

			if ($this->exportToXLS) {
				$strSalida.= $crlf.'<button id="btnExport" type="button" class="btn btn-sm btn-success" onclick="exportar'. $this->name .'();"><i class="far fa-file-excel fa-fw" aria-hidden="true"></i> '.gral_export.'</button>';
			}

			if ($this->allowNew || $this->allowEdit) {
				if ($this->modalForm) {
					$strSalida.= $crlf.'<div id="mdl'. $this->tabladb .'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mdl'. $this->tabladb .'">';
					$strSalida.= $crlf.'  <div class="modal-dialog modal-lg modal-xl" role="document">';
					$strSalida.= $crlf.'    <div class="modal-content">';
					$strSalida.= $crlf.'		<div class="modal-header">';
					$strSalida.= $crlf.'			<h4 class="modal-title" id="frm'. $this->tabladb .'-title"></h4>';
					$strSalida.= $crlf.'		</div>';
					$strSalida.= $crlf.'		<form id="frm'. $this->tabladb .'" class="mt-4" method="post" onSubmit="return false;">';
					$strSalida.= $crlf.'			<input type="hidden" id="hdnTabla" value="'.$this->tabladb.'" />';
					$strSalida.= $crlf.'			<input type="hidden" id="hdnOperacion" value="0" />';
					$strSalida.= $crlf.'			<input type="hidden" id="hdnIdViejo" value="" />';

					$strSalida.= $crlf.'			<div class="modal-body">';
					foreach ($this->fields as $field) {
						if ($field["numeCarg"] === '' || $field["numeCarg"] >= $numeCarg) {
							$strSalida.= $crlf.'				'.$this->createField($field, '', $field["conBuscador"]);
						}
					}

					$strSalida.= $crlf.'				<div class="clearer"></div>';
					$strSalida.= $crlf.'				<div id="divMsjModal" class="alert alert-danger" role="alert" style="display: none;">';
					$strSalida.= $crlf.'					<span id="txtHintModal">Info</span>';
					$strSalida.= $crlf.'				</div>';
					$strSalida.= $crlf.'			</div>';
					$strSalida.= $crlf.'			<div class="modal-footer">';
					$strSalida.= $crlf.'				<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check fa-fw" aria-hidden="true"></i> '.gral_accept.'</button>';
					$strSalida.= $crlf.'				&nbsp;';
					$strSalida.= $crlf.'				<button type="reset" class="btn btn-sm btn-secondary"><i class="fa fa-times fa-fw" aria-hidden="true"></i> '.gral_cancel.'</button>';
					$strSalida.= $crlf.'			</div>';
					$strSalida.= $crlf.'		</form>';
					$strSalida.= $crlf.'    </div>';
					$strSalida.= $crlf.'  </div>';
					$strSalida.= $crlf.'</div>';
				}
				else {
					$strSalida.= $crlf.'<form id="frm'. $this->tabladb .'" class="mt-4 frmObjeto" method="post" onSubmit="return false;">';
					$strSalida.= $crlf.'<input type="hidden" id="hdnTabla" value="'.$this->tabladb.'" />';
					$strSalida.= $crlf.'<input type="hidden" id="hdnOperacion" value="0" />';
					$strSalida.= $crlf.'<input type="hidden" id="hdnIdViejo" value="" />';

					foreach ($this->fields as $field) {
						if ($field["numeCarg"] === '' || $field["numeCarg"] >= $numeCarg) {
							$strSalida.= $crlf . $this->createField($field, '', $field["conBuscador"]);
						}
					}

					$strSalida.= $crlf.'<div id="grpBotones" class="form-group">';
					$strSalida.= $crlf.'	<div class="offset-md-2 col-md-4">';
					$strSalida.= $crlf.'		<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check fa-fw" aria-hidden="true"></i> '.gral_accept.'</button>';
					$strSalida.= $crlf.'&nbsp;';
					// $strSalida.= $crlf.'		<button type="reset" class="btn btn-sm btn-secondary" onclick="editar'. $this->tabladb .'(false, false);"><i class="fa fa-times fa-fw" aria-hidden="true"></i> '.gral_cancel.'</button>';
					$strSalida.= $crlf.'		<button type="reset" class="btn btn-sm btn-secondary"><i class="fa fa-times fa-fw" aria-hidden="true"></i> '.gral_cancel.'</button>';
					$strSalida.= $crlf.'	</div>';
					$strSalida.= $crlf.'</div>';
					$strSalida.= '</form>';
				}
			}
			else {
				//Agrego el campo clave solamente para que sea necesario eliminar registros
				if  ($this->allowDelete) {
					$this->createFormHidden();
				}
			}
		}

		echo $strSalida;
	}

	public function createFormHidden() {
		global $crlf;

		$strSalida = '';
		$strSalida.= $crlf.'<form id="frm'. $this->tabladb .'" class="mt-4 frmObjeto" method="post" onSubmit="return false;">';
		$strSalida.= $crlf.'<input type="hidden" id="hdnTabla" value="'.$this->tabladb.'" />';
		$strSalida.= $crlf.'<input type="hidden" id="hdnOperacion" value="0" />';

		$fieldID = $this->fields[$this->IDField];
		$fieldID["isHiddenInForm"] = true;

		$strSalida.= $crlf . $this->createField($fieldID);

		$strSalida.= '</form>';
		echo $strSalida;
	}

	public function createField($field, $prefix = '', $conBuscador = false)	{
		global $crlf, $config, $formatDateJS;

		$strSalida = '';

		if ($prefix == '') {
			if ($field["controlAlias"] == '') {
				$fname = $field['name'];
			}
			else {
				$fname = $field['controlAlias'];
			}
		} else {
			if ($field["controlAlias"] == '') {
				$fname = $prefix  .'-'. $field['name'];
			}
			else {
				$fname = $prefix  .'-'. $field['controlAlias'];
			}
		}


		//if (!$field['isMasterID'] && $field['showOnForm']) {
		if ($field['showOnForm'] || ($prefix == 'search')) {
			if (($field['isHiddenInForm'] || $field["type"] == 'hidden') && ($prefix != 'search')) {
				$strSalida.= $crlf.'<input type="hidden" id="'.$fname.'" name="'.$fname.'" value="'.$field['value'].'" />';
			} else {
				$strSalida.= $crlf.'<div id="formGroup-'.$fname.'" class="form-group row '.$field['cssGroup'].'">';

				if ($field['type'] != 'checkbox') {
					$strSalida.= $crlf.'<label for="'.$fname.'" class="col-form-label col-form-label-sm col-md-2">'.$field['label'].':</label>';

					if ($field['size'] <= 20) {
						$strSalida.= $crlf.'<div class="col-md-2">';
					} elseif ($field['size'] <= 40) {
						$strSalida.= $crlf.'<div class="col-md-3">';
					} elseif ($field['size'] <= 80) {
						$strSalida.= $crlf.'<div class="col-md-4">';
					} elseif ($field['size'] <= 160) {
						$strSalida.= $crlf.'<div class="col-md-5">';
					} elseif ($field['size'] <= 200) {
						$strSalida.= $crlf.'<div class="col-md-6">';
					} else {
						$strSalida.= $crlf.'<div class="col-md-10">';
					}
				}

				switch ($field["type"]) {
					case 'text':
					case 'email':
					case 'password':
					case 'color':
						$strSalida.= $crlf.'<input type="'.$field['type'].'" class="form-control form-control-sm '.$field['cssControl'].'" id="'.$fname.'" name="'.$fname.'" '. ($field['required']?'required':'') .' '. ($field['size'] > 0?'size="'.$field['size'].'"':'') .' '. ($field['readOnly']?'readonly':'') .' '. ($field['value']!=''?'value="'.$field['value'].'"':'') .' '. ($field['onChange'] !=''?'onchange="'.$field['onChange'].'"':'');
						foreach ($field['attrControl'] as $key => $value) {
							$strSalida.= ' '. $key .'="'. $value .'"';
						}
						$strSalida.= '/>';
					break;

					case 'number':
						$strSalida.= $crlf.'<input type="'.$field['type'].'" step="'.$field["step"].'" class="form-control form-control-sm '.$field['cssControl'].'" id="'.$fname.'" name="'.$fname.'" '. ($field['required']?'required':'') .' '. ($field['size'] > 0?'size="'.$field['size'].'"':'') .' '. ($field['readOnly'] && $prefix!='search'?'readonly':'') .' '. ($field['value']!=''?'value="'.$field['value'].'"':'') .' '. ($field['onChange'] !=''?'onchange="'.$field['onChange'].'"':'');
						foreach ($field['attrControl'] as $key => $value) {
							$strSalida.= ' '. $key .'="'. $value .'"';
						}
						$strSalida.= '/>';
					break;

					case 'file':
						if ($field["required"] == false) {
							$strSalida.= $crlf.'<button id="btnBorrar'.$fname.'" type="button" class="btn btn-secondary" title="'.gral_delete.'" onclick="borrar(\''.$fname.'\');"><i class="fa fa-times" aria-hidden="true"></i></button>';
							$strSalida.= $crlf.'<input id="hdn'.$fname.'-Clear" type="hidden" value="0" />';
						}
						$strSalida.= $crlf.'<input type="'.$field['type'].'" onchange="$(\'#hdn'.$fname.'-Clear\').val(0);" class="form-control form-control-sm" id="'.$fname.'" name="'.$fname.'" '. ($field['required']?'required':'') .' '. ($field['size'] > 0?'size="'.$field['size'].'"':'') .' '. ($field['readOnly']?'readonly':'') .' '. ($field['value']!=''?'value="'.$field['value'].'"':'') .'/>';
					break;

					case 'image':
						$strSalida.= $crlf.'<div id="divPreview'.$fname.'" class="divPreview"></div>';
						if ($field["required"] == false) {
							$strSalida.= $crlf.'<button id="btnBorrar'.$fname.'" type="button" class="btn btn-secondary" title="'.gral_delete.'" onclick="borrar(\''.$fname.'\');"><i class="fa fa-times" aria-hidden="true"></i></button>';
							$strSalida.= $crlf.'<input id="hdn'.$fname.'-Clear" type="hidden" value="0" />';
						}
						$strSalida.= $crlf.'<input onchange="preview(event, $(\'#divPreview'.$fname.'\')); $(\'#hdn'.$fname.'-Clear\').val(0);" type="file" class="form-control form-control-sm" id="'.$fname.'" name="'.$fname.'" '. ($field['required']?'required':'') .' '. ($field['size'] > 0?'size="'.$field['size'].'"':'') .' '. ($field['readOnly']?'readonly':'') .' '. ($field['value']!=''?'value="'.$field['value'].'"':'') .'/>';
					break;

					case 'image-multiple':
						$strSalida.= $crlf.'<div id="divPreview'.$fname.'" class="divPreview"></div>';
						if ($field["required"] == false) {
							$strSalida.= $crlf.'<button id="btnBorrar'.$fname.'" type="button" class="btn btn-secondary" title="'.gral_delete.'" onclick="borrar(\''.$fname.'\');"><i class="fa fa-times" aria-hidden="true"></i></button>';
							$strSalida.= $crlf.'<input id="hdn'.$fname.'-Clear" type="hidden" value="0" />';
						}
						$strSalida.= $crlf.'<input type="file" multiple onchange="preview(event, $(\'#divPreview'.$fname.'\')); $(\'#hdn'.$fname.'-Clear\').val(0);" class="form-control form-control-sm" id="'.$fname.'" name="'.$fname.'" '. ($field['required']?'required':'') .' '. ($field['size'] > 0?'size="'.$field['size'].'"':'') .' '. ($field['readOnly']?'readonly':'') .' '. ($field['value']!=''?'value="'.$field['value'].'"':'') .'/>';
					break;

					case 'textarea':
						$strSalida.= $crlf.'<textarea class="form-control form-control-sm autogrow '.$field['cssControl'].'" id="'.$fname.'" name="'.$fname.'" '. ($field['required']?'required':'') .' '. ($field['readOnly']?'readonly':'');
						foreach ($field['attrControl'] as $key => $value) {
							$strSalida.= ' '. $key .'="'. $value .'"';
						}
						$strSalida.= '></textarea>';
						$strSalida.= $crlf.'<script type="text/javascript">';
						$strSalida.= $crlf.'$("#'.$fname.'").autogrow({vertical: true, horizontal: false, minHeight: 36});';
						$strSalida.= $crlf.'</script>';
					break;

					case 'select':
						if ($conBuscador) {
							$strSalida.= $crlf.'<div class="input-group">';
							$strSalida.= $crlf.'	<input type="text" class="form-control form-control-sm" id="buscar'.$fname.'" data-field="'. ($field['controlAlias'] == ''? $field['name']: $field['controlAlias']) .'">';
							$strSalida.= $crlf.'	<span class="input-group-btn">';
							$strSalida.= $crlf.'		<button type="button" class="btn btn-sm btn-secondary" title="Buscar" onclick="buscarCampo(\''.$fname.'\', \'\')"><i class="fa fa-search"></i></button>';
							$strSalida.= $crlf.'	</span>';
							$strSalida.= $crlf.'</div>';
						}
						$strSalida.= $crlf.'<select class="form-control form-control-sm ucase '.$field['cssControl'].'" id="'.$fname.'" name="'.$fname.'" '. ($field['required']?'required':'') .' '. ($field['readOnly']?'readonly disabled':'') .' '. ($field['onChange'] !=''?'onchange="'.$field['onChange'].'"':'') .' '. ($conBuscador?' disabled':'') .'>';
						if ($field['lookupTable'] != '' && !$conBuscador) {
							$strSalida.= $crlf. $config->cargarCombo($field['lookupTable'], $field['lookupFieldID'], $field['lookupFieldLabel'], $field['lookupConditions'], $field['lookupOrder'], $field['value'], ($prefix == ''? $field['itBlank']: true), $field['itBlankText'], $field['lookupTableAlias']);
						}
						$strSalida.= $crlf.'</select>';

						if ($conBuscador) {
							$strSalida.= $crlf.'<script>';
							$strSalida.= $crlf.'$(document).ready(function() {';
							$strSalida.= $crlf.'	$("#buscar'.$fname.'").keydown(kdown_'. \str_ireplace('-', '_', $fname) .');';
							$strSalida.= $crlf.'});';

							$strSalida.= $crlf;
							$strSalida.= $crlf.'function kdown_'.\str_ireplace('-', '_', $fname).'(event) {';
							$strSalida.= $crlf.'	var charcode = (event.which) ? event.which : window.event.keyCode;';
							$strSalida.= $crlf.'	if (charcode == 13) {';
							$strSalida.= $crlf.'		event.preventDefault();';
							$strSalida.= $crlf.'		buscarCampo("'.$fname.'", "");';
							$strSalida.= $crlf.'		return false;';
							$strSalida.= $crlf.'	}';
							$strSalida.= $crlf.'	else {';
							$strSalida.= $crlf.'		return true;';
							$strSalida.= $crlf.'	}';
							$strSalida.= $crlf.'}';
							$strSalida.= $crlf.'</script>';
						}
					break;

					case 'selectmultiple':
						$strSalida.= $crlf.'<select class="form-control form-control-sm ucase selectpicker '.$field['cssControl'].'" multiple id="'.$fname.'" name="'.$fname.'" '. ($field['required']?'required':'') .' title="'.gral_select.'" '. ($field['readOnly']?'readonly':'') .' '. ($field['onChange'] !=''?'onchange="'.$field['onChange'].'"':'') .'>';
                        if ($field['lookupTable'] != '') {
                            $strSalida.= $crlf. $config->cargarCombo($field['lookupTable'], $field['lookupFieldID'], $field['lookupFieldLabel'], $field['lookupConditions'], $field['lookupOrder'], $field['value'], $field['itBlank'], $field['itBlankText'], $field['lookupTableAlias']);
                        }
						$strSalida.= $crlf.'</select>';
						$strSalida.= $crlf.'<script type="text/javascript">';
						$strSalida.= $crlf.'$("#'.$fname.'").selectpicker({
								actionsBox: true,
								selectAllText: "Todos",
								deselectAllText: "Ninguno",
								}).selectpicker("deselectAll");';
						$strSalida.= $crlf.'</script>';
					break;

					case 'datalist':
						// $strSalida.= $crlf.'<input class="form-control form-control-sm '.$field['cssControl'].'" list="lst-'.$fname.'" id="'.$fname.'" name="'.$fname.'" '. ($field['isID']?'disabled':'') .' '. ($field['required']?'required':'') .' '. ($field['size'] > 0?'size="'.$field['size'].'"':'') .' '. ($field['readOnly']?'readonly':'') .' '. ($field['onChange'] !=''?'onchange="'.$field['onChange'].'"':'') .'/>';
						$strSalida.= $crlf.'<input class="form-control form-control-sm '.$field['cssControl'].'" list="lst-'.$fname.'" id="'.$fname.'" name="'.$fname.'" '. ($field['required']?'required':'') .' '. ($field['size'] > 0?'size="'.$field['size'].'"':'') .' '. ($field['readOnly']?'readonly':'') .' '. ($field['onChange'] !=''?'onchange="'.$field['onChange'].'"':'') .'/>';
						$strSalida.= $crlf.'<datalist id="lst-'.$fname.'">';
						$strSalida.= $crlf. $config->cargarCombo($field['lookupTable'], $field['lookupFieldLabel'], '', $field['lookupConditions'], $field['lookupOrder'], $field['value'], ($prefix == ''? $field['itBlank']: true), $field['itBlankText'], $field['lookupTableAlias']);
						$strSalida.= $crlf.'</datalist>';
					break;

					case 'checkbox':
						if ($field['size'] <= 20) {
							$strSalida.= $crlf.'<div class="col-md-4 offset-md-2">';
						} elseif ($field['size'] <= 40) {
							$strSalida.= $crlf.'<div class="col-md-5 offset-md-2">';
						} elseif ($field['size'] <= 80) {
							$strSalida.= $crlf.'<div class="col-md-6 offset-md-2">';
						} elseif ($field['size'] <= 160) {
							$strSalida.= $crlf.'<div class="col-md-7 offset-md-2">';
						} elseif ($field['size'] <= 200) {
							$strSalida.= $crlf.'<div class="col-md-8 offset-md-2">';
						} else {
							$strSalida.= $crlf.'<div class="col-md-10 offset-md-2">';
						}

						// $strSalida.= $crlf.'<div class="col-md-4 offset-md-2">';
						$strSalida.= $crlf.'<label class="labelCheck ucase">';
						$strSalida.= $crlf.'<input type="checkbox" id="'.$fname.'" name="'.$fname.'" '. ($field['readOnly']?'readonly':'') .' '. (boolval($field["value"])? 'checked': '') .' '.($field['onChange'] !=''?'onchange="'.$field['onChange'].'"':'').'> '. $field['label'];
						$strSalida.= $crlf.'</label>';
					break;

					case 'datetime':
						$strSalida.= $crlf.'<div class="input-group date margin-bottom-sm inp'.$fname.'">';
						$strSalida.= $crlf.'<input type="text" class="form-control form-control-sm dtpPicker '.$field['cssControl'].'" id="'.$fname.'" name="'.$fname.'" size="16" value="'.$field["value"].'" '. ($field['readOnly']?'readonly disabled':'') . ($prefix != 'search'?' autocomplete="off"': '') .' />';
						$strSalida.= $crlf.'<div class="input-group-append">';
						$strSalida.= $crlf.'<span class="input-group-text" onclick="$(\'#'.$fname.'\').focus();"><i class="fa fa-calendar fa-fw"></i></span>';
						// $strSalida.= $crlf.'<button class="btn btn-sm btn-outline-secondary" type="button" data-toggle onclick="$(\'#'. $fname .'\').datetimepicker(\'show\');"><i class="fa fa-calendar fa-fw"></i></button>';
						// if ($prefix == 'search') {
						// 	$strSalida.= $crlf.'<button class="btn btn-sm btn-outline-secondary" type="button" title="Limpiar" data-clear><i class="fa fa-times fa-fw"></i></button>';
						// }
						$strSalida.= $crlf.'</div>';
						$strSalida.= $crlf.'</div>';
						if ($field['mirrorField'] != '') {
							$strSalida.= $crlf.'<input type="hidden" id="'. $field['mirrorField'] .'" />';
						}

						if (!$field["readOnly"]) {
							$strSalida.= $crlf.'<script type="text/javascript">';
							$strSalida.= $crlf.'$("#'.$fname.'").datetimepicker({';
							$strSalida.= $crlf.'	timepicker:true,';
							$strSalida.= $crlf.'	format: "'. $formatDateJS .' HH:mm",';
							$strSalida.= $crlf.'	onShow: function(ct, $i) {';
							$strSalida.= $crlf.'		var h = 0 - ($(".xdsoft_datetimepicker:visible .xdsoft_time_variant").height() / $(".xdsoft_datetimepicker:visible .xdsoft_time").length * $(".xdsoft_datetimepicker:visible .xdsoft_time.xdsoft_current").index());';
							$strSalida.= $crlf.'		$(".xdsoft_datetimepicker:visible .xdsoft_time_variant").css("margin-top", h + "px");';
							$strSalida.= $crlf.'	},';
							$strSalida.= $crlf.'	step: '.($field["step"]!= 1? $field["step"]: '15').',';

							if (isset($_SESSION['Theme'])) {
								$strSalida.= $crlf.'	theme: "dark",';
							}
							$strSalida.= $crlf.'});';
							$strSalida.= $crlf.'</script>';
						}
					break;

					case 'date':
						$strSalida.= $crlf.'<div class="input-group date margin-bottom-sm inp'.$fname.'">';
						$strSalida.= $crlf.'	<input type="text" class="form-control form-control-sm dtpPicker '.$field['cssControl'].'" id="'.$fname.'" name="'.$fname.'" size="10" value="'.$field["value"].'" '. ($field['readOnly']?'readonly disabled':'')  . ($prefix != 'search'?' autocomplete="off"': '') .' />';
						$strSalida.= $crlf.'	<div class="input-group-append">';
						$strSalida.= $crlf.'		<span class="input-group-text" onclick="$(\'#'.$fname.'\').focus();"><i class="fa fa-calendar fa-fw"></i></span>';
						$strSalida.= $crlf.'	</div>';
						$strSalida.= $crlf.'</div>';

						if (!$field["readOnly"]) {
							$strSalida.= $crlf.'<script type="text/javascript">';
							$strSalida.= $crlf.'$("#'.$fname.'").datetimepicker({';
							$strSalida.= $crlf.'	timepicker:false,';
							$strSalida.= $crlf.'	format:"'. $formatDateJS .'",';

							if (isset($_SESSION['Theme'])) {
								$strSalida.= $crlf.'	theme: "dark",';
							}

							$strSalida.= $crlf.'});';
							$strSalida.= $crlf.'</script>';
						}
					break;

					case 'month':
						$strSalida.= $crlf.'<select class="form-control form-control-sm ucase '.$field['cssControl'].'" id="'.$fname.'" name="'.$fname.'" '. ($field['required']?'required':'') .' '. ($field['readOnly']?'readonly disabled':'') .' '. ($field['onChange'] !=''?'onchange="'.$field['onChange'].'"':'') .' '. ($conBuscador?' disabled':'') .'>';
						if ($field['itBlank']) {
							$strSalida.= $crlf.'	<option value="">'.($field['itBlankText'] != ''? $field['itBlankText']: gral_select).'</option>';
						}
						$strSalida.= $crlf.'	<option value="1">ENERO</option>';
						$strSalida.= $crlf.'	<option value="2">FEBRERO</option>';
						$strSalida.= $crlf.'	<option value="3">MARZO</option>';
						$strSalida.= $crlf.'	<option value="4">ABRIL</option>';
						$strSalida.= $crlf.'	<option value="5">MAYO</option>';
						$strSalida.= $crlf.'	<option value="6">JUNIO</option>';
						$strSalida.= $crlf.'	<option value="7">JULIO</option>';
						$strSalida.= $crlf.'	<option value="8">AGOSTO</option>';
						$strSalida.= $crlf.'	<option value="9">SEPTIEMBRE</option>';
						$strSalida.= $crlf.'	<option value="10">OCTUBRE</option>';
						$strSalida.= $crlf.'	<option value="11">NOVIEMBRE</option>';
						$strSalida.= $crlf.'	<option value="12">DICIEMBRE</option>';
						$strSalida.= $crlf.'</select>';
					break;

					case 'time':
						$strSalida.= $crlf.'<div class="input-group date margin-bottom-sm inp'.$fname.'">';
						$strSalida.= $crlf.'<input type="time" class="form-control form-control-sm dtpPicker '.$field['cssControl'].'" id="'.$fname.'" name="'.$fname.'" size="16" value="'.$field["value"].'" '. ($field['required']?'required':'') .' '. ($field['readOnly']?'readonly disabled':'') .' data-input autocomplete="off" />';
						$strSalida.= $crlf.'<div class="input-group-append">';
						$strSalida.= $crlf.'<span class="input-group-text"><i class="fa fa-calendar fa-fw"></i></span>';
						// $strSalida.= $crlf.'<button class="btn btn-sm btn-outline-secondary" type="button" data-toggle onclick="$(\'#'. $fname .'\').datetimepicker(\'show\');"><i class="fa fa-calendar fa-fw"></i></button>';
						// if ($prefix == 'search') {
						// 	$strSalida.= $crlf.'<button class="btn btn-sm btn-outline-secondary" type="button" title="Limpiar" data-clear><i class="fa fa-times fa-fw"></i></button>';
						// }
						$strSalida.= $crlf.'</div>';
						$strSalida.= $crlf.'</div>';
						if (!$field["readOnly"]) {
							$strSalida.= $crlf.'<script type="text/javascript">';
							$strSalida.= $crlf.'$("#'.$fname.'").datetimepicker({';
							$strSalida.= $crlf.'	datepicker: false,';
							$strSalida.= $crlf.'	timepicker: true,';
							$strSalida.= $crlf.'	format: "HH:mm",';
							$strSalida.= $crlf.'	step: '.($field["step"]!= 1? $field["step"]: '15').',';
							$strSalida.= $crlf.'	onShow: function(ct, $i) {';
							$strSalida.= $crlf.'		var h = 0 - ($(".xdsoft_datetimepicker:visible .xdsoft_time_variant").height() / $(".xdsoft_datetimepicker:visible .xdsoft_time").length * $(".xdsoft_datetimepicker:visible .xdsoft_time.xdsoft_current").index());';
							$strSalida.= $crlf.'		$(".xdsoft_datetimepicker:visible .xdsoft_time_variant").css("margin-top", h + "px");';
							$strSalida.= $crlf.'	},';

							if (isset($_SESSION['Theme'])) {
								$strSalida.= $crlf.'	theme: "dark",';
							}

							$strSalida.= $crlf.'});';
							$strSalida.= $crlf.'</script>';
						}
					break;

					case "ckeditor":
						$strSalida.= $crlf.'<textarea class="form-control form-control-sm" id="'.$fname.'" name="'.$fname.'" '. ($field['required']?'required':'') .' '. ($field['readOnly']?'readonly':'') .'></textarea>';
						$strSalida.= $crlf.'<script type="text/javascript">';
						$strSalida.= $crlf.'CKEDITOR.replace( "'.$fname.'" );';
						$strSalida.= $crlf.'</script>';
					break;

					case "gmaps":
						$strSalida.= $crlf.'<input type="hidden" id="'.$fname.'" name="'.$fname.'" />';
						$strSalida.= $crlf.'<input type="text" class="form-control form-control-sm '.$field['cssControl'].'" id="'.$fname.'-buscar" placeholder="Ingrese dirección" onkeydown="if (event.keyCode == 13) return false;" />';
						$strSalida.= $crlf.'</div>';
						// $strSalida.= $crlf.'<div class="col-md-2">';
						// $strSalida.= $crlf.'<button type="button" class="btn btn-secondary" id="'.$fname.'-btnBuscar" onclick="buscarLoc($(\'#'.$fname.'-buscar\').val(), \'#'.$fname.'\')">Buscar</button>';
						// $strSalida.= $crlf.'</div>';
						$strSalida.= $crlf.'</div>';
						$strSalida.= $crlf.'<div class="form-group">';
						$strSalida.= $crlf.'<div class="col-md-10 offset-md-2">';
						$strSalida.= $crlf.'<div id="map" style="height: 500px;" data-campo="#'.$fname.'"></div>';
					break;

					default:
						// $strSalida.= $crlf.'<input type="text" class="form-control form-control-sm '.$field['cssControl'].'" id="'.$fname.'" name="'.$fname.'" '. ($field['isID']?'disabled':'') .' '. ($field['required']?'required':'') .' '. ($field['size'] > 0?'size="'.$field['size'].'"':'') .' '. ($field['readOnly']?'readonly':'') .' value="'.$field["value"].'" '. ($field['onChange'] !=''?'onchange="'.$field['onChange'].'"':'') .'/>';
						$strSalida.= $crlf.'<input type="text" class="form-control form-control-sm '.$field['cssControl'].'" id="'.$fname.'" name="'.$fname.'" '. ($field['required']?'required':'') .' '. ($field['size'] > 0?'size="'.$field['size'].'"':'') .' '. ($field['readOnly']?'readonly':'') .' value="'.$field["value"].'" '. ($field['onChange'] !=''?'onchange="'.$field['onChange'].'"':'');
						foreach ($field['attrControl'] as $key => $value) {
							$strSalida.= ' '. $key .'="'. $value .'"';
						}
						$strSalida.= '/>';
					break;
				}

				$strSalida.= $crlf.'</div>'; //col-md
				$strSalida.= $crlf.'</div>'; //form-group
			}
		}

		return $strSalida;
	}

	public function listar($strFiltro = "", $conBotones = true, $btnList = [], $order = '', $pagina = 1, $strFiltroSQL = '', $conCheckboxes = false)
	{
		global $config, $crlf, $nombSistema, $formatDateDB;

		$resultado = [];
		$joins = [];

		$numeCarg = intval($config->buscarDato("SELECT NumeCarg FROM ".$config->tbLogin." WHERE NumeUser = ". $_SESSION["NumeUser"]));

		$strSalida = '';

		if (isset($this->fields)) {
			$strSQL = "SELECT ";

			$strFields = '';
			$arrFields = [];
			foreach ($this->fields as $field) {
				if ($field['type'] != "calcfield" && $field['type'] != "eval" && $field["showOnList"] != false) {

					if ($field['formatDb'] == '') {

						if ($field['type'] != "select" && $field["type"] != "selectmultiple") {
							if ($field['type'] != "datetime" && $field["type"] != "date") {
								if (!\in_array($this->tabladb. "." .$field['name']. " " .$field["nameAlias"], $arrFields)) {
									$arrFields[] = $this->tabladb. "." .$field['name']. " " .$field["nameAlias"];
								}
							}
							else {
								if ($field['type'] == "datetime") {
									$strAux = 'DATE_FORMAT('. $this->tabladb. "." .$field['name']. ", '". $formatDateDB ." %H:%i') " . ($field["nameAlias"] != ''? $field["nameAlias"]: $field["name"]);
									if (!\in_array($strAux, $arrFields)) {
										$arrFields[] = $strAux;
									}
								}
								else {
									$strAux = 'DATE_FORMAT('. $this->tabladb. "." .$field['name']. ", '". $formatDateDB ."') " . ($field["nameAlias"] != ''? $field["nameAlias"]: $field["name"]);
									if (!\in_array($strAux, $arrFields)) {
										$arrFields[] = $strAux;
									}
								}
							}
						}
						else {
							if (!\in_array($this->tabladb. "." .$field['name'], $arrFields)) {
								$arrFields[] = $this->tabladb. "." .$field['name'];
							}

							if ($field['type'] == "select") {
								if ($field["lookupTableAlias"] == "") {
									if ($field["lookupTable"] != "") {
										$arrFields[] = $field["lookupTable"]. "." .$field['lookupFieldLabel']. " " .$field["nameAlias"];
									}
								} else {
									$arrFields[] = $field["lookupTableAlias"]. "." .$field['lookupFieldLabel']. " " .$field["nameAlias"];
								}
							}
						}
					} else {
						$arrFields[] = $field['formatDb']. " " .$field["nameAlias"];

						// if ($field['type'] != "select" && $field["type"] != "selectmultiple") {
						// 	$arrFields[] = $field['formatDb']. " " .$field["nameAlias"];
						// } else {
						// 	if ($field["lookupTableAlias"] == "") {
						// 		if ($field["lookupTable"] != "") {
						// 			$arrFields[] = $field["lookupTable"]. "." .$field['formatDb']. " " .$field["nameAlias"];
						// 		}
						// 	} else {
						// 		$arrFields[] = $field["lookupTableAlias"]. "." .$field['formatDb']. " " .$field["nameAlias"];
						// 	}
						// }
					}
				}
			}

			if ($this->orderField != '') {
				if ($strFields != '') {
					$arrFields[] = $this->tabladb. "." .$this->orderField;
				} else {
					$arrFields[] = $this->tabladb. "." .$this->orderField;
				}
			}

			$strFields = \implode($crlf.', ', $arrFields);
			$strSQL.= $strFields;

			$strSQL.= $crlf." FROM ". $this->tabladb;

			//JOINS
			$strJoins = '';
			foreach ($this->fields as $field) {
				if (($field['type'] == "select") && ($field['showOnList'])) {
					if ($field['lookupTableAlias'] == '') {
						if ($field["lookupTable"] != "") {
							if (!\in_array($field["lookupTable"], $joins)) {
								$joins[] = $field["lookupTable"];
								$strJoins.= $crlf." LEFT JOIN ". $field["lookupTable"] ." ON ". $this->tabladb .".". $field['name'] ." = ". $field["lookupTable"]. "." .$field['lookupFieldID'];

								if ($field["joinConditions"] != "") {
									$strJoins.= $crlf." AND ".$field["joinConditions"];
								}
							}
						}
					} else {
						if (!\in_array($field["lookupTableAlias"], $joins)) {
							$joins[] = $field["lookupTableAlias"];
							$strJoins.= $crlf." LEFT JOIN ". $field["lookupTable"] ." ". $field["lookupTableAlias"] ." ON ". $this->tabladb .".". $field['name'] ." = ". $field["lookupTableAlias"]. "." .$field['lookupFieldID'];

							if ($field["joinConditions"] != "") {
								$strJoins.= $crlf." AND ".$field["joinConditions"];
							}
						}
					}
				}
			}

			$strSQL.= $strJoins;

			$filtro = '';
			if ($this->masterFieldId != '') {
				if (isset($_REQUEST[$this->masterFieldId])) {
					$filtro.= $crlf. $this->tabladb .'.'. $this->masterFieldId ." = '" . $_REQUEST[$this->masterFieldId] ."'";
				}
			}

			//Filtro por formulario
			if ($strFiltro != "") {
				foreach ($strFiltro as $key => $data) {
					if ($filtro != "") {
						$filtro.= $crlf." ".$data["join"];
					}

					switch ($data["type"]) {
						case 'datetime':
							$data["name"] = "DATE_FORMAT({$data["name"]}, '%Y-%m-%d %H:%i')";
							$data["value"] = "'". $data["value"] . "'";
							// $data["value"] = "STR_TO_DATE('". $data["value"] . "', '%Y-%m-%d %H:%i')";
						break;

						case 'date':
							$data["name"] = "DATE_FORMAT({$data["name"]}, '%Y-%m-%d')";
							$data["value"] = "'". $data["value"] . "'";
							// $data["value"] = "STR_TO_DATE('". $data["value"] . "', '%Y-%m-%d')";
						break;

						case 'time':
							$data["name"] = "DATE_FORMAT({$data["name"]}, '%H:%i')";
							$data["value"] = "'". $data["value"] . "'";
							// $data["value"] = "STR_TO_DATE('". $data["value"] . "', '%H:%i')";
						break;

						default:
							switch (\strtoupper($data["operator"])) {
								case 'LIKE':
									// $data["value"] = "'%". $data["value"] . "%'";

									$strAux = '';
									$palabras = explode(" ", $data["value"]);

									foreach ($palabras as $palabra) {
										if ($strAux != '') {
											$strAux.= " AND ";
										}

										$strAux.= "({$data["name"]} LIKE '%{$palabra}%')";
									}
									$data["value"] = $strAux;
								break;

								case '=':
									$data["value"] = "'". $data["value"] . "'";
								break;

								case 'IN':
									$aux = \explode(',' , $data["value"]);
									$aux2 = '';
									foreach ($aux as $valor) {
										$valor = "'". trim($valor) ."'";

										if ($aux2 != '') $aux2.= ',';
										$aux2.= $valor;
									}
									$data["value"] = "(". $aux2 . ")";
								break;
							}
						break;
					}

					switch (\strtoupper($data["operator"])) {
						case 'CUSTOM':
						case 'LIKE':
							$filtro.= $crlf. $data["value"];
						break;

						default:
							$filtro.= $crlf. $data["name"] ." ". $data["operator"] ." ". $data["value"];
						break;
					}
				}
			}

			//Filtro por código sql de la clase
			if ($this->filterSQL != "") {
				if ($filtro != "") {
					$filtro.= $crlf." AND";
				}

				$filtro.= $crlf." ".$this->filterSQL;
			}

			//Filtro por código sql pasado por parámetro
			if ($strFiltroSQL != "") {
				if ($filtro != "") {
					$filtro.= $crlf." AND";
				}

				$filtro.= $crlf." ".$strFiltroSQL;
			}

			//Filtro por cargo
			if (count($this->filterxCargo) > 0) {
				foreach ($this->filterxCargo as $cargo => $filtroCargo) {
					if ($cargo == $numeCarg) {
						if ($filtro != "") {
							$filtro.= $crlf." AND";
						}

						$filtro.= $crlf." ".$filtroCargo;
					}
				}
			}

			if ($filtro != "") {
				$strSQL.= $crlf." WHERE ".$filtro;
			}

			if ($order != '') {
				$strSQL.= $crlf." ORDER BY ". $order;
			} elseif ($this->order != '') {
				$strSQL.= $crlf." ORDER BY ". $this->order;
			}

			if ($this->paginacion && $pagina > -1) {
				$strSQL.= $crlf." LIMIT ". (($pagina-1) * $this->pageRows) .", ". $this->pageRows;
			}

			if (isset($_SESSION[$nombSistema. "_debug"])) {
				$resultado["sql"] = $strSQL;
			}

			$tabla = $config->cargarTabla($strSQL);

			if ($tabla) {
				if ($tabla->num_rows > 0) {

					if ($this->paginacion && $pagina > -1) {
						$strSQL = "SELECT COUNT(*)";
						$strSQL.= $crlf."FROM ". $this->tabladb;

						$strSQL.= $strJoins;

						if ($filtro != "") {
							$strSQL.= $crlf."WHERE ".$filtro;
						}
						$cantTotRows = $config->buscarDato($strSQL);

						$cantPages = ceil($cantTotRows / $this->pageRows);

						$resultado["num_rows"] = $cantTotRows;

						require_once 'paginator.php';

						$paginador = new \VectorForms\Paginator($cantTotRows, $this->pageRows, $pagina, '', 'intPagina = (:num); listar'. $this->tabladb .'();');
						$paginador->setMaxPagesToShow(20);

						$strSalida.= $crlf. $paginador->toHtml();
					}
					else {
						$resultado["num_rows"] = $tabla->num_rows;
					}

					$strSalida.= $crlf.'<table id="tbl'.$this->name.'" class="table table-striped table-bordered table-hover table-sm table-responsive-sm'. ($this->orderColumns? ' sortable': '') .'">';
					$strSalida.= $crlf.'<thead>';
					$strSalida.= $crlf.'<tr>';
					$I = 0;

					//Si tiene checkboxes
					if ($conCheckboxes) {
						$strSalida.= $crlf.'<th class="noPrn noXLS text-center">Selección</th>';
						$I++;
					}

					foreach ($this->fields as $field) {
						if ($field['showOnList'] && ($field["numeCarg"] === '' || $field["numeCarg"] >= $numeCarg)) {
							if (!$field['isHiddenInList']) {
								$strSalida.= $crlf.'<th class="text-'. $field['txtAlign'] . ($this->orderColumns? ' clickable': '') . (!$field["print"]? ' noPrn': '') .'" '. ($this->orderColumns? 'onclick="ordenar('.$I.', this);"': '') .'>'. $field['label'] .'</th>';
								$I++;
							}
						}
					}

					if ($conBotones) {
						//Botones de la clase
						if (count($this->btnList) > 0) {
							foreach ($this->btnList as $btn) {
								if ($btn->numeCarg === '' || $btn->numeCarg >= $numeCarg) {
									$strSalida.= $crlf.'<th class="noPrn noXLS text-center">'.$btn->titulo.'</th>';
								}
							}
						}

						//Orden
						if ($this->orderField != '') {
							$strSalida.= $crlf.'<th class="noPrn noXLS"></th>';
						}

						//Editar
						if ($this->allowEdit && $this->numeCargEdit >= $numeCarg) {
							$strSalida.= $crlf.'<th class="noPrn noXLS"></th>';
						}

						//Borrar
						if ($this->allowDelete && $this->numeCargDelete >= $numeCarg) {
							$strSalida.= $crlf.'<th class="noPrn noXLS"></th>';
						}
					}

					//Botones del método
					if (count($btnList) > 0) {
						foreach ($btnList as $btn) {
							if ($btn->numeCarg === '' || $btn->numeCarg >= $numeCarg) {
								$strSalida.= $crlf.'<th class="noPrn noXLS text-center">'.$btn->titulo.'</th>';
							}
						}
					}

					$strSalida.= $crlf.'</thead>';
					$strSalida.= $crlf.'</tr>';
					$strSalida.= $crlf.'<tbody>';

					// $strFootValue = 0;
					// $colFooter = 0;

					while ($fila = $tabla->fetch_assoc()) {
						$col = 0;

						$strSalida.= $crlf.'<tr id="vFila'. $fila[$this->IDField] .'">';

						//Si tiene checkboxes
						if ($conCheckboxes) {
							$strSalida.= $crlf.'<td class="noPrn noXLS text-center"><input id="chk-'.$fila[$this->IDField].'" type="checkbox" value="'.$fila[$this->IDField].'"></td>';
						}

						foreach ($this->fields as $field) {
							if ($field["nameAlias"] == '') {
								$fname = $field['name'];
							} else {
								$fname = $field['nameAlias'];
							}

							if ($field['showOnList'] && ($field["numeCarg"] === '' || $field["numeCarg"] >= $numeCarg)) {
								if ($field['isHiddenInList']) {
									switch ($field["type"]) {
										case 'eval':
											$dato = eval($field["evalData"]);
											$strSalida.= $crlf.'<input type="hidden" id="'.$fname. $dato.'" value="'.htmlentities($dato, ENT_QUOTES, 'UTF-8').'" />';
										break;

										default:
											$strSalida.= $crlf.'<input type="hidden" id="'.$fname. $fila[$this->IDField].'" value="'.htmlentities($fila[$fname], ENT_QUOTES, 'UTF-8').'" />';
										break;
									}
								} else {
									switch ($field["type"]) {
										case 'select':
											if ($field["nameAlias"] == '') {
												$fnameLookup = $field['lookupFieldLabel'];
											} else {
												$fnameLookup = $field['nameAlias'];
											}

											if (isset($fila[$fnameLookup]) && $fila[$fnameLookup] != '') {
												$dato = $fila[$fnameLookup];
											}
											elseif ($field["value"] != '') {
												$dato = $field["value"];
											}
											elseif ($field['itBlank']) {
												$dato = $field["itBlankTextList"];
											}
											else {
												$dato = '';
											}

											$strSalida.= $crlf.'<td id="'.$fnameLookup . $fila[$this->IDField].'" data-valor="'. str_replace('"', '', $dato) .'" class="text-'. $field['txtAlign'] .' '. $field["cssList"] .' '. (eval($field["condFormat"])? $field["classFormat"]: '') . (!$field["print"]? ' noPrn': '') .'"';
											foreach ($field['attrList'] as $key => $value) {
												$strSalida.= ' '. $key .'="'. $value .'"';
											}
											$strSalida.= '>';
											$strSalida.= $crlf.$field["txtBefore"].$dato.$field["txtAfter"];

											$strSalida.= $crlf.'<input type="hidden" id="'.$fname. $fila[$this->IDField].'" value="'.$fila[$field["name"]].'" />';
											$strSalida.= $crlf.'</td>';
										break;

										case 'selectmultiple':
											if ($field["nameAlias"] == '') {
												$fnameLookup = $field['lookupFieldLabel'];
											} else {
												$fnameLookup = $field['nameAlias'];
											}

											if ($fila[$field["name"]] != '') {
												$tbSM = $config->cargarTabla("SELECT {$fnameLookup} FROM {$field['lookupTable']} WHERE {$field['lookupFieldID']} IN ({$fila[$field["name"]]})");
												$dato = "";
												if ($tbSM->num_rows > 0) {
													while ($filaSM = $tbSM->fetch_row()) {
														if ($dato != '') {
															$dato.= ', ';
														}
														$dato.= $filaSM[0];
													}
												}
											}
											else {
												$dato = '';
											}
											$strSalida.= $crlf.'<td id="'.$fnameLookup . $fila[$this->IDField].'" data-valor="'. str_replace('"', '', $dato) .'" class="text-'. $field['txtAlign'] .' '. $field["cssList"] .' '. (eval($field["condFormat"])? $field["classFormat"]: '') . (!$field["print"]? ' noPrn': '') .'"';
											foreach ($field['attrList'] as $key => $value) {
												$strSalida.= ' '. $key .'="'. $value .'"';
											}
											$strSalida.= '>';
											$strSalida.= $crlf.$field["txtBefore"].$dato.$field["txtAfter"];

											$strSalida.= $crlf.'<input type="hidden" id="'.$fname. $fila[$this->IDField].'" value="'.$fila[$field["name"]].'" />';
											$strSalida.= $crlf.'</td>';
										break;

										case 'calcfield':
											$post['field'] = $field['name'];
											$post['dato'] = $fila[$this->IDField];
											$dato = $this->customFunc($post);

											$strSalida.= $crlf.'<td id="'.$fname. $fila[$this->IDField].'" data-valor="'. str_replace('"', '', $dato) .'" class="text-'. $field['txtAlign'] .' '. $field["cssList"] .' '. (eval($field["condFormat"])? $field["classFormat"]: '') . (!$field["print"]? ' noPrn': '') .'"';
											foreach ($field['attrList'] as $key => $value) {
												$strSalida.= ' '. $key .'="'. $value .'"';
											}
											$strSalida.= '>';
											$strSalida.= $crlf.$field["txtBefore"].$dato.$field["txtAfter"];
											$strSalida.= $crlf.'</td>';
										break;

										case 'eval':
											$dato = eval($field["evalData"]);
											$strSalida.= $crlf.'<td id="'.$fname. $fila[$this->IDField].'" data-valor="'. str_replace('"', '', $dato) .'" class="text-'. $field['txtAlign'] .' '. $field["cssList"] .' '. (eval($field["condFormat"])? $field["classFormat"]: '') . (!$field["print"]? ' noPrn': '') .'"';
											foreach ($field['attrList'] as $key => $value) {
												$strSalida.= ' '. $key .'="'. $value .'"';
											}
											$strSalida.= '>';
											$strSalida.= $crlf.$field["txtBefore"].$dato.$field["txtAfter"];
											$strSalida.= $crlf.'</td>';
										break;

										case 'image':
										case 'image-multiple':
										case 'file-url':
											$strSalida.= $crlf.'<td class="'. $field["cssList"] . (!$field["print"]? ' noPrn': '') .'"';
											foreach ($field['attrList'] as $key => $value) {
												$strSalida.= ' '. $key .'="'. $value .'"';
											}
											$strSalida.= '>';
											$strSalida.= $crlf.'<input type="hidden" id="'.$fname. $fila[$this->IDField].'" value="'.$fila[$fname].'" />';
											if ($fila[$fname] != '') {
												$strSalida.= $crlf.'<img src="'. $fila[$fname].'" class="thumbnailChico">';
											}
											$strSalida.= $crlf.'</td>';
										break;

										case 'file':
											$strSalida.= $crlf.'<td class="'. $field["cssList"] . (!$field["print"]? ' noPrn': '') .'"';
											foreach ($field['attrList'] as $key => $value) {
												$strSalida.= ' '. $key .'="'. $value .'"';
											}
											$strSalida.= '>';
											$strSalida.= $crlf.'<input type="hidden" id="'.$fname. $fila[$this->IDField].'" value="'.$fila[$fname].'" />';
											$strSalida.= $crlf.$fila[$fname];
											$strSalida.= $crlf.'</td>';
										break;

										case 'checkbox':
											$strSalida.= $crlf.'<td data-valor="'. str_replace('"', '', $fila[$fname]) .'" class="text-'. $field['txtAlign'] .' '. $field["cssList"] . (eval($field["condFormat"])? $field["classFormat"]: '') . (!$field["print"]? ' noPrn': '') .'"';
											foreach ($field['attrList'] as $key => $value) {
												$strSalida.= ' '. $key .'="'. $value .'"';
											}
											$strSalida.= '>';

											$strSalida.= $crlf.'<input type="hidden" id="'.$fname. $fila[$this->IDField].'" value="'.$fila[$fname].'" />';
											if (boolval($fila[$fname])) {
												$strSalida.= $crlf.'<i class="far fa-check-square fa-fw" aria-hidden="true"></i>';
											} else {
												$strSalida.= $crlf.'<i class="far fa-square fa-fw" aria-hidden="true"></i>';
											}
											$strSalida.= $crlf.'</td>';
										break;

										case 'textarea':
											$strSalida.= $crlf.'<td data-valor="'. str_replace('"', '', $fila[$fname]) .'" class="text-'. $field['txtAlign'] .' '. $field["cssList"] .' '. (eval($field["condFormat"])? $field["classFormat"]: '') . (!$field["print"]? ' noPrn': '') .'" id="'.$fname . $fila[$this->IDField].'"';
											foreach ($field['attrList'] as $key => $value) {
												$strSalida.= ' '. $key .'="'. $value .'"';
											}
											$strSalida.= '>';
											$strSalida.= nl2br($fila[$fname]);
											$strSalida.= '</td>';
										break;

										case 'color':
											$strSalida.= $crlf.'<td data-valor="'. str_replace('"', '', $fila[$fname]) .'" class="text-'. $field['txtAlign'] .' '. $field["cssList"] .' '. (eval($field["condFormat"])? $field["classFormat"]: '') . (!$field["print"]? ' noPrn': '') .'"';
											foreach ($field['attrList'] as $key => $value) {
												$strSalida.= ' '. $key .'="'. $value .'"';
											}
											$strSalida.= '>';
											$strSalida.= $crlf.'<input type="color" id="'.$fname . $fila[$this->IDField].'" disabled value="'.$fila[$fname].'" />';
											$strSalida.= '</td>';
										break;

										default:
											$strSalida.= $crlf.'<td data-valor="'. str_replace('"', '', $fila[$fname]) .'" class="text-'. $field['txtAlign'] .' '. $field["cssList"] .' '. (eval($field["condFormat"])? $field["classFormat"]: '') . (!$field["print"]? ' noPrn': '') .'" id="'.$fname . $fila[$this->IDField].'"';
											foreach ($field['attrList'] as $key => $value) {
												$strSalida.= ' '. $key .'="'. $value .'"';
											}
											$strSalida.= '>';
											$strSalida.= $field["txtBefore"].$fila[$fname].$field["txtAfter"];
											$strSalida.= '</td>';
										break;
									}

									//Footer - me fijo a que columna corresponde cada campo
									foreach ($this->footerFields as $footerField) {
										if ($footerField->name == $fname) {
											$footerField->col = $col;
										}
									}

									$col++;
								}
							}
						}

						//Botones
						if ($conBotones) {
							//De clase
							foreach ($this->btnList as $btn) {
								if ($btn->numeCarg === '' || $btn->numeCarg >= $numeCarg) {
									$strSalida.= $crlf.'<td class="noPrn noXLS text-center">';
									if (eval($btn->cond)) {
										$strSalida.= $crlf.'<'.$btn->type.' role="button" id="'.$btn->id.$fila[$this->IDField].'" title="'.$btn->titulo.'" class="btn btn-sm '. $btn->class .'" ';
										if ($btn->onclick != '') {
											$strSalida.= 'onclick="'. $btn->onclick .'(\''.$fila[$this->IDField].'\')" ';
										}

										if ($btn->href != '') {
											$strSalida.= 'href="'. $btn->href .'='.$fila[$this->IDField].'" ';
										}

										if ($btn->attribs != '') {
											$strSalida.= ' '.$btn->attribs;
										}

										$strSalida.= '>'. $btn->texto .'</'.$btn->type.'>';
									}
									$strSalida.= $crlf.'</td>';
								}
							}

							if ($this->orderField != '') {
								$strSalida.= $crlf.'<td class="noPrn noXLS text-center">';
								$strSalida.= $crlf.'<button class="btn btn-sm btn-secondary" onclick="subir'. $this->tabladb .'(\''.$fila[$this->IDField].'\', \''.$fila[$this->orderField].'\')"><i class="fa fa-arrow-up fa-fw" aria-hidden="true"></i></button>';
								$strSalida.= $crlf.'<button class="btn btn-sm btn-secondary" onclick="bajar'. $this->tabladb .'(\''.$fila[$this->IDField].'\', \''.$fila[$this->orderField].'\')"><i class="fa fa-arrow-down fa-fw" aria-hidden="true"></i></button>';
								$strSalida.= $crlf.'</td>';
							}

							//Editar
							if ($this->allowEdit  && $this->numeCargEdit >= $numeCarg) {
								$strSalida.= $crlf.'<td class="noPrn noXLS text-center">';
								if (eval($this->condEdit)) {
									$strSalida.= $crlf.'	<button id="btnEditar'.$fila[$this->IDField].'" class="btn btn-sm btn-info" onclick="editar'. $this->tabladb .'(\''.$fila[$this->IDField].'\')"><i class="fa fa-edit fa-fw" aria-hidden="true"></i> '.gral_edit.'</button>';
								}
								$strSalida.= $crlf.'</td>';
							}
							//Borrar
							if ($this->allowDelete && $this->numeCargDelete >= $numeCarg) {
								$strSalida.= $crlf.'<td class="noPrn noXLS text-center">';
								if (eval($this->condDelete)) {
									$strSalida.= $crlf.'	<button id="btnBorrar'.$fila[$this->IDField].'" class="btn btn-sm btn-danger" onclick="borrar'. $this->tabladb .'(\''.$fila[$this->IDField].'\')"><i class="fa fa-trash-alt fa-fw" aria-hidden="true"></i> '.gral_delete.'</button>';
								}
								$strSalida.= $crlf.'</td>';
							}
						}

						//Botones del método
						foreach ($btnList as $btn) {
							if ($btn->numeCarg === '' || $btn->numeCarg >= $numeCarg) {
								$strSalida.= $crlf.'<td class="noPrn noXLS text-center">';
								$strSalida.= $crlf.'<'.$btn->type.' role="button" id="'.$btn->id.$fila[$this->IDField].'" title="'.$btn->titulo.'" class="btn btn-sm '. $btn->class .'" ';
								if ($btn->onclick != '') {
									$strSalida.= 'onclick="'. $btn->onclick .'(\''.$fila[$this->IDField].'\')" ';
								}

								if ($btn->href != '') {
									$strSalida.= 'href="'. $btn->href .'='.$fila[$this->IDField].'" ';
								}

								if ($btn->attribs != '') {
									$strSalida.= ' '.$btn->attribs;
								}

								$strSalida.= '>'. $btn->texto .'</'.$btn->type.'>';
								$strSalida.= $crlf.'</td>';
							}
						}

						$strSalida.= $crlf.'</tr>';

						//Footer - lleno los valores de cada campo
						foreach ($this->footerFields as $footerField) {
							if ($footerField->cond != '') {
								if (!eval($footerField->cond)) {
									continue;
								}
							}

							if ($this->fields[$footerField->name]["nameAlias"] == '') {
								$filaName = $this->fields[$footerField->name]['name'];
							} else {
								$filaName = $this->fields[$footerField->name]['nameAlias'];
							}

							switch ($footerField->funcion) {
								case "COUNT":
									$footerField->count++;
									$footerField->value++;
									break;

								case "SUM":
									switch ($this->fields[$footerField->name]['type']) {
										case 'time':
											if ($footerField->value == 0) {
												$footerField->value = $fila[$footerField->name];
											}
											else {
												$footerField->value = $config->sum_time($footerField->value, $fila[$filaName]);
											}
											break;

										case 'eval':
											$dato = eval($this->fields[$footerField->name]["evalData"]);
											$footerField->value+= floatval($dato);
											break;

										default:
											$footerField->value+= floatval($fila[$filaName]);
											break;
									}
									break;

								case 'AVG':
									$footerField->count++;
									$footerField->value+= floatval($fila[$filaName]);
									break;
							}
						}

					}
					//Fin while
					$strSalida.= $crlf.'</tbody>';

					//Footer - se crea la fila en la tabla
					$strFooter = '';
					$blnHayFooter = false;
					if (count($this->footerFields) > 0) {
						for ($I = 0; $I < $col; $I++) {
							$blnProcesado = false;

							foreach ($this->footerFields as $footerField) {
								if ($this->fields[$footerField->name]["numeCarg"] === '' || $this->fields[$footerField->name]["numeCarg"] >= $numeCarg) {
									$blnHayFooter = true;
									if ($I == $footerField->col) {
										$blnProcesado = true;

										$strFooter.= $crlf.'<td class="text-'. $this->fields[$footerField->name]['txtAlign'] .'">';

										switch ($footerField->funcion) {
											case "COUNT":
												$strFooter.= $crlf.'<strong>CANT:</strong> '. (is_float($footerField->value)? number_format($footerField->value, 2) : $footerField->value);
												break;

											case "SUM":
												$strFooter.= $crlf.'<strong>TOTAL:</strong> '. $this->fields[$footerField->name]['txtBefore'] . (is_float($footerField->value)? number_format($footerField->value, 2) : $footerField->value) .$field["txtAfter"];
												break;

											case "AVG":
												$strFooter.= $crlf.'<strong>PROM:</strong> '. $this->fields[$footerField->name]['txtBefore'] . ($footerField->count > 0 ? number_format($footerField->value / $footerField->count, 2) : number_format(0, 2)) .$field["txtAfter"];
												break;
										}

										$strFooter.= $crlf.'</td>';
										break;
									}
								}
							}

							if (!$blnProcesado) {
								$strFooter.= $crlf.'<td></td>';
							}
						}
					}

					if ($blnHayFooter) {
						$strSalida.= $crlf.'<tfoot><tr>';
						$strSalida.= $crlf.$strFooter;
						$strSalida.= $crlf.'</tr></tfoot>';
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
		} else {
			$resultado["num_rows"] = 0;
			$strSalida = "<h3>".gral_nodata."</h3>";
		}

		$resultado["tabla"] = $tabla;
		$resultado["html"] = $strSalida;

		return $resultado;
	}

	public function searchForm() {
		global $crlf, $config;

		$numeCarg = intval($config->buscarDato("SELECT NumeCarg FROM ".$config->tbLogin." WHERE NumeUser = ". $_SESSION["NumeUser"]));

		$strSalida = '';
		$flagField = false;

		if (count($this->searchFields) > 0) {
			$strSalida.= $crlf.'<div id="searchForm">';
			$strSalida.= $crlf.'<hr>';
			$strSalida.= $crlf.'<h4>'. gral_search .' '. $this->titulo .'</h4>';
			$strSalida.= $crlf.'<form id="frmSearch'. $this->tabladb .'" class="frmSearch mt-4" method="post" onSubmit="return false;" novalidate>';
			$strSalida.= $crlf.'	<input type="number" id="hdnDirtySearch" class="d-none" />';

			foreach ($this->searchFields as $sfield) {
				if (($this->fields[$sfield->name]["numeCarg"] === '' || $this->fields[$sfield->name]["numeCarg"] >= $numeCarg) && ($this->masterFieldId != $sfield->name || !isset($_GET[$this->masterFieldId]))) {
					$flagField = true;

					// Clono el campo
					$fieldClone = $this->fields[$sfield->name];

					// Me fijo si el campo es igual al master y el master no es parte del filtro de url
					if ($sfield->label != null) {
						$fieldClone["label"] = $sfield->label;
					}

					// Controlo el valor por defecto del campo búsqueda
					if ($sfield->value !== null) {
						$fieldClone["value"] = $sfield->value;
					}

					// Controlo el alias del control del campo búsqueda
					if ($sfield->controlAlias !== null) {
						$fieldClone["controlAlias"] = $sfield->controlAlias;
					}

					// Controlo el tipo del control del campo búsqueda
					if ($sfield->type !== null) {
						$fieldClone["type"] = $sfield->type;
					}

					// Lo hago read write
					$fieldClone["readOnly"] = false;

					// Creo el campo
					$strSalida.= $crlf . $this->createField($fieldClone, 'search', $sfield->conBuscador);
				}
			}

			// Creo el botón de búsqueda
			$strSalida.= $crlf.'<div class="form-group">';
			$strSalida.= $crlf.'	<div class="offset-md-2 col-md-4">';
			$strSalida.= $crlf.'		<button type="submit" class="btn btn-sm btn-primary" onclick="$(\'#hdnDirtySearch\').val(1); intPagina = 1; listar'. $this->tabladb .'();"><i class="fa fa-search fa-fw" aria-hidden="true"></i> '. gral_search .'</button>';
			$strSalida.= $crlf.'	</div>';
			$strSalida.= $crlf.'</div>';
			$strSalida.= $crlf.'</form>';
			$strSalida.= $crlf.'</div>';

			if ($flagField) {
				echo $strSalida;
			}
		}
	}

	public function script() {
		global $config, $crlf;

		$numeCarg = intval($config->buscarDato("SELECT NumeCarg FROM ".$config->tbLogin." WHERE NumeUser = ". $_SESSION["NumeUser"]));

		$strSalida = '';

		if (count($this->jsFiles) > 0) {
			for ($I = 0; $I < count($this->jsFiles); $I++) {
				$strSalida.= $crlf.'	<script src="'. $config->raiz . $this->jsFiles[$I] .'"></script>';
			}
		}

		if (count($this->cssFiles) > 0) {
			for ($I = 0; $I < count($this->cssFiles); $I++) {
				$strSalida.= $crlf.'	<link rel="stylesheet" href="'. $config->raiz . $this->cssFiles[$I] .'" />';
			}
		}

		if ($this->gmaps) {
			$strSalida.= $crlf.'	<script async defer src="https://maps.googleapis.com/maps/api/js?libraries=places&key='.$this->gmapsApiKey.'"></script>';
		}

		$strSalida.= $crlf;
		$strSalida.= $crlf.'<script>';
		// $strSalida.= $crlf.'var blnEdit = false;';
		$strSalida.= $crlf.'var intPagina = 1;';

		$strSalida.= $crlf;


		//Document Ready
		$strSalida.= $crlf.'$(document).ready(function() {';
		// $strSalida.= $crlf.'	divActualizando.close();';
		// $strSalida.= $crlf.'	$("#divMsj").hide();';
		$strSalida.= $crlf.'	$("#frm'. $this->tabladb .'").submit(function(event) {';
		$strSalida.= $crlf.'		if (typeof validar == "function") {';
		$strSalida.= $crlf.'			event.preventDefault();';
		$strSalida.= $crlf.'		}';
		$strSalida.= $crlf.'		aceptar'. $this->tabladb .'();';
		$strSalida.= $crlf.'	});';
		$strSalida.= $crlf;
		$strSalida.= $crlf.'	$("#frm'. $this->tabladb .' button[type=\'reset\']").on("click", function(event){';
		$strSalida.= $crlf.'		event.preventDefault();';
		$strSalida.= $crlf.'		swal({';
		$strSalida.= $crlf.'			title: "'.gral_confirm.'",';
		$strSalida.= $crlf.'			type: "question",';
		$strSalida.= $crlf.'			text: "'.gral_cancelform.'",';
		$strSalida.= $crlf.'			showCancelButton: true,';
		$strSalida.= $crlf.'			confirmButtonText: "'.gral_yesbutton.'",';
		$strSalida.= $crlf.'			cancelButtonText: "'.gral_nobutton.'",';
		$strSalida.= $crlf.'			focusCancel: true,';
		$strSalida.= $crlf.'		}).then((result) => {';
		$strSalida.= $crlf.'			if (result.value) {';
		$strSalida.= $crlf.'				editar'. $this->tabladb .'(false, false);';
		if ($this->masterFieldId != '' && isset($_GET[$this->masterFieldId])) {
			$strSalida.= $crlf.'				$("#'. $this->masterFieldId .'").val('. $_GET[$this->masterFieldId] .');';
		}
		$strSalida.= $crlf.'			}';
		$strSalida.= $crlf.'		});';
		$strSalida.= $crlf.'	});';

		if ($this->modalForm) {
			$strSalida.= $crlf;
			$strSalida.= $crlf.'	$("#mdl'. $this->tabladb .'").on("shown.bs.modal", function() {';
			$strSalida.= $crlf.'		$($("#frm'. $this->tabladb .'").find(".form-control[type!=\'hidden\'][disabled!=disabled][readonly!=readonly]:first , .form-control.dtpPicker:first")[0]).focus().select();';
			$strSalida.= $crlf.'		$("textarea").autogrow({vertical: true, horizontal: false, minHeight: 36});';
			$strSalida.= $crlf.'	});';
		}

		$strSalida.= $crlf;

		// LISTAR
		$strSalida.= $crlf;
		if ($this->listarOnLoad) {
			if (!isset($_REQUEST["listar"]) || $_REQUEST["listar"] == 1) {
				// PAGINA
				if ($this->paginacion && isset($_REQUEST["page"])) {
					$strSalida.= $crlf.'	intPagina = '. $_REQUEST["page"] .';';
				}

				// EDITAR
				global $item, $itemFila;

				if ($item != "") {
					$strSalida.= $crlf.'	listar'. $this->tabladb .'("'. $item .'", {}, editar'. $this->tabladb .');';
				}
				else {
					$strSalida.= $crlf.'	listar'. $this->tabladb .'("'. $itemFila .'");';
				}
			}
		}
		else {
			$strSalida.= $crlf.'	if ($("#hdnDirtySearch").val() == 1) listar'. $this->tabladb .'();';
		}

		// NUEVO
		if (isset($_REQUEST["new"]) && $_REQUEST["new"] == "1") {
			$strSalida.= $crlf;
			$strSalida.= $crlf.'	editar'. $this->tabladb .'(false, true);';
		}

		$strSalida.= $crlf.'	'.$this->jsOnLoad;

		$strSalida.= $crlf.'});';

		//Listar
		$strSalida.= $crlf;
		$strSalida.= $crlf.'function listar'. $this->tabladb .'(vFilaMarcada = "", filtros = {}, callback) {';

		// $strSalida.= $crlf.'	actualizando();';
		// $strSalida.= $crlf.'	$("#divDatos").html("");';
		$strSalida.= $crlf;
		// $strSalida.= $crlf.'	var filtros = {};';
		// $strSalida.= $crlf.'	var filtros = "";';

		//Search Fields
		if (count($this->searchFields) > 0) {
			foreach ($this->searchFields as $sfield) {
				$sfName = ($sfield->controlAlias == ''? $sfield->name: $sfield->controlAlias);

				$strSalida.= $crlf.'	if ($("#search-'.$sfName.'").length > 0 && $("#search-'.$sfName.'").val() != "" && $("#search-'.$sfName.'").val() != null) {';
				$strSalida.= $crlf.'		filtros["'.$sfName.'"] = {';
				$strSalida.= $crlf.'			"name": "'.$sfield->searchName.'",';
				$strSalida.= $crlf.'			"type": "'. ($sfield->type == null? $this->fields[$sfield->name]["type"]: $sfield->type) .'",';
				$strSalida.= $crlf.'			"operator":"'.$sfield->operator.'",';
				$strSalida.= $crlf.'			"join":"'.$sfield->join.'",';
				$strSalida.= $crlf.'			"value": $("#search-'.$sfName.'").val()';
				$strSalida.= $crlf.'		}';
				$strSalida.= $crlf.'	}';
			}

			$strSalida.= $crlf;
		}

		//Me fijo el orden por javascript
		$strSalida.= $crlf;
		$strSalida.= $crlf.'	var colOrden = $("#tbl'. $this->name .'-orden").val();';
		$strSalida.= $crlf.'	if (colOrden != "") {';
		$strSalida.= $crlf.'		var criterio = $("#tbl'. $this->name .'-ordenTipo").val();';
		$strSalida.= $crlf.'		criterio = criterio == "asc"? "desc": "asc";';
		$strSalida.= $crlf.'	}';
		$strSalida.= $crlf.'	else {';
		$strSalida.= $crlf.'		colOrden = undefined;';
		$strSalida.= $crlf.'	}';
		$strSalida.= $crlf;

		$strSalida.= $crlf.'	'. $this->jsBeforeList;
		$strSalida.= $crlf;

		$strSalida.= $crlf.'	$.post("php/tablaHandler.php",';
		$strSalida.= $crlf.'		{ operacion: "10"';
		$strSalida.= $crlf.'			, tabla: "'.$this->name.'"';
		$strSalida.= $crlf.'			, filtro: filtros';

		if ($this->masterFieldId != '' && isset($_GET[$this->masterFieldId])) {
			$strSalida.= $crlf.'			, '. $this->masterFieldId .': "'. $_GET[$this->masterFieldId] .'"';
		}

		if ($this->paginacion) {
			$strSalida.= $crlf.'			, pagina: intPagina';
		}

		$strSalida.= $crlf.'		},';
		$strSalida.= $crlf.'		function(data) {';
		$strSalida.= $crlf.'			if (divActualizando != undefined) divActualizando.close();';

		$strSalida.= $crlf.'			$("#divDatos").html(data.html);';

		if ($this->showRowCount) {
			$strSalida.= $crlf.'			$("#divDatos").prepend("<div>'.gral_rowcount.': " + data.num_rows +"</div>");';
		}

		if ($this->paginacion) {
			$strSalida.= $crlf.'			if (intPagina > 1) {';
			$strSalida.= $crlf.'				if (history.pushState) {';
			$strSalida.= $crlf.'					var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + "?page=" + intPagina;';
			$strSalida.= $crlf.'					window.history.replaceState({path:newurl}, "", newurl);';
			$strSalida.= $crlf.'				}';
			$strSalida.= $crlf.'			}';
		}

		$strSalida.= $crlf.'			if (vFilaMarcada != "") {';
		$strSalida.= $crlf.'				$("#vFila" + vFilaMarcada).addClass("table-success");';
		$strSalida.= $crlf.'			}';
		$strSalida.= $crlf.'			if (data.sql) {';
		$strSalida.= $crlf.'				console.log(data.sql);';
		$strSalida.= $crlf.'			}';
		$strSalida.= $crlf.'			habilitarTooltips();';
		$strSalida.= $crlf;
		// Si tenia orden por javascript lo vuelvo a ordenar
		$strSalida.= $crlf.'			if (colOrden != undefined) {';
		$strSalida.= $crlf.'				$("#tbl'. $this->name .'-ordenTipo").val(criterio);';
		$strSalida.= $crlf.'				ordenar(colOrden, $("#tbl'. $this->name .' th")[colOrden]);';
		$strSalida.= $crlf.'			}';
		$strSalida.= $crlf;
		$strSalida.= $crlf.'			if (typeof callback == "function") callback(vFilaMarcada);';
		$strSalida.= $crlf;
		$strSalida.= $crlf.'			'. $this->jsOnList;
		$strSalida.= $crlf.'		}';
		$strSalida.= $crlf.'	);';
		$strSalida.= $crlf.'}';

		//Preview IMG
		if ($this->allowNew || $this->allowEdit) {
			$blnPreview = false;
			if (isset($this->fields)) {
				foreach ($this->fields as $field) {
					if ($field['type'] == 'image' || $field['type'] == 'image-multiple' || $field['type'] == 'file') {
						$blnPreview = true;
						break;
					}
				}
			}

			if ($blnPreview || $this->overridePreview) {
				$strSalida.= $crlf;
				$strSalida.= $crlf.'function preview(event, divPreview) {';
				$strSalida.= $crlf.'	divPreview.html("");';
				$strSalida.= $crlf.'	var id = divPreview.attr("id").substr(10);';
				$strSalida.= $crlf;
				$strSalida.= $crlf.'	var files = event.target.files; //FileList object';
				$strSalida.= $crlf;
				$strSalida.= $crlf.'	for(var i = 0; i< files.length; i++)';
				$strSalida.= $crlf.'	{';
				$strSalida.= $crlf.'		var file = files[i];';
				$strSalida.= $crlf;
				$strSalida.= $crlf.'		//Solo imagenes';
				$strSalida.= $crlf.'		if(!file.type.match("image"))';
				$strSalida.= $crlf.'			continue;';
				$strSalida.= $crlf;
				$strSalida.= $crlf.'		var picReader = new FileReader();';
				$strSalida.= $crlf;
				$strSalida.= $crlf.'		picReader.addEventListener("load",function(event){';
				$strSalida.= $crlf;
				$strSalida.= $crlf.'			var picFile = event.target;';
				$strSalida.= $crlf;
				$strSalida.= $crlf.'			divPreview.append(\'<img id="img\' + divPreview.children().length + \'" class="thumbnail" src="\' + picFile.result + \'" />\');';
				$strSalida.= $crlf;
				$strSalida.= $crlf.'			$("#btnBorrar" + id).show();';
				$strSalida.= $crlf.'			$("#hdn" + id + "-Clear").val("0");';
				$strSalida.= $crlf.'		});';
				$strSalida.= $crlf;
				$strSalida.= $crlf.'		//Leer la imagen';
				$strSalida.= $crlf.'		picReader.readAsDataURL(file);';
				$strSalida.= $crlf.'	}';
				$strSalida.= $crlf.'}';
			}
		}

		//Borrar
		if ($this->allowDelete) {
			$strSalida.= $crlf;
			$strSalida.= $crlf.'function borrar'. $this->tabladb .'(strID){';
			$strSalida.= $crlf.'	swal({';
			$strSalida.= $crlf.'		title: "'.gral_confirm.'",';
			$strSalida.= $crlf.'		type: "warning",';
			$strSalida.= $crlf.'		text: "'. gral_delete .' '.$this->tituloSingular. ($this->labelField!=''?' " + $("#'.$this->labelField.'" + strID).text().trim()':' '.gral_selected.'"') . ' + "?",';
			$strSalida.= $crlf.'		showCancelButton: true,';
			$strSalida.= $crlf.'		confirmButtonText: "'.gral_yesbutton.'",';
			$strSalida.= $crlf.'		cancelButtonText: "'.gral_nobutton.'",';
			$strSalida.= $crlf.'	}).then((result) => {';
			$strSalida.= $crlf.'		if (result.value) {';
			$strSalida.= $crlf.'			$("#hdnOperacion").val("2");';
			$strSalida.= $crlf.'			$("#'.$this->IDField.'").val(strID);';
			$strSalida.= $crlf.'			aceptar'. $this->tabladb .'();';
			$strSalida.= $crlf.'		}';
			$strSalida.= $crlf.'	});';
			$strSalida.= $crlf.'}';
		}

		//CargarControles
		if ($this->allowNew || $this->allowEdit) {
			$strSalida.= $crlf;
			$strSalida.= $crlf.'function controles'. $this->tabladb .'(strID) {';

			// Si es para editar
			$strSalida.= $crlf.'	if (strID !== false) {';

			//Si hay una fila con color se lo quito
			$strSalida.= $crlf.'		$("tr.table-success").removeClass("table-success");';

			//Le doy color a la fila editada
			$strSalida.= $crlf.'		$("#vFila" + strID).addClass("table-success");';

			$strSalida.= $crlf.'		$("#hdnOperacion").val("1");';

			if (isset($this->fields)) {
				$field = $this->fields[$this->IDField];
				if ($field["nameAlias"] == '') {
					$filaName = $field['name'];
				} else {
					$filaName = $field['nameAlias'];
				}

				if (($field['isHiddenInList']) || ($field['type'] == "checkbox") || ($field['type'] == "select") || ($field['type'] == "selectmultiple")) {
					$strSalida.= $crlf.'		$("#hdnIdViejo").val($("#'.$filaName.'" + strID).val());';
				} else {
					$strSalida.= $crlf.'		$("#hdnIdViejo").val($("#'.$filaName.'" + strID).text().replace("'.$field["txtBefore"].'", "").replace("'.$field["txtAfter"].'", "").trim());';
				}

				foreach ($this->fields as $field) {
					if ($field["controlAlias"] == '') {
						$controlName = $field['name'];
					} else {
						$controlName = $field['controlAlias'];
					}

					if ($field["nameAlias"] == '') {
						$filaName = $field['name'];
					} else {
						$filaName = $field['nameAlias'];
					}

					if ($field['showOnForm'] && ($field["numeCarg"] === '' || $field["numeCarg"] >= $numeCarg)) {
						if ($field['showOnList']) {
							if (($field['isHiddenInList']) || ($field['type'] == "checkbox") || ($field['type'] == "select") || ($field['type'] == "selectmultiple")) {
								switch ($field["type"]) {
									case "ckeditor":
										$strSalida.= $crlf.'		CKEDITOR.instances.'.$controlName.'.setData($("#'.$filaName.'" + strID).val());';
									break;

									case "select":
										$strSalida.= $crlf.'		$("#'.$controlName.'").val($("#'.$filaName.'" + strID).val());';
										if ($field['conBuscador']) {
											$strSalida.= $crlf.'		buscarCampo("'.$controlName.'", $("#'.$filaName.'" + strID).val());';
										}
									break;

									case "selectmultiple":
										$strSalida.= $crlf.'		$("#'.$controlName.'").selectpicker("val", $("#'.$filaName.'" + strID).val().split(","));';
									break;

									case "image":
									case "image-multiple":
									case "file":
										$strSalida.= $crlf.'		$("#'.$controlName.'").val(null);';
										$strSalida.= $crlf.'		if ($("#'.$filaName.'" + strID).val() != "") {';
										if ($field["type"] == "image" || $field["type"] == "image-multiple") {
											$strSalida.= $crlf.'			$("#divPreview'.$controlName.'").html(\'<img id="img0" class="thumbnail" src="\' + $("#'.$filaName.'" + strID).val() + \'" />\');';
										}
										if ($field["required"] == false) {
											$strSalida.= $crlf.'			$("#btnBorrar'.$controlName.'").show();';
											$strSalida.= $crlf.'			$("#hdn'.$controlName.'-Clear").val("0");';
										}

										$strSalida.= $crlf.'		}';
										$strSalida.= $crlf.'		else {';
										if ($field["type"] == "image" || $field["type"] == "image-multiple") {
											$strSalida.= $crlf.'			$("#divPreview'.$controlName.'").html("");';
										}
										if ($field["required"] == false) {
											$strSalida.= $crlf.'			$("#btnBorrar'.$controlName.'").hide();';
											$strSalida.= $crlf.'			$("#hdn'.$controlName.'-Clear").val("0");';
										}
										$strSalida.= $crlf.'		}';
									break;

									case "checkbox":
										$strSalida.= $crlf.'		$("#'.$controlName.'").prop("checked", Boolean(parseInt($("#'.$filaName.'" + strID).val())));';
									break;

									default:
										$strSalida.= $crlf.'		$("#'.$controlName.'").val($("#'.$filaName.'" + strID).val());';
									break;
								}
							} else {
								switch ($field["type"]) {
									case "ckeditor":
										$strSalida.= $crlf.'		CKEDITOR.instances.'.$controlName.'.setData($("#'.$filaName.'" + strID).html());';
									break;

									case "image":
									case "image-multiple":
									case "file":
										$strSalida.= $crlf.'		if ($("#'.$filaName.'" + strID).val() != "") {';
										if ($field["type"] == "image" || $field["type"] == "image-multiple") {
											$strSalida.= $crlf.'			$("#divPreview'.$controlName.'").html(\'<img id="img0" class="thumbnail" src="\' + $("#'.$filaName.'" + strID).val() + \'" />\');';
										}
										if ($field["required"] == false) {
											$strSalida.= $crlf.'			$("#btnBorrar'.$controlName.'").show();';
											$strSalida.= $crlf.'			$("#hdn'.$controlName.'-Clear").val("0");';
										}

										$strSalida.= $crlf.'		}';
										$strSalida.= $crlf.'		else {';
										if ($field["type"] == "image" || $field["type"] == "image-multiple") {
											$strSalida.= $crlf.'			$("#divPreview'.$controlName.'").html("");';
										}
										if ($field["required"] == false) {
											$strSalida.= $crlf.'			$("#btnBorrar'.$controlName.'").hide();';
											$strSalida.= $crlf.'			$("#hdn'.$controlName.'-Clear").val("0");';
										}
										$strSalida.= $crlf.'		}';
									break;

									case "checkbox":
										$strSalida.= $crlf.'		$("#'.$controlName.'").prop("checked", Boolean(parseInt($("#'.$filaName.'" + strID).val())));';
									break;

									case "color":
										$strSalida.= $crlf.'		$("#'.$controlName.'").val($("#'.$filaName.'" + strID).val());';
									break;

									default:
										$strSalida.= $crlf.'		$("#'.$controlName.'").val($("#'.$filaName.'" + strID).text().replace("'.$field["txtBefore"].'", "").replace("'.$field["txtAfter"].'", "").trim());';
									break;
								}
							}
						} elseif ($field['type'] == "password") {
							$strSalida.= $crlf.'		$("#'.$controlName.'").val("****");';
						}

						// if ($field['onChange'] != '') {
						// 	$strSalida.= $crlf.'		$("#'.$controlName.'").trigger("change");';
						// }

						switch ($field['type']) {
							case 'image':
							case 'image-multiple':
							case 'file':
								$strSalida.= $crlf.'		$("#'.$controlName.'").removeAttr("required");';
								$strSalida.= $crlf.'		$("#'.$controlName.'").removeAttr("multiple");';
								$strSalida.= $crlf.'		$("#'.$controlName.'").val(null);';
								$strSalida.= $crlf.'		$("#btnBorrar'.$controlName.'").hide();';
							break;

							case 'textarea':
								$strSalida.= $crlf.'		$("#'.$controlName.'").autogrow({vertical: true, horizontal: false, minHeight: 36});';
							break;

							case 'calcfield':
								$strSalida.= $crlf.'		if (typeof calcField == "function") {';
								$strSalida.= $crlf.'			calcField("'.$controlName.'");';
								$strSalida.= $crlf.'		}';
								$strSalida.= $crlf;
							break;

							case 'date':
							case 'datetime':
							case 'time':
								if (!$field["readOnly"]) {
									$strSalida.= $crlf.'		$("#'.$controlName.'").datetimepicker({value: $("#'.$filaName.'" + strID).text().replace("'.$field["txtBefore"].'", "").replace("'.$field["txtAfter"].'", "").trim()});';
									// $strSalida.= $crlf.'		$(".inp'.$controlName.'").datetimepicker("show");';
									// $strSalida.= $crlf.'		$(".inp'.$controlName.'").datetimepicker("hide");';
									// $strSalida.= $crlf.'		document.querySelector(".inp'.$controlName.'")._flatpickr.setDate($("#'.$filaName.'" + strID).text().replace("'.$field["txtBefore"].'", "").replace("'.$field["txtAfter"].'", "").trim());';
									$strSalida.= $crlf;
								}
							break;

							case 'gmaps':
								$strSalida.= $crlf.'		if (marker != null)';
								$strSalida.= $crlf.'				marker.setMap(null);';
								$strSalida.= $crlf;
								$strSalida.= $crlf.'		if ($("#'.$controlName.'").val() != "") {';
								$strSalida.= $crlf;
								$strSalida.= $crlf.'			var aux = $("#'.$controlName.'").val();';
								$strSalida.= $crlf.'			var lat = aux.substring(0, aux.indexOf(\'|\'));';
								$strSalida.= $crlf.'			var lng = aux.substring(aux.indexOf(\'|\')+1);';
								$strSalida.= $crlf;
								$strSalida.= $crlf.'				var pos = new google.maps.LatLng(lat, lng);';
								$strSalida.= $crlf;
								$strSalida.= $crlf.'				marker = new google.maps.Marker({';
								$strSalida.= $crlf.'					position: pos,';
								$strSalida.= $crlf.'					map: map';
								$strSalida.= $crlf.'				});';
								$strSalida.= $crlf;
								$strSalida.= $crlf.'				map.setCenter(pos);';
								$strSalida.= $crlf.'				map.setZoom(17);';
								$strSalida.= $crlf.'		}';
							break;
						}
					}
				}
			}

			if ($this->jsOnEdit != '') {
				$strSalida.= $crlf.'		'. $this->jsOnEdit;
			}
			$strSalida.= $crlf.'	}';

			// Si es un registro nuevo
			$strSalida.= $crlf.'	else {';
			if ($this->jsOnNew != '') {
				$strSalida.= $crlf.'		'. $this->jsOnNew;
			}
			$strSalida.= $crlf.'		$("#hdnOperacion").val("0");';
			$strSalida.= $crlf.'		$(".divPreview").html("");';
			$strSalida.= $crlf.'		$("#hdnIdViejo").val("");';

			if (isset($this->fields)) {
				foreach ($this->fields as $field) {
					if ($field["controlAlias"] == '') {
						$controlName = $field['name'];
					} else {
						$controlName = $field['controlAlias'];
					}

					if ($field["nameAlias"] == '') {
						$filaName = $field['name'];
					} else {
						$filaName = $field['nameAlias'];
					}

					if ($field['showOnForm'] && ($field["numeCarg"] === '' || $field["numeCarg"] >= $numeCarg)) {
						switch ($field['type']) {
							case 'image':
							case 'image-multiple':
							case 'file':
								$strSalida.= $crlf.'		$("#'.$controlName.'").val(null);';
								if ($field['required']) {
									$strSalida.= $crlf.'		$("#'.$controlName.'").attr("required", true);';
								} else {
									$strSalida.= $crlf.'		$("#btnBorrar'.$controlName.'").hide();';
									$strSalida.= $crlf.'		$("#hdn'.$controlName.'-Clear").val("0");';
								}

								if ($field['type'] == 'image-multiple') {
									$strSalida.= $crlf.'		$("#'.$controlName.'").attr("multiple", true);';
								}
							break;

							case 'date':
								if ($field['value'] == '') {
									$strSalida.= $crlf.'		$("#'.$controlName.'").val(moment().format("Y-MM-DD"));';
								} else {
									$strSalida.= $crlf.'		$("#'.$controlName.'").val("'.$field['value'].'");';
								}
								$strSalida.= $crlf.'		$("#'.$controlName.'").datetimepicker({value: $("#'.$controlName.'").val()});';
							break;

							case 'datetime':
								if ($field['value'] == '') {
									$strSalida.= $crlf.'		$("#'.$controlName.'").val(moment().format("Y-MM-DD HH:mm"));';
								} else {
									$strSalida.= $crlf.'		$("#'.$controlName.'").val("'.$field['value'].'");';
								}
								$strSalida.= $crlf.'		$("#'.$controlName.'").datetimepicker({value: $("#'.$controlName.'").val()});';
							break;

							case 'time':
								if ($field['value'] == '') {
									$strSalida.= $crlf.'		$("#'.$controlName.'").val(moment().format("HH:00"));';
								} else {
									$strSalida.= $crlf.'		$("#'.$controlName.'").val("'.$field['value'].'");';
								}
								$strSalida.= $crlf.'		$("#'.$controlName.'").datetimepicker({value: $("#'.$controlName.'").val()});';
							break;

							case 'textarea':
								$strSalida.= $crlf.'		$("#'.$controlName.'").val("'.$field['value'].'");';
								$strSalida.= $crlf.'		$("#'.$controlName.'").removeAttr("style");';
								$strSalida.= $crlf.'		$("#'.$controlName.'").autogrow({vertical: true, horizontal: false, minHeight: 36});';
							break;

							case 'selectmultiple':
								$strSalida.= $crlf.'		$("#'.$controlName.'").selectpicker("deselectAll");';
								$strSalida.= $crlf.'		$("#'.$controlName.'").val("'.$field['value'].'");';
							break;

							case 'gmaps':
								$strSalida.= $crlf.'		$("#'.$controlName.'").val("'.$field['value'].'");';
								$strSalida.= $crlf.'		if (marker != null)';
								$strSalida.= $crlf.'			marker.setMap(null);';
								$strSalida.= $crlf.'		map.setCenter({lat: '.$this->gmapsCenterLat.', lng: '.$this->gmapsCenterLng.'});';
							break;

							case 'ckeditor':
								$strSalida.= $crlf.'		CKEDITOR.instances.'.$controlName.'.setData("");';
							break;

							case "select":
								if (!$field['conBuscador']) {
									$strSalida.= $crlf.'		$("#'.$controlName.'").val("'.$field['value'].'");';
								} else {
									$strSalida.= $crlf.'		$("#buscar'.$controlName.'").val("");';

									if ($field['name'] == $this->masterFieldId && $this->masterFieldId != '' && isset($_GET[$this->masterFieldId])) {
										$strSalida.= $crlf.'		buscarCampo("'.$controlName.'", '. $_GET[$this->masterFieldId] .');';
									} elseif ($field["value"] != '') {
										$strSalida.= $crlf.'		buscarCampo("'.$controlName.'", "'.$field['value'].'");';
									}
								}
							break;

							default:
								$strSalida.= $crlf.'		$("#'.$controlName.'").val("'.$field['value'].'");';
							break;
						}

						if ($field['mirrorField'] != '') {
							$strSalida.= $crlf.'		$("#'.$field['mirrorField'].'").val("'.$field['value'].'");';
						}
					}
				}

				if ($this->masterFieldId != '' && isset($_GET[$this->masterFieldId])) {
					$strSalida.= $crlf.'		$("#'. $this->masterFieldId .'").val('. $_GET[$this->masterFieldId] .');';
				}
			}

			if ($this->jsAfterNew != '') {
				$strSalida.= $crlf.'		'. $this->jsAfterNew;
			}
			$strSalida.= $crlf.'	}';
			$strSalida.= $crlf.'}';
		}

		//Editar
		if ($this->allowNew || $this->allowEdit) {
			$strSalida.= $crlf;
			$strSalida.= $crlf.'function editar'. $this->tabladb .'(strID, blnEsNuevo) {';

			// Si no está en el listado
			// if (isset($_REQUEST["listar"]) && $_REQUEST["listar"] == 0) {
				$strSalida.= $crlf.'	if ((strID !== false) && $("#vFila" + strID).length == 0) {';
				$strSalida.= $crlf.'		listar'. $this->tabladb .'(strID, {"'. $this->IDField .'": {"name": "'. $this->tabladb .'.'. $this->IDField .'", "type":"number", "operator": "=", "join": "AND", "value": strID}}, editar'. $this->tabladb .')';
				$strSalida.= $crlf.'		return;';
				$strSalida.= $crlf.'	}';
			// }

			if ($this->gmaps) {
				$strSalida.= $crlf.'	initMap();';
			}

			$strSalida.= $crlf.'	if (strID !== false) {';

			//Si el formulario es modal lo abro
			if ($this->modalForm) {
				$strSalida.= $crlf.'		$("#frm'. $this->tabladb .'-title").html("'. gral_edit .' '.$this->tituloSingular .' "'. ($this->labelField!=''?' + $("#'.$this->labelField.'" + strID).html().trim()':'') . ');';
				// $strSalida.= $crlf.'		$("#divMsjModal").hide();';
				$strSalida.= $crlf.'		$("#mdl'. $this->tabladb .'").modal({ backdrop: "static", keyboard: false });';
				$strSalida.= $crlf.'		controles'. $this->tabladb .'(strID);';
			}
			else {
                //Si hay form de busqueda lo oculto
                if ((count($this->searchFields) > 0) && (!isset($_REQUEST["buscar"]) || $_REQUEST["buscar"] == 1)) {
					$strSalida.= $crlf.'		$("#searchForm").fadeOut(function() {';
					$strSalida.= $crlf.'			$("#frm'. $this->tabladb .'").fadeIn(function() {';
					$strSalida.= $crlf.'				controles'. $this->tabladb .'(strID);';
					$strSalida.= $crlf.'				$($("#frm'. $this->tabladb .'").find(".form-control[type!=\'hidden\'][disabled!=disabled][readonly!=readonly]:first , .form-control.dtpPicker:first")[0]).focus().select();';
					$strSalida.= $crlf.'			});';
                } else {
					$strSalida.= $crlf.'		$("#frm'. $this->tabladb .'").fadeIn(function() {';
					$strSalida.= $crlf.'			controles'. $this->tabladb .'(strID);';
					$strSalida.= $crlf.'			$($("#frm'. $this->tabladb .'").find(".form-control[type!=\'hidden\'][disabled!=disabled][readonly!=readonly]:first , .form-control.dtpPicker:first")[0]).focus().select();';
					$strSalida.= $crlf.'		});';
				}

                $strSalida.= $crlf.'		if (!isScrolledIntoView("#frm'. $this->tabladb .'")) {';
                $strSalida.= $crlf.'			$("html, body").animate({';
                $strSalida.= $crlf.'				scrollTop: $("#frm'. $this->tabladb .'").offset().top';
				$strSalida.= $crlf.'			}, 1000);';
				$strSalida.= $crlf.'		}';

				if ((count($this->searchFields) > 0) && (!isset($_REQUEST["buscar"]) || $_REQUEST["buscar"] == 1)) {
					$strSalida.= $crlf.'		});';
				}
            }
			$strSalida.= $crlf.'	}';

			$strSalida.= $crlf.'	else {';
			$strSalida.= $crlf.'		if (blnEsNuevo) {';

			//Si hay una fila con color se lo quito
			$strSalida.= $crlf.'			$("tr.table-success").removeClass("table-success");';

			if ($this->modalForm) {
				$strSalida.= $crlf.'			$("#frm'. $this->tabladb .'-title").html("'.gral_new.'");';
				// $strSalida.= $crlf.'			$("#divMsjModal").hide();';
				$strSalida.= $crlf.'			$("#mdl'. $this->tabladb .'").modal({ backdrop: "static", keyboard: false });';
				$strSalida.= $crlf.'			controles'. $this->tabladb .'(strID);';
			}
			else {
                if ((count($this->searchFields) > 0) && (!isset($_REQUEST["buscar"]) || $_REQUEST["buscar"] == 1)) {
                    $strSalida.= $crlf.'			$("#searchForm").fadeOut(function() {';
					$strSalida.= $crlf.'				$("#frm'. $this->tabladb .'").fadeIn(function() {';
					$strSalida.= $crlf.'					controles'. $this->tabladb .'(strID);';
					$strSalida.= $crlf.'					$($("#frm'. $this->tabladb .'").find(".form-control[type!=\'hidden\'][disabled!=disabled][readonly!=readonly]:first , .form-control.dtpPicker:first")[0]).focus().select();';
					$strSalida.= $crlf.'				});';
                    $strSalida.= $crlf.'			});';
                } else {
					$strSalida.= $crlf.'			$("#frm'. $this->tabladb .'").fadeIn(function() {';
					$strSalida.= $crlf.'				controles'. $this->tabladb .'(strID);';
					$strSalida.= $crlf.'				$($("#frm'. $this->tabladb .'").find(".form-control[type!=\'hidden\'][disabled!=disabled][readonly!=readonly]:first , .form-control.dtpPicker:first")[0]).focus().select();';
					$strSalida.= $crlf.'			});';
                }
            }

			$strSalida.= $crlf.'		}';
			$strSalida.= $crlf.'		else {';
			$strSalida.= $crlf.'			controles'. $this->tabladb .'(false)';

			if ($this->modalForm) {
				$strSalida.= $crlf.'			$("#mdl'. $this->tabladb .'").modal("hide");';
			}
			else {
				$strSalida.= $crlf.'			$("#frm'. $this->tabladb .'").fadeOut(function() { $("#searchForm").fadeIn(); });';
			}
			$strSalida.= $crlf.'		}';
			$strSalida.= $crlf.'	}';
			$strSalida.= $crlf.'}';
		}

		//Aceptar
		if ($this->allowNew || $this->allowEdit) {
			$strSalida.= $crlf;
			$strSalida.= $crlf.'function aceptar'. $this->tabladb .'(){';
			$strSalida.= $crlf.'	actualizando();';
			$strSalida.= $crlf.'	var frmData = new FormData();';
			$strSalida.= $crlf.'	if ($("#hdnOperacion").val() != "2") {';
			$strSalida.= $crlf.'		if (typeof validar == "function") {';
			$strSalida.= $crlf.'			if (!validar())';
			$strSalida.= $crlf.'				return;';
			$strSalida.= $crlf.'		}';
			$strSalida.= $crlf.'	}';

			$strSalida.= $crlf.'	frmData.append("operacion", $("#hdnOperacion").val());';
			$strSalida.= $crlf.'	frmData.append("idViejo", $("#hdnIdViejo").val());';
			$strSalida.= $crlf.'	frmData.append("tabla", "'.$this->name.'");';
			if (isset($this->fields)) {
				foreach ($this->fields as $field) {
					if ($field["controlAlias"] == '') {
						$controlName = $field['name'];
					}
					else {
						$controlName = $field['controlAlias'];
					}

					if (($field['showOnForm']) &&
						($field['type'] != 'calcfield' || $field['processAnyway']) &&
						($field["numeCarg"] === '' || $field["numeCarg"] >= $numeCarg)) {
						switch ($field['type']) {
							case "checkbox":
								$strSalida.= $crlf.'	frmData.append("'.$field['name'].'", $("#'.$controlName.'").prop("checked") ? 1 : 0);';
								break;

							case "file":
							case "image":
								$strSalida.= $crlf.'	if ($("#'.$controlName.'").get(0).files[0] != null)';
								$strSalida.= $crlf.'		frmData.append("'.$field['name'].'", $("#'.$controlName.'").get(0).files[0]);';

								if ($field["required"] == false) {
									$strSalida.= $crlf.'	frmData.append("vectorClear-'.$field['name'].'", $("#hdn'.$controlName.'-Clear").val());';
								}
								break;

							case "image-multiple":
								$strSalida.= $crlf;
								$strSalida.= $crlf.'	var imagenes = document.getElementById("'. $controlName .'");';
								$strSalida.= $crlf.'	for (var I = 0; I < imagenes.files.length; I++) {';
								$strSalida.= $crlf.'		frmData.append("'. $field['name'] .'[" + I + "]", imagenes.files[I]);';
								$strSalida.= $crlf.'	}';
								if ($field["required"] == false) {
									$strSalida.= $crlf.'	frmData.append("vectorClear-'.$field['name'].'", $("#hdn'.$controlName.'-Clear").val());';
								}
								break;

							case "ckeditor":
								if ($field["required"]) {
									$strSalida.= $crlf.'	if (CKEDITOR.instances.'.$controlName.'.getData() == "" && $("#hdnOperacion").val() != "2") {';
									$strSalida.= $crlf.'		divActualizando.close();';
									$strSalida.= $crlf.'		notifyDanger({title: "El campo <strong>'. $field["label"] .'</strong> no puede estar vacío."});';
									$strSalida.= $crlf.'		return false;';
									$strSalida.= $crlf.'	}';
								}
								$strSalida.= $crlf.'	frmData.append("'.$field['name'].'", CKEDITOR.instances.'.$controlName.'.getData());';
								break;

							default:
								if ($field['mirrorField'] == '') {
									$strSalida.= $crlf.'	frmData.append("'.$field['name'].'", $("#'.$controlName.'").val());';
								} else {
									$strSalida.= $crlf.'	frmData.append("'.$field['name'].'", $("#'.$field['mirrorField'].'").val());';
								}
								break;
						}
					}
				}
			}

			if ($this->jsBeforeSubmit != '') {
				$strSalida.= $crlf.'	'.$this->jsBeforeSubmit;
			}

			$strSalida.= $crlf;

			$strSalida.= $crlf.'	if (window.XMLHttpRequest)';
			$strSalida.= $crlf.'	{// code for IE7+, Firefox, Chrome, Opera, Safari';
			$strSalida.= $crlf.'		xmlhttp = new XMLHttpRequest();';
			$strSalida.= $crlf.'	}';
			$strSalida.= $crlf.'	else';
			$strSalida.= $crlf.'	{// code for IE6, IE5';
			$strSalida.= $crlf.'		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");';
			$strSalida.= $crlf.'	}';
			$strSalida.= $crlf.'	';
			$strSalida.= $crlf.'	xmlhttp.onreadystatechange = function() {';
			$strSalida.= $crlf.'		if (xmlhttp.readyState==4 && xmlhttp.status==200) {';
			$strSalida.= $crlf.'			var result = JSON.parse(xmlhttp.responseText);';
			$strSalida.= $crlf.'			divActualizando.close();';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'			if (result.estado === true) {';
			$strSalida.= $crlf.'				notifySuccess({message:"'.gral_dataupdated.'"});';
			$strSalida.= $crlf.'				$(".selectpicker").selectpicker("deselectAll");';
			if ($this->allowNew || $this->allowEdit) {
				$strSalida.= $crlf.'				editar'. $this->tabladb .'(false, false);';
			}

			if ($this->jsAfterSubmit != '') {
				$strSalida.= $crlf.'				'.$this->jsAfterSubmit;
			}

			$strSalida.= $crlf.'				listar'. $this->tabladb .'(result.id);';
			$strSalida.= $crlf.'			}';
			$strSalida.= $crlf.'			else {';
			$strSalida.= $crlf.'				notifyDanger({title: "'.gral_updateerror.'", message:"<br>" + result.estado});';
			$strSalida.= $crlf.'			}';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'			if (result.sql) {';
			$strSalida.= $crlf.'				console.log(result.sql);';
			$strSalida.= $crlf.'			}';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'		}';
			$strSalida.= $crlf.'	};';
			$strSalida.= $crlf.'	';
			$strSalida.= $crlf.'	xmlhttp.open("POST","php/tablaHandler.php",true);';
			$strSalida.= $crlf.'	xmlhttp.send(frmData);';
			$strSalida.= $crlf.'}';
		}
		elseif ($this->allowDelete) {
			$strSalida.= $crlf;
			$strSalida.= $crlf.'function aceptar'. $this->tabladb .'(){';
			$strSalida.= $crlf.'	actualizando();';
			$strSalida.= $crlf.'	var frmData = new FormData();';

			$strSalida.= $crlf.'	frmData.append("operacion", $("#hdnOperacion").val());';
			$strSalida.= $crlf.'	frmData.append("idViejo", $("#hdnIdViejo").val());';
			$strSalida.= $crlf.'	frmData.append("tabla", "'.$this->name.'");';

			if (isset($this->fields)) {
				$strSalida.= $crlf.'	frmData.append("'.$this->IDField.'", $("#'.$this->IDField.'").val());';
			}

			$strSalida.= $crlf;

			$strSalida.= $crlf.'	if (window.XMLHttpRequest)';
			$strSalida.= $crlf.'	{// code for IE7+, Firefox, Chrome, Opera, Safari';
			$strSalida.= $crlf.'		xmlhttp = new XMLHttpRequest();';
			$strSalida.= $crlf.'	}';
			$strSalida.= $crlf.'	else';
			$strSalida.= $crlf.'	{// code for IE6, IE5';
			$strSalida.= $crlf.'		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");';
			$strSalida.= $crlf.'	}';
			$strSalida.= $crlf.'	';
			$strSalida.= $crlf.'	xmlhttp.onreadystatechange = function() {';
			$strSalida.= $crlf.'		if (xmlhttp.readyState==4 && xmlhttp.status==200) {';
			$strSalida.= $crlf.'			var result = JSON.parse(xmlhttp.responseText);';
			$strSalida.= $crlf.'			divActualizando.close();';
			$strSalida.= $crlf.'			if (result.estado === true) {';
			$strSalida.= $crlf.'				notifySuccess({message:\''.gral_dataupdated.'\'});';
			$strSalida.= $crlf.'				$(".selectpicker").selectpicker("deselectAll");';

			if ($this->jsAfterSubmit != '') {
				$strSalida.= $crlf.'				'.$this->jsAfterSubmit;
			}

			$strSalida.= $crlf.'				listar'. $this->tabladb .'();';
			$strSalida.= $crlf.'			}';
			$strSalida.= $crlf.'			else {';
			$strSalida.= $crlf.'				notifyDanger({title: "'.gral_updateerror.'", message:"<br>" + result.estado});';
			$strSalida.= $crlf.'			}';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'			if (result.sql) {';
			$strSalida.= $crlf.'				console.log(result.sql);';
			$strSalida.= $crlf.'			}';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'		}';
			$strSalida.= $crlf.'	};';
			$strSalida.= $crlf.'	';
			$strSalida.= $crlf.'	xmlhttp.open("POST","php/tablaHandler.php",true);';
			$strSalida.= $crlf.'	xmlhttp.send(frmData);';
			$strSalida.= $crlf.'}';
		}

		//Si hay campo con buscador
		$blnBuscador = false;
		if (isset($this->fields)) {
			foreach ($this->fields as $field) {
				if ($field['conBuscador']) {
					$blnBuscador = true;
					break;
				}
			}

			foreach ($this->searchFields as $field) {
				if ($field->conBuscador) {
					$blnBuscador = true;
					break;
				}
			}

			if ($blnBuscador) {
				$strSalida.= $crlf;
				$strSalida.= $crlf.'function buscarCampo(strCampo, strID) {';
				$strSalida.= $crlf.'	var valor = $("#buscar" + strCampo).val().trim();';
				$strSalida.= $crlf.'	var name = $("#buscar" + strCampo).data("field");';
				$strSalida.= $crlf;
				$strSalida.= $crlf.'	if (valor.length > 3 || strID != "") {';
				$strSalida.= $crlf.'		$("#" + strCampo).attr("disabled", true);';
				$strSalida.= $crlf.'		$("#" + strCampo).html("");';
				$strSalida.= $crlf;
				$strSalida.= $crlf.'		actualizando();';
				$strSalida.= $crlf;
				$strSalida.= $crlf.'		$.ajax({';
				$strSalida.= $crlf.'			type: "POST",';
				$strSalida.= $crlf.'			url: "php/tablaHandler.php",';
				$strSalida.= $crlf.'			data: {';
				$strSalida.= $crlf.'				operacion: "99",';
				$strSalida.= $crlf.'				tabla: "'.$this->name.'",';
				$strSalida.= $crlf.'				field: strCampo,';
				$strSalida.= $crlf.'				campo: name,';
				$strSalida.= $crlf.'				dato: valor,';
				$strSalida.= $crlf.'				strID: strID';
				$strSalida.= $crlf.'			},';
				$strSalida.= $crlf.'			success: function(data) {';
				$strSalida.= $crlf.'				if (data.valor != "") {';
				$strSalida.= $crlf.'					$("#" + strCampo).html(data.valor);';
				$strSalida.= $crlf.'					$("#" + strCampo).attr("disabled", false);';
				$strSalida.= $crlf.'					$("#" + strCampo).focus();';
				$strSalida.= $crlf.'					$("#" + strCampo).attr("size", $("#" + strCampo).find("option").length);';
				$strSalida.= $crlf.'					$("#" + strCampo).css("height", (($("#" + strCampo).find("option").length * 15) + 12) + "px");';
				$strSalida.= $crlf.'				}';
				$strSalida.= $crlf.'				divActualizando.close();';
				$strSalida.= $crlf.'			},';
				$strSalida.= $crlf.'			async: true';
				$strSalida.= $crlf.'		});';
				$strSalida.= $crlf.'	}';
				$strSalida.= $crlf.'	else {';
				$strSalida.= $crlf.'		if (valor.length == 0) {';
				$strSalida.= $crlf.'			$("#" + strCampo).html("");';
				$strSalida.= $crlf.'			$("#" + strCampo).attr("size", 1);';
				$strSalida.= $crlf.'			$("#" + strCampo).css("height", "24px");';
				$strSalida.= $crlf.'			$("#" + strCampo).attr("disabled", true);';
				$strSalida.= $crlf.'		}';
				$strSalida.= $crlf.'		else {';
				$strSalida.= $crlf.'			notifyDanger({title: "El texto ingresado debe tener más de 3 caracteres."});';
				$strSalida.= $crlf.'		}';
				$strSalida.= $crlf.'	}';
				$strSalida.= $crlf.'	return false;';
				$strSalida.= $crlf.'}';
			}
		}

		//Google maps
		if ($this->gmaps) {
		//InitMap
			$strSalida.= $crlf;
			$strSalida.= $crlf.'var map;';
			$strSalida.= $crlf.'var marker;';
			$strSalida.= $crlf.'var geocoder;';
			$strSalida.= $crlf.'var searchBox;';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'function initMap() {';
			$strSalida.= $crlf.'	if (map != null) {';
			$strSalida.= $crlf.'		return;';
			$strSalida.= $crlf.'	}';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'	map = new google.maps.Map(document.getElementById("map"), {';
			$strSalida.= $crlf.'		center: {lat: '.$this->gmapsCenterLat.', lng: '.$this->gmapsCenterLng.'},';
			$strSalida.= $crlf.'		zoom: 8';
			$strSalida.= $crlf.'	});';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'	searchBox = new google.maps.places.SearchBox($($("#map").data("campo") + "-buscar")[0]);';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'	map.addListener("bounds_changed", function() {';
			$strSalida.= $crlf.'		searchBox.setBounds(map.getBounds());';
			$strSalida.= $crlf.'	});';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'	searchBox.addListener("places_changed", function() {';
			$strSalida.= $crlf.'		var places = searchBox.getPlaces();';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'		if (places.length == 0) {';
			$strSalida.= $crlf.'			return;';
			$strSalida.= $crlf.'		}';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'		// Clear out the old markers.';
			$strSalida.= $crlf.'		if (marker != null)';
			$strSalida.= $crlf.'			marker.setMap(null);';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'		// For each place, get the icon, name and location.';
			$strSalida.= $crlf.'		var bounds = new google.maps.LatLngBounds();';
			$strSalida.= $crlf.'		if (places.length > 0) {';
			$strSalida.= $crlf.'			var place = places[0];';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'			if (!place.geometry) {';
			$strSalida.= $crlf.'				console.log("Returned place contains no geometry");';
			$strSalida.= $crlf.'				return;';
			$strSalida.= $crlf.'			}';
			$strSalida.= $crlf.'			var icon = {';
			$strSalida.= $crlf.'				url: place.icon,';
			$strSalida.= $crlf.'				size: new google.maps.Size(71, 71),';
			$strSalida.= $crlf.'				origin: new google.maps.Point(0, 0),';
			$strSalida.= $crlf.'				anchor: new google.maps.Point(17, 34),';
			$strSalida.= $crlf.'				scaledSize: new google.maps.Size(25, 25)';
			$strSalida.= $crlf.'			};';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'			marker = new google.maps.Marker({';
			$strSalida.= $crlf.'				map: map,';
			$strSalida.= $crlf.'				title: place.name,';
			$strSalida.= $crlf.'				position: place.geometry.location';
			$strSalida.= $crlf.'			});';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'			var campo = $("#map").data("campo");';
			$strSalida.= $crlf.'			$(campo).val(place.geometry.location.lat() + "|" + place.geometry.location.lng());';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'			if (place.geometry.viewport) {';
			$strSalida.= $crlf.'				// Only geocodes have viewport.';
			$strSalida.= $crlf.'				bounds.union(place.geometry.viewport);';
			$strSalida.= $crlf.'			} else {';
			$strSalida.= $crlf.'				bounds.extend(place.geometry.location);';
			$strSalida.= $crlf.'			}';
			$strSalida.= $crlf.'		}';
			$strSalida.= $crlf.'		map.fitBounds(bounds);';
			$strSalida.= $crlf.'	});';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'	map.addListener("click", function(event){';
			$strSalida.= $crlf.'		if (marker != null)';
			$strSalida.= $crlf.'			marker.setMap(null);';
			$strSalida.= $crlf.'		';
			$strSalida.= $crlf.'		marker = new google.maps.Marker({';
			$strSalida.= $crlf.'			position: event.latLng,';
			$strSalida.= $crlf.'			map: map';
			$strSalida.= $crlf.'		});';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'		var campo = $("#map").data("campo");';
			$strSalida.= $crlf.'		$(campo).val(event.latLng.lat() + "|" + event.latLng.lng()); ';
			$strSalida.= $crlf.'	});';
			// $strSalida.= $crlf.'	geocoder = new google.maps.Geocoder();';
			$strSalida.= $crlf.'}';

			$strSalida.= $crlf;
			$strSalida.= $crlf.'function buscarLoc(address, campo) {';
			$strSalida.= $crlf.'	if (address != "") {';
			$strSalida.= $crlf.'		geocoder.geocode({"address": address}, function(results, status) {';
			$strSalida.= $crlf.'			if (status === google.maps.GeocoderStatus.OK) {';
			$strSalida.= $crlf.'				map.setCenter(results[0].geometry.location);';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'				if (marker != null)';
			$strSalida.= $crlf.'					marker.setMap(null);';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'				marker = new google.maps.Marker({';
			$strSalida.= $crlf.'					map: map,';
			$strSalida.= $crlf.'					position: results[0].geometry.location';
			$strSalida.= $crlf.'				});';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'				$("#" + campo).val(results[0].geometry.location.lat() + "|" + results[0].geometry.location.lng());';
			$strSalida.= $crlf.'			} else {';
			$strSalida.= $crlf.'				swal("'.gral_locnotfound.'");';
			$strSalida.= $crlf.'			}';
			$strSalida.= $crlf.'		});';
			$strSalida.= $crlf.'	}';
			$strSalida.= $crlf.'}';
		}

		//Orden de las filas
		if ($this->orderField != '') {
			$strSalida.= $crlf;
			$strSalida.= $crlf.'function subir'. $this->tabladb .'(strID, orden){';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'	if (orden == "1") {return false}';;
			$strSalida.= $crlf;
			$strSalida.= $crlf.'	$.post("php/tablaHandler.php",';
			$strSalida.= $crlf.'		{ "operacion": "3"';
			$strSalida.= $crlf.'			, "tabla": "'.$this->name.'"';
			$strSalida.= $crlf.'			, "ID": strID';
			$strSalida.= $crlf.'			, "Orden": orden';

			if ($this->masterFieldId != '' && isset($_GET[$this->masterFieldId])) {
				$strSalida.= $crlf.'			, '. $this->masterFieldId .': "'. $_GET[$this->masterFieldId] .'"';
			}

			$strSalida.= $crlf.'		},';
			$strSalida.= $crlf.'		function(data) {';
			$strSalida.= $crlf.'			if (divActualizando != undefined) divActualizando.close();';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'			if (data.indexOf("Error") == -1) {';
			$strSalida.= $crlf.'				notifySuccess({message: data});';
			$strSalida.= $crlf.'				listar'. $this->tabladb .'(strID);';
			$strSalida.= $crlf.'			}';
			$strSalida.= $crlf.'			else {';
			$strSalida.= $crlf.'				notifyDanger({title: data});';
			$strSalida.= $crlf.'			}';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'		}';
			$strSalida.= $crlf.'	);';
			$strSalida.= $crlf.'}';

			$strSalida.= $crlf;

			$strSalida.= $crlf.'function bajar'. $this->tabladb .'(strID, orden){';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'	if (orden == $("#divDatos > table tr").length - 1) {return false}';;
			$strSalida.= $crlf;
			$strSalida.= $crlf.'	$.post("php/tablaHandler.php",';
			$strSalida.= $crlf.'		{ operacion: "4"';
			$strSalida.= $crlf.'			, "tabla": "'.$this->name.'"';
			$strSalida.= $crlf.'			, "ID": strID';
			$strSalida.= $crlf.'			, "Orden": orden';

			if ($this->masterFieldId != '' && isset($_GET[$this->masterFieldId])) {
				$strSalida.= $crlf.'			, '. $this->masterFieldId .': "'. $_GET[$this->masterFieldId] .'"';
			}

			$strSalida.= $crlf.'		},';
			$strSalida.= $crlf.'		function(data) {';
			$strSalida.= $crlf.'			if (divActualizando != undefined) divActualizando.close();';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'			if (data.indexOf("Error") == -1) {';
			$strSalida.= $crlf.'				notifySuccess({message: data});';
			$strSalida.= $crlf.'				listar'. $this->tabladb .'(strID);';
			$strSalida.= $crlf.'			}';
			$strSalida.= $crlf.'			else {';
			$strSalida.= $crlf.'				notifyDanger({title: data});';
			$strSalida.= $crlf.'			}';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'		}';
			$strSalida.= $crlf.'	);';
			$strSalida.= $crlf.'}';
		}

		//Exportar a Excel
		if ($this->exportToXLS) {
			$strSalida.= $crlf.'function exportar'. $this->name .'() {';
			$strSalida.= $crlf.'	$("#tbl'. $this->name .'").table2excel({';
			$strSalida.= $crlf.'		exclude: ".noXLS",';
			$strSalida.= $crlf.'		name: "'. $this->titulo .'",';
			$strSalida.= $crlf.'		filename: "'. $this->titulo .'"';
			$strSalida.= $crlf.'	});';
			$strSalida.= $crlf.'}';
		}

		//Si la tabla es de login
		if ($this->name == $config->tbLogin) {
			$strSalida.= $crlf;
			$strSalida.= $crlf.'function resetearPwd(strID) {';
			$strSalida.= $crlf.'	swal({';
			$strSalida.= $crlf.'		title: "'.gral_confirm.'",';
			$strSalida.= $crlf.'		type: "question",';
			$strSalida.= $crlf.'		text: "'.gral_resetpwd.' " + $("#NombPers" + strID).text().trim() + "?",';
			$strSalida.= $crlf.'		showCancelButton: true,';
			$strSalida.= $crlf.'		confirmButtonText: "'.gral_yesbutton.'",';
			$strSalida.= $crlf.'		cancelButtonText: "'.gral_nobutton.'",';
			$strSalida.= $crlf.'		focusCancel: true,';
			$strSalida.= $crlf.'	}).then((result) => {';
			$strSalida.= $crlf.'		if (result.value) {';
			$strSalida.= $crlf.'			actualizando();';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'			$.ajax({';
			$strSalida.= $crlf.'				type: "POST",';
			$strSalida.= $crlf.'				url: "php/tablaHandler.php",';
			$strSalida.= $crlf.'				data: {';
			$strSalida.= $crlf.'					operacion: "1",';
			$strSalida.= $crlf.'					tabla: "'. $this->name .'",';
			$strSalida.= $crlf.'					NumeUser: strID,';
			$strSalida.= $crlf.'					idViejo: strID,';
			$strSalida.= $crlf.'					FechPass: ""';
			$strSalida.= $crlf.'				},';
			$strSalida.= $crlf.'				success: function() {';
			$strSalida.= $crlf.'					divActualizando.close();';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'					notifySuccess({message: "'.gral_resetpwdtxt1.'<strong>" + $("#NombPers" + strID).text().trim() + "</strong> '.gral_resetpwdtxt2.'"});';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'					listar'. $this->name .'(strID);';
			$strSalida.= $crlf.'				},';
			$strSalida.= $crlf.'				async: true';
			$strSalida.= $crlf.'			});';
			$strSalida.= $crlf.'		}';
			$strSalida.= $crlf.'	});';
			$strSalida.= $crlf.'}';
		}

		$strSalida.= $crlf.'</script>';
		$strSalida.= $crlf;

		echo $strSalida;
	}

	public function insertar($datos) {
		try {
			global $config, $formatDateDB, $nombSistema;
			$strCampos = "";
			$strValores = "";
			$strID = "";
			$campoMultiple = false;
			$intOrden = 1;

			//Registro el usuario
			if ($this->regUser) {
				$strCampos = "NumeUser";
				$strValores = $_SESSION["NumeUser"];
			}

			//Registro el orden
			if ($this->orderField != '') {
				if ($this->orderFieldAppend) { //Agrego el objeto al final
					$strSQL = "SELECT COALESCE(MAX({$this->orderField}), 0) + 1 FROM ". $this->tabladb;
					if (($this->masterTable != '') && ($this->masterFieldId != '') && isset($datos[$this->masterFieldId])) {
						$strSQL.= " WHERE {$this->masterFieldId} = {$datos[$this->masterFieldId]}";
					}
					if ($strCampos != "") {
						$strCampos.= ", ";
						$strValores.= ", ";
					}
					$strCampos.= $this->orderField;
					$intOrden = $config->buscarDato($strSQL);
					$strValores.= $intOrden;
				}
				else { //Agrego el objeto al principio
					if ($strCampos != "") {
						$strCampos.= ", ";
						$strValores.= ", ";
					}
					$strCampos.= $this->orderField;
					$strValores.= "1";

					$strSQL = "UPDATE ". $this->tabladb;
					$strSQL.= " SET ". $this->orderField ." = ". $this->orderField ." + 1";
					$config->ejecutarCMD($strSQL);
				}
			}

			$strSQL = "INSERT INTO ". $this->tabladb;

			foreach ($datos as $name => $value) {
				if ($this->fields[$name]['processBD']) {
					if (strcmp($this->IDField, $name) == 0 && !$this->IDFieldAutoIncrement) {
						if ($value == "") {
							$value = $config->buscarDato("SELECT COALESCE(MAX($name), 0) + 1 Numero FROM $this->tabladb");
						}
						$strID = $value;
					}

					if ($value != '') {
						if ($strCampos != "") {
							$strCampos.= ", ";
							$strValores.= ", ";
						}

						$strCampos.= $name;
						if ($this->fields[$name]['isMD5']) {
							$strValores.= "'".md5($value)."'";
						} else {
							if (($value == '' || $value == 'null') && !$this->fields[$name]['required']) {
								$strValores.= "null";
							} else {
								if (!is_array($value)) {
									switch ($this->fields[$name]['type']) {
										case 'datetime':
											$strValores.= "STR_TO_DATE('".$value."', '".$formatDateDB." %H:%i')";
										break;

										case 'date':
											$strValores.= "STR_TO_DATE('".$value."', '".$formatDateDB."')";
										break;

										default:
											$strValores.= "'". \str_replace("'", "\'", $value) ."'";
										break;
									}
								}
								else {
									$campoMultiple = $name;
									$strValores.= "'@array@'";
								}
							}
						}
					}
				}
			}
			$strSQL.= " ($strCampos)";
			$strSQL.= " VALUES ($strValores)";

			//Seteo la variable a devolver
			$result = [
				'estado' => true,
				'id' => ''
			];

			if (isset($_SESSION[$nombSistema. "_debug"])) {
				$result["sql"] = $strSQL;
			}

			if (!$campoMultiple) {
				if (!$this->IDFieldAutoIncrement) {
					// SI EL ID NO ES AUTOINCREMENT
					$result["estado"] = $config->ejecutarCMD($strSQL);
					$result["id"] = $strID;
				}
				else {
					$result["estado"] = $config->ejecutarCMD($strSQL, true);

					if (is_numeric($result["estado"])) {
						$result["id"] = $result["estado"];
						$result["estado"] = true;
					}
					else {
						$result["id"] = '';
					}
				}
			}
			else {
				//Si tiene orden lo voy acomodando
				if ($this->orderField != '') {
					$strSQL_order = "UPDATE ". $this->tabladb;
					$strSQL_order.= " SET ". $this->orderField ." = ". $this->orderField ." + 1";
					$strSQL_order.= " WHERE ". $this->orderField ." >= ". $intOrden;
					if (($this->masterTable != '') && ($this->masterFieldId != '') && isset($datos[$this->masterFieldId])) {
						$strSQL_order.= " AND {$this->masterFieldId} = {$datos[$this->masterFieldId]}";
					}
				}

				//Agrego un registro por cada valor
				foreach ($datos[$campoMultiple] as $value) {
					$config->ejecutarCMD($strSQL_order);

					$strSQL2 = str_replace('@array@', $value, $strSQL);
					$result['id'] = $config->ejecutarCMD($strSQL2, true);
				}
			}

			// return json_encode($result);
			return $result;
		} catch (Exception $e) {
			return false;
		}
	}

	public function editar($datos, $idViejo) {
		try {
			global $config, $formatDateDB, $nombSistema;

			$strCampos = "";
			$strWhere = "";
			$strID = "";

			$strSQL = "UPDATE ". $this->tabladb;

			//Registro el usuario
			if ($this->regUser) {
				$strCampos = "NumeUser = ". $_SESSION["NumeUser"];
			}

			foreach ($datos as $name => $value) {
				if ($this->fields[$name]['processBD']) {
					switch ($this->fields[$name]['type']) {
						case "password":
							if ($value != "****") {
								if ($strCampos != "") {
									$strCampos.= ", ";
								}

								if ($this->fields[$name]['isMD5']) {
									$strCampos.= $name." = '".md5($value)."'";
								} else {
									$strCampos.= $name." = '". \str_replace("'", "\'", $value) ."'";
								}
							}
						break;

						case "number":
						case "select":
						case 'time':
						case 'month':
							if ($strCampos != "") {
								$strCampos.= ", ";
							}

							if ($value != '' && $value != 'null') {
								$strCampos.= $name." = '".$value."'";
							} else {
								$strCampos.= $name." = null";
							}

						break;

						case 'datetime':
						case 'date':
							if ($strCampos != "") {
								$strCampos.= ", ";
							}

							if ($value != '' && $value != 'null') {
								if ($this->fields[$name]['type'] == 'date') {
									$strCampos.= $name." = STR_TO_DATE('".$value."', '".$formatDateDB."')";
								}
								else {
									$strCampos.= $name." = STR_TO_DATE('".$value."', '".$formatDateDB." %H:%i')";
								}
							} else {
								$strCampos.= $name." = null";
							}
						break;

						default:
							if ($strCampos != "") {
								$strCampos.= ", ";
							}

							if ($this->fields[$name]['isMD5']) {
								$strCampos.= $name." = '".md5($value)."'";
							} else {
								if (!is_array($value)) {
									$strCampos.= $name." = '". \str_replace("'", "\'", $value) ."'";
								}
								else {
									$strCampos.= $name." = '". \str_replace("'", "\'", $value[0]) ."'";
								}
							}
						break;
					}

					if (strcmp($this->IDField, $name) == 0) {
						if ($strWhere != "") {
							$strWhere.= " AND ";
						}

						if ($idViejo != "") {
							$strWhere.= $name." = '$idViejo'";
						}
						else {
							$strWhere.= $name." = '$value'";
						}

						$strID = $value;
					}
				}
			}
			$strSQL.= " SET ". $strCampos;
			$strSQL.= " WHERE ". $strWhere  ;

			$result["estado"] = $config->ejecutarCMD($strSQL);
			$result["id"] = $strID;

			if (isset($_SESSION[$nombSistema. "_debug"])) {
				$result["sql"] = $strSQL;
			}

			// return json_encode($result);
			return $result;
		} catch (Exception $e) {
			return false;
		}
	}

	public function borrar($datos, $filtro = '') {
		try {
			global $config, $nombSistema;
			$strWhere = "";
			$strID = "";

			$strSQL = "DELETE FROM ". $this->tabladb;

			if ($filtro != '') {
				$strID = $filtro;

				$strWhere = $filtro;
			} else {
				foreach ($datos as $name => $value) {
					if (strcmp($this->IDField, $name) == 0) {
						$strID = $value;

						if ($strWhere != "") {
							$strWhere.= " AND ";
						}

						$strWhere.= $name." = '$value'";
					}
				}
			}

			$strSQL.= " WHERE ". $strWhere  ;

			// Controlo si la tabla tiene campos de archivos
			foreach ($this->fields as $field) {
				if ($field["type"] == 'file' || $field["type"] == 'image' || $field["type"] == 'image-multiple') {
					if ($field["processBD"]) {
						$archivo = "../". $config->buscarDato('SELECT '. $field['name'] .' FROM '. $this->tabladb .' WHERE '. $strWhere);

						if (file_exists($archivo)) {
							unlink($archivo);
						}
					}
				}
			}

			// Borro el registro
			$result["estado"] = $config->ejecutarCMD($strSQL);
			$result["id"] = $strID;

			if (isset($_SESSION[$nombSistema. "_debug"])) {
				$result["sql"] = $strSQL;
			}

			// return json_encode($result);
			return $result;
		} catch (Exception $e) {
			return false;
		}
	}

	function subirBajar($operacion, $datos) {
		global $config;

		$filtro = "";

		if (($this->masterTable != '') && ($this->masterFieldId != '') && isset($datos[$this->masterFieldId])) {
			$filtro = " AND {$this->masterFieldId} = {$datos[$this->masterFieldId]}";
		}

		//Actualizo el registro al que se le suplanata el orden
		$strSQL = "SELECT {$this->IDField} FROM {$this->tabladb} WHERE {$this->orderField} = ". $datos["Orden"];
		if ($operacion == "3") {
			$strSQL.= "-1";
		} else {
			$strSQL.= "+1";
		}
		$strSQL.= $filtro;

		$numeObjeOld = $config->buscarDato($strSQL);

		$strSQL = "UPDATE ". $this->tabladb;
		if ($operacion == "3") {
			$strSQL.= " SET {$this->orderField} = {$this->orderField} + 1";
		}
		else {
			$strSQL.= " SET {$this->orderField} = {$this->orderField} - 1";
		}
		$strSQL.= " WHERE {$this->IDField} = ". $numeObjeOld;
		$config->ejecutarCMD($strSQL);

		//Actualizo el registro actual
		$strSQL = "UPDATE ". $this->tabladb;
		if ($operacion == "3") {
			$strSQL.= " SET {$this->orderField} = {$this->orderField} - 1";
		}
		else {
			$strSQL.= " SET {$this->orderField} = {$this->orderField} + 1";
		}
		$strSQL.= " WHERE {$this->IDField} = ". $datos["ID"];

		$result["estado"] = $config->ejecutarCMD($strSQL);
		$result["id"] = $datos["ID"];

		// return json_encode($result);
		return $result;
	}

	public function crearFicha($strID) {
		global $config, $crlf;

		$resultado = [];

		$strSQL = "SELECT ";

		$strFields = '';
		foreach ($this->fields as $field) {
			if ($field['type'] != "calcfield" && $field["showOnList"] != false) {
				if ($strFields != '') {
					$strFields.= $crlf.', ';
				}

				if ($field['formatDb'] == '') {
					if ($field['type'] != "select" && $field["type"] != "selectmultiple") {
						$strFields.= $this->tabladb. "." .$field['name']. " " .$field["nameAlias"];
					}
					else {
						$strFields.= $this->tabladb. "." .$field['name'];

						if ($field['type'] == "select") {
							if ($field["lookupTableAlias"] == "") {
								if ($field["lookupTable"] != "") {
									$strFields.= $crlf.', ';
									$strFields.= $field["lookupTable"]. "." .$field['lookupFieldLabel']. " " .$field["nameAlias"];
								}
							} else {
								$strFields.= $crlf.', ';
								$strFields.= $field["lookupTableAlias"]. "." .$field['lookupFieldLabel']. " " .$field["nameAlias"];
							}
						}
					}
				} else {
					if ($field['type'] != "select" && $field["type"] != "selectmultiple") {
						$strFields.= $field['formatDb']. " " .$field["nameAlias"];
					} else {
						$strFields.= $field['formatDb']. " " .$field["nameAlias"];
					}
				}
			}
		}

		if ($this->orderField != '') {
			if ($strFields != '') {
				$strFields.= $crlf.', '. $this->tabladb. "." .$this->orderField;
			} else {
				$strFields.= $crlf. $this->tabladb. "." .$this->orderField;
			}
		}

		$strSQL.= $strFields;

		$strSQL.= $crlf." FROM ". $this->tabladb;

		foreach ($this->fields as $field) {
			//JOINS
			if (($field['type'] == "select") && ($field['showOnList'])) {
				if ($field['lookupTableAlias'] == '') {
					if ($field["lookupTable"] != "") {
						$strSQL.= $crlf." LEFT JOIN ". $field["lookupTable"] ." ON ". $this->tabladb .".". $field['name'] ." = ". $field["lookupTable"]. "." .$field['lookupFieldID'];
					}
				} else {
					$strSQL.= $crlf." LEFT JOIN ". $field["lookupTable"] ." ". $field["lookupTableAlias"] ." ON ". $this->tabladb .".". $field['name'] ." = ". $field["lookupTableAlias"]. "." .$field['lookupFieldID'];
				}

				if ($field["joinConditions"] != "") {
					$strSQL.= $crlf." AND ".$field["joinConditions"];
				}
			}
		}

		$filtro = '';
		if ($this->masterFieldId != '') {
			if (isset($_REQUEST[$this->masterFieldId])) {
				$filtro.= $crlf. $this->tabladb .'.'. $this->masterFieldId ." = '" . $_REQUEST[$this->masterFieldId] ."'";
			}
		}

		$strSQL.= $crlf." WHERE ". $this->tabladb .'.'. $this->IDField ." = ". $strID;
		if ($filtro != "") {
			if ($filtro != '') {
				$strSQL.= ' AND '. $filtro;
			}
		}

		if ($this->order != '') {
			$strSQL.= $crlf." ORDER BY ". $this->order;
		}

		$fila = $config->buscarDato($strSQL);

		$resultado['fila'] = $fila;

		$strSalida = '';

		if (isset($this->fields)) {
			$strSalida.= $crlf.'<form id="frm'. $this->tabladb .'" class="mt-4" method="post" onSubmit="return false;">';

			//Registro completo
			$strSalida.= $crlf.'<input type="hidden" id="'. $this->tabladb .'-fila" value=\''.\json_encode($fila).'\' />';

			foreach ($this->fields as $field) {
				if ($field["controlAlias"] == '') {
					$fname = $field['name'];
				}
				else {
					$fname = $field['controlAlias'];
				}

				$filaName = $field['name'];
				if ($field["nameAlias"] != '') {
					$filaName = $field['nameAlias'];
				}

				if ($field['showOnFicha']) {
					if ($field['isHiddenInForm'] || $field["type"] == 'hidden') {
						$strSalida.= $crlf.'<input type="hidden" id="'.$fname.'" value="'.$fila[$filaName].'" />';
					} else {
						$strSalida.= $crlf.'<div class="form-group row '.$field['cssGroup'].'">';

						if ($field['type'] != 'checkbox') {
							$strSalida.= $crlf.'<label for="'.$fname.'" class="col-form-label col-form-label-sm col-md-2">'.$field['label'].':</label>';

							if ($field['size'] <= 20) {
								$strSalida.= $crlf.'<div class="col-md-2">';
							} elseif ($field['size'] <= 40) {
								$strSalida.= $crlf.'<div class="col-md-3">';
							} elseif ($field['size'] <= 80) {
								$strSalida.= $crlf.'<div class="col-md-4">';
							} elseif ($field['size'] <= 160) {
								$strSalida.= $crlf.'<div class="col-md-5">';
							} elseif ($field['size'] <= 200) {
								$strSalida.= $crlf.'<div class="col-md-6">';
							} else {
								$strSalida.= $crlf.'<div class="col-md-10">';
							}
						}

						switch ($field["type"]) {
							case 'file':
								$strSalida.= $crlf.'<a href="'.$fila[$filaName].'" target="_blank" id="'.$fname.'">'.$fila[$filaName].'</a>';
								break;

							case 'image':
								$strSalida.= $crlf.'<div id="divPreview'.$fname.'" class="divPreview">';
								$strSalida.= $crlf.'<img src="'.$fila[$filaName].'" class="thumbnail" />';
								$strSalida.= $crlf.'</div>';
								break;

							case 'textarea':
								$strSalida.= $crlf.'<textarea class="form-control form-control-sm autogrow '.$field['cssControl'].'" id="'.$fname.'" readonly>';
								$strSalida.= $fila[$filaName];
								$strSalida.= '</textarea>';
								$strSalida.= $crlf.'<script type="text/javascript">';
								$strSalida.= $crlf.'$("#'.$fname.'").autogrow({vertical: true, horizontal: false, minHeight: 36});';
								$strSalida.= $crlf.'</script>';
								break;

							case 'select':
							case 'datalist':
								if ($field["nameAlias"] == '') {
									$fnameLookup = $field['lookupFieldLabel'];
								} else {
									$fnameLookup = $field['nameAlias'];
								}
								$strSalida.= $crlf.'<input type="hidden" id="'.$fname.'" value="'.$fila[$filaName].'" />';
								$strSalida.= $crlf.'<input type="text" class="form-control form-control-sm ucase '.$field['cssControl'].'" id="cmb-'.$fname.'" value="'.$field["txtBefore"] .(isset($fila[$fnameLookup])? $fila[$fnameLookup]: ''). $field["txtAfter"].'" readonly />';
								break;

							case 'selectmultiple':
								if ($field["nameAlias"] == '') {
									$fnameLookup = $field['lookupFieldLabel'];
								} else {
									$fnameLookup = $field['nameAlias'];
								}

								$tbSM = $config->cargarTabla("SELECT {$fnameLookup} FROM {$field['lookupTable']} WHERE {$field['lookupFieldID']} IN ({$fila[$field["name"]]})");
								$dato = "";
								if ($tbSM->num_rows > 0) {
									while ($filaSM = $tbSM->fetch_row()) {
										if ($dato != '') {
											$dato.= ', ';
										}
										$dato.= $filaSM[0];
									}
								}
								$strSalida.= $crlf.'<input type="hidden" id="'.$fname.'" value="'.$fila[$filaName].'" />';
								$strSalida.= $crlf.'<input type="text" class="form-control form-control-sm ucase '.$field['cssControl'].'" id="cmb-'.$fname.'" value="'.$field["txtBefore"].$dato.$field["txtAfter"].'" readonly />';
								break;

							case 'checkbox':
								$strSalida.= $crlf.'<div class="col-md-4 offset-md-2">';
								$strSalida.= $crlf.'<label class="labelCheck ucase">';
								$strSalida.= $crlf.'<input type="checkbox" id="'.$fname.'" '. (boolval($fila[$filaName])? 'checked': '') .' onclick="return false;"> '. $field['label'];
								$strSalida.= $crlf.'</label>';
								break;

							case "ckeditor":
								$strSalida.= $crlf.$fila[$fname];
								break;

							case "gmaps":
								$strSalida.= $crlf.'<input type="hidden" id="'.$fname.'" value="'.$fila[$filaName].'" />';
								$strSalida.= $crlf.'</div>';
								$strSalida.= $crlf.'</div>';
								$strSalida.= $crlf.'<div class="form-group row">';
								$strSalida.= $crlf.'<div class="col-md-10 offset-md-2">';
								$strSalida.= $crlf.'<div id="map" style="height: 500px;" data-campo="'.$fname.'"></div>';
								if ($fila[$filaName] != '') {
									$strSalida.= $crlf.'<script type="text/javascript">';
									$strSalida.= $crlf.'initMap();';
									$strSalida.= $crlf;
									$strSalida.= $crlf.'var aux = "'.$fila[$filaName].'";';
									$strSalida.= $crlf.'var lat = aux.substring(0, aux.indexOf("|"));';
									$strSalida.= $crlf.'var lng = aux.substring(aux.indexOf("|")+1);';
									$strSalida.= $crlf;
									$strSalida.= $crlf.'var pos = new google.maps.LatLng(lat, lng);';
									$strSalida.= $crlf;
									$strSalida.= $crlf.'marker = new google.maps.Marker({';
									$strSalida.= $crlf.'	position: pos,';
									$strSalida.= $crlf.'	map: map';
									$strSalida.= $crlf.'});';
									$strSalida.= $crlf;
									$strSalida.= $crlf.'map.setCenter(pos);';
									$strSalida.= $crlf.'</script>';
								}
								break;

							default:
								// $strSalida.= $crlf.'<input type="'.$field['type'].'" class="form-control form-control-sm '.$field['cssControl'].'" id="'.$fname.'" value="'.$field["txtBefore"].$fila[$filaName].$field["txtAfter"].'" readonly />';
								$strSalida.= $crlf.'<input type="text" class="form-control form-control-sm '.$field['cssControl'].'" id="'.$fname.'" value="'.$field["txtBefore"].$fila[$filaName].$field["txtAfter"].'" readonly />';
								break;
						}

						$strSalida.= $crlf.'</div>'; //col-md
						$strSalida.= $crlf.'</div>'; //form-group
					}
				}
			}
			$strSalida.= $crlf.'</form>';

		}

		$resultado["html"] = $strSalida;

		return $resultado;
	}

	public function scriptFicha() {
		global $config, $crlf;

		$strSalida = '';

		if (count($this->jsFilesFicha) > 0) {
			for ($I = 0; $I < count($this->jsFilesFicha); $I++) {
				$strSalida.= $crlf.'	<script src="'. $config->raiz . $this->jsFilesFicha[$I] .'"></script>';
			}
		}

		if (count($this->cssFiles) > 0) {
			for ($I = 0; $I < count($this->cssFiles); $I++) {
				$strSalida.= $crlf.'	<link rel="stylesheet" href="'. $config->raiz . $this->cssFiles[$I] .'" />';
			}
		}

		if ($this->gmaps) {
			$strSalida.= $crlf.'	<script async defer src="https://maps.googleapis.com/maps/api/js?key='.$this->gmapsApiKey.'"></script>';
		}

		$strSalida.= $crlf;
		$strSalida.= $crlf.'<script>';
		$strSalida.= $crlf;

		//Document Ready
		$strSalida.= $crlf.'$(document).ready(function() {';
		$strSalida.= $crlf.$this->jsOnLoadFicha;
		$strSalida.= $crlf.'});';

		//Google maps
		if ($this->gmaps) {
		//InitMap
			$strSalida.= $crlf;
			$strSalida.= $crlf.'var map;';
			$strSalida.= $crlf.'var marker;';
			$strSalida.= $crlf.'var geocoder;';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'function initMap() {';
			$strSalida.= $crlf.'	if (map != null) {';
			$strSalida.= $crlf.'		return;';
			$strSalida.= $crlf.'	}';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'	map = new google.maps.Map(document.getElementById("map"), {';
			$strSalida.= $crlf.'		center: {lat: '.$this->gmapsCenterLat.', lng: '.$this->gmapsCenterLng.'},';
			$strSalida.= $crlf.'		zoom: 8';
			$strSalida.= $crlf.'	});';
			$strSalida.= $crlf;
			$strSalida.= $crlf.'}';

		}

		$strSalida.= $crlf.'</script>';
		$strSalida.= $crlf;

		echo $strSalida;
	}


	public function customFunc($post) {
		return true;
	}
}