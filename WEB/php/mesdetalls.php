<?php
session_start();
require_once '../php/conexio.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $query = $conn->prepare("SELECT * FROM posts WHERE id_post = ?");
    $query->execute([$id]);
    $post = $query->fetch(PDO::FETCH_ASSOC);

    if (!$post) {
        die("Post no trobat.");
    }
} else {
    die("ID de post no proporcionat.");
}
?>
