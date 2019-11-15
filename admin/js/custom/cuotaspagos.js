var $;

function abrirCheques() {
	$('[data-fancybox]').fancybox({
		iframe: {
			css: {
				width: '100%',
				height: '100%'
			}
		},
		afterClose: function() {
			cargarCheques();
		}
	});

	$('#modalCheques').click();
}

function afterLoad() {
	$('#CodiCheq').prop('disabled', true);

	cargarCheques();
	afterList();
}

function afterList() {
	var saldo = parseFloat($('#txtSaldo').html());

	if (saldo == 0) {
		$('#btnNuevo').hide();
	} else {
		$('#btnNuevo').show();
	}

	$('#divDatos')
		.find('tr')
		.each(function(I) {
			if (I > 0) {
				var strID = $(this)
					.find("input[id^='NumePago']")
					.val();

				if ($('#NumeEsta' + strID).val() != '1') {
					$(this).addClass('txtTachado');
				}
			}
		});
}

function cargarCheques() {
	$.ajax({
		url: 'php/tablaHandler.php',
		type: 'post',
		async: true,
		data: {
			operacion: '100',
			tabla: 'cuotaspagos',
			field: 'Cheques',
			dato: ''
		},
		success: function(data) {
			$('#CodiCheq').html(data['valor']);
		}
	});
}

function buscarImporte() {
	var codiCheq = $('#CodiCheq').val();

	if (codiCheq != '') {
		$.ajax({
			type: 'POST',
			url: 'php/tablaHandler.php',
			data: {
				operacion: '100',
				tabla: 'cuotaspagos',
				field: 'ImpoCheq',
				dato: { CodiCheq: codiCheq }
			},
			success: function(data) {
				$('#ImpoPago').val(data.valor);
			},
			async: false
		});
	}
}

function formasPago() {
	var formaPago = $('#NumeTipoPago option:selected')
		.text()
		.toUpperCase();

	if (formaPago === 'CHEQUE') {
		$('#CodiCheq').prop('disabled', false);
		$('#ImpoPago').prop('readonly', true);
	} else {
		$('#CodiCheq').prop('disabled', true);
		$('#ImpoPago').prop('readonly', false);
	}
}

function cambiarEstado(strID) {
	actualizando();

	var codiIden = $('#CodiIden' + strID).val();

	$.ajax({
		type: 'POST',
		url: 'php/tablaHandler.php',
		data: {
			operacion: '100',
			tabla: 'cuotaspagos',
			field: 'NumeEsta',
			dato: { NumePago: strID, CodiIden: codiIden }
		},
		success: function(data) {
			divActualizando.close();

			if (data.valor === true) {
				notifySuccess();

				listarcuotaspagos();
			} else {
				notifyDanger({ message: data.valor });
			}
		},
		async: true
	});
}

function validar() {
	var saldo = parseFloat($('#txtSaldo').html());
	var impoPago = parseFloat($('#ImpoPago').val());

	var mensaje = '';

	if (saldo < impoPago) {
		mensaje += 'El importe del pago no puede ser mayor al saldo!<br>';
	}

	var formaPago = $('#NumeTipoPago option:selected')
		.text()
		.toUpperCase();
	if (formaPago === 'CHEQUE') {
		if ($('#CodiCheq').val() == '') {
			mensaje += 'Debe seleccionar un cheque!<br>';
		}
	}

	if (isNaN(impoPago) || impoPago <= 0) {
		mensaje += 'El importe del pago debe ser mayor a 0 (cero)<br>';
	}

	if (mensaje != '') {
		divActualizando.close();
		notifyDanger({ message: mensaje });
		return false;
	}

	return true;
}

function calcularIntereses() {
	actualizando();
	var codiIden = getVariable('CodiIden');

	$.post(
		'php/tablaHandler.php',
		{
			operacion: '100',
			tabla: 'cuotas',
			field: 'CalcInterses',
			CodiIden: codiIden
		},
		function(data) {
			divActualizando.close();

			if (data.valor === true) {
				notifySuccess();

				listarcuotaspagos();
			} else {
				notifyDanger();
			}
		}
	);
}