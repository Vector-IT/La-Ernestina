<?php
	$crlf = "\n";

	$tiempoSesion = 30;
	$diasPassword = 90;

	$nombSistema = "CRM";

	$formatDateDB = '%Y-%m-%d';
	$formatDateJS = 'Y-MM-DD';

	if (isset($_SERVER['SERVER_PORT'])) {
		switch ($_SERVER['SERVER_PORT']) {
			case '80':
				$url = 'http://' . $_SERVER['SERVER_NAME'] . $raiz;
				break;

			case '443':
				$url = 'https://' . $_SERVER['SERVER_NAME'] . $raiz;
				break;

			default:
				$url = 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $raiz;
				break;
		}
	}

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	if (isset($_SESSION[$nombSistema . '_lang'])) {
		$lang = isset($_SESSION[$nombSistema . '_lang']) ? $_SESSION[$nombSistema . '_lang'] : '';
	} else {
		// Idioma por defecto si no se seleccionó nada
		$lang = 'es';
	}

	require_once 'lang/' . $lang . '.php';
?>