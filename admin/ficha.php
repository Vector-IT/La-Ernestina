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

	            if (isset($_REQUEST["id"])) {
					$item = $_REQUEST["id"];
				}
				else {
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
	} else {
	    header($urlIndex);
	    die();
	}

	$ficha = $tabla->crearFicha($item);

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

		$tabla->scriptFicha();
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
                echo $icono.$tabla->titulo;
            } else {
                if (isset($_REQUEST[$tabla->masterFieldId])) {
                    $strAux = $config->buscarDato("SELECT {$tabla->masterFieldName} FROM {$tabla->masterTable} WHERE {$tabla->masterFieldId} = '{$_REQUEST[$tabla->masterFieldId]}'");
                    echo $icono.$tabla->titulo. ' de ' .$strAux;
                } else {
                    echo $icono.$tabla->titulo;
                }
            }
            ?>
			</h2>
			<hr>
        </div>

		<?php
			$strSalida = '';
			$strSalida.= $crlf.'<button id="btnVolver" type="button" title="Volver" class="btn btn-sm btn-info" onclick="history.go(-1)"><i class="fa fa-chevron-circle-left fa-fw"></i> '.gral_back.'</button>';

            if (!isset($_REQUEST["imprimir"]) || $_REQUEST["imprimir"] == 1) {
                $strSalida.= $crlf.'<button id="btnImprimir" type="button" title="Imprimir" class="btn btn-sm btn-primary" onclick="window.print()"><i class="fa fa-print fa-fw"></i> '.gral_print.'</button>';
            }

			//Botones opcionales
			foreach ($tabla->btnFicha as $btn) {
				if (($btn->numeCarg === '' || $btn->numeCarg >= $numeCarg) && eval($btn->cond)) {
					$strSalida.= $crlf.'<'.$btn->type.' role="button" id="'.$btn->id.'" title="'.$btn->titulo.'" class="btn btn-sm '. $btn->class .'" ';
					if ($btn->onclick != '') {
						$strSalida.= 'onclick="'. $btn->onclick .'" ';
					}

					if ($btn->href != '') {
						$strSalida.= 'href="'. $btn->href .'" ';
					}

					if ($btn->attribs != '') {
						$strSalida.= ' '.$btn->attribs;
					}

					$strSalida.= '>'. $btn->texto .'</'.$btn->type.'>';
				}
			}
			echo $strSalida;
		?>

		<?php echo $ficha["html"]; ?>

    </div>

    <?php
		for ($I = 0; $I < count($tabla->includeList); $I++) {
			require_once $tabla->includeList[$I];
		}

		require_once 'php/footer.php';
    ?>
</body>
</html>
