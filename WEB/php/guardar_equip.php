<?php
include('connexio.php'); // Connexió a la BBDD

$data = json_decode(file_get_contents('php://input'), true);
$pokemons = $data['pokemons'];
$usuariId = intval($data['usuariId']);

if (count($pokemons) !== 6) {
    echo json_encode(['success' => false, 'message' => 'Calen 6 pokémons per guardar l\'equip.']);
    exit;
}

$taules = ['1er_pokemon', '2on_pokemon', '3er_pokemon', '4rt_pokemon', '5e_pokemon', '6e_pokemon'];
$ids = [];

foreach ($pokemons as $index => $poke) {
    $taula = $taules[$index];

    $stmt = $conn->prepare("INSERT INTO `$taula` (fk_pokemon, nom, nivell, sexe, shiny, iv_ps, iv_atac, iv_def, iv_AEsp, iv_DEsp, iv_vel, ev_ps, ev_atac, ev_def, ev_AEsp, ev_DEsp, ev_velocitat, fk_mov1, fk_mov2, fk_mov3, fk_mov4)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $fk_pokemon = intval($poke['id_pokemon']);
    $nom = $poke['nom'];
    $nivell = intval($poke['nivell']);
    $sexe = $poke['sexe'];
    $shiny = $poke['shiny'] ? 1 : 0;

    $stmt->bind_param(
        'isssiiiiiiiiiiiiiiiii',
        $fk_pokemon, $nom, $nivell, $sexe, $shiny,
        $poke['IvPS'], $poke['IvAtac'], $poke['IvDefensa'],
        $poke['IvAtEspecial'], $poke['IvDefEspecial'], $poke['IvVelocitat'],
        $poke['EvPS'], $poke['EvAtac'], $poke['EvDefensa'],
        $poke['EvAtEspecial'], $poke['EvDefEspecial'], $poke['EvVelocitat'],
        $poke['id_moviments'][0], $poke['id_moviments'][1],
        $poke['id_moviments'][2], $poke['id_moviments'][3]
    );

    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Error insertant Pokémon: ' . $stmt->error]);
        exit;
    }

    $ids[] = $conn->insert_id;
    $stmt->close();
}

// Inserir a equips_pokemon
$stmt2 = $conn->prepare("INSERT INTO equips_pokemon (fk_1er_pokemon, fk_2on_pokemon, fk_3er_pokemon, fk_4rt_pokemon, fk_5e_pokemon, fk_6e_pokemon, fk_usuari)
                         VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt2->bind_param('iiiiiii', $ids[0], $ids[1], $ids[2], $ids[3], $ids[4], $ids[5], $usuariId);

if ($stmt2->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error insertant equip: ' . $stmt2->error]);
}

$stmt2->close();
$conn->close();
?>
