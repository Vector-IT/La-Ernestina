var $;

function cambiarEstado(strID) {
	actualizando();

	$.ajax({
		type: 'POST',
		url: 'php/tablaHandler.php',
		data: {
			operacion: '100',
			tabla: 'caja',
			field: 'NumeEsta',
			dato: { NumeCaja: strID, NumeEsta: $('#NumeEsta' + strID).val() }
		},
		success: function(data) {
			divActualizando.close();

			if (data.valor === true) {
				notifySuccess();

				listarcaja();
			} else {
				notifyDanger({ message: data.valor });
			}
		},
		async: true
	});
}

function iniciar() {
	//$("#search-FechCaja").parent().parent().parent().hide();
}

function verTodos() {
	$('#search-FechCaja').val('TODOS');
	listarcaja();
}
