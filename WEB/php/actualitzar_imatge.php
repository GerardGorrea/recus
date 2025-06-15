<?php
session_start();
require_once("connexio.php");

var_dump($_SESSION['ID_usuari']);

if (isset($_POST['imatgeSeleccionada']) && isset($_SESSION['ID_usuari'])) {
    $novaRuta = $_POST['imatgeSeleccionada']; // aquí la ruta amb ../../IMG/pokemons/arxiu

    $idUsuari = $_SESSION['ID_usuari'];

    // Preparar la consulta
    $sql = "UPDATE usuaris SET imatge = ? WHERE ID_usuari = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error en preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("si", $novaRuta, $idUsuari);

    if (!$stmt->execute()) {
        die("Error en executar la consulta: " . $stmt->error);
    }

    // Actualitzar la sessió perquè la imatge es mostri sense necessitat de tornar a entrar
    $_SESSION['imatge'] = $novaRuta;

    // Redirigir a perfil
    header("Location: ../html/perfil.php");
    exit();

} else {
    die("No s'ha enviat la imatge o no hi ha sessió d'usuari.");
}
