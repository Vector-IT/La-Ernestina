var $;

function cambiarEstado(strID) {
	actualizando();

	$.ajax({
		type: 'POST',
		url: 'php/tablaHandler.php',
		data: {
			operacion: '100',
			tabla: 'indexaciones',
			field: 'NumeEsta',
			dato: { NumeInde: strID, PorcInde: $('#PorcInde' + strID).html() }
		},
		success: function(data) {
			divActualizando.close();

			if (data.valor === true) {
				notifySuccess();

				listarindexaciones();
			} else {
				notifyDanger({ message: data.valor });
			}
			divActualizando.close();
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
					.find("input[id^='NumeInde']")
					.val();

				if ($('#NumeEsta' + strID).val() != '1') {
					$(this).addClass('txtTachado');
				}
			}
		});
}
