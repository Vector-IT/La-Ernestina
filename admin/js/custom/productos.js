var $;

$(document).ready(function() {
	$('#modalCliente').on('shown.bs.modal', function() {
		$('#NumeClie').focus();
	});

	$('#frmAsignarCliente').submit(function() {
		cerrarModal()
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
	$('#vFila' + numeProd).addClass('table-success');

	swal({
		title: "Confirmar",
		type: "warning",
		html: "Seguro de borrar el cliente <span class='font-weight-bold'>" + $("#NombClie" + numeProd).text() + "</span> del plan <span class='font-weight-bold'>" + $("#NombProd" + numeProd).text() + "</span>?",
		showCancelButton: true,
		confirmButtonText: "SI",
		cancelButtonText: "NO",
	}).then((result) => {
		if (result.value) {
			actualizando();

			$.post(
				'php/tablaHandler.php',
				{
					operacion: '100',
					tabla: 'productos',
					field: 'Borrar Cliente',
					dato: { NumeProd: numeProd }
				},
				function(data) {
					divActualizando.close();

					if (data.valor === true) {
						notifySuccess();

						listarproductos();
					} else {
						notifyDanger({ message: data.valor });
					}
				}
			);
		}
	});
}

function cerrarModal() {
	var numeProd = $('#hdnNumeProd').val();
	var numeClie = $('#NumeClie').val();
	var impoAnti = $('#ImpoAnti').val();
	var interes = $('#Interes').val();
	var fechInic = $('#Fecha').val();
	var cantCuot = $('#CantCuot').val();
	var cantCuotExtr = $('#cuotasExtra').children().length;

	var montoCuot = [];
	var fechExtr = [];

	for (var I = 0; I < cantCuotExtr; I++) {
		montoCuot.push($("input[id^='CuotExtr']")[I].value);
		fechExtr.push($("input[id^='FechExtr']")[I].value);
	}

	$('#modalCliente').modal('hide');

	actualizando();

	$.post(
		'php/tablaHandler.php',
		{
			operacion: '100',
			tabla: 'productos',
			field: 'Asignar Cliente',
			dato: { NumeProd: numeProd, NumeClie: numeClie, ImpoAnti: impoAnti, Interes: interes, FechInic: fechInic, CantCuot: cantCuot, CuotExtr: montoCuot, FechExtr: fechExtr }
		},
		function(data) {
			divActualizando.close();

			if (data.valor === true) {
				notifySuccess();

				listarproductos(numeProd);
			} else {
				notifyDanger({ message: data.valor });
			}
		}
	);
}

function agregarCuota() {
	var I = $('#cuotasExtra').children().length + 1;

	$('#btnBorrarCuota').remove();

	var strCuota = '';

	strCuota += '\n<div id="Cuota' + I + '" class="clearer">';
	strCuota += '\n	<div class="form-group form-group2 row">';
	strCuota += '\n	    <label for="CuotExtr" class="control-label col-md-2">Cuota extraordinaria ' + I + ':</label>';
	strCuota += '\n	    <div class="col-md-8">';
	strCuota += '\n	        <input type="number" min="0" class="form-control ucase" id="CuotExtr' + I + '" required>';
	// strCuota += '\n        <button type="button" class="btn btn-sm btn-danger" id="btnBorrarCuota" onclick="borrarCuota(this)"><i class="fa fa-trash" aria-hidden="true"></i></button>';
	strCuota += '\n	    </div>';
	strCuota += '\n	</div>';
	strCuota += '\n	<div class="form-group form-group2 row">';
	strCuota += '\n	    <label for="FechExtr' + I + '" class="control-label col-md-2">Fecha venc ' + I + ':</label>';
	strCuota += '\n	    <div class="col-md-8">';
	strCuota += '\n	        <input type="text" class="form-control ucase" id="FechExtr' + I + '" required autocomplete="off">';
	strCuota += '\n	        <button type="button" class="btn btn-sm btn-danger" id="btnBorrarCuota" onclick="borrarCuota(' + I + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
	strCuota += '\n	    </div>';
	strCuota += '\n	</div>';
	strCuota += '\n</div>';

	$('#cuotasExtra').append(strCuota);

	$('#FechExtr' + I).datetimepicker({
		timepicker: false,
		format: 'Y-MM-DD',
		onShow: function(ct, $i) {
			var h = 0 - ($(".xdsoft_datetimepicker:visible .xdsoft_time_variant").height() / $(".xdsoft_datetimepicker:visible .xdsoft_time").length * $(".xdsoft_datetimepicker:visible .xdsoft_time.xdsoft_current").index());
			$(".xdsoft_datetimepicker:visible .xdsoft_time_variant").css("margin-top", h + "px");
		},
		step: 15
	});

	$('#CuotExtr' + I).focus();
}

function borrarCuota(I) {
	$('#Cuota' + I).remove();

	var I = $('#cuotasExtra').children().length;
	if (I > 0) {
		strBoton = '\n        <button type="button" class="btn btn-sm btn-danger" id="btnBorrarCuota" onclick="borrarCuota(' + I + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>';

		$($($($('#cuotasExtra').children()[I - 1]).children()[1]).children()[1]).append(strBoton);
	}
}
