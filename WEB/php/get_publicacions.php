<?php
require_once 'connexio.php';

header('Content-Type: application/json');

$id = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($id) {
    // Busquem una publicació concreta
    $sql = "SELECT p.ID_publicacio, p.titol, p.descripcio, u.nom, u.apodo, u.imatge, p.fk_equipPokemon
            FROM publicacio p
            JOIN usuaris u ON p.id_usuari = u.ID_usuari
            WHERE p.ID_publicacio = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(['error' => 'Publicació no trobada']);
        exit;
    }

    $row = $result->fetch_assoc();

    $post = [
        'ID_publicacio' => $row['ID_publicacio'],
        'titol' => $row['titol'],
        'descripcio' => $row['descripcio'],
        'nom_usuari' => $row['apodo'],
        'imatge_usuari' => $row['imatge'],
        'id_equip' => $row['fk_equipPokemon']
    ];

    echo json_encode($post, JSON_PRETTY_PRINT);

} else {
    // Retornem totes les publicacions
    $sql = "SELECT p.ID_publicacio, p.titol, p.descripcio, u.nom, u.apodo, u.imatge, p.fk_equipPokemon
            FROM publicacio p
            JOIN usuaris u ON p.id_usuari = u.ID_usuari
            ORDER BY p.ID_publicacio DESC";

    $result = $conn->query($sql);

    $posts = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $posts[] = [
                'ID_publicacio' => $row['ID_publicacio'],
                'titol' => $row['titol'],
                'descripcio' => $row['descripcio'],
                'nom_usuari' => $row['apodo'],
                'imatge_usuari' => $row['imatge'],
                'id_equip' => $row['fk_equipPokemon']
            ];
        }
    }

    echo json_encode($posts, JSON_PRETTY_PRINT);
}
