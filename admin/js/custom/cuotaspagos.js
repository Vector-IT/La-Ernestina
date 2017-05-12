function abrirCheques() {
    $("[data-fancybox]").fancybox({
        iframe : {
            css : {
                width : '100%',
                height: '100%'
            },
        },
        afterClose: function () {
            cargarCheques();
        }
    });


    $("#modalCheques").click();
}

function cargarCheques() {
    $.ajax({
		url: 'php/tablaHandler.php',
		type: 'post',
		async: true,
		data: {	
			operacion: '100', 
			tabla: 'cuotas', 
			field: "Cheques", 
			dato: "" 
		}, 
		success: 
			function(data) {
				$("#CodiCheq").html(data['valor']);
			}
	});
}