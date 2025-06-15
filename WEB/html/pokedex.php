<?php
require '../php/connexio.php';
include '../php/iniciar_sessio_js.php';

$linies = 20;

if (isset($_REQUEST['paginacio']))
    $inici = $_REQUEST['paginacio'];
else
    $inici = 0;

$sql = "SELECT * FROM pokedex LIMIT $inici, $linies";
$registres = $conn->query($sql);
$impressos = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="../css/colors.css">
  <link rel="stylesheet" href="../css/nav_i_footer.css">
  <link rel="stylesheet" href="../css/pokedex.css">
  <title>Pokedex</title>
</head>
<body>
    <nav>
        <div class="logoMenu">
            <a href="index.php">
                <img src="../../IMG/logo.png" class="logo" alt="logo pagina i link al Menu">
            </a>
            <div class="menu" id="menu">
                <ul class="llistaMenu">
                    <li><a href="index.php">Inici</a></li>
                    <li class="dropdown"><a href="pokedex.php">Pokedex</a>
                        <ul class="menuDropdown">
                            <li><a href="pokedex.php">Normal</a></li>
                            <li><a href="pokedex.php">Planta</a></li>
                            <li><a href="pokedex.php">Fuego</a></li>
                            <li><a href="pokedex.php">Agua</a></li>
                            <li><a href="pokedex.php">Lucha</a></li>
                            <li><a href="pokedex.php">Bicho</a></li>
                            <li><a href="pokedex.php">Veneno</a></li>
                            <li><a href="pokedex.php">Psiquico</a></li>
                            <li><a href="pokedex.php">Fantasma</a></li>
                            <li><a href="pokedex.php">Eléctico</a></li>
                            <li><a href="pokedex.php">Hielo</a></li>
                            <li><a href="pokedex.php">Dragon</a></li>
                            <li><a href="pokedex.php">Roca</a></li>
                            <li><a href="pokedex.php">Tierra</a></li>
                            <li><a href="pokedex.php">Volador</a></li>
                        </ul>
                    </li>
                    <li><a href="builder.php">Builder</a></li>
                    <li><a href="posts.php">Publicacions</a></li>
                    <li><a href="preguntesfrq.php">Preguntes frequents</a></li>
                    <li><a href="nosaltres.php">Qui som?</a></li>
                </ul>
            </div>
        </div>
        <div class="perfil" id="perfil">
            <?php if (isset($_SESSION['apodo'])): ?>
                <div class="user-dropdown">
                    <div class="user-info">
                        <p><?= htmlspecialchars($_SESSION['apodo']) ?></p>
                        <img src="<?= htmlspecialchars($_SESSION['imatge']) ?>" class="fotoUser" alt="foto del usuari">
                    </div>
                    <div class="dropdown-menu">
                        <a href="perfil.php" class="dropdown-item">
                            <span class='bx bx-user'></span>Perfil
                        </a>
                        <a href="../php/logout.php" class="dropdown-item logout">
                            <span class='bx bx-log-out'></span>Tancar sessió
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <a href="login.php">Inicia sessió</a>
            <?php endif; ?>
        </div>
    </nav>

  <div class="cont_blanc">
    <header>
      <h1>POKÉDEX</h1>
      <div class="divBuscador">
        <input type="text" placeholder="Cerca..." class="buscador" id="buscador" oninput="buscadorPokedex()">
        <i class='bx bx-search-alt-2 lupa'></i>
      </div>
    </header>
  
    <section>
      <div class="divFiltro">
        <div class="filtro" data-filtre="false" data-nomF="Normal" id="filtroNormal"><p>Normal</p></div>
        <div class="filtro" data-filtre="false" data-nomF="Planta" id="filtroPlanta"><p>Planta</p></div>
        <div class="filtro" data-filtre="false" data-nomF="Fuego" id="filtroFuego"><p>Fuego</p></div>
        <div class="filtro" data-filtre="false" data-nomF="Agua" id="filtroAgua"><p>Agua</p></div>
        <div class="filtro" data-filtre="false" data-nomF="Lucha" id="filtroLucha"><p>Lucha</p></div>
        <div class="filtro" data-filtre="false" data-nomF="Bicho" id="filtroBicho"><p>Bicho</p></div>
        <div class="filtro" data-filtre="false" data-nomF="Veneno" id="filtroVeneno"><p>Veneno</p></div>
        <div class="filtro" data-filtre="false" data-nomF="Psiquico" id="filtroPsiquico"><p>Psiquico</p></div>
        <div class="filtro" data-filtre="false" data-nomF="Fantasma" id="filtroFantasma"><p>Fantasma</p></div>
        <div class="filtro" data-filtre="false" data-nomF="Electrico" id="filtroElectrico"><p>Eléctrico</p></div>
        <div class="filtro" data-filtre="false" data-nomF="Hielo" id="filtroHielo"><p>Hielo</p></div>
        <div class="filtro" data-filtre="false" data-nomF="Dragon" id="filtroDragon"><p>Dragon</p></div>
        <div class="filtro" data-filtre="false" data-nomF="Roca" id="filtroRoca"><p>Roca</p></div>
        <div class="filtro" data-filtre="false" data-nomF="Tierra" id="filtroTierra"><p>Tierra</p></div>
        <div class="filtro" data-filtre="false" data-nomF="Volador" id="filtroVolador"><p>Volador</p></div>
      </div>
    </section>

    <section>
      <div class="pokedex" id="pokedex">
        <?php
        while ($reg = $registres->fetch_array()) {
          $impressos++;
        ?>
          <a href="pokedexDetall.php?id=<?php echo $reg['ID_pokedex']; ?>">
            <div class="divPkmn">
              <p>#<?php echo $reg['ID_pokedex']; ?></p>
              <img src="<?php echo $reg['imatgeM']; ?>" alt="<?php echo $reg['nom']; ?>">
              <p><?php echo $reg['nom']; ?></p>
            </div>
          </a>
        <?php } ?>
      </div>
    </section>
    
    <section>
      <div class="paginacio">
        <?php
          if ($inici == 0) {
              echo "";
          }else {
              $anterior = $inici - $linies;
              echo "<a href=\"pokedex.php?paginacio=$anterior\" class=\"anterior\"><- Anterior</a> ";
          }

          if ($impressos == $linies) {
              $proper = $inici + $linies;
              echo "<a href=\"pokedex.php?paginacio=$proper\" class=\"seguent\">Següent -></a>";
          }
        ?>
      </div>
    </section>
  </div>

  <footer>
            <div class="menuFooter">
              <h3>Menu Ràpid</h3>
              <ul>
                <li><a href="index.php">Inici</a></li>
                <li><a href="pokedex.php">Pokedex</a></li>
                <li><a href="builder.php">Builder</a></li>
                <li><a href="posts.php">Publicacions</a></li>
                <li><a href="preguntesfrq.php">Preguntes frequents</a></li>
                <li><a href="nosaltres.php">Qui som?</a></li>
              </ul>
            </div>
            <div class="formulariFoter">
                <p class="pokebuilder_logo">
                    P
                    <span class="footer_span">
                        <img src="../../IMG/logo.png" alt="logo"/>
                    </span>
                    KÉBUILDER
                </p>
                <img src="" alt="" class="logoFooter">
                <h3>Formulari de contacte</h3>
              <div>
                <label for="emailFooter">Email: </label>
                <input type="email" name="emailFooter" id="emailFooter">
              </div>
              <div>
                <label for="msgFooter">Missatge de contacte</label>
                <textarea name="msgFooter" id="msgFooter" placeholder="Diguen's coses a millorar o si tens algun problema"></textarea>
              </div>
            </div>
            <div class="contacteFooter">
              <h3>Contacten's</h3>
              <div class="divContacte">
                <div class="contacte"><a href="https://www.instagram.com"><img src="../../IMG/contacte/insta.png" alt=""></a></div>
                <div class="contacte"><a href="https://www.tiktok.com/"><img src="../../IMG/contacte/tiktok.png" alt=""></a></div>
                <div class="contacte"><a href="https://www.discord.com/"><img src="../../IMG/contacte/discord.png" alt=""></a></div>
                <div class="contacte"><a href="https://www.x.com/"><img src="../../IMG/contacte/x.png" alt=""></a></div>
              </div>
            </div>
        </footer>
  <script src="../JavaScript/buscadorPokedex.js"></script>
</body>
</html>