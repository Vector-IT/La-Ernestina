$(document).ready(function() {
	$('#modalCliente').on('shown.bs.modal', function() {
		$("#NumeClie").focus();
    });
});

function cheqList() {
    $("td[id^='NumeLote']").each(function (index, campo) {
        var numeLote = $(campo).html();

        if ($("#NumeClie"+numeLote).val() != "") {
            $("#btnAsigClie"+numeLote).hide();

            if ($("#CantCuot"+numeLote).html() == "" || $("#CantCuot"+numeLote).html() == "0") {
                $("#btnVerCuot"+numeLote).hide();
            }
        }
        else {
            $("#btnVerCuot"+numeLote).hide();
        }
    });
}

function verCuotas(NumeLote) {
    location.href = "objeto/cuotas&NumeLote="+NumeLote;
}

function asignarCliente(NumeLote) {
    $("#divMsjModal").hide();
    $("#hdnNumeLote").val(NumeLote);
    $("#txtNombLote").html($("#NombLote"+NumeLote).html());
    $("#ImpoAnti").prop("max", $("#ValoLote"+NumeLote).html());

	$("#modalCliente").modal();
}

function cerrarModal() {
    var numeLote = $("#hdnNumeLote").val();
	var numeClie = $("#NumeClie").val();
    var impoAnti = $("#ImpoAnti").val();
	var fechInic = $("#hdnFechInic").val();
    var cantCuot = $("#CantCuot").val();
	
    $("#modalCliente").modal('hide');

	$("#divMsj").hide();
	$("#actualizando").show();
    
	$.post("php/tablaHandler.php", {
            operacion: '100', 
            tabla: 'lotes', 
            field: 'Asignar Cliente', 
            dato: {"NumeLote": numeLote, "NumeClie": numeClie, "ImpoAnti": impoAnti, "FechInic": fechInic, "CantCuot": cantCuot}
		},
		function(data) {
            if (data.valor === true) {
                $("#txtHint").html("Datos actualizados!");
                $("#divMsj").removeClass("alert-danger");
				$("#divMsj").addClass("alert-success");

                listarlotes();
            }
            else {
                $("#txtHint").html(data.valor);
                $("#divMsj").removeClass("alert-success");
				$("#divMsj").addClass("alert-danger");
            }
            $("#actualizando").hide();
			$("#divMsj").show();
		}
	);

	
}