<?php
	namespace VectorForms;

	ini_set("log_errors", 1);
	ini_set("error_log", "php-error.log");
	
	require_once 'datosdb.php';
	require_once 'vectorForms.php';

	require_once 'custom/caja.php';
	require_once 'custom/lote.php';
	require_once 'custom/cuota.php';

	//Variables
	$crlf = "\n";

	//Datos de configuracion iniciales
	$config = new VectorForms($dbhost, $dbschema, $dbuser, $dbpass, $raiz, "La Ernestina", "img/logo.png", true);
	$config->tbLogin = 'usuarios';
	$config->cssFiles = ["admin/css/custom.css"];

	$_SESSION['imgCKEditor'] = '/VectorForms/admin/ckeditor/imgup';

	/**
	 * Items de menu adicionales
	 */
	$config->menuItems = [
			new MenuItem("Configuraciones", '', '', 'fa-cogs', 1, true, false),
			new MenuItem("Salir del Sistema", 'logout.php', '', 'fa-sign-out', '', false, false)
	];


	/**
	 * TABLAS
	 */

	/**
	 * USUARIOS
	 */
	$tabla = new Tabla("usuarios", "usuarios", "Usuarios", "el Usuario", true, "objeto/usuarios", "fa-users");
	$tabla->labelField = "NombPers";
	$tabla->numeCarg = 1;
	$tabla->isSubItem = true;

	$tabla->addField("NumeUser", "number", 0, "Número", false, true, true);
	$tabla->addField("NombPers", "text", 200, "Nombre Completo");
	$tabla->addField("NombUser", "text", 0, "Usuario");
	$tabla->fields['NombUser']['classControl'] = "ucase";

	$tabla->addField("NombPass", "password", 0, "Contraseña", true, false, false, false);
	$tabla->fields["NombPass"]['isMD5'] = true;
	$tabla->addField("NumeCarg", "select", 0, "Cargo", true, false, false, true, '', '', 'cargos', 'NumeCarg', 'NombCarg', '', 'NombCarg');
	$tabla->addField("NumeEsta", "select", 0, "Estado", true, false, false, true, '1', '', 'estados', 'NumeEsta', 'NombEsta', '', 'NombEsta');

	$config->tablas["usuarios"] = $tabla;

	/**
	 * BANCOS
	 */
	$tabla = new Tabla("bancos", "bancos", "Bancos", "el Banco", true, "objeto/bancos/", "fa-bank");
	$tabla->labelField = "NombBanc";
	$tabla->isSubItem = true;

	$tabla->addField("NumeBanc", "number", 0, "Número", false, true, true);
	$tabla->addField("NombBanc", "text", 200, "Nombre");
	$tabla->fields["NombBanc"]["cssControl"] = "ucase";

	$tabla->addField("NumeEsta", "select", 0, "Estado", true, false, false, true, '1', '', 'estados', 'NumeEsta', 'NombEsta', '', 'NombEsta');

	$config->tablas["bancos"] = $tabla;

	/**
	 * VENDEDORES
	 */
	$tabla = new Tabla("vendedores", "vendedores", "Vendedores", "el Vendedor", true, "objeto/vendedores/", "fa-male");
	$tabla->labelField = "NombVend";
	$tabla->isSubItem = true;

	$tabla->addField("NumeVend", "number", 0, "Número", false, true, true);
	$tabla->addField("NombVend", "text", 200, "Nombre");
	$tabla->fields["NombVend"]["cssControl"] = "ucase";

	$tabla->addField("NumeEsta", "select", 0, "Estado", true, false, false, true, '1', '', 'estados', 'NumeEsta', 'NombEsta', '', 'NombEsta');

	$config->tablas["vendedores"] = $tabla;

	/**
	 * TIPOS DE PAGOS
	 */
	$tabla = new Tabla("tipospagos", "tipospagos", "Formas de Pago", "la Forma de Pago", true, "objeto/tipospagos/", "fa-credit-card");
	$tabla->labelField = "NombTipoPago";
	$tabla->isSubItem = true;

	$tabla->addField("NumeTipoPago", "number", 0, "Número", false, true, true);
	$tabla->addField("NombTipoPago", "text", 100, "Nombre");
	$tabla->fields["NombTipoPago"]["cssControl"] = "ucase";

	$tabla->addField("NumeEsta", "select", 0, "Estado", true, false, false, true, '1', '', 'estados', 'NumeEsta', 'NombEsta', '', 'NombEsta');

	$config->tablas["tipospagos"] = $tabla;

	/**
	 * ESTADOS LOTES
	 */
	$tabla = new Tabla("estadoslotes", "estadoslotes", "Estados de lotes", "el Estado", false, "objeto/estadoslotes/", "fa-wrench");
	$tabla->labelField = "NombEstaLote";
	$tabla->isSubItem = true;

	$tabla->addField("NumeEstaLote", "number", 0, "Número", false, true, true);
	$tabla->addField("NombEstaLote", "text", 100, "Nombre");
	$tabla->fields["NombEstaLote"]["cssControl"] = "ucase";

	$config->tablas["estadoslotes"] = $tabla;

	/**
	 * PROVINCIAS
	 */
	$tabla = new Tabla("provincias", "provincias", "Provincias", "la provincia", true, "objeto/provincias/", "fa-linode");
	$tabla->labelField = "NombProv";
	$tabla->isSubItem = true;
	$tabla->allowDelete = false;
	$tabla->allowEdit = false;
	$tabla->allowNew = false;

	$tabla->addFieldId("NumeProv", "Número");
	$tabla->addField("NombProv", "text", 200, "Nombre");

	$config->tablas["provincias"] = $tabla;

	/**
	 * TIPOS DE CAJA
	 */
	$tabla = new Tabla("tiposcaja", "tiposcaja", "Tipos de operaciones de caja", "el registro", true, "objeto/tiposcaja/", "fa-sitemap");
	$tabla->isSubItem = true;
	$tabla->labelField = "NombTipoCaja";

	$tabla->addFieldId("NumeTipoCaja", "Número");
	$tabla->addField("NombTipoCaja", "text", 100, "Nombre");
	$tabla->fields["NombTipoCaja"]["cssControl"] = "ucase";
	$tabla->addField("NumeTipoOper", "select", 0, "Tipo de operación", true, false, false, true, '', '', 'tiposoperaciones', 'NumeTipoOper', 'NombTipoOper');

	$config->tablas["tiposcaja"] = $tabla;

	/**
	 * CAJA
	 */
	$tabla = new Caja("caja", "caja", "Caja", "el detalle", true, "objeto/caja/", "fa-money");
	$tabla->labelField = "NombCaja";
	$tabla->allowDelete = false;
	$tabla->allowEdit = false;
	$tabla->searchFields = ["NombCaja", "NumeTipoCaja"];
	$tabla->jsFiles = ["admin/js/custom/caja.js"];

	$tabla->btnForm = [
		array(
			"titulo"=> '<i class="fa fa-th fa-fw" aria-hidden="true"></i> Ver Todos',
			"class"=> "btn-primary",
			"onclick"=> "verTodos()"
		)
	];
	
	$tabla->addFieldId("NumeCaja", "Número de caja");
	$tabla->addField("FechCaja", "date", 0, "Fecha");
	$tabla->fields["FechCaja"]["isHiddenInForm"] = true;
	
	$tabla->addField("NumeUser", "select", 0, "Usuario", true, false, false, true, '', '', 'usuarios', 'NumeUser', 'NombPers');
	$tabla->fields["NumeUser"]["isHiddenInForm"] = true;

	$tabla->addField("NombCaja", "text", 80, "Descripcion");
	$tabla->fields["NombCaja"]["cssControl"] = "ucase";
	$tabla->addField("NumeTipoCaja", "select", 80, "Tipo de operación", true, false, false, true, '', '', 'tiposcaja', 'NumeTipoCaja', 'NombTipoCaja', '', 'NombTipoCaja');
	$tabla->addField("ImpoCaja", "number", 0, "Importe");
	$tabla->fields["ImpoCaja"]["step"] = "0.1";
	$tabla->addField("NumeEsta", "select", 0, "Estado", true, false, false, true, '1', '', 'estados', 'NumeEsta', 'NombEsta', '', 'NombEsta');

	$config->tablas["caja"] = $tabla;

	/**
	 * LOTES
	 */
	$tabla = new Lote("lotes", "lotes", "Lotes", "el Lote", true, "objeto/lotes/", "fa-map-o", "NombLote");
	$tabla->labelField = "NombLote";
	$tabla->allowDelete = false;

	$tabla->searchFields = ["NumeLote", "NombLote"];

	$tabla->btnList = [
			array(
				"id"=> "btnAsigClie",
				"titulo"=> '<i class="fa fa-id-card-o fa-fw" aria-hidden="true"></i> Asignar Cliente',
				"onclick"=> "asignarCliente",
				"class"=> "btn-default"),
			array(
				"id"=> "btnVerCuot",
				"titulo"=> 'Ver Cuotas',
				"onclick"=> "verCuotas",
				"class"=> "btn-default"),
	];

	$tabla->jsFiles = ["admin/js/custom/lotes.js"];

	$tabla->jsOnLoad = "cheqList();";
	$tabla->jsOnList = "cheqList();";

	$tabla->modalList = ["php/modals/loteCliente.php"];

	$tabla->addFieldId("NumeLote", "Número de lote");
	$tabla->addField("NombLote", "text", 100, "Nombre");
	$tabla->addField("LoteCoor", "text", 80, "Coordenadas mapa");
	$tabla->fields["LoteCoor"]["isHiddenInList"] = true;

	$tabla->addField("ValoLote", "number", 0, "Precio");

	$tabla->addField("NumeEstaLote", "select", 0, "Estado", true, false, false, true, '1', '', 'estadoslotes', 'NumeEstaLote', 'NombEstaLote');
	$tabla->fields["NumeEstaLote"]["showOnForm"] = false;
	
	$tabla->addField("NumeClie", "select", 100, "Cliente", false, false, false, true, '', '', 'clientes', 'NumeClie', 'NombClie', 'NumeEsta = 1', 'NombClie');
	$tabla->fields["NumeClie"]["showOnForm"] = false;
	
	$tabla->addField("CantCuot", "number", 0, "Cantidad de Cuotas");
	$tabla->fields["CantCuot"]["showOnForm"] = false;

	$config->tablas["lotes"] = $tabla;

	/**
	 * CUOTAS
	 */
	$tabla = new Cuota("cuotas", "cuotas", "Cuotas", "la Cuota", false, "objeto/cuotas/", "");
	$tabla->labelField = "NumeCuot";
	$tabla->masterTable = "lotes";
	$tabla->masterFieldId = "NumeLote";
	$tabla->masterFieldName = "NombLote";

	$tabla->btnList = [
		array(
			"id"=>"btnPagos",
			"titulo"=>"Ver Pagos",
			"class"=>"btn-primary",
			"onclick"=>"verPagos"
		)
	];

	$tabla->jsFiles = ["admin/js/custom/cuotas.js"];

	$tabla->allowNew = false;
	$tabla->allowDelete = false;

	$tabla->addFieldId("CodiIden", "Código", true, true);
	$tabla->addField("NumeCuot", "number", 0, "Número", true, true);
	$tabla->addField("FechCuot", "date", 0, "Fecha de creación");
	$tabla->fields["FechCuot"]["showOnForm"] = false;

	$tabla->addField("NumeLote", "select", 0, "Lote", true, false, false, true, '', '', 'lotes', 'NumeLote', 'NombLote');
	$tabla->fields["NumeLote"]["showOnForm"] = false;
	$tabla->fields["NumeLote"]["showOnList"] = false;

	$tabla->addField("NumeTipoCuot", "select", 0, "Tipo", true, false, false, true, '', '', 'tiposcuotas', 'NumeTipoCuot', 'NombTipoCuot');
	$tabla->fields["NumeTipoCuot"]["showOnForm"] = false;

	$tabla->addField("FechVenc", "date", 0, "Fecha de vencimiento");
	$tabla->fields["FechVenc"]["showOnForm"] = false;

	$tabla->addField("ImpoCuot", "number", 0, "Importe de cuota pura", true, true);
	$tabla->fields["ImpoCuot"]["step"] = "0.01";

	$tabla->addField("ImpoOtro", "number", 0, "Interés", true, true);
	$tabla->fields["ImpoOtro"]["step"] = "0.01";

	$tabla->addField("ObseCuot", "textarea", 200, "Observaciones", false);
	$tabla->fields["ObseCuot"]["isHiddenInList"] = true;

	$tabla->addField("NumeEstaCuot", "select", 0, "Estado", true, true, false, true, '1', '', 'estadoscuotas', 'NumeEstaCuot', 'NombEstaCuot', '', 'NombEstaCuot');

	$config->tablas["cuotas"] = $tabla;

	/**
	 * CUOTASPAGOS
	 */
	$tabla = new Tabla("cuotaspagos", "cuotaspagos", "Pagos de la Cuota", "el pago", false);
	$tabla->masterTable = "cuotas";
	$tabla->masterFieldId = "CodiIden";
	$tabla->masterFieldName = "NumeCuot";

	$tabla->btnForm = [
		array(
			"titulo"=> '<i class="fa fa-credit-card fa-fw" aria-hidden="true"></i> Cheques',
			"class"=> 'btn-primary',
			"onclick"=> "abrirCheques();"
		)
	];

	$tabla->modalList = ["php/modals/cheques.php"];

	$tabla->jsFiles = [
		"admin/js/custom/cuotaspagos.js",
		"admin/js/custom/jquery.fancybox.min.js"
	];

	$tabla->jsOnLoad = "cargarCheques();";

	$tabla->cssFiles = [
		"admin/css/custom/jquery.fancybox.min.css"
	];

	$tabla->addFieldId("NumePago", "NumePago", false, false);
	$tabla->addField("CodiIden", "number");
	$tabla->fields["CodiIden"]["showOnForm"] = false;
	$tabla->fields["CodiIden"]["showOnList"] = false;

	$tabla->addField("NumeTipoPago", "select", 80, "Forma de pago", true, false, false, true, '', '', 'tipospagos', 'NumeTipoPago', 'NombTipoPago', "NumeEsta = 1");
	$tabla->addField("CodiCheq", "select", 100, "Cheque", false, false, false, true, '', '', 'cheques', 'CodiCheq', 'NumeCheq', "NumeEsta = 1", "NumeCheq");
	$tabla->fields["CodiCheq"]["itBlank"] = true;

	$tabla->addField("ObsePago", "textarea", 200, "Observaciones", false);
	$tabla->fields["ObsePago"]["isHiddenInList"] = true;

	$config->tablas["cuotaspagos"] = $tabla;

	/**
	 * CLIENTES
	 */
	$tabla = new Tabla("clientes", "clientes", "Clientes", "el Cliente", true, "objeto/clientes/", "fa-id-card-o");
	$tabla->labelField = "NombClie";

	$tabla->searchFields = array("NumeClie", "NombClie");

	$tabla->btnList = [
			array(
				"id"=>"btnVerClie",
				"titulo"=> 'Ficha',
				"onclick"=> "verCliente",
				"class"=> "btn-default"),
	];

	$tabla->jsFiles = ['admin/js/custom/clientes.js'];

	$tabla->addField("NumeClie", "number", 0, "Numero", false, true, true);
	$tabla->fields["NumeClie"]["isHiddenInForm"] = true;
	$tabla->fields["NumeClie"]["isHiddenInList"] = true;

	$tabla->addField("NombClie", "text", 200, "Nombre");

	$tabla->addField("NumeTele", "text", 100, "Teléfono", false);
	$tabla->fields["NumeTele"]["cssGroup"] = "form-group2";

	$tabla->addField("NumeCelu", "text", 100, "Celular", false);
	$tabla->fields["NumeCelu"]["cssGroup"] = "form-group2";

	$tabla->addField("MailClie", "email", 200, "E-mail", false);

	$tabla->addField("DireClie", "text", 200, "Dirección");
	$tabla->fields["DireClie"]["cssGroup"] = "form-group2";
	$tabla->fields["DireClie"]["isHiddenInList"] = true;

	$tabla->addField("NombBarr", "text", 200, "Barrio", false);
	$tabla->fields["NombBarr"]["cssGroup"] = "form-group2";
	$tabla->fields["NombBarr"]["isHiddenInList"] = true;

	$tabla->addField("NombLoca", "text", 200, "Localidad");
	$tabla->fields["NombLoca"]["cssGroup"] = "form-group2";

	$tabla->addField("NumeProv", "select", 200, "Provincia", true, false, false, true, '', '', 'provincias', 'NumeProv', 'NombProv', '', 'NombProv');
	$tabla->fields["NumeProv"]["cssGroup"] = "form-group2";
	$tabla->fields["NumeProv"]["isHiddenInList"] = true;

	$tabla->addField("CodiPost", "text", 0, "Código postal", false);
	$tabla->fields["CodiPost"]["isHiddenInList"] = true;

	$tabla->addField("NumeVend", "select", 80, "Vendedor", true, false, false, true, '', '', 'vendedores', 'NumeVend', 'NombVend', '', 'NombVend');
	$tabla->fields["NumeVend"]["isHiddenInList"] = true;

	$tabla->addField("ObseClie", "textarea", 201, "Observaciones", false);
	$tabla->fields["ObseClie"]["isHiddenInList"] = true;

	$tabla->addField("NumeEsta", "select", 0, "Estado", true, false, false, true, '1', '', 'estados', 'NumeEsta', 'NombEsta', '', 'NombEsta');

	$config->tablas["clientes"] = $tabla;

	/**
	 * CHEQUES
	 */
	$tabla = new Tabla("cheques", "cheques", "Cheques", "el Cheque", true, "objeto/cheques/", "fa-credit-card");
	
	$tabla->addFieldId("CodiCheq", "CodiCheq", true, true);
	$tabla->addField("NumeCheq", "number", 80, "Número");
	$tabla->addField("EsPropio", "checkbox", 0, "Es propio?");
	$tabla->addField("Cruzado", "checkbox", 0, "Es cruzado?");

	$tabla->addField("FechReci", "date", 0, "Fecha recibido");
	$tabla->fields["FechReci"]["cssGroup"] = "form-group3";

	$tabla->addField("FechEmis", "date", 0, "Fecha de Emisión");
	$tabla->fields["FechEmis"]["cssGroup"] = "form-group3";

	$tabla->addField("FechPago", "date", 0, "Fecha de Vencimiento");
	$tabla->fields["FechPago"]["cssGroup"] = "form-group3";

	$tabla->addField("NumeBanc", "select", 80, "Banco", true, false, false, true, '', '', "bancos", "NumeBanc", "NombBanc", "NumeEsta = 1", "NombBanc");
	$tabla->fields["NumeBanc"]["cssGroup"] = "form-group2";

	$tabla->addField("NumeTipoCheq", "select", 80, "Tipo de cheque", true, false, false, true, '', '', "tiposcheques", "NumeTipoCheq", "NombTipoCheq", "", "NombTipoCheq");
	$tabla->fields["NumeTipoCheq"]["cssGroup"] = "form-group2";

	$tabla->addField("NombTitu", "text", 100, "Titular");
	$tabla->fields["NombTitu"]["cssGroup"] = "form-group2";

	$tabla->addField("CUITTitu", "text", 100, "CUIT Titular");
	$tabla->fields["CUITTitu"]["cssGroup"] = "form-group2";
	$tabla->fields["CUITTitu"]["isHiddenInList"] = true;

	$tabla->addField("NombReci", "text", 80, "Nombre tercero", true);

	$tabla->addField("TeleReci", "text", 80, "Teléfono tercero", true);
	$tabla->fields["TeleReci"]["isHiddenInList"] = true;

	$tabla->addField("DireReci", "text", 400, "Dirección tercero", false);
	$tabla->fields["DireReci"]["isHiddenInList"] = true;

	$tabla->addField("ImpoCheq", "number", 0, "Importe");
	$tabla->fields["ImpoCheq"]["step"] = "0.01";
	
	$tabla->addField("ObseCheq", "textarea", 400, "Observaciones", false);
	$tabla->fields["ObseCheq"]["isHiddenInList"] = true;

	$tabla->addField("NumeEsta", "select", 0, "Estado", true, false, false, true, '1', '', 'estados', 'NumeEsta', 'NombEsta', '', 'NombEsta');

	$config->tablas["cheques"] = $tabla;
	?>