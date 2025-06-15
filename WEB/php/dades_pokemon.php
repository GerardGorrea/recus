<?php
header('Content-Type: application/json');

require_once 'connexio.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    echo json_encode(["error" => "ID invàlid"]);
    exit;
}

$sql = "SELECT ID_pokedex as id, nom, imatgeM, imatgeF, imatgeShinyM, imatgeShinyF,
        PS, atac, defensa, atEspecial, defEspecial, velocitat, total
        FROM pokedex WHERE ID_pokedex = $id";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode(["error" => "Error en la consulta: " . $conn->error]);
    exit;
}

if ($result->num_rows == 0) {
    echo json_encode(["error" => "Pokémon no trobat"]);
    exit;
}

$row = $result->fetch_assoc();

$teSexe = false;
if (!empty($row['imatgeF']) && strtolower($row['imatgeF']) != strtolower($row['imatgeM'])) {
    $teSexe = true;
}

$row['teSexe'] = $teSexe;

echo json_encode($row);

$conn->close();
?>
