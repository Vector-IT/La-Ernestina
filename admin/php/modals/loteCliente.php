<div id="modalCliente" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<form class="form-horizontal" method="post" onsubmit="cerrarModal();">
				<div class="modal-header">
					<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
					<h4 class="modal-title">Asignar cliente al lote <span id="txtNombLote"></span></h4>
				</div>

				<div class="modal-body">
                    <input type="hidden" id="hdnNumeLote">

					<div class="form-group form-group-sm">
						<label for="NumeClie" class="control-label col-md-2">Cliente:</label>
						<div class="col-md-8">
							<select class="form-control ucase" id="NumeClie">
								<?php echo $config->cargarCombo('clientes', 'NumeClie', 'NombClie', 'NumeEsta = 1', 'NombClie')?>
							</select>
						</div>
					</div>

					<div class="form-group form-group-sm">
						<label for="ImpoAnti" class="control-label col-md-2">Anticipo:</label>
						<div class="col-md-8">
							<input type="number" min="0" class="form-control" id="ImpoAnti" required value="0">
						</div>
					</div>

					<div class="form-group form-group-sm ">
						<label for="Fecha" class="control-label col-md-2">Fecha de Compra:</label>
						<div class="col-md-8">
							<div class="input-group date margin-bottom-sm inpFecha">
								<input type="text" class="form-control" id="Fecha" size="16" value="" readonly required>
								<span class="input-group-addon add-on clickable" title="Abrir Calendario"><i class="fa fa-calendar fa-fw"></i></span>
							</div>
							<input type="hidden" id="hdnFechInic">
							<script type="text/javascript">
								$(".inpFecha").datetimepicker({
									language: "es",
									format: "dd/mm/yyyy",
									minView: 2,
									autoclose: true,
									todayBtn: true,
									todayHighlight: false,
									minuteStep: 15,
									pickerPosition: "bottom-left",
									linkField: "hdnFechInic",
									linkFormat: "yyyy-mm-dd",
									fontAwesome: true
								});
							</script>
						</div>
					</div>

					<div class="form-group form-group-sm">
						<label for="CantCuot" class="control-label col-md-2">Cantidad de cuotas:</label>
						<div class="col-md-8">
							<input type="number" min="0" class="form-control ucase" id="CantCuot" required>
						</div>
					</div>

					<div id="cuotasExtra"></div>
					<div class="form-group form-group-sm text-center">
						<button class="btn btn-primary" onclick="agregarCuota()"><i class="fa fa-plus-circle" aria-hidden="true"></i> Cuota extraordinaria</button>
					</div>

				</div>
				<div class="modal-footer">
					<div id="divMsjModal" class="alert alert-danger text-left" role="alert">
						<span id="txtHintModal">Info</span>
					</div>
					<button type="submit" id="btnAceptar" class="btn btn-primary">Aceptar</button>
					<button type="button" id="btnCancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				</div>
			</form>
		</div>
	</div>
</div>