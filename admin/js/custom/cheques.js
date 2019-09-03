var $;

$(document).ready(function() {
	var strAux = '<hr class="clearer">';
	strAux += '<h4>Recibido de</h4>';

	$(strAux).insertBefore(
		$('#NombReci')
			.parent()
			.parent()
	);

	var strAux = '<hr class="clearer">';
	strAux += '<h4>Entregado a</h4>';
	$(strAux).insertBefore(
		$('#NombEntr')
			.parent()
			.parent()
	);
});

function cambiarEstado(strID) {
	actualizando();

	$.ajax({
		type: 'POST',
		url: 'php/tablaHandler.php',
		data: {
			operacion: '100',
			tabla: 'cheques',
			field: 'NumeEsta',
			dato: { CodiCheq: strID }
		},
		success: function(data) {
			if (data.valor === true) {
				notifySuccess();

				listarcheques();
			} else {
				notifyDanger({ Title: data.valor });
			}
		},
		async: true
	});
}

function verEstado() {
	$('#divDatos')
		.find('tr')
		.each(function(I) {
			if (I > 0) {
				var strID = $(this)
					.find("input[id^='CodiCheq']")
					.val();

				if ($('#NumeEsta' + strID).val() != '1') {
					$(this).addClass('txtTachado');
				}
			}
		});
}

function onNew() {
	$('#NumeCheq').prop('readonly', false);
}

function onEdit() {
	$('#NumeCheq').prop('readonly', true);
}
