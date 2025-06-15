<?php
require_once 'connexio.php';

header('Content-Type: application/json');

$equip_id = isset($_GET['equip_id']) ? intval($_GET['equip_id']) : null;
$slot = isset($_GET['slot']) ? intval($_GET['slot']) : null;

if (!$equip_id || !$slot || $slot < 1 || $slot > 6) {
    echo json_encode(['error' => 'Paràmetres invàlids']);
    exit;
}

// Map slot a taula
$taules = [
    1 => '1er_pokemon',
    2 => '2on_pokemon',
    3 => '3er_pokemon',
    4 => '4rt_pokemon',
    5 => '5è_pokemon',
    6 => '6è_pokemon'
];

$taula = $taules[$slot];


$sql = "SELECT p.*, base.nom, base.PS, base.atac, base.defensa, base.atEspecial, base.defEspecial, base.velocitat
        FROM $taula p
        JOIN pokedex base ON p.fk_pokemon = base.ID_pokemon
        WHERE p.fk_equipPokemon = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $equip_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['error' => 'Pokémon no trobat per aquest slot i equip']);
    exit;
}

$row = $result->fetch_assoc();

echo json_encode($row, JSON_PRETTY_PRINT);
