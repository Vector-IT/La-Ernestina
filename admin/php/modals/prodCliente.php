<div id="modalCliente" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<form id="frmAsignarCliente" class="form-horizontal" method="post" onsubmit="return false;">
				<div class="modal-header">
					<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
					<h4 class="modal-title">Asignar cliente al producto <span id="txtNombProd"></span></h4>
				</div>

				<div class="modal-body">
                    <input type="hidden" id="hdnNumeProd">

					<div class="form-group row">
						<label for="NumeClie" class="control-label col-md-2">Cliente:</label>
						<div class="col-md-8">
							<select class="form-control ucase" id="NumeClie">
								<?php echo $config->cargarCombo('clientes', 'NumeClie', 'NombClie', 'NumeEsta = 1', 'NombClie')?>
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label for="ImpoAnti" class="control-label col-md-2">Anticipo:</label>
						<div class="col-md-8">
							<input type="number" min="0" class="form-control" id="ImpoAnti" required value="0">
						</div>
					</div>

					<div class="form-group row">
						<label for="Interes" class="control-label col-md-2">Interés diario:</label>
						<div class="col-md-8">
							<input type="number" min="0" class="form-control" id="Interes" required value="0">
						</div>
					</div>

					<div class="form-group row ">
						<label for="Fecha" class="control-label col-md-2">Fecha de Compra:</label>
						<div class="col-md-8">
							<div class="input-group date margin-bottom-sm inpFecha">
								<input type="text" class="form-control" id="Fecha" size="16" value="" required autocomplete="off">
								<div class="input-group-append">
									<span class="input-group-text" onclick="$('#Fecha').focus();"><i class="fa fa-calendar fa-fw"></i></span>
								</div>
							</div>
							<script type="text/javascript">
								$("#Fecha").datetimepicker({
									timepicker:true,
									format: "<?php echo $formatDateJS?> HH:mm",
									onShow: function(ct, $i) {
										var h = 0 - ($(".xdsoft_datetimepicker:visible .xdsoft_time_variant").height() / $(".xdsoft_datetimepicker:visible .xdsoft_time").length * $(".xdsoft_datetimepicker:visible .xdsoft_time.xdsoft_current").index());
										$(".xdsoft_datetimepicker:visible .xdsoft_time_variant").css("margin-top", h + "px");
									},
									step: 15,
									<?php if (isset($_SESSION['Theme'])) {?>
									theme: "dark",
									<?php }?>
								});
							</script>
						</div>
					</div>

					<div class="form-group row">
						<label for="CantCuot" class="control-label col-md-2">Cantidad de cuotas:</label>
						<div class="col-md-8">
							<input type="number" min="0" class="form-control ucase" id="CantCuot" required>
						</div>
					</div>

					<div id="cuotasExtra"></div>
					<div class="form-group row text-center">
						<button type="button" class="btn btn-primary" onclick="agregarCuota()"><i class="fa fa-plus-circle" aria-hidden="true"></i> Cuota extraordinaria</button>
					</div>

				</div>
				<div class="modal-footer">
					<div id="divMsjModal" class="alert alert-danger text-left" role="alert">
						<span id="txtHintModal">Info</span>
					</div>
					<button type="submit" id="btnAceptar" class="btn btn-primary">Aceptar</button>
					<button type="button" id="btnCancelar" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				</div>
			</form>
		</div>
	</div>
</div>