<?php
header('Content-Type: application/json; charset=utf-8');
include 'connexio.php';

if (!isset($_GET['id'])) {
    echo json_encode(null);
    exit;
}

$id = intval($_GET['id']);

$sql = "SELECT ps, atac, defensa, atEspecial, defEspecial, velocitat, total FROM pokedex WHERE ID_pokedex = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$estat = $result->fetch_assoc();

echo json_encode($estat);
?>
