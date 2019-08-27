<?php
	require_once 'php/datos.php';

	header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
	header("Pragma: no-cache"); // HTTP 1.0.
	header("Expires: 0"); // Proxies.
?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once 'php/linksHeader.php'; ?>

	<script type="text/javascript">
		$(document).ready(function() {
			$("#usuario").focus();

			limpiarTemas();

			// TEMA
			$('input[name="theme"]').click(function() {
				limpiarTemas();

				if (this.value != '') {
					var styleSheets = $("link");
					var href = 'css/bootstrap-' + this.value + '.css';
					for (var i = 0; i < styleSheets.length; i++) {
						if (styleSheets[i].href != null) {
							if (styleSheets[i].href.indexOf(href) >= 0) {
								styleSheets[i].disabled = false;
								break;
							}
						}
					}
				}
			});

			<?php echo ($config->theme == 'dark'? '$("#themeDark").click();': '').$crlf?>

			// IDIOMA
			$('input[name="lang"]').click(function() {
				$.post("php/lang/changeLang.php", {lang: $('input[name="lang"]:checked').val()},
					function () {
						location.reload(true);
					}
				);
			});
		});

		function limpiarTemas() {
			var styleSheets = $("link");
			var href = 'css/bootstrap-dark.css';
			for (var i = 0; i < styleSheets.length; i++) {
				if (styleSheets[i].href != null) {
				    if (styleSheets[i].href.indexOf(href) >= 0) {
				        styleSheets[i].disabled = true;
				        break;
				    }
				}
			}
		}

		function cambiarTema() {
			var styleSheets = $("link");
			var href = 'css/bootstrap-dark.css';
			for (var i = 0; i < styleSheets.length; i++) {
				if (styleSheets[i].href != null) {
				    if (styleSheets[i].href.indexOf(href) >= 0) {
				        styleSheets[i].disabled = !$("#theme").prop("checked");
				        break;
				    }
				}
			}
		}

	</script>
</head>
<body>
	<?php require_once 'php/header.php'; ?>

	<div class="container-fluid">
		<div class="mt-5">
			<h2><?php echo login_title?></h2>
			<hr>
		</div>

		<form action="php/loginProcesar.php" method="post">
			<?php
				if (isset($_REQUEST["error"])) {
					$strSalida = '';
					$strSalida.= '<div class="alert alert-danger" role="alert">';
					$strSalida.= '<strong>Error!</strong> '. login_error;
					$strSalida.= '</div>';

					echo $strSalida;
				}

				if (isset($_REQUEST["timeout"])) {
					$strSalida = '';
					$strSalida.= '<div class="alert alert-warning" role="alert">';
					$strSalida.= login_sessionexpired;
					$strSalida.= '</div>';

					echo $strSalida;
				}

				if (isset($_REQUEST["returnUrl"])) {
					$returnUrl = $_REQUEST["returnUrl"];
				}
				else {
					$returnUrl = '';
				}
				echo '<input type="hidden" name="returnUrl" value="'.$returnUrl.'" />';
			?>

			<div class="card">
				<div class="card-header">
					<h3 class="card-title"><?php echo login_subtitle?></h3>
				</div>
				<div class="card-body">
					<div class="form-group row mt-4">
						<label for="usuario" class="col-form-label col-md-2 offset-md-2"><?php echo login_username?>:</label>
						<div class="col-md-4">
							<input type="text" class="form-control" id="usuario" name="usuario" placeholder="<?php echo login_username?>" autocomplete="username" required />
						</div>
					</div>
					<div class="form-group row">
						<label for="password" class="col-form-label col-md-2 offset-md-2"><?php echo login_password?>:</label>
						<div class="col-md-4">
							<input type="password" class="form-control" name="password" placeholder="<?php echo login_password?>" autocomplete="current-password" required />
						</div>
					</div>

					<!-- <label class="labelCheck col-md-4 offset-md-4">
						<input type="checkbox" name="theme" id="theme" onchange="cambiarTema()" /> Tema oscuro
					</label> -->


					<div class="form-group row">
						<label class="col-form-label col-md-2 pt-0 offset-md-2"><?php echo login_theme?>:</label>
						<div class="col-md-2">
							<div class="radio">
								<label>
									<input type="radio" name="theme" id="themeDefault" value="" checked>
									<?php echo login_theme_default?>
								</label>
							</div>
							<div class="radio">
								<label>
									<input type="radio" name="theme" id="themeDark" value="dark">
									<?php echo login_theme_dark?>
								</label>
							</div>
						</div>

						<?php if ($config->showLangs) {?>
						<label class="col-form-label col-md-1 pt-0"><?php echo login_language?>:</label>
						<div class="col-md-2">
							<div class="radio">
								<label>
									<input type="radio" name="lang" id="langEs" value="es" <?php echo ($lang == 'es'? 'checked': '')?>>
									<?php echo login_lang_es?>
								</label>
							</div>
							<div class="radio">
								<label>
									<input type="radio" name="lang" id="langEn" value="en" <?php echo ($lang == 'en'? 'checked': '')?>>
									<?php echo login_lang_en?>
								</label>
							</div>
						</div>
						<?php }?>

					</div>


					<div class="form-group">
						<div class="offset-md-4 col-md-4 text-right">
							<button type="submit" class="btn btn-primary"><i class="fa fa-sign-in-alt"></i> <?php echo login_button?></button>
						</div>
					</div>
				</div>
			</div>
		</form>

		<div class="row mt-4">
			<div class="col-md-12">
				<button class="btn btn-light border" onclick="location.href = '<?php echo $config->raiz?>';"><i class="fa fa-paper-plane"></i> <?php echo login_gotosite?></button>
			</div>
		</div>

	</div>

	<?php
		require_once 'php/footer.php';
	?>
</body>
</html>