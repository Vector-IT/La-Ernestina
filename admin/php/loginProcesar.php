<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	require_once 'datos.php';

	if (!isset($_POST["password_new"])) {
		//Login normal
		$user = strtoupper(str_replace("'", "", $_POST["usuario"]));
		$pass = md5(str_replace("'", "", $_POST["password"]));

		$tabla = $config->cargarTabla("SELECT NumeUser, NombPers, FechPass, FlagExpiPass FROM {$config->tbLogin} WHERE NumeEsta = 1 AND NumeCarg < 10 AND UPPER(NombUser) = '{$user}' AND NombPass = '{$pass}'");

		$strSalida = "";

		if ($tabla->num_rows == 1)
		{
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}

			$fila = $tabla->fetch_assoc();
			$_SESSION['NombUser'] = $_POST['usuario'];
			$_SESSION['NumeUser'] = $fila['NumeUser'];
			$_SESSION['NombPers'] = $fila['NombPers'];

			if (isset($_POST['theme']) && $_POST["theme"] != "") {
				$_SESSION['Theme'] = $_POST['theme'];
			}

			//Controlo contraseña
			$fechHoy = new \DateTime();
			$fechPass = new \DateTime($fila["FechPass"]);
			$aux = $fechHoy->diff($fechPass, true);

			if ($fila["FechPass"] == ''
				|| ($aux->days >= $diasPassword && $fila["FlagExpiPass"] == "1")) {
				header("Location:../changePassword.php". ($_POST["returnUrl"] != ""? "?returnUrl={$_POST["returnUrl"]}": ""));
				die();
			}

			$_SESSION['is_logged_in_'. $nombSistema] = 1;
			$_SESSION['session_time'] = time();


			$config->ejecutarCMD("UPDATE {$config->tbLogin} SET FechUltiEntr = SYSDATE() WHERE NumeUser = {$fila["NumeUser"]}");

			$tabla->free();
		}
		else {
			//Error
			header("Location:../login.php?returnUrl={$_POST["returnUrl"]}&error=1");
			die();
		}
	}
	else {
		//Cambiar contraseña
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		$pass = trim(str_replace("'", "", $_POST["password"]));
		$pass1 = trim(str_replace("'", "", $_POST["password_new"]));
		$pass2 = trim(str_replace("'", "", $_POST["password_new2"]));

		if ($pass1 != $pass2) {
			header("Location:../changePassword.php?returnUrl={$_POST["returnUrl"]}&error=1");
			die();
		}

		if ($pass == $pass1) {
			header("Location:../changePassword.php?returnUrl={$_POST["returnUrl"]}&error=3");
			die();
		}

		if (strlen($pass1) < 6) {
			header("Location:../changePassword.php?returnUrl={$_POST["returnUrl"]}&error=4");
			die();
		}

		$pass = md5($pass);
		$pass1 = md5($pass1);
		$pass2 = md5($pass2);

		$numeUser = $config->buscarDato("SELECT NumeUser FROM {$config->tbLogin} WHERE NumeEsta = 1 AND NumeCarg < 10 AND NumeUser = '{$_SESSION["NumeUser"]}' AND NombPass = '{$pass}'");

		$strSalida = "";

		if ($numeUser == $_SESSION["NumeUser"])
		{
			$config->ejecutarCMD("UPDATE {$config->tbLogin} SET NombPass = '{$pass1}', FechPass = SYSDATE(), FechUltiEntr = SYSDATE() WHERE NumeUser = {$numeUser}");

			$_SESSION['is_logged_in_'. $nombSistema] = 1;
			$_SESSION['session_time'] = time();
		}
		else {
			//Error
			header("Location:../changePassword.php?returnUrl={$_POST["returnUrl"]}&error=2");
			die();
		}
	}

	if ($_POST["returnUrl"] == "") {
		header("Location:../");
	}
	else {
		header("Location:".$_POST["returnUrl"]);
	}
}
?>
