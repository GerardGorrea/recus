<?php
session_start();
require_once 'connexio.php';

header('Content-Type: application/json');

// Comprovar sessió iniciada
if (!isset($_SESSION['ID_usuari'])) {
    echo json_encode(['success' => false, 'message' => 'No autenticat']);
    exit;
}

// Rebre dades
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id_equip'])) {
    echo json_encode(['success' => false, 'message' => 'ID d\'equip no rebut']);
    exit;
}

$id_equip = intval($data['id_equip']);
$usuari_id = $_SESSION['ID_usuari'];

// Eliminar només si l’equip pertany a l’usuari
$stmt = $conn->prepare("DELETE FROM equips_pokemon WHERE ID_equipsPokemon = ? AND fk_usuari = ?");
$stmt->bind_param("ii", $id_equip, $usuari_id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Equip no trobat o no autoritzat']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error a la base de dades']);
}

$stmt->close();
$conn->close();
