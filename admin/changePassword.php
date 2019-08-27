<?php
    namespace VectorForms;

    ini_set("log_errors", 1);
    ini_set("error_log", "php-error.log");

	session_start();

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
			$("#password_old").focus();
		});

		function cambiarPWD() {
			var pass, pass1, pass2;
			pass = $("#password_old").val().trim();
			pass1 = $("#password_new").val().trim();
			pass2 = $("#password_new2").val().trim();

			if (pass == pass1) {
				$("#divAlert").html('<strong>Error!</strong> <?php echo changepwd_cantbesame?>');
				$("#divAlert").show();
				return false;
			}

			if (pass1 != pass2) {
				$("#divAlert").html('<strong>Error!</strong> <?php echo changepwd_nomatch?>');
				$("#divAlert").show();
				return false;
			}

			if (pass1.length < 6) {
				$("#divAlert").html('<strong>Error!</strong> <?php echo changepwd_toosmall?>');
				$("#divAlert").show();
				return false;
			}

			return true;
		}
	</script>
</head>
<body>
	<?php
        if (isset($_SESSION['is_logged_in_'. $nombSistema])) {
            $config->crearMenu();
        }

		require_once 'php/header.php';
	?>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6 offset-md-3">
				<div class="mt-5">
					<h2><?php echo $_SESSION["NombPers"]?></h2>
					<hr>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 offset-md-3">
				<form id="frmCambiarPWD" method="post" onsubmit="return cambiarPWD();" action="php/loginProcesar.php">
				<?php
					if (isset($_REQUEST["error"])) {
						switch ($_REQUEST["error"]) {
							case '1':
								$strSalida = '';
								$strSalida.= '<div id="divAlert" class="alert alert-danger" role="alert">';
								$strSalida.= '<strong>Error!</strong> '. changepwd_nomatch;
								$strSalida.= '</div>';
								break;

							case '2':
								$strSalida = '';
								$strSalida.= '<div id="divAlert" class="alert alert-danger" role="alert">';
								$strSalida.= '<strong>Error!</strong> '. changepwd_wrongpass;
								$strSalida.= '</div>';
								break;

							case '3':
								$strSalida = '';
								$strSalida.= '<div id="divAlert" class="alert alert-danger" role="alert">';
								$strSalida.= '<strong>Error!</strong> '. changepwd_cantbesame;
								$strSalida.= '</div>';
								break;

							case '4':
								$strSalida = '';
								$strSalida.= '<div id="divAlert" class="alert alert-danger" role="alert">';
								$strSalida.= '<strong>Error!</strong> '. changepwd_toosmall;
								$strSalida.= '</div>';
								break;
						}

						echo $strSalida;
					}
					else {
						$strSalida = '';
						$strSalida.= '<div id="divAlert" class="alert alert-danger" role="alert" style="display: none;"></div>';
						echo $strSalida;
					}

					if (isset($_REQUEST["returnUrl"])) {
						$returnUrl = $_REQUEST["returnUrl"];
					}
					else {
						$returnUrl = '';
					}
					echo '<input type="hidden" name="returnUrl" value="'.$returnUrl.'" />';
					echo '<input type="hidden" name="usuario" value="'.$_SESSION["NombUser"].'" />';
				?>

					<div class="card">
						<div class="card-header">
							<h3 class="card-title"><?php echo changepwd_title?></h3>
						</div>
						<div class="card-body">
							<div class="form-group row mt-4">
								<label for="password_old" class="col-form-label col-md-4"><?php echo changepwd_current?>:</label>
								<div class="col-md-6">
									<input type="password" class="form-control" id="password_old" name="password" placeholder="<?php echo changepwd_current?>" autocomplete="current-password" required />
								</div>
							</div>
							<div class="form-group row">
								<label for="password_new" class="col-form-label col-md-4"><?php echo changepwd_new?>:</label>
								<div class="col-md-6">
									<input type="password" class="form-control" id="password_new" name="password_new" placeholder="<?php echo changepwd_new?>" autocomplete="new-password" required />
								</div>
							</div>
							<div class="form-group row">
								<label for="password_new2" class="col-form-label col-md-4"><?php echo changepwd_new2?>:</label>
								<div class="col-md-6">
									<input type="password" class="form-control" id="password_new2" name="password_new2" placeholder="<?php echo changepwd_new2?>" autocomplete="new-password" required />
								</div>
							</div>


							<div class="form-group row">
								<div class="offset-md-4 col-md-6 text-right">
									<button type="submit" class="btn btn-primary"><i class="fa fa-sign-in-alt"></i> <?php echo changepwd_button?></button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>

	<?php
		require_once 'php/footer.php';
	?>
</body>
</html>