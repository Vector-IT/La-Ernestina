<?php
	try {
		session_start();
	}
	catch (Exception $e) {}

    $_SESSION = array();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
        );
    }

    session_destroy();

	if (file_exists('login.php')) {
		header("location:login.php");
	}
	elseif (file_exists('../login.php')) {
		header("location:../login.php");
	}
?>