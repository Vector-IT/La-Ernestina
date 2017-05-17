<?php
    namespace VectorForms;

    ini_set("log_errors", 1);
    ini_set("error_log", "php-error.log");

    session_start();
    require_once 'php/datos.php';

    $urlLogin = "Location:". "http://". $_SERVER['SERVER_NAME'] . ($_SERVER['SERVER_PORT'] != "80"? ":".$_SERVER['SERVER_PORT']: "") . $config->raiz ."admin/login.php?returnUrl=" . $_SERVER['REQUEST_URI'];
    $urlIndex = "Location:". "http://". $_SERVER['SERVER_NAME'] . ($_SERVER['SERVER_PORT'] != "80"? ":".$_SERVER['SERVER_PORT']: "") . $config->raiz ."admin/";
    
    if (!isset($_SESSION['is_logged_in'])) {
        header($urlLogin);
        die();
    }
    
    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
    header("Pragma: no-cache"); // HTTP 1.0.
    header("Expires: 0"); // Proxies.
?>
<!DOCTYPE html>
<html>
<head>
    <?php
        require_once 'php/linksHeader.php';
    ?>
    <script src="js/custom/reportes.js"></script>
</head>
<body>
    <?php
        $config->crearMenu();
        
        require_once 'php/header.php';
    ?>
    
    <div class="container-fluid">
        <div class="page-header">
            <h2>Reportes</h2>
        </div>
        
        <div id="actualizando" class="alert alert-info" role="alert">
            <i class="fa fa-refresh fa-fw fa-spin"></i> Actualizando datos, por favor espere...
        </div>
        
        <div id="divMsj" class="alert alert-danger" role="alert">
            <span id="txtHint">Info</span>
        </div>

        <div id="divDatos" class="marginTop40">
        </div>
    </div>
    
    <?php
        require_once 'php/footer.php';
    ?>  
</body>
</html>
