var $;
$( document ).ready( function() {
	$('#frmReportes').submit( function() {
		aceptar();
	} );
} );

function buscarParametros() {
	if ( $('#NumeRepo').val() === '') {
		$('#divParametros').html('');
		$('#btnAceptar').hide();
	} else {
		actualizando();

		$.post('php/reportes.php',
			{
				'operacion': 1,
				'NumeRepo': $('#NumeRepo').val()
			},
			function(data) {
				data = JSON.parse(data);

				divActualizando.close();
				$('#btnAceptar').show();

				$('#divParametros').html(data.html);
			},
			'html'
		);
	}
}

function aceptar() {
	actualizando();

	var params = [];
	$('#divParametros .form-control').each(function() {
		params.push(this.value);
	} );

	$.ajax({
		type: 'get',
		url: 'php/reportes.php',
		data: {
			'operacion': 2,
			'NumeRepo': $('#NumeRepo').val(),
			'Params': params
		},
		success: function(response) {
			divActualizando.close();

			$('#divDatos').html(response.html);

			if (response.sql != undefined) {
				console.log(response.sql);
			}

			$('#frmReportes').fadeToggle();
			$('#btnVerFiltros').fadeToggle();
		},
		async: true
	});
}

function exportarExcel() {
	$('#tblReporte').table2excel({
		exclude: '.noXLS',
		name: $('#txtTitulo').text(),
		filename: $('#txtTitulo').text()
	});
}

function verFiltros() {
	$('#frmReportes').fadeToggle();
	$('#btnVerFiltros').fadeToggle();
}