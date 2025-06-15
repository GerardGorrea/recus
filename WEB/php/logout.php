<?php
    session_start();

    // Destruir totes les variables de sessió
    $_SESSION = array();

    // Si es vol destruir la sessió completament, també cal eliminar la cookie de sessió
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Finalment, destruir la sessió
    session_destroy();

    // Redirigir a la pàgina principal o de login
    header("Location: ../html/index.php");
    exit();
?>