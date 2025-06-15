<?php
session_start();
require_once 'connexio.php';

header('Content-Type: application/json');

if (!isset($_SESSION['ID_usuari'])) {
    echo json_encode(['success' => false, 'message' => 'Usuari no autenticat.']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$titol = $data['title'] ?? '';
$descripcio = $data['description'] ?? '';
$fk_equip = $data['category'] ?? null;
$id_usuari = $_SESSION['ID_usuari'];

if (empty($titol) || empty($descripcio) || empty($fk_equip)) {
    echo json_encode(['success' => false, 'message' => 'Falten camps.']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO publicacio (titol, descripcio, id_usuari, fk_equipPokemon) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssii", $titol, $descripcio, $id_usuari, $fk_equip);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Publicació guardada correctament.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar la publicació.']);
}

$stmt->close();
$conn->close();
?>
