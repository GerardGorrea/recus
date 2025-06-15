<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'connexio.php';
error_log("Usuari sessió: " . $_SESSION['ID_usuari']);


header('Content-Type: application/json');

if (!isset($_SESSION['ID_usuari'])) {
    echo json_encode([]);
    exit;
}

$usuari_id = $_SESSION['ID_usuari'];
$pokemonsAmbGenere = ['003', '012', '019', '020', '025', '026', '041', '042', '044', '045', '064', '065', '084', '085', '097', '111', '112', '118', '119', '123', '129', '130'];

// Comprovem si arriba un paràmetre id
$idEquip = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($idEquip) {
    error_log("Consulta equip amb id $idEquip per usuari $usuari_id");
    // Retornem només l'equip amb aquest id i usuari
    $sql = "SELECT * FROM equips_pokemon WHERE ID_equipsPokemon = ? AND fk_usuari = ?";
    $stmtEquips = $conn->prepare($sql);
    $stmtEquips->bind_param("ii", $idEquip, $usuari_id);
} else {
    error_log("Consulta tots equips per usuari $usuari_id");
    // Retornem tots els equips de l'usuari
    $sql = "SELECT * FROM equips_pokemon WHERE fk_usuari = ?";
    $stmtEquips = $conn->prepare($sql);
    $stmtEquips->bind_param("i", $usuari_id);
}



$stmtEquips->execute();
$result = $stmtEquips->get_result();

$equips = [];

$taules_pokemon = [
    ['taula' => '1er_pokemon', 'fk' => 'fk_1er_pokemon', 'id' => 'ID_1erPokemon'],
    ['taula' => '2on_pokemon', 'fk' => 'fk_2on_pokemon', 'id' => 'ID_2onPokemon'],
    ['taula' => '3er_pokemon', 'fk' => 'fk_3er_pokemon', 'id' => 'ID_3erpokemon'],
    ['taula' => '4rt_pokemon', 'fk' => 'fk_4rt_pokemon', 'id' => 'ID_4rtpokemon'],
    ['taula' => '5e_pokemon', 'fk' => 'fk_5e_pokemon', 'id' => 'ID_5ePokemon'],
    ['taula' => '6e_pokemon', 'fk' => 'fk_6e_pokemon', 'id' => 'ID_6ePokemon']
];

while ($row = $result->fetch_assoc()) {
    $equip = [
        'id' => $row['ID_equipsPokemon'], // necessari per eliminar
        'pokemons' => []
    ];

    foreach ($taules_pokemon as $pokeInfo) {
        $idPokemon = $row[$pokeInfo['fk']];
        if ($idPokemon) {
            $sqlPokemon = "SELECT * FROM {$pokeInfo['taula']} WHERE {$pokeInfo['id']} = ?";
            $stmt = $conn->prepare($sqlPokemon);
            $stmt->bind_param("i", $idPokemon);
            $stmt->execute();
            $resultPokemon = $stmt->get_result();

            if ($resultPokemon->num_rows > 0) {
                $pokemon = $resultPokemon->fetch_assoc();

                $sqlPokedex = "SELECT * FROM pokedex WHERE ID_pokedex = ?";
                $stmt2 = $conn->prepare($sqlPokedex);
                $stmt2->bind_param("i", $pokemon['fk_pokemon']);
                $stmt2->execute();
                $resultPokedex = $stmt2->get_result();

                if ($resultPokedex->num_rows > 0) {
                    $pokedex = $resultPokedex->fetch_assoc();

                    $id_str = str_pad($pokemon['fk_pokemon'], 3, "0", STR_PAD_LEFT);
                    $shiny = $pokemon['shiny'];
                    $sexe = strtolower($pokemon['sexe']);
                    $ambGenere = in_array($id_str, $pokemonsAmbGenere);

                    // Decidir la imatge final
                    if ($ambGenere) {
                        if ($shiny) {
                            $imatge = ($sexe === 'dona') ? $pokedex['imatgeShinyF'] : $pokedex['imatgeShinyM'];
                        } else {
                            $imatge = ($sexe === 'dona') ? $pokedex['imatgeF'] : $pokedex['imatgeM'];
                        }
                    } else {
                        $imatge = ($shiny) ? $pokedex['imatgeShinyM'] : $pokedex['imatgeM'];
                    }

                    $equip['pokemons'][] = [
                        'dades' => $pokemon,
                        'pokedex' => $pokedex,
                        'imatge_final' => $imatge
                    ];
                }
                $stmt2->close();
            }
            $stmt->close();
        }
    }

    $equips[] = $equip;
}

$stmtEquips->close();

if ($idEquip) {
    echo json_encode($equips[0] ?? ['error' => 'Equip no trobat o sense permisos'], JSON_PRETTY_PRINT);
} else {
    echo json_encode($equips, JSON_PRETTY_PRINT);
}