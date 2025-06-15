<?php
  include '../php/iniciar_sessio_js.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="../css/colors.css">
  <link rel="stylesheet" href="../css/nav_i_footer.css">
  <link rel="stylesheet" href="../css/nosaltres.css">
  <title>Qui som?</title>
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

  <header>
    <h1>Qui som?</h1>
  </header>

  <section>
    <p>Som dos estudiants que preferim estar en el anonimat per el moment i que ens agrada molt pokemon. 
      Desde petits sempre ens ha agradat pokemon fins a dia de avui. Per aquells temps feiem lo que tothom 
      ha fet almenys una vegada, quedarse els llegendaris perque son mes xulos i mes ‘forts’ o que el starter 
      sigui el carry de tot el equip en tota la aventura. Ara que som més concients de com funciona em 
      volgut compartir els nostres coneixements per ajudarvos a crear el vostre equip. Com ultimament el 
      competitiu es cada vegada més conegut, i a mes a mes, després de que Nintendo hagi publicat un nou joc 
      exclusivament per el competitiu hi ha mes gent que vol entrar en aquest mon. Aixi que em decidit crear 
      aquesta pagina web per ajudar a la gent per a que es crei el seu equip.</p>
  </section>

  <section>
    <h2>Membres</h2>
    <div class="membre1">
      <h3>Jordi Ariza</h3>
        <p>
          Sóc una persona bastant friki d'aquest món del Pokémon, des de petit m'ha apassionat tot el que envolta aquesta saga: els videojocs, les sèries, les cartes... Tot! M'encanta perdre'm en aquest univers i descobrir-ne cada detall. No m'agrada deixar les coses a mitges. 
        </p>
        <p>
          Quan em poso amb un projecte, m'hi involucro al màxim i no paro fins que les coses surten bé. M'agrada 
          fer-les amb cura, i sobretot, amb ganes. Em considero una persona amable i sempre disposada a ajudar els altres amb el que faci falta. Aquest espai neix amb la intenció de compartir la meva passió i connectar amb altres entrenadors i entrenadores com jo.
      </p>
    </div>
    <div class="membre2">
      <h3>Gerard Gorrea</h3>
        <p>
          Sóc una persona que li agrada molt els videojocs, les pelicules i les sèries. De petit un dels primers jocs que vaig jugar va ser el <span class="cursiva">Pokémon: Heart Gold</span> i, a dia d'avui segueix sent un dels meus jocs preferits.
        </p>
        <p>
          M'agrada el món Pokémon des de petit. Des de petit m'ha agradat la idea de crear el meu equip.
          També m'he interessat recentment pel món del competitiu, i m'agrada aprendre'n cada dia.      
        </p>
    </div>
  </section>

  <section>
    <h2>El nostre objectiu</h2>
    <p>Tot i incentivar a fer equips competitius, els equips no han de ser competitius, es poden fer inclus 
      només per diversió, probar coses noves, crear obres d’art o inclus aberracions. El objectiu d’aquesta 
      web és que es diverteixin crean el seu equip competitiu o no competitiu. Creiem que és una bona forma 
      de començar en aquest mon.
    </p>
  </section>

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
</body>

</html>