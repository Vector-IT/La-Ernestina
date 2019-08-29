<meta charset="UTF-8">
	<meta name="author" content="Vector-IT - www.vector-it.com.ar" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

	<link rel="shortcut icon" href="<?php echo $config->raiz ?>admin/img/favicon.png" type="image/png" />
	<link rel="apple-touch-icon" href="<?php echo $config->raiz ?>admin/img/favicon.png"/>

	<title><?php echo $config->titulo ?></title>

	<!-- JQUERY -->
	<script src="<?php echo $config->raiz ?>admin/js/jquery-3.3.1.min.js"></script>

<?php if (isset($_SESSION['is_logged_in_'. $nombSistema])) { ?>
	<script src="<?php echo $config->raiz ?>admin/js/vectorMenu.js?1"></script>
<?php }?>

	<!-- BOOTSTRAP -->
	<link rel="stylesheet" href="<?php echo $config->raiz ?>admin/css/bootstrap.css?1">
	<script src="<?php echo $config->raiz ?>admin/js/popper.js?1"></script>
	<script src="<?php echo $config->raiz ?>admin/js/bootstrap.min.js?1"></script>

	<?php
		if (isset($_SESSION['Theme'])) {
			echo $crlf.'<link rel="stylesheet" href="'.$config->raiz.'admin/css/bootstrap-'. $_SESSION["Theme"] .'.css?1">';
		}
		if (!isset($_SESSION['is_logged_in_'. $nombSistema]) && basename($_SERVER['PHP_SELF']) == "login.php") {
			echo $crlf.'<link rel="stylesheet" href="'.$config->raiz.'admin/css/bootstrap-dark.css?1">';
		}
	?>

	<!-- FONT AWESOME -->
	<script defer src="<?php echo $config->raiz ?>admin/js/fontawesome-all.min.js?1"></script>

	<!-- Animate.CSS -->
	<link rel="stylesheet" href="<?php echo $config->raiz ?>admin/css/animate.css">

	<!-- DATETIME PICKER -->
	<!-- <link rel="stylesheet" type="text/css" href="<?php echo $config->raiz ?>admin/css/bootstrap-datetimepicker.css">
	<script src="<?php echo $config->raiz ?>admin/js/bootstrap-datetimepicker/bootstrap-datetimepicker.js"></script>
	<script src="<?php echo $config->raiz ?>admin/js/bootstrap-datetimepicker/locales/bootstrap-datetimepicker.es.js"></script> -->

	<link rel="stylesheet" type="text/css" href="<?php echo $config->raiz ?>admin/js/datetimepicker/jquery.datetimepicker.min.css">
	<script src="<?php echo $config->raiz ?>admin/js/datetimepicker/jquery.datetimepicker.full.min.js"></script>

	<!-- TEXTAREA AUTOGROW -->
	<script src="<?php echo $config->raiz ?>admin/js/jquery.ns-autogrow.min.js"></script>

	<!-- BOOTSTRAP-SELECT -->
	<link rel="stylesheet" type="text/css" href="<?php echo $config->raiz ?>admin/css/bootstrap-select.min.css">
	<script src="<?php echo $config->raiz ?>admin/js/bootstrap-select/bootstrap-select.min.js"></script>
	<script src="<?php echo $config->raiz ?>admin/js/bootstrap-select/i18n/defaults-es_CL.min.js"></script>

	<!-- CKEditor -->
	<script src="<?php echo $config->raiz ?>admin/ckeditor/ckeditor.js"></script>

	<!-- Moments.js -->
	<script src="<?php echo $config->raiz ?>admin/js/moment-with-locales.min.js"></script>

	<!-- Sweet Alet 2 -->
	<script src="<?php echo $config->raiz ?>admin/js/sweetalert2.all.min.js"></script>

	<!-- Bootstrap Notify -->
	<script src="<?php echo $config->raiz ?>admin/js/bootstrap-notify.js"></script>

	<!-- Back to top -->
	<script src="<?php echo $config->raiz ?>admin/js/back-to-top.js"></script>

	<?php
		if  (isset($tabla) && $tabla->orderColumns) {
			echo '	<script src="'. $config->raiz .'admin/js/tinysort.js"></script>';
		}
	?>

	<?php
		if  (isset($tabla) && $tabla->exportToXLS) {
			echo '	<script src="'. $config->raiz .'admin/js/jquery.table2excel.js"></script>';
		}
	?>

	<link rel="stylesheet" type="text/css" href="<?php echo $config->raiz ?>admin/css/estilos.css">

	<?php
		echo '<base href="'. $config->raiz .'admin/" />';

		foreach ($config->cssFiles as $css) {
			echo $crlf.'	<link rel="stylesheet" type="text/css" href="'.$config->raiz.$css.'">';
		}

		foreach ($config->jsFiles as $js) {
			echo $crlf.'	<script src="'.$config->raiz.$js.'"></script>';
		}
	?>

	<script>
		var vRaiz = '<?php echo $raiz?>';
		var txtActualizando = '<?php echo gral_updating?>';

		$.datetimepicker.setLocale('<?php echo $lang?>');
		$.datetimepicker.setDateFormatter('moment');

		$(function () {
			habilitarTooltips();
		});

		//Habilitar tooltips y popovers
		function habilitarTooltips() {
			$('[data-toggle="tooltip"]').tooltip({
				trigger: 'hover'
			});

			$('[data-toggle="popover"]').popover({
				container: 'body'
			});
		}

		$.notifyDefaults({
			mouse_over: 'pause',
			delay: 1000,
			z_index: 2000,
			allow_dismiss: false,
			// placement: {
			// 	from: 'bottom',
			// 	align: 'right'
			// },
			// animate: {
			// 	enter: 'animated fadeInUp',
			// 	exit: 'animated fadeOutDown'
			// }
		});
	</script>