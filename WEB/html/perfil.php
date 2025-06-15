<?php
  include '../php/iniciar_sessio_js.php';
?>
<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="../css/colors.css">
  <link rel="stylesheet" href="../css/nav_i_footer.css">
  <link rel="stylesheet" href="../css/perfil.css">
  <title>Perfil</title>
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
    <section>
      <div class="estruct">
        <div class="dadesPrincipal">

          <!-- AIXO S'HA DE CAMBIAR PER QUE DETECTI SEGONS LA BBDD -->
          <?php if (isset($_SESSION['apodo'])): ?>
            <div class="centrar">
              <!-- AL FER CLICK EN AQUESTA IMATGE QUE S'OBRI UN MODAL AMB EL FORMULARI PER CANVIAR LA FOTO DE PERFIL -->
              <img src="<?= htmlspecialchars($_SESSION['imatge']) ?>" alt="Foto de perfil" id="fotoPerfil">
              <!-- AL FER CLICK EN AQUESTA IMATGE QUE S'OBRI UN MODAL AMB EL FORMULARI PER CANVIAR LA FOTO DE PERFIL -->
              <h2><?= htmlspecialchars($_SESSION['apodo']) ?></h2>
            </div>
            <?php endif; ?>
          <!-- AIXO S'HA DE CAMBIAR PER QUE DETECTI SEGONS LA BBDD -->
        </div>
        <div class="equipsCreats">
          <h1>Equips</h1>
          <div id="caixes">

            <!-- CAIXA EQUIP CANVIAR CONT PER UN SELECT VARIAT AMB LA ID D'USUARI -->
            <div class="caixa">
              <div class="nomMiniMenu">
                <h3>Nom Equip</h3>
                <div class="menuOpcionsContainer">
                  <i class='bx bx-md bx-dots-horizontal-rounded miniMenu'></i>
                  <div class="menuOpcions">
                    <p><i class='bx  bx-link'></i></p>
                    <p><i class='bx  bx-trash-x'></i></p>
                  </div>
                </div>
              </div>
              <div class="equip">
                <img src="../../img/shilluette.png" class="equipPokemon" id="pokemon1" alt="">
                <img src="../../img/shilluette.png" class="equipPokemon" id="pokemon2" alt="">
                <img src="../../img/shilluette.png" class="equipPokemon" id="pokemon3" alt="">
                <img src="../../img/shilluette.png" class="equipPokemon" id="pokemon4" alt="">
                <img src="../../img/shilluette.png" class="equipPokemon" id="pokemon5" alt="">
                <img src="../../img/shilluette.png" class="equipPokemon" id="pokemon6" alt="">
              </div>
            </div>
            <!-- CAIXA EQUIP CANVIAR CONT PER UN SELECT VARIAT AMB LA ID D'USUARI -->

          </div>
          
          <!-- CAIXA PER AFEGIR NOUS EQUIPS -->
          <a href="builder.php">
          <div class="afegirCaixa">
              <i class='bx bx-lg bx-plus-circle'></i>
            </div>
          </a>
          <!-- CAIXA PER AFEGIR NOUS EQUIPS -->
        </div>
      </div>
    </section>
  </div>

  <!-- Modal ocult per canviar la imatge -->
  <div id="modalCanviImatge" class="modal">
    <div class="modal-content">
      <span class="tancar-modal">&times;</span>
      <h2>Selecciona la teva imatge de perfil</h2>

      <form action="../php/actualitzar_imatge.php" method="POST">
        <div class="galeria-imatges">
          <?php
          $directori = '../../IMG/Pokemons/';
          $fitxers = scandir($directori);

          foreach ($fitxers as $fitxer) {
            if (in_array(pathinfo($fitxer, PATHINFO_EXTENSION), ['png', 'jpg', 'jpeg', 'gif'])) {
              $ruta = $directori . $fitxer;
              echo '<img src="' . $ruta . '" class="img-opcio" data-path="' . $ruta . '">';
            }
          }
          ?>
        </div>

        <!-- Input ocult per guardar la selecció -->
        <input type="hidden" name="imatgeSeleccionada" id="inputImatgeSeleccionada">
        <br>
        <button type="submit">Guardar</button>
      </form>
    </div>
  </div>
  <!-- Modal ocult per canviar la imatge -->

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
  <script src="../JavaScript/perfil.js"></script>
</body>
</html>
