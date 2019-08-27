<?php
	if (isset($_REQUEST['js'])) {
		session_start();

		require_once 'datosdb.php';
	}

	if (isset($_SESSION['is_logged_in_'. $nombSistema])){
		$ahora = time();

		$login = $_SESSION['session_time'];

		if (round(abs($ahora - $login) / 60) >= $tiempoSesion) {
			$_SESSION = array();

			if (ini_get("session.use_cookies")) {
				$params = session_get_cookie_params();
				setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
				);
			}

			try {
				session_destroy();
			}
			catch (Exception $e) {
			}

			if (isset($_REQUEST['js'])) {
				$array = array(
					"estado" => false
				);

				header('Content-Type: application/json');
				echo json_encode($array);
			}
		}
		else {
			if (isset($_REQUEST['js'])) {
				$array = array(
					"estado" => true
				);

				header('Content-Type: application/json');
				echo json_encode($array);
			}
			else {
				$_SESSION['session_time'] = $ahora;
			}
		}
	}
	else {
		if (isset($_REQUEST['js'])) {
			$array = array(
				"estado" => false
			);

			header('Content-Type: application/json');
			echo json_encode($array);
		}
	}
?>