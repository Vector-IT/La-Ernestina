<?php
	require_once '../datosdb.php';

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	$_SESSION[$nombSistema."_lang"] = $_POST["lang"];
?>