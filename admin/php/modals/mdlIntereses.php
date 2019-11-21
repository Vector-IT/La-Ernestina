<div id="modalIntereses" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="frmIntereses" class="form-horizontal" method="post" onsubmit="return false;">
				<div class="modal-header">
					<h4 class="modal-title">Colocar Fecha de cálculo de Intereses</span></h4>
				</div>

				<div class="modal-body">
					<div class="form-group row ">
						<label for="Fecha" class="control-label col-md-2">Fecha:</label>
						<div class="col-md-8">
							<div class="input-group date margin-bottom-sm inpFecha">
								<input type="text" class="form-control" id="Fecha" size="16" value="" required autocomplete="off">
								<div class="input-group-append">
									<span class="input-group-text" onclick="$('#Fecha').focus();"><i class="fa fa-calendar fa-fw"></i></span>
								</div>
							</div>
							<script type="text/javascript">
								$("#Fecha").datetimepicker({
									timepicker:false,
									format: "<?php echo $formatDateJS?>",
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
				</div>
				<div class="modal-footer">
					<button type="submit" id="btnAceptar" class="btn btn-primary">Aceptar</button>
					<button type="button" id="btnCancelar" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				</div>
			</form>
		</div>
	</div>
</div>