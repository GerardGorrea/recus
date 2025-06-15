<?php
// cerca_pokemon_id.php
header('Content-Type: application/json');
require_once 'connexio.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id < 1 || $id > 151) {
    echo json_encode(['error' => 'ID fora de rang']);
    exit;
}

$sql = "SELECT * FROM pokedex WHERE ID_pokedex = $id";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    echo json_encode(['error' => 'Pokémon no trobat']);
    exit;
}

$pokemon = $result->fetch_assoc();

// També agafem les dades de 1er_pokemon per IV/EV i moviments
$sql2 = "SELECT * FROM 1er_pokemon WHERE fk_pokemon = $id LIMIT 1";
$result2 = $conn->query($sql2);

$extra = null;
if ($result2 && $result2->num_rows > 0) {
    $extra = $result2->fetch_assoc();
}

$response = [
    'pokemon' => $pokemon,
    'extra' => $extra
];

echo json_encode($response);

$conn->close();
?>
