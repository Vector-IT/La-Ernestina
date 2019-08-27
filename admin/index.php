<?php
    session_start();

    ini_set("log_errors", 1);
    ini_set("error_log", "php-error.log");

    require_once 'php/datos.php';

    if (!isset($_SESSION['is_logged_in_'. $nombSistema])) {
        header("Location:". $url ."admin/login.php");
        die();
    }

    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
    header("Pragma: no-cache"); // HTTP 1.0.
    header("Expires: 0"); // Proxies.
?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once 'php/linksHeader.php';?>
</head>
<body>
	<?php
        $config->crearMenu();

        require_once 'php/header.php';
    ?>

	<div class="container-fluid">
		<div class="mt-5">
			<h2><?php echo index_title?></h2>
		</div>

		<p class="lead">
			<?php echo str_replace('#titulo#', $config->titulo, index_text)?>
		</p>
	</div>

	<?php
        require_once 'php/footer.php';
    ?>
</body>
</html>