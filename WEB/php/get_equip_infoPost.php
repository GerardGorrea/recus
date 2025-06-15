<?php
session_start();
require_once 'connexio.php';

header('Content-Type: application/json');

$pokemonsAmbGenere = ['003', '012', '019', '020', '025', '026', '041', '042', '044', '045', '064', '065', '084', '085', '097', '111', '112', '118', '119', '123', '129', '130'];

$idEquip = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$idEquip) {
    http_response_code(400);
    echo json_encode(['error' => 'ID d\'equip no proporcionat']);
    exit;
}

// Consulta l'equip Pokémon segons l'id rebut
$sql = "SELECT * FROM equips_pokemon WHERE ID_equipsPokemon = ?";
$stmtEquips = $conn->prepare($sql);
$stmtEquips->bind_param("i", $idEquip);
$stmtEquips->execute();
$result = $stmtEquips->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(['error' => 'Equip no trobat']);
    exit;
}

$row = $result->fetch_assoc();

$taules_pokemon = [
    ['taula' => '1er_pokemon', 'fk' => 'fk_1er_pokemon', 'id' => 'ID_1erPokemon'],
    ['taula' => '2on_pokemon', 'fk' => 'fk_2on_pokemon', 'id' => 'ID_2onPokemon'],
    ['taula' => '3er_pokemon', 'fk' => 'fk_3er_pokemon', 'id' => 'ID_3erpokemon'],
    ['taula' => '4rt_pokemon', 'fk' => 'fk_4rt_pokemon', 'id' => 'ID_4rtpokemon'],
    ['taula' => '5e_pokemon', 'fk' => 'fk_5e_pokemon', 'id' => 'ID_5ePokemon'],
    ['taula' => '6e_pokemon', 'fk' => 'fk_6e_pokemon', 'id' => 'ID_6ePokemon']
];

$pokemons = [];

foreach ($taules_pokemon as $pokeInfo) {
    $idPokemon = $row[$pokeInfo['fk']];
    if ($idPokemon) {
        // Obtenim dades del pokemon de la taula corresponent (1er_pokemon, 2on_pokemon, etc)
        $sqlPokemon = "SELECT * FROM {$pokeInfo['taula']} WHERE {$pokeInfo['id']} = ?";
        $stmt = $conn->prepare($sqlPokemon);
        $stmt->bind_param("i", $idPokemon);
        $stmt->execute();
        $resultPokemon = $stmt->get_result();

        if ($resultPokemon->num_rows > 0) {
            $pokemon = $resultPokemon->fetch_assoc();

            // Ara agafem dades de la pokedex per a aquest pokemon
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

                // Decidim la imatge final segons shiny i sexe
                if ($ambGenere) {
                    if ($shiny) {
                        $imatge = ($sexe === 'dona') ? $pokedex['imatgeShinyF'] : $pokedex['imatgeShinyM'];
                    } else {
                        $imatge = ($sexe === 'dona') ? $pokedex['imatgeF'] : $pokedex['imatgeM'];
                    }
                } else {
                    $imatge = ($shiny) ? $pokedex['imatgeShinyM'] : $pokedex['imatgeM'];
                }

                $pokemons[] = [
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

$stmtEquips->close();

echo json_encode([
    'id' => $row['ID_equipsPokemon'],
    'pokemons' => $pokemons
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
