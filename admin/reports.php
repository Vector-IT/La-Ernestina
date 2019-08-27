<?php
    namespace VectorForms;

    ini_set("log_errors", 1);
    ini_set("error_log", "php-error.log");

    session_start();
    require_once 'php/datos.php';

    $urlLogin = "Location:". $url ."admin/login.php?timeout&returnUrl=" . urlencode($_SERVER['REQUEST_URI']);
    $urlIndex = "Location:". $url ."admin/";

    if (!isset($_SESSION['is_logged_in_'. $nombSistema])) {
        header($urlLogin);
        die();
    }

	if ($config->numeCargReportes !== '') {
		if (intval($config->numeCargReportes) < $numeCarg) {
			header($urlIndex);
			die();
		}
	}

    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
    header("Pragma: no-cache"); // HTTP 1.0.
    header("Expires: 0"); // Proxies.
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $config->titulo .' - '. reports_title ?></title>
    <?php
        require_once 'php/linksHeader.php';
    ?>
    <script src="js/reportes.js?<?php echo rand(1, 999)?>"></script>
	<script src="js/jquery.table2excel.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
	<script>
		Chart.defaults.global.plugins.datalabels.anchor = 'end';
		Chart.defaults.global.plugins.datalabels.align = 'end';
	</script>
</head>
<body>
    <?php
        $config->crearMenu();

        require_once 'php/header.php';
    ?>

    <div class="container-fluid">
        <div class="mt-5">
			<h2><i class="fab fa-fw fa-slideshare" aria-hidden="true"></i> <?php echo reports_title?> <button id="btnVerFiltros" class="btn btn-sm btn-primary" style="display: none;" onclick="verFiltros()"><i class="fas fa-filter"></i> <?php echo reports_showfilters?></button></h2>
        </div>

        <form id="frmReportes" class="form-horizontal mt-4 noPrn" method="post" onsubmit="return false;">
            <div class="form-group row">
                <label for="NumeRepo" class="col-form-label col-form-label-sm col-md-2"><?php echo reports_report?>:</label>
                <div class="col-md-4">
                    <select id="NumeRepo" class="form-control form-control-sm ucase" onchange="buscarParametros();">
					<?php echo $config->cargarCombo("reportes", "NumeRepo", "NombRepo", "NumeEsta = 1 AND (NumeCarg IS NULL OR NumeCarg >= {$numeCarg})", "NombRepo", '', true);?>
                    </select>
                </div>
            </div>
            <div id="divParametros"></div>
            <div class="form-group">
                <div class="offset-md-2 col-md-4 text-right">
                    <button id="btnAceptar" type="submit" class="btn btn-sm btn-primary" style="display: none;"><i class="fa fa-check fa-fw" aria-hidden="true"></i> <?php echo reports_button?></button>
                </div>
            </div>
        </form>

        <div id="divDatos" class="marginTop40">
        </div>
    </div>

    <?php
        require_once 'php/footer.php';
    ?>
</body>
</html>
