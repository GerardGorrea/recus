<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>
<script>
  // Passar l'ID de l'usuari de PHP a JavaScript (sessionStorage)
  sessionStorage.setItem('usuariId', '<?php echo $_SESSION["ID_usuari"] ?? ''; ?>');
</script>
