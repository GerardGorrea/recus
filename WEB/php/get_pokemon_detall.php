<?php
require_once 'connexio.php';
header('Content-Type: application/json');

// Obtenir i validar paràmetres
$id_pokemon = isset($_GET['id']) ? intval($_GET['id']) : null;
$slot = isset($_GET['slot']) ? intval($_GET['slot']) : null;

if (!$id_pokemon || $slot < 1 || $slot > 6) {
    http_response_code(400);
    echo json_encode(['error' => 'ID o slot invàlid']);
    exit;
}

// Taules i claus primàries corresponents al slot
$taules = ['1er_pokemon', '2on_pokemon', '3er_pokemon', '4rt_pokemon', '5e_pokemon', '6e_pokemon'];
$ids_col = ['ID_1erPokemon', 'ID_2onPokemon', 'ID_3erPokemon', 'ID_4rtPokemon', 'ID_5ePokemon', 'ID_6ePokemon'];

$taula = $taules[$slot - 1];
$id_columna = 'fk_pokemon';
// Consulta SQL per obtenir el Pokémon i els seus moviments
$sql = "SELECT p.*, 
               m1.nom AS moviment1, m2.nom AS moviment2, 
               m3.nom AS moviment3, m4.nom AS moviment4
        FROM `$taula` p
        LEFT JOIN moviments m1 ON p.fk_mov1 = m1.ID_moviment
        LEFT JOIN moviments m2 ON p.fk_mov2 = m2.ID_moviment
        LEFT JOIN moviments m3 ON p.fk_mov3 = m3.ID_moviment
        LEFT JOIN moviments m4 ON p.fk_mov4 = m4.ID_moviment
        WHERE p.`$id_columna` = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Error preparant la consulta SQL: ' . $conn->error]);
    exit;
}

$stmt->bind_param("i", $id_pokemon);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(['error' => 'Pokémon no trobat']);
    exit;
}

$row = $result->fetch_assoc();

// Crear el camí de la imatge
$id_poke_base = str_pad($row['fk_pokemon'], 3, '0', STR_PAD_LEFT);
$imatge = '../../IMG/Pokemons/' . $id_poke_base . ($row['shiny'] ? 'Shiny' : '') . '.png';

// Formatació final
$resposta = [
    'id' => $row[$id_columna],
    'nom' => $row['nom'],
    'nivell' => $row['nivell'],
    'sexe' => $row['sexe'],
    'shiny' => boolval($row['shiny']),
    'imatge_final' => $imatge,
    'ivs' => [
        'hp' => intval($row['iv_ps']),
        'atac' => intval($row['iv_atac']),
        'defensa' => intval($row['iv_def']),
        'sp_atac' => intval($row['iv_AEsp']),
        'sp_defensa' => intval($row['iv_DEsp']),
        'velocitat' => intval($row['iv_vel']),
    ],
    'evs' => [
        'hp' => intval($row['ev_ps']),
        'atac' => intval($row['ev_atac']),
        'defensa' => intval($row['ev_def']),
        'sp_atac' => intval($row['ev_AEsp']),
        'sp_defensa' => intval($row['ev_DEsp']),
        'velocitat' => intval($row['ev_velocitat']),
    ],
    'moviments' => array_values(array_filter([
        $row['moviment1'],
        $row['moviment2'],
        $row['moviment3'],
        $row['moviment4']
    ]))
];

echo json_encode($resposta, JSON_PRETTY_PRINT);
?>
