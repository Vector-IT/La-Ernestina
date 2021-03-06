<?php
	namespace VectorForms;

	ini_set("log_errors", 1);
	ini_set("error_log", "php-error.log");

	require_once 'datosdb.php';
	require_once 'vectorForms.php';

	require_once 'custom/caja.php';
	require_once 'custom/clientes.php';
	require_once 'custom/producto.php';
	require_once 'custom/cuota.php';
	require_once 'custom/cuotapago.php';
	require_once 'custom/cheque.php';
	require_once 'custom/indexacion.php';

	//Variables
	$crlf = "\n";

	//Datos de configuracion iniciales
	$config = new VectorForms($dbhost, $dbschema, $dbuser, $dbpass, $raiz, "Sistema", "", true);
	$config->tbLogin = 'usuarios';
	// $config->theme = 'dark';

	$_SESSION[$nombSistema.'_debug'] = '1';

	// CARGO
	if (isset($_SESSION["NumeUser"])) {
		$numeUser = $_SESSION["NumeUser"];
        $numeCarg = intval($config->buscarDato("SELECT NumeCarg FROM ".$config->tbLogin." WHERE NumeUser = ". $_SESSION["NumeUser"]));
	}
	else {
		$numeUser = '';
		$numeCarg = PHP_INT_MAX;
	}

	/**
	 * Items de menu adicionales
	 */
	$config->menuItems = [
			new MenuItem("Configuraciones", '', '', 'fa-cogs', 1, true, false),
			new MenuItem("Reportes", 'reports.php', '', 'fab fa-slideshare', '', false, false),
			new MenuItem("Salir del Sistema", 'logout.php', '', 'fa-sign-out-alt', '', false, false)
	];

	$config->cssFiles[] = "admin/js/custom/fancybox/jquery.fancybox.min.css";
	$config->cssFiles[] = "admin/css/custom/custom.css";

	$config->jsFiles[] = 'admin/js/custom/fancybox/jquery.fancybox.min.js';
	$config->jsFiles[] = 'admin/js/custom/publicos.js?'. rand(1, 999);

	/**
	 * TABLAS
	 */

	/**
	 * USUARIOS
	 */
	$tabla = new Tabla("usuarios", "usuarios", "Usuarios", "el Usuario", true, "objeto/usuarios.php", "fa-users");
	$tabla->labelField = "NombPers";
	$tabla->numeCarg = 1;
	$tabla->isSubItem = true;

	$tabla->btnList = [
		new \VectorForms\btnListItem('btnResetPwd', 'Reset PWD', '<i class="fas fa-user-secret"></i>', 'btn-secondary', 'button', '', 'resetearPwd')
	];

	$tabla->addFieldId("NumeUser", "Número");
	$tabla->addField("NombPers", "text", 200, "Nombre Completo");
	$tabla->addField("NombUser", "text", 0, "Usuario");
	$tabla->fields['NombUser']['attrControl'] = [
		'onkeyup'=>'this.value = this.value.toUpperCase();'
	];

	$tabla->addField("NombPass", "password", 0, "Contraseña", true, false, false, false);
	$tabla->fields["NombPass"]['isMD5'] = true;

	$tabla->addField("FechPass", "number", 0, "Ult. modificación de password");
	$tabla->fields['FechPass']['showOnList'] = false;
	$tabla->fields['FechPass']['showOnForm'] = false;

	$tabla->addField('FlagExpiPass', 'checkbox', 0, 'Expiración de contraseña');

	$tabla->addField("FechUltiEntr", "datetime", 0, "Ult. acceso al sistema");
	$tabla->fields['FechUltiEntr']['showOnForm'] = false;

	$tabla->addFieldSelect("NumeCarg", 40, "Cargo", true, '', 'cargos', '', 'NumeCarg', 'NombCarg', '', '', 'NumeCarg');

	$tabla->addFieldSelect("NumeEsta", 0, "Estado", true, '1', 'estados', '', 'NumeEsta', 'NombEsta', '', '', 'NombEsta');
	$tabla->fields["NumeEsta"]["condFormat"] = 'return ($fila[$field["name"]] == 0);';
	$tabla->fields["NumeEsta"]["classFormat"] = 'txtRed';

	$config->tablas["usuarios"] = $tabla;

	/**
	 * GRUPOS DE VENTA
	 */
	$tabla = new Tabla('gruposventa', 'gruposventa', 'Grupos de Venta', 'el Grupo de Venta', true, 'objeto/gruposventa.php', 'far fa-object-ungroup', 'NombGrup');
	$tabla->labelField = 'NombGrup';
	$tabla->numeCarg = 2;
	$tabla->isSubItem = true;

	$tabla->btnList[] = new btnListItem('btnUsuarios', 'Integrantes', '<i class="fas fa-users"></i>', 'btn-secondary', 'a', 'objeto/gruposventadetalles.php?NumeGrup');

	$tabla->addFieldId('NumeGrup', 'Número', true, true);
	$tabla->addField('NombGrup', 'text', 40, 'Nombre del Grupo');
	$tabla->addFieldSelect("NumeSupe", 0, "Supervisor", true, '', 'usuarios', '', 'NumeUser', 'NombPers', 'NumeEsta = 1 AND NumeCarg <= 3', '', 'NombPers');
	$tabla->addFieldSelect("NumeEsta", 0, "Estado", true, '1', 'estados', '', 'NumeEsta', 'NombEsta', '', '', 'NombEsta');
	$tabla->fields["NumeEsta"]["condFormat"] = 'return ($fila[$field["name"]] == 0);';
	$tabla->fields["NumeEsta"]["classFormat"] = 'txtRed';

	$config->tablas['gruposventa'] = $tabla;

	/**
	 * GRUPOS DE VENTA DETALLES
	 */
	$tabla = new Tabla('gruposventadetalles', 'gruposventadetalles', 'Integrantes', 'el Integrante', false, 'objeto/gruposventadetalles.php', 'fas fa-users', '');
	$tabla->numeCarg = 2;
	$tabla->masterTable = 'gruposventa';
	$tabla->masterFieldIdMaster = 'NumeGrup';
	$tabla->masterFieldId = 'NumeGrup';
	$tabla->masterFieldName = 'NombGrup';

	$tabla->addFieldId('NumeDeta', 'Numero', true, true);
	$tabla->addField('NumeGrup', 'hidden', 0, 'NumeGrup');
	$tabla->fields['NumeGrup']['isHiddenInList'] = true;

	$tabla->addFieldSelect("NumeUser", 0, "Integrante", true, '', 'usuarios', '', 'NumeUser', 'NombPers', 'NumeEsta = 1', '', 'NombPers');

	$config->tablas['gruposventadetalles'] = $tabla;

	/**
	 * CARGOS
	 */
	$tabla = new Tabla('cargos', 'cargos', 'Cargos', 'el Cargo', false, 'objeto/cargos.php', 'fas fa-user-tag', 'NumeCarg');
	$tabla->labelField = 'NumeCarg';
	$tabla->numeCarg = 1;
	$tabla->isSubItem = true;

	$tabla->addFieldId('NumeCarg', 'Número');
	$tabla->addField('NombCarg', 'text', 40, 'Nombre');
	$tabla->fields['NombCarg']['attrControl'] = [
		'onblur'=>'this.value = this.value.toUpperCase();',
		'onkeypress'=>'if(event.keyCode == 13) this.value = this.value.toUpperCase();'
	];

	$config->tablas['cargos'] = $tabla;

	/**
	 * BANCOS
	 */
	$tabla = new Tabla("bancos", "bancos", "Bancos", "el Banco", true, "objeto/bancos.php", "fas fa-university");
	$tabla->labelField = "NombBanc";
	$tabla->isSubItem = true;

	$tabla->addField("NumeBanc", "number", 0, "Número", false, true, true);
	$tabla->addField("NombBanc", "text", 200, "Nombre");
	$tabla->fields['NombBanc']['attrControl'] = [
		'onblur'=>'this.value = this.value.toUpperCase();',
		'onkeypress'=>'if(event.keyCode == 13) this.value = this.value.toUpperCase();'
	];

	$tabla->addField("NumeEsta", "select", 0, "Estado", true, false, false, true, '1', '', 'estados', 'NumeEsta', 'NombEsta', '', 'NombEsta');

	$config->tablas["bancos"] = $tabla;

	/**
	 * VENDEDORES
	 */
	// $tabla = new Tabla("vendedores", "vendedores", "Vendedores", "el Vendedor", true, "objeto/vendedores.php", "fa-male");
	// $tabla->labelField = "NombVend";
	// $tabla->isSubItem = true;

	// $tabla->addField("NumeVend", "number", 0, "Número", false, true, true);
	// $tabla->addField("NombVend", "text", 200, "Nombre");
	// $tabla->fields["NombVend"]["cssControl"] = "ucase";

	// $tabla->addField("NumeEsta", "select", 0, "Estado", true, false, false, true, '1', '', 'estados', 'NumeEsta', 'NombEsta', '', 'NombEsta');

	// $config->tablas["vendedores"] = $tabla;

	/**
	 * TIPOS DE PAGOS
	 */
	$tabla = new Tabla("tipospagos", "tipospagos", "Formas de Pago", "la Forma de Pago", true, "objeto/tipospagos.php", "fa-credit-card");
	$tabla->labelField = "NombTipoPago";
	$tabla->isSubItem = true;
	$tabla->allowDelete = false;
	$tabla->allowEdit = false;
	$tabla->allowNew = false;

	$tabla->addField("NumeTipoPago", "number", 0, "Número", false, true, true);
	$tabla->addField("NombTipoPago", "text", 100, "Nombre");
	$tabla->fields["NombTipoPago"]["cssControl"] = "ucase";

	$tabla->addField("NumeEsta", "select", 0, "Estado", true, false, false, true, '1', '', 'estados', 'NumeEsta', 'NombEsta', '', 'NombEsta');

	$config->tablas["tipospagos"] = $tabla;

	/**
	 * ESTADOS CLIENTES
	 */
	$tabla = new Tabla("estadosclientes", "estadosclientes", "Estados de clientes", "el Estado", true, "objeto/estadosclientes.php", "fa-wrench");
	$tabla->labelField = "NombEstaClie";
	$tabla->isSubItem = true;

	$tabla->addField("NumeEstaClie", "number", 0, "Número", false, true, true);
	$tabla->addField("NombEstaClie", "text", 100, "Nombre");
	$tabla->fields["NombEstaClie"]["cssControl"] = "ucase";

	$config->tablas["estadosclientes"] = $tabla;

	/**
	 * ESTADOS PRODUCTOS
	 */
	$tabla = new Tabla("estadosproductos", "estadosproductos", "Estados de productos", "el Estado", true, "objeto/estadosproductos.php", "fa-wrench");
	$tabla->labelField = "NombEstaProd";
	$tabla->isSubItem = true;

	$tabla->addField("NumeEstaProd", "number", 0, "Número", false, true, true);
	$tabla->addField("NombEstaProd", "text", 100, "Nombre");
	$tabla->fields["NombEstaProd"]["cssControl"] = "ucase";

	$config->tablas["estadosproductos"] = $tabla;

	/**
	 * PROVINCIAS
	 */
	$tabla = new Tabla("provincias", "provincias", "Provincias", "la provincia", true, "objeto/provincias.php", "fab fa-linode");
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
	$tabla = new Tabla("tiposcaja", "tiposcaja", "Tipos de operaciones de caja", "el registro", true, "objeto/tiposcaja.php", "fa-sitemap", 'NumeTipoCaja');
	$tabla->isSubItem = true;
	$tabla->labelField = "NombTipoCaja";

	$tabla->condEdit = 'return ($fila["NumeTipoCaja"] > 1);';
	$tabla->condDelete = 'return ($fila["NumeTipoCaja"] > 1);';

	$tabla->addFieldId("NumeTipoCaja", "Número");
	$tabla->addField("NombTipoCaja", "text", 100, "Nombre");
	$tabla->fields['NombTipoCaja']['cssControl'] = 'ucase';
	$tabla->fields['NombTipoCaja']['attrControl'] = [
		'onblur'=>'this.value = this.value.toUpperCase();',
		'onkeypress'=>'if(event.keyCode == 13) this.value = this.value.toUpperCase();'
	];
	$tabla->addField("NumeTipoOper", "select", 0, "Tipo de operación", true, false, false, true, '', '', 'tiposoperaciones', 'NumeTipoOper', 'NombTipoOper');

	$config->tablas["tiposcaja"] = $tabla;

	/**
	 * TIPOS SEGUIMIENTOS
	 */
	$tabla = new Tabla("tiposseguimientos", "tiposseguimientos", "Tipos de Seguimiento", "el Tipo de Seguimiento", true, "objeto/tiposseguimientos.php", "fa-cog");
	$tabla->labelField = "NombTipoSegu";
	$tabla->numeCarg = 1;
	$tabla->isSubItem = true;

	$tabla->addFieldId("NumeTipoSegu", "Número");
	$tabla->addField("NombTipoSegu", "text", 100, "Nombre");

	$config->tablas["tiposseguimientos"] = $tabla;

	/**
	 * CAJA
	 */
	$tabla = new Caja("caja", "caja", "Caja", "el detalle", true, "objeto/caja.php", "fas fa-money-bill");
	$tabla->labelField = "NombCaja";
	$tabla->allowDelete = false;
	$tabla->allowEdit = false;

	$tabla->regUser = true;

	$tabla->searchFields = [
		new SearchField("NombCaja"),
		new SearchField("FechCaja", '=', 'AND', 'caja.FechCaja', false, null, null, null, 'date'),
		new SearchField("NumeTipoCaja", "=", "AND", "caja.NumeTipoCaja")
	];
	$tabla->jsFiles = ["admin/js/custom/caja.js"];

	$tabla->jsOnLoad = "iniciar();";

	$tabla->btnForm = [
		new btnListItem('btnVerTodos', '', '<i class="fa fa-th fa-fw" aria-hidden="true"></i> Ver Todos', 'btn-primary', 'button', '', 'verTodos()')
	];

	$tabla->addFieldId("NumeCaja", "Número de caja", true, true);
	$tabla->addField("FechCaja", "datetime", 80, "Fecha");
	$tabla->fields["FechCaja"]["showOnForm"] = false;

	$tabla->addField("NumeUser", "select", 0, "Usuario", true, false, false, true, '', '', 'usuarios', 'NumeUser', 'NombPers');
	$tabla->fields["NumeUser"]["isHiddenInForm"] = true;

	$tabla->addField("NombCaja", "text", 80, "Descripcion");
	$tabla->fields['NombCaja']['cssControl'] = 'ucase';
	$tabla->fields['NombCaja']['attrControl'] = [
		'onblur'=>'this.value = this.value.toUpperCase();',
		'onkeypress'=>'if(event.keyCode == 13) this.value = this.value.toUpperCase();'
	];

	$tabla->addField("NumeTipoCaja", "select", 80, "Tipo de operación", true, false, false, true, '', '', 'tiposcaja', 'NumeTipoCaja', 'NombTipoCaja', 'NumeTipoCaja > 1', 'NombTipoCaja');
	$tabla->addField("ImpoCaja", "number", 0, "Importe");
	$tabla->fields["ImpoCaja"]["step"] = "0.1";
	$tabla->addField("NumeEsta", "select", 0, "Estado", true, false, false, true, '1', '', 'estados', 'NumeEsta', 'NombEsta', '', 'NombEsta');

	$config->tablas["caja"] = $tabla;

	/**
	 * CAJA 2
	 */
	$tabla = new Caja("caja2", "caja2", "Caja 2", "el detalle", true, "objeto/caja2.php", "fas fa-money-bill");
	$tabla->labelField = "NombCaja";
	$tabla->allowDelete = false;
	$tabla->allowEdit = false;

	$tabla->regUser = true;

	$tabla->searchFields = [
		new SearchField("NombCaja"),
		new SearchField("FechCaja", '=', 'AND', 'caja.FechCaja', false, null, null, null, 'date'),
		new SearchField("NumeTipoCaja", "=", "AND", "caja.NumeTipoCaja")
	];
	$tabla->jsFiles = ["admin/js/custom/caja.js"];

	$tabla->jsOnLoad = "iniciar();";

	$tabla->btnForm = [
		new btnListItem('btnVerTodos', '', '<i class="fa fa-th fa-fw" aria-hidden="true"></i> Ver Todos', 'btn-primary', 'button', '', 'verTodos()')
	];

	$tabla->addFieldId("NumeCaja", "Número de caja");
	$tabla->addField("FechCaja", "datetime", 80, "Fecha");
	$tabla->fields["FechCaja"]["showOnForm"] = false;

	$tabla->addField("NumeUser", "select", 0, "Usuario", true, false, false, true, '', '', 'usuarios', 'NumeUser', 'NombPers');
	$tabla->fields["NumeUser"]["isHiddenInForm"] = true;

	$tabla->addField("NombCaja", "text", 80, "Descripcion");
	$tabla->fields['NombCaja']['cssControl'] = 'ucase';
	$tabla->fields['NombCaja']['attrControl'] = [
		'onblur'=>'this.value = this.value.toUpperCase();',
		'onkeypress'=>'if(event.keyCode == 13) this.value = this.value.toUpperCase();'
	];

	$tabla->addField("NumeTipoCaja", "select", 80, "Tipo de operación", true, false, false, true, '', '', 'tiposcaja', 'NumeTipoCaja', 'NombTipoCaja', 'NumeTipoCaja > 1', 'NombTipoCaja');
	$tabla->addField("ImpoCaja", "number", 0, "Importe");
	$tabla->fields["ImpoCaja"]["step"] = "0.1";
	$tabla->addField("NumeEsta", "select", 0, "Estado", true, false, false, true, '1', '', 'estados', 'NumeEsta', 'NombEsta', '', 'NombEsta');

	$config->tablas["caja2"] = $tabla;

	/**
	 * PRODUCTOS
	 */
	$tabla = new Producto("productos", "productos", "Stock y Planes", "el Registro", true, "objeto/productos.php", "far fa-paper-plane", "NumeProd");
	$tabla->labelField = "NombProd";
	$tabla->allowDelete = false;

	$tabla->searchFields = [
		new SearchField('NombProd', 'LIKE')
	];

	$tabla->btnList[] = new btnListItem('btnAsigClie', 'Asignar Cliente', '<i class="fas fa-plus-circle fa-fw"></i>', 'btn-success', 'button', '', 'asignarCliente');
	$tabla->btnList[] = new btnListItem('btnBorrClie', 'Borrar Cliente', '<i class="fa fa-times fa-fw"></i>', 'btn-danger', 'button', '', 'borrarCliente', 1);
	$tabla->btnList[] = new btnListItem('btnVerCliente', 'Ver Cliente', '<i class="far fa-id-card"></i>', 'btn-secondary', 'button', '', 'verCliente', '', 'return ($fila["NumeClie"] != "");');
	$tabla->btnList[] = new btnListItem('btnVerCuot', 'Ver Cuotas', '<i class="far fa-map"></i>', 'btn-secondary', 'a', 'objeto/cuotas.php?NumeProd');
	$tabla->btnList[] = new btnListItem('btnWhatsapp', 'WhatsApp', '<i class="fab fa-whatsapp"></i>', 'btn-success', 'button', '', 'enviarWhatsapp');


	$tabla->jsFiles = ["admin/js/custom/productos.js"];

	$tabla->jsOnLoad = "cheqList();";
	$tabla->jsOnList = "cheqList();";

	$tabla->includeList = ["php/modals/prodCliente.php"];

	$tabla->addFieldId("NumeProd", "Número de Plan", true, true);
	$tabla->addField("NombProd", "text", 100, "Producto");

	$tabla->addField('ImpoCost', 'number', 0, 'Costo');
	$tabla->fields["ImpoCost"]["txtAlign"] = "right";
	$tabla->fields["ImpoCost"]["txtBefore"] = "$ ";
	$tabla->fields['ImpoCost']['numeCarg'] = 2;

	$tabla->addField("ValoProd", "number", 0, "Precio");
	$tabla->fields["ValoProd"]["txtAlign"] = "right";
	$tabla->fields["ValoProd"]["txtBefore"] = "$ ";

	$tabla->addFieldSelect("NumeEstaProd", 0, "Estado", true, '1', 'estadosproductos', '', 'NumeEstaProd', 'NombEstaProd', '', '', 'NumeEstaProd');

	$tabla->addField("NumeClie", "select", 100, "Cliente", false, false, false, true, '', '', 'clientes', 'NumeClie', 'NombClie', 'NumeEsta = 1', 'NombClie');
	$tabla->fields["NumeClie"]["showOnForm"] = false;

	$tabla->addFieldSelect('NumeTele', 0, 'Teléfono', true, '', 'clientes', '', 'NumeClie', 'NumeTele', '', '', 'NumeTele');
	$tabla->fields['NumeTele']['name'] = 'NumeClie';
	$tabla->fields["NumeTele"]["showOnForm"] = false;

	$tabla->addField("CantCuot", "number", 0, "Cantidad de Cuotas");
	$tabla->fields["CantCuot"]["showOnForm"] = false;
	$tabla->fields["CantCuot"]["txtAlign"] = "right";

	$tabla->addField("InteresDiario", "number", 0, "Interés diario");
	$tabla->fields["InteresDiario"]["showOnForm"] = false;
	$tabla->fields["InteresDiario"]["txtAlign"] = "right";
	$tabla->fields["InteresDiario"]["txtAfter"] = "%";
	$tabla->fields["InteresDiario"]["step"] = "0.01";

	$tabla->addFieldSelect('NumeVend', 0, 'Vendedor', true, '', 'usuarios', '', 'NumeUser', 'NombPers', 'NumeCarg = 4', '', 'NombPers');

	$config->tablas["productos"] = $tabla;

	/**
	 * CUOTAS
	 */
	$tabla = new Cuota("cuotas", "cuotas", "Cuotas", "la Cuota", false, "", "far fa-map");
	$tabla->labelField = "NumeCuot";
	$tabla->masterTable = "productos";
	$tabla->masterFieldId = "NumeProd";
	$tabla->masterFieldIdMaster = "NumeProd";
	$tabla->masterFieldName = "NombProd";
	$tabla->order = 'FechVenc, NumeCuot';

	$tabla->btnList[] = new btnListItem('btnPagos', 'Ver Pagos', '<i class="fas fa-cash-register fa-fw"></i>', 'btn-primary', 'a', 'objeto/cuotaspagos.php?CodiIden');

	$tabla->btnForm[] = new btnListItem('btnWhatsapp', 'WhatsApp', '<i class="fab fa-whatsapp"></i> Enviar WhatsApp', 'btn-success', 'button', '', 'enviarWhatsappOtro()');

	$tabla->allowNew = false;
	$tabla->allowDelete = false;

	$tabla->addFieldId("CodiIden", "Código", true, true);
	$tabla->addField("NumeCuot", "number", 0, "Número", true, true);
	$tabla->addField("FechCuot", "date", 0, "Fecha de creación");
	$tabla->fields["FechCuot"]["showOnForm"] = false;

	$strSQL = "(SELECT NumeProd, NombProd, NumeTele";
	$strSQL.= $crlf."FROM productos p";
	$strSQL.= $crlf."INNER JOIN clientes c ON p.NumeClie = c.NumeClie)";
	$tabla->addFieldSelect('NumeProd', 0, 'Plan', true, '', $strSQL, 'productos', 'NumeProd', 'NombProd', '', '', 'NombProd');
	$tabla->fields["NumeProd"]["showOnForm"] = false;
	$tabla->fields["NumeProd"]["showOnList"] = false;

	$tabla->addFieldSelect('NumeTele', 0, 'Telefono', true, '', $strSQL, 'productos', 'NumeProd', 'NumeTele', '', '', 'NumeTele');
	$tabla->fields['NumeTele']['name'] = 'NumeProd';
	$tabla->fields['NumeTele']['nameAlias'] = 'NumeTele';
	$tabla->fields["NumeTele"]["showOnForm"] = false;
	$tabla->fields['NumeTele']['isHiddenInList'] = true;

	$tabla->addField("NumeTipoCuot", "select", 0, "Tipo", true, false, false, true, '', '', 'tiposcuotas', 'NumeTipoCuot', 'NombTipoCuot');
	$tabla->fields["NumeTipoCuot"]["showOnForm"] = false;

	$tabla->addField("FechVenc", "date", 0, "Fecha de vencimiento");
	$tabla->fields["FechVenc"]["showOnForm"] = false;

	$tabla->addField("ImpoCuot", "number", 0, "Importe de cuota pura", true, true);
	$tabla->fields["ImpoCuot"]["step"] = "0.01";
	$tabla->fields["ImpoCuot"]["txtAlign"] = "right";
	$tabla->fields["ImpoCuot"]["txtBefore"] = "$ ";

	$tabla->addField("ImpoOtro", "number", 0, "Interés", true, true);
	$tabla->fields["ImpoOtro"]["step"] = "0.01";
	$tabla->fields["ImpoOtro"]["txtAlign"] = "right";
	$tabla->fields["ImpoOtro"]["txtBefore"] = "$ ";

	$tabla->addField("ImpoPago", "calcfield", 0, "Importe Pagado");
	$tabla->fields["ImpoPago"]["showOnForm"] = false;
	$tabla->fields["ImpoPago"]["txtAlign"] = "right";
	$tabla->fields["ImpoPago"]["txtBefore"] = "$ ";

	$tabla->addField("ObseCuot", "textarea", 200, "Observaciones", false);
	$tabla->fields["ObseCuot"]["isHiddenInList"] = true;

	$tabla->addField("NumeEstaCuot", "select", 0, "Estado", true, true, false, true, '1', '', 'estadoscuotas', 'NumeEstaCuot', 'NombEstaCuot', '', 'NombEstaCuot');

	$config->tablas["cuotas"] = $tabla;

	/**
	* CUOTASPAGOS
	*/
	$tabla = new CuotaPago("cuotaspagos", "cuotaspagos", "Pagos de la Cuota", "el pago", false, "", "fas fa-cash-register");
	$tabla->masterTable = "cuotas";
	$tabla->masterFieldId = "CodiIden";
	$tabla->masterFieldName = "NumeCuot";
	$tabla->allowEdit = false;
	$tabla->allowDelete = false;

	$tabla->regUser = true;

	$tabla->includeList = ["php/modals/mdlIntereses.php"];

	$tabla->btnForm[] = new btnListItem('btnCheques', 'Cheques', '<i class="fa fa-credit-card fa-fw"></i> Cheques', 'btn-primary', 'button', '', 'abrirCheques();');
	$tabla->btnForm[] = new btnListItem('btnActualizar', 'Calcular Interés', '<i class="fas fa-percentage fa-fw"></i> Calcular Interés', 'btn-warning', 'button', '', "$('#modalIntereses').modal('show');");
	$tabla->btnForm[] = new btnListItem('btnWhatsapp', 'WhatsApp', '<i class="fab fa-whatsapp"></i> Enviar WhatsApp', 'btn-success', 'button', '', 'enviarWhatsappOtro()');

	$tabla->btnList = [
		new btnListItem('btnCambiarEstado', 'Cambiar Estado', '<i class="fas fa-retweet fa-fw"></i>', 'btn-danger', 'button', '', 'cambiarEstado')
	];

	$tabla->jsFiles = [
		"admin/js/custom/cuotaspagos.js",
	];

	$tabla->jsOnLoad = "afterLoad();";
	$tabla->jsOnList = "afterList();";

	$tabla->addFieldId("NumePago", "NumePago", false, false);
	$tabla->fields["NumePago"]["isHiddenInForm"] = true;
	$tabla->fields["NumePago"]["isHiddenInList"] = true;

	$tabla->addField("CodiIden", "number");
	$tabla->fields["CodiIden"]["isHiddenInForm"] = true;
	$tabla->fields["CodiIden"]["isHiddenInList"] = true;

	$strSQL = "(SELECT CodiIden, NumeTele";
	$strSQL.= $crlf."FROM cuotas c";
	$strSQL.= $crlf."INNER JOIN (SELECT NumeProd, NumeTele";
	$strSQL.= $crlf."FROM productos p";
	$strSQL.= $crlf."INNER JOIN clientes c ON p.NumeClie = c.NumeClie) p ON c.NumeProd = p.NumeProd)";

	$tabla->addFieldSelect('NumeTele', 0, 'Telefono', true, '', $strSQL, 'productos', 'CodiIden', 'NumeTele', '', '', 'NumeTele');
	$tabla->fields['NumeTele']['name'] = 'CodiIden';
	$tabla->fields['NumeTele']['nameAlias'] = 'NumeTele';
	$tabla->fields["NumeTele"]["showOnForm"] = false;
	$tabla->fields['NumeTele']['isHiddenInList'] = true;

	$tabla->addField("FechPago", "datetime", 0, "Fecha");
	$tabla->fields["FechPago"]["showOnForm"] = false;

	$tabla->addField("NumeTipoPago", "select", 80, "Forma de pago", true, false, false, true, '1', '', 'tipospagos', 'NumeTipoPago', 'NombTipoPago', "NumeEsta = 1");
	$tabla->fields["NumeTipoPago"]["onChange"] = "formasPago()";

	$tabla->addField("CodiCheq", "select", 100, "Cheque", false, false, false, true, '', '', 'cheques', 'CodiCheq', 'NumeCheq', "NumeEsta = 1", "NumeCheq");
	$tabla->fields["CodiCheq"]["itBlank"] = true;
	$tabla->fields["CodiCheq"]["onChange"] = "buscarImporte()";

	$tabla->addField("ImpoPago", "number", 0, "Importe");
	$tabla->fields["ImpoPago"]["step"] = "0.01";
	$tabla->fields["ImpoPago"]["txtAlign"] = "right";
	$tabla->fields["ImpoPago"]["txtBefore"] = "$ ";

	$tabla->addField("ObsePago", "textarea", 200, "Observaciones", false);
	$tabla->fields["ObsePago"]["isHiddenInList"] = true;

	$tabla->addField("NumeEsta", "select", 0, "Estado", true, false, false, true, '1', '', 'estados', 'NumeEsta', 'NombEsta', '', 'NombEsta');
	$tabla->fields["NumeEsta"]["isHiddenInForm"] = true;

	$config->tablas["cuotaspagos"] = $tabla;

	/**
	 * INDEXACION DE CUOTAS
	 */
	// $tabla = new Indexacion("indexaciones", "indexaciones", "Indexación de Cuotas", "el índice", true, "objeto/indexaciones.php", "fa-percent");
	// $tabla->allowDelete = false;
	// $tabla->allowEdit = false;

	// $tabla->jsFiles = ["admin/js/custom/indexaciones.js"];

	// $tabla->jsOnLoad = "verEstado();";
	// $tabla->jsOnList = "verEstado();";

	// $tabla->btnList = [
	// 	new btnListItem('btnCambiarEstado', 'Cambiar Estado', '<i class="fas fa-retweet fa-fw"></i>', 'btn-warning', 'button', '', 'cambiarEstado')
	// ];

	// $tabla->addFieldId("NumeInde", "", true, true);
	// $tabla->addField("FechInde", "datetime", 0, "Fecha");
	// $tabla->fields["FechInde"]["showOnForm"] = false;

	// $tabla->addField("PorcInde", "number", 0, "Porcentaje");
	// $tabla->fields["PorcInde"]["step"] = "0.01";

	// $tabla->addField("NumeEsta", "select", 0, "Estado", true, false, false, true, '1', '', 'estados', 'NumeEsta', 'NombEsta', '', 'NombEsta');
	// $tabla->fields["NumeEsta"]["isHiddenInForm"] = true;

	// $config->tablas["indexaciones"] = $tabla;

	/**
	 * CLIENTES
	 */
	$tabla = new Cliente("clientes", "clientes", "Clientes", "el Cliente", true, "objeto/clientes.php", "far fa-id-card");
	$tabla->labelField = "NombClie";

	$tabla->searchFields = [
		new SearchField('NombClie', 'LIKE')
	];

	$tabla->btnFicha[] = new btnListItem('btnWhatsapp', 'WhatsApp', '<i class="fab fa-whatsapp"></i> Enviar WhatsApp', 'btn-success', 'button', '', 'enviarWhatsappCliente()');

	$tabla->btnList[] = new btnListItem('btnVerEstados', "Estados", '<i class="fa fa-archive fa-fw" aria-hidden="true"></i>', "btn-info", 'button', "", "verEstados");
	$tabla->btnList[] = new btnListItem('btnVerSeguimientos', "Seguimientos", '<i class="far fa-calendar-alt fa-fw" aria-hidden="true"></i>', "btn-info", 'button', "", "verSeguimientos");
	$tabla->btnList[] = new btnListItem('btnWhatsapp', 'WhatsApp', '<i class="fab fa-whatsapp"></i>', 'btn-success', 'button', '', 'enviarWhatsapp');

	$tabla->addField("NumeClie", "number", 0, "Numero", false, true, true);
	$tabla->fields["NumeClie"]["isHiddenInForm"] = true;
	$tabla->fields["NumeClie"]["isHiddenInList"] = true;

	$tabla->addField("NombClie", "text", 200, "Nombre");
	$tabla->fields["NombClie"]["cssGroup"] = "form-group2";

	$tabla->addField("NumeDocu", "number", 200, "DNI/CUIL/CUIT");
	$tabla->fields["NumeDocu"]["cssGroup"] = "form-group2";

	$tabla->addField("NumeTele", "text", 100, "Teléfono", false);
	$tabla->fields["NumeTele"]["cssGroup"] = "form-group2";

	$tabla->addField("NumeCelu", "text", 100, "Celular", false);
	$tabla->fields["NumeCelu"]["cssGroup"] = "form-group2";

	$tabla->addField("MailClie", "email", 60, "E-mail", false);

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

	$strSQL = "(SELECT NumeUser NumeVend, NombPers NombVend";
	$strSQL.= $crlf."FROM usuarios)";
	$tabla->addFieldSelect("NumeVend", 50, "Vendedor", false, '', $strSQL, 'vendedores', 'NumeVend', 'NombVend', '', '', 'NombVend', true);
	$tabla->fields["NumeVend"]["isHiddenInList"] = true;

	$tabla->addField("ObseClie", "textarea", 201, "Observaciones", false);
	$tabla->fields["ObseClie"]["isHiddenInList"] = true;

	$tabla->addFieldSelect("CantDias", 0, 'Días', false, '', '(SELECT NumeClie, MAX(FechRegi) FechRegi FROM clientesestados GROUP BY NumeClie)', 'se', 'NumeClie', 'FechRegi');
	$tabla->fields["CantDias"]["name"] = "NumeClie";
	$tabla->fields["CantDias"]["formatDb"] = "TIMESTAMPDIFF(DAY, FechRegi, SYSDATE())";
	$tabla->fields["CantDias"]["nameAlias"] = "CantDias";
	$tabla->fields["CantDias"]["txtAlign"] = "right";
	$tabla->fields["CantDias"]["showOnForm"] = false;
	$tabla->fields["CantDias"]["condFormat"] = 'return $this->colorEstado($field, $fila);';

	$tabla->addField("NumeEstaClie", "select", 0, "Estado", true, false, false, true, '1', '', 'estadosclientes', 'NumeEstaClie', 'NombEstaClie', '', 'NumeEstaClie');

	$config->tablas["clientes"] = $tabla;

	/**
	 * CLIENTES ESTADOS
	 */
	$tabla = new Tabla("clientesestados", "clientesestados", "Estados", "el estado", false, "", "fa-archive");
	$tabla->masterTable = "clientes";
	$tabla->masterFieldId = "NumeClie";
	$tabla->masterFieldIdMaster = "NumeClie";
	$tabla->masterFieldName = "NombClie";
	$tabla->order = "FechRegi";

	$tabla->allowNew = false;
	$tabla->allowEdit = false;
	$tabla->numeCargDelete = 1;

	$tabla->regUser = true;

	$tabla->addFieldId("CodiIden", 'Número', true, true);

	$tabla->addField("NumeClie", "hidden", "Plan");
	$tabla->fields["NumeClie"]["isHiddenInList"] = true;

	$tabla->addField("FechRegi", "datetime", 0, "Fecha / Hora");
	$tabla->addFieldSelect("NumeEstaClie", 0, "Estado", true, '', 'estadosclientes', '', 'NumeEstaClie', 'NombEstaClie', '', '', 'NombEstaClie');

	$tabla->addFieldSelect("NumeUser", 0, 'Usuario', true, '', 'usuarios', '', 'NumeUser', 'NombPers');

	$config->tablas["clientesestados"] = $tabla;

	/**
	 * SEGUIMIENTOS DE PRODUCTOS
	 */
	$tabla = new Tabla("seguimientos", "seguimientos", "Seguimientos", "el registro", false, "objeto/seguimientos.php", "far fa-calendar-alt");
	$tabla->masterTable = "productos";
	$tabla->masterFieldId = "NumeClie";
	$tabla->masterFieldIdMaster = "NumeClie";
	$tabla->masterFieldName = "NombClie";
	$tabla->order = "FechSegu";

	$tabla->masterTable = 'clientes';
	$tabla->masterFieldIdMaster = 'NumeClie';
	$tabla->masterFieldId = 'NumeClie';
	$tabla->masterFieldName = 'NombClie';

	$tabla->regUser = true;

	$tabla->allowDelete = false;


	$tabla->addFieldId("NumeSegu", "Número", true, true);
	$tabla->addField("NumeClie", "number", 0, "Cliente");
	$tabla->fields["NumeClie"]["isHiddenInList"] = true;
	$tabla->fields["NumeClie"]["isHiddenInForm"] = true;

	$tabla->addField("FechSegu", "date", 0, "Fecha");

	$tabla->addFieldSelect("NumeUser", 0, 'Usuario', true, '', 'usuarios', '', 'NumeUser', 'NombPers');
	$tabla->fields["NumeUser"]["showOnForm"] = false;

	$tabla->addFieldSelect("NumeTipoSegu", 0, 'Tipo de seguimiento', true, '', 'tiposseguimientos', '', 'NumeTipoSegu', 'NombTipoSegu');

	// $tabla->addFieldSelect("NumeEstaSegu", 0, "Estado", true, '', 'estadosseguimientos', '', 'NumeEstaSegu', 'NombEstaSegu', '', '', 'NombEstaSegu');
	// $tabla->fields["NumeEstaSegu"]["condFormat"] = 'return ($fila[$field["name"]] == 0);';
	// $tabla->fields["NumeEstaSegu"]["classFormat"] = 'txtRed';

	$tabla->addField("ObseSegu", "textarea", 100, "Observaciones");

	$config->tablas["seguimientos"] = $tabla;

	/**
	 * PERSONAS
	 */
	$tabla = new Tabla('personas', 'personas', 'Personas', 'la persona', true, 'objeto/personas.php', 'fas fa-male', 'NombPers');
	$tabla->labelField = 'NombPers';
	$tabla->numeCarg = 2;

	$tabla->addFieldId('NumePers', 'Número', true, true);
	$tabla->addField('NombPers', 'text', 40, 'Nombre completo');
	$tabla->fields['NombPers']['cssControl'] = 'ucase';
	$tabla->fields['NombPers']['attrControl'] = [
		'onblur'=>'this.value = this.value.toUpperCase();',
		'onkeypress'=>'if(event.keyCode == 13) this.value = this.value.toUpperCase();'
	];
	$tabla->addField('NumeDocu', 'text', 40, 'DNI / CUIT');
	$tabla->addField('NumeTele', 'text', 40, 'Teléfono');
	$tabla->addField('DirePers', 'text', 60, 'Dirección', false);

	$config->tablas['personas'] = $tabla;

	/**
	 * CHEQUES
	 */
	$tabla = new Cheque("cheques", "cheques", "Cheques", "el Cheque", true, "objeto/cheques.php", "fa-credit-card");
	$tabla->labelField = "NumeCheq";

	$tabla->allowDelete = false;

	$tabla->btnList = [
		new btnListItem('btnCambiarEstado', 'Cambiar estado', '<i class="fas fa-retweet fa-fw"></i>', 'btn-warning', 'button', '', 'cambiarEstado')
	];

	$tabla->searchFields[] = new SearchField('NumeCheq', 'LIKE');
	$tabla->searchFields[] = new SearchField('NombTitu', 'LIKE');
	$tabla->searchFields[] = new SearchField('CUITTitu', 'LIKE');

	$tabla->jsFiles = ["admin/js/custom/cheques.js"];
	$tabla->jsOnList = "verEstado();";
	$tabla->jsOnNew = "onNew();";
	$tabla->jsOnEdit = "onEdit();";

	$tabla->addFieldId("CodiCheq", "CodiCheq", true, true);
	$tabla->addField("NumeCheq", "text", 80, "Número");
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

	$tabla->addField("ImpoCheq", "number", 0, "Importe");
	$tabla->fields["ImpoCheq"]["step"] = "0.01";

	$tabla->addField("ObseCheq", "textarea", 400, "Observaciones", false);
	$tabla->fields["ObseCheq"]["isHiddenInList"] = true;
	$tabla->fields["ObseCheq"]["isHiddenInForm"] = true;

	$tabla->addField("NumeEsta", "select", 0, "Estado", true, false, false, true, '1', '', 'estados', 'NumeEsta', 'NombEsta', '', 'NombEsta');

	//Recibido de
	$strSQL = "(SELECT NumePers, CONCAT(NombPers, ' - ', NumeTele) NombPersReci";
	$strSQL.= $crlf."FROM personas)";
	$tabla->addFieldSelect('NumePersReci', 80, 'Recibido de', true, '', $strSQL, 'precibido', 'NumePers', 'NombPersReci', '', '', 'NombPersReci');
	$tabla->fields["NumePersReci"]["cssGroup"] = "form-group2";

	//Entregado a
	$strSQL = "(SELECT NumePers, CONCAT(NombPers, ' - ', NumeTele) NombPersEntr";
	$strSQL.= $crlf."FROM personas)";
	$tabla->addFieldSelect('NumePersEntr', 80, 'Entregado a', false, '', $strSQL, 'pentregado', 'NumePers', 'NombPersEntr', '', '', 'NombPersEntr', true);
	$tabla->fields["NumePersEntr"]["cssGroup"] = "form-group2";

	$config->tablas["cheques"] = $tabla;

	/**
	 * OBLIGACIONES
	 */
	$tabla = new Tabla("obligaciones", "obligaciones", "Obligaciones", "el registro", true, "objeto/obligaciones.php", "far fa-calendar-alt");
	$tabla->order = "FechSegu";
	$tabla->numeCarg = 1;

	$tabla->regUser = true;

	$tabla->allowDelete = false;

	// $tabla->btnForm = [
	// 	new \VectorForms\btnListItem('btnVerProducto', 'Ver Producto', '<i class="far fa-file-alt"></i> Ver Producto', 'btn-info', 'button', '', "window.open('ver/productos.php?id=' + getVariable('NumeProd'));")
	// ];

	$tabla->addFieldId("NumeObli", "Número", true, true);

	$tabla->addField("FechSegu", "date", 0, "Fecha");

	$tabla->addFieldSelect("NumeUser", 0, 'Usuario', true, '', 'usuarios', '', 'NumeUser', 'NombPers');
	$tabla->fields["NumeUser"]["showOnForm"] = false;

	$tabla->addFieldSelect("NumeTipoSegu", 0, 'Tipo de obligacion', true, '', 'tiposseguimientos', '', 'NumeTipoSegu', 'NombTipoSegu');

	// $tabla->addFieldSelect("NumeEstaSegu", 0, "Estado", true, '', 'estadosseguimientos', '', 'NumeEstaSegu', 'NombEstaSegu', '', '', 'NombEstaSegu');
	// $tabla->fields["NumeEstaSegu"]["condFormat"] = 'return ($fila[$field["name"]] == 0);';
	// $tabla->fields["NumeEstaSegu"]["classFormat"] = 'txtRed';

	$tabla->addField("ObseSegu", "textarea", 100, "Observaciones");

	$tabla->addFieldSelect("NumeTipoPago", 40, "Forma de pago", true, '1', 'tipospagos', '', 'NumeTipoPago', 'NombTipoPago', "NumeEsta = 1", '', 'NombTipoPago');
	$tabla->addFieldSelect('NumeBanc', 40, 'Banco', false, '', 'bancos', '', 'NumeBanc', 'NombBanc', 'NumeEsta = 1', '', 'NombBanc', true, 'SIN BANCO', 'SIN BANCO');
	$tabla->addField('NombTitu', 'text', 40, 'Titular', false);
	$tabla->addField("ImpoCheq", "number", 0, "Importe", true);
	$tabla->fields["ImpoCheq"]["step"] = "0.01";
	$tabla->addField("CUITTitu", "text", 40, "CUIT Titular", false);
	$tabla->addField("FechEmis", "date", 0, "Fecha de Emisión", false);
	$tabla->addField("FechVenc", "date", 0, "Fecha de Vencimiento", false);

	$config->tablas["obligaciones"] = $tabla;

	/**
	 * ADMINISTRADOR DE REPORTES
	 */
	$tabla = new Tabla("reportes", "reportes", "Administrador de Reportes", "el reporte", false);
	$tabla->labelField = "NombRepo";

	$tabla->jsFiles = ["admin/js/custom/adminReportes.js"];

	$tabla->addFieldId("NumeRepo", "Número");
	$tabla->addField("NombRepo", "text", 80, "Nombre");
	$tabla->addField("SQLRepo", "textarea", 400, "SQL");
	$tabla->fields["SQLRepo"]["isHiddenInList"] = true;

	$tabla->addField("CantParams", "number", 0, "Cantidad de parámetros");
	$tabla->fields["CantParams"]["isHiddenInList"] = true;

	$tabla->addField("TipoParam", "select", 0, "Tipo de parámetros");
	$tabla->fields["TipoParam"]["isHiddenInList"] = true;

	$tabla->addField("Tabla", "text", 80, "Tabla", false);
	$tabla->fields["Tabla"]["isHiddenInList"] = true;

	$tabla->addField("CampoNumero", "text", 80, "Campo Número", false);
	$tabla->fields["CampoNumero"]["isHiddenInList"] = true;

	$tabla->addField("CampoNombre", "text", 80, "Campo Nombre", false);
	$tabla->fields["CampoNombre"]["isHiddenInList"] = true;

	$tabla->addField("ColumnFoot", "number", 0, "Columna footer");
	$tabla->fields["ColumnFoot"]["isHiddenInList"] = true;

	$tabla->addField("FooterEsMoneda", "checkbox", 0, "Footer es moneda?");
	$tabla->fields["FooterEsMoneda"]["isHiddenInList"] = true;

	$tabla->addField("NumeEsta", "select", 0, "Estado", true, false, false, true, '1', '', 'estados', 'NumeEsta', 'NombEsta', '', 'NombEsta');

	$config->tablas["reportes"] = $tabla;

	?>