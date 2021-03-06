var $;

function verCliente(numeProd) {
	numeClie = $('#NumeClie' + numeProd).val();

	$.fancybox.open({
		src: 'ver/clientes.php?id=' + numeClie + '&menu=0&header=0&back=0',
		type: 'iframe',
		toolbar: false,
		smallBtn: true,
		lang: 'es',
		i18n: {
			es: {
				CLOSE: 'Cerrar'
			}
		},
		iframe: {
			css: {
				width: '95%',
				height: '100%',
				margin: '0'
			}
		}
	});
}

function verEstados(numeProd) {
	$.fancybox.open({
		src: 'objeto/clientesestados.php?NumeClie=' + numeProd + '&menu=0&header=0&back=0',
		type: 'iframe',
		toolbar: false,
		smallBtn: true,
		lang: 'es',
		i18n: {
			es: {
				CLOSE: 'Cerrar'
			}
		},
		iframe: {
			css: {
				width: '95%',
				height: '100%',
				margin: '0'
			}
		}
	});
}

function verSeguimientos(numeClie) {
	$.fancybox.open({
		src: 'objeto/seguimientos.php?NumeClie=' + numeClie + '&menu=0&header=0&back=0',
		type: 'iframe',
		toolbar: false,
		smallBtn: true,
		lang: 'es',
		i18n: {
			es: {
				CLOSE: 'Cerrar'
			}
		},
		iframe: {
			css: {
				width: '95%',
				height: '100%',
				margin: '0'
			}
		}
	});
}

function verSeguimiento(numeSegu, numeClie) {
	$.fancybox.open({
		src: 'objeto/seguimientos.php?NumeClie=' + numeClie + '&id=' + numeSegu + '&menu=0&header=0&back=0',
		type: 'iframe',
		toolbar: false,
		smallBtn: true,
		lang: 'es',
		i18n: {
			es: {
				CLOSE: 'Cerrar'
			}
		},
		iframe: {
			css: {
				width: '95%',
				height: '100%',
				margin: '0'
			}
		}
	});
}


function abrirCheques() {
	$.fancybox.open({
		src: 'objeto/cheques.php?menu=0&header=0',
		type: 'iframe',
		toolbar: false,
		smallBtn: true,
		lang: 'es',
		i18n: {
			es: {
				CLOSE: 'Cerrar'
			}
		},
		iframe: {
			css: {
				width: '95%',
				height: '100%',
				margin: '0'
			}
		},
		afterClose: function() {
			cargarCheques();
		}
	});
}

function enviarWhatsapp(strID) {
	var numeTele = $('#NumeTele' + strID).val();

	if (numeTele == '') {
		numeTele = $('#NumeTele' + strID).text().trim();
	}

	window.open('https://wa.me/' + numeTele);
}

function enviarWhatsappCliente() {
	var numeTele = $('#NumeTele').val();

	window.open('https://wa.me/' + numeTele);
}

function enviarWhatsappOtro() {
	var numeTele = $('[id^="NumeTele"]').val();

	window.open('https://wa.me/' + numeTele);
}
