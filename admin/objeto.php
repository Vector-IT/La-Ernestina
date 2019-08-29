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

	if ($_SESSION['is_logged_in_'. $nombSistema] !== 1) {
	    header($urlLogin);
	    die();
	}

	if (isset($_REQUEST["tb"])) {
	    if ($_REQUEST["tb"] != "") {
	        if (isset($config->tablas[$_REQUEST["tb"]])) {
	            $tabla = $config->tablas[$_REQUEST["tb"]];

	            if ($tabla->numeCarg !== '') {
	                if (intval($tabla->numeCarg) < $numeCarg) {
	                    header($urlIndex);
	                    die();
	                }
	            }

	            (isset($_REQUEST["id"]))? $item = $_REQUEST["id"]: $item = "";
	            (isset($_REQUEST["idFila"]))? $itemFila = $_REQUEST["idFila"]: $itemFila = "";
	        } else {
	            header($urlIndex);
	            die();
	        }
	    } else {
	        header($urlIndex);
	        die();
	    }
	} else {
	    header($urlIndex);
	    die();
	}

    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
    header("Pragma: no-cache"); // HTTP 1.0.
    header("Expires: 0"); // Proxies.
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $config->titulo .' - '. $tabla->titulo ?></title>
    <?php
        require_once 'php/linksHeader.php';

        $tabla->script();
    ?>
</head>
<body>
    <?php
        if (!isset($_REQUEST["menu"]) || $_REQUEST["menu"] == 1) {
            $config->crearMenu();
        }

        require_once 'php/header.php';

        for ($I = 0; $I < count($tabla->headerFiles); $I++) {
            require_once $tabla->headerFiles[$I];
        }

    ?>

    <div class="container-fluid">
        <div class="mt-5">
            <h2>
            <?php
            $icono = "";
            if ($tabla->icono != '') {
                $icono = '<i class="fa fa-fw '.$tabla->icono.'" aria-hidden="true"></i> ';
            }

            if ($tabla->masterTable == '') {
                echo $icono.'<span id="txtTituloObjeto">'.$tabla->titulo.'</span>';
            } else {
                if (isset($_REQUEST[$tabla->masterFieldId]) && $tabla->masterFieldName != '') {
					$strAux = $config->buscarDato("SELECT {$tabla->masterFieldName} FROM {$tabla->masterTable} WHERE {$tabla->masterFieldIdMaster} = '{$_REQUEST[$tabla->masterFieldId]}'");
					if ($strAux != gral_queryerror) {
						echo $icono.'<span id="txtTituloObjeto">'.$tabla->titulo.' '.gral_of.' '.$strAux.'</span>';
					}
					else {
						echo $icono.'<span id="txtTituloObjeto">'.$tabla->titulo.'</span>';
					}
                } else {
                    echo $icono.'<span id="txtTituloObjeto">'.$tabla->titulo.'</span>';
                }
            }
            ?>
			</h2>
			<hr>
        </div>

        <?php
        if (((($tabla->masterTable != '') && isset($_REQUEST[$tabla->masterFieldId])) || (isset($_REQUEST["id"]))) && (!isset($_REQUEST["back"]) || $_REQUEST["back"] == 1)) {
            echo '<button class="btn btn-sm btn-info" onclick="((document.referrer.indexOf(\'/login.php\') == -1)? history.go(-1): history.go(-3));"><i class="fa fa-chevron-circle-left fa-fw" aria-hidden="true"></i> '. gral_back .'</button>';
        }

		$tabla->createForm();
        ?>

		<?php
			if (!isset($_REQUEST["buscar"]) || $_REQUEST["buscar"] == 1) {
				$tabla->searchForm();
			}

			echo $crlf.'		<input id="tbl'. $tabla->name .'-orden" type="text" value="" class="d-none" />';
			echo $crlf.'		<input id="tbl'. $tabla->name .'-ordenTipo" type="text" value="" class="d-none" />';
		?>

        <div id="divDatos" class="marginTop40">
        </div>
    </div>

    <?php
		for ($I = 0; $I < count($tabla->includeList); $I++) {
			require_once $tabla->includeList[$I];
		}

		require_once 'php/footer.php';
    ?>
</body>
</html>
