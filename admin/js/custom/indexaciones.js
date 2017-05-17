function cambiarEstado(strID) {
    $("#actualizando").show();

	$.ajax({
		type: 'POST',
		url: 'php/tablaHandler.php',
		data: { 
			operacion: '100', 
			tabla: 'indexaciones', 
			field: 'NumeEsta', 
			dato: {"NumeInde": strID, "PorcInde": $("#PorcInde"+strID).html()}
		},
		success: function(data) {
            if (data.valor === true) {
                $("#txtHint").html("Datos actualizados!");
                $("#divMsj").removeClass("alert-danger");
				$("#divMsj").addClass("alert-success");

                listarindexaciones();
            }
            else {
                $("#txtHint").html(data.valor);
                $("#divMsj").removeClass("alert-success");
				$("#divMsj").addClass("alert-danger");
            }
            $("#actualizando").hide();
			$("#divMsj").show();
		},
		async:true
	});
}