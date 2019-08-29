var $;

$(document).ready(function() {
	$('#modalCliente').on('shown.bs.modal', function() {
		$('#NumeClie').focus();
	});
});

function cheqList() {
	$("tr input[id^='NumeProd']").each(function(index, campo) {
		var numeProd = $(campo).val();

		if ($('#NumeClie' + numeProd).val() != '') {
			$('#btnAsigClie' + numeProd).hide();

			if ($('#CantCuot' + numeProd).html() == '') {
				$('#btnVerCuot' + numeProd).hide();
			}
		} else {
			$('#btnBorrClie' + numeProd).hide();
			$('#btnVerCuot' + numeProd).hide();
		}
	});
}

function verCuotas(NumeProd) {
	location.href = 'objeto/cuotas.php?NumeProd=' + NumeProd;
}

function asignarCliente(NumeProd) {
	$('#divMsjModal').hide();
	$('#hdnNumeProd').val(NumeProd);
	$('#txtNombProd').html($('#NombProd' + NumeProd).html());
	$('#ImpoAnti').prop('max', $('#ValoProd' + NumeProd).html());
	$('#cuotasExtra').html('');

	$('#modalCliente').modal();
}

function borrarCliente(numeProd) {
	$('#divMsj').hide();
	$('#actualizando').show();

	$.post(
		'php/tablaHandler.php',
		{
			operacion: '100',
			tabla: 'productos',
			field: 'Borrar Cliente',
			dato: { NumeProd: numeProd }
		},
		function(data) {
			if (data.valor === true) {
				$('#txtHint').html('Datos actualizados!');
				$('#divMsj').removeClass('alert-danger');
				$('#divMsj').addClass('alert-success');

				listarproductos();
			} else {
				$('#txtHint').html(data.valor);
				$('#divMsj').removeClass('alert-success');
				$('#divMsj').addClass('alert-danger');
			}
			$('#actualizando').hide();
			$('#divMsj').show();
		}
	);
}

function cerrarModal() {
	var numeProd = $('#hdnNumeProd').val();
	var numeClie = $('#NumeClie').val();
	var impoAnti = $('#ImpoAnti').val();
	var fechInic = $('#hdnFechInic').val();
	var cantCuot = $('#CantCuot').val();
	var cantCuotExtr = $('#cuotasExtra').children().length;

	var montoCuot = [];

	for (var I = 0; I < cantCuotExtr; I++) {
		montoCuot.push($("input[id='CuotExtr']")[I].value);
	}

	$('#modalCliente').modal('hide');

	$('#divMsj').hide();
	$('#actualizando').show();

	$.post(
		'php/tablaHandler.php',
		{
			operacion: '100',
			tabla: 'productos',
			field: 'Asignar Cliente',
			dato: { NumeProd: numeProd, NumeClie: numeClie, ImpoAnti: impoAnti, FechInic: fechInic, CantCuot: cantCuot, CuotExtr: montoCuot }
		},
		function(data) {
			if (data.valor === true) {
				$('#txtHint').html('Datos actualizados!');
				$('#divMsj').removeClass('alert-danger');
				$('#divMsj').addClass('alert-success');

				listarproductos();
			} else {
				$('#txtHint').html(data.valor);
				$('#divMsj').removeClass('alert-success');
				$('#divMsj').addClass('alert-danger');
			}
			$('#actualizando').hide();
			$('#divMsj').show();
		}
	);
}

function agregarCuota() {
	var I = $('#cuotasExtra').children().length + 1;

	$('#btnBorrarCuota').remove();

	var strCuota = '';

	strCuota += '\n<div class="form-group form-group-sm">';
	strCuota += '\n    <label for="CuotExtr" class="control-label col-md-2">Cuota extraordinaria ' + I + ':</label>';
	strCuota += '\n    <div class="col-md-8">';
	strCuota += '\n        <input type="number" min="0" class="form-control ucase" style="width: 93%; display: inline-block;" id="CuotExtr" required>';
	strCuota += '\n        <button type="button" class="btn btn-sm btn-danger" id="btnBorrarCuota" onclick="borrarCuota(this)"><i class="fa fa-trash" aria-hidden="true"></i></button>';
	strCuota += '\n    </div>';
	strCuota += '\n</div>';

	$('#cuotasExtra').append(strCuota);
}

function borrarCuota(objeto) {
	$(objeto)
		.parent()
		.parent()
		.remove();

	var I = $('#cuotasExtra').children().length;
	if (I > 0) {
		strBoton = '\n        <button type="button" class="btn btn-sm btn-danger" id="btnBorrarCuota" onclick="borrarCuota(this)"><i class="fa fa-trash" aria-hidden="true"></i></button>';

		$($($('#cuotasExtra').children()[I - 1]).children()[1]).append(strBoton);
	}
}
