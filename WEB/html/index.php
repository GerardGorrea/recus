<?php
session_start();
// echo($_SESSION['imatge']);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" href="../../IMG/logo.png" type="image/x-icon">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/colors.css">
    <link rel="stylesheet" href="../css/nav_i_footer.css">
    <link rel="stylesheet" href="../css/style.css">
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
                
    <section class="pokebuilder">
        <h1>PokéBuildeR</h1>
        <p style="color:white;">la web per crear els teus equips de somni</p>
         <!-- <img src="../../IMG/pokebuilder_titol.png" alt="Pokebuilder" class="pokebuilder_titol"> -->
        <div class="curva-separador">
            <svg viewBox="0 0 1440 320" preserveAspectRatio="none">
                <path fill="white" d="M0,192L80,176C160,160,320,128,480,112C640,96,800,96,960,112C1120,128,1280,160,1360,176L1440,192L1440,320L0,320Z"></path>
            </svg>
        </div>
    </section>

    <!-- SEPARADOR ARRODONIT -->
        <!-- seccio builder recu -->
        <section class="a1_sec_rec">
            <div class="highlight_recu">
                <h2 class="titolcaixa">Exemples d'Equips Pokémon d'usuaris</h2>
                <div class="posInici_recu">
                    <div class="highlightPosts_recu">
                        <div class="post1">
                            <div class="usrPost">
                                <div class="equipPost">
                                    <div class="pokemons">
                                        <p class="nom.equip">Exemple D'equip</p>
                                        <?php
                                            // Ruta a la carpeta de pokémons
                                            $ruta = '../../img/pokemons';

                                            // Obtenir totes les imatges de la carpeta (formats comuns)
                                            $fitxers = glob($ruta . '/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);

                                            // Barreja aleatòriament les imatges
                                            shuffle($fitxers);

                                            // Agafem només les 6 primeres (si n’hi ha prou)
                                            $seleccionades = array_slice($fitxers, 0, 6);
                                        ?>

                                        <div class="fila1">
                                            <?php for ($i = 0; $i < 3; $i++): ?>
                                                <a href="#">
                                                    <img src="<?php echo $seleccionades[$i]; ?>" alt="Pokemon">
                                                </a>
                                            <?php endfor; ?>
                                        </div>
                                        <div class="fila2">
                                            <?php for ($i = 3; $i < 6; $i++): ?>
                                                <a href="#">
                                                    <img src="<?php echo $seleccionades[$i]; ?>" alt="Pokemon">
                                                </a>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="post2">
                            <div class="usrPost">
                                <div class="equipPost">
                                    <div class="pokemons">
                                        <p class="nom.equip">Exemple D'equip</p>
                                        <?php
                                            // Ruta a la carpeta de pokémons
                                            $ruta = '../../img/pokemons';

                                            // Obtenir totes les imatges de la carpeta (formats comuns)
                                            $fitxers = glob($ruta . '/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);

                                            // Barreja aleatòriament les imatges
                                            shuffle($fitxers);

                                            // Agafem només les 6 primeres (si n’hi ha prou)
                                            $seleccionades = array_slice($fitxers, 0, 6);
                                        ?>

                                        <div class="fila1">
                                            <?php for ($i = 0; $i < 3; $i++): ?>
                                                <a href="#">
                                                    <img src="<?php echo $seleccionades[$i]; ?>" alt="Pokemon">
                                                </a>
                                            <?php endfor; ?>
                                        </div>
                                        <div class="fila2">
                                            <?php for ($i = 3; $i < 6; $i++): ?>
                                                <a href="#">
                                                    <img src="<?php echo $seleccionades[$i]; ?>" alt="Pokemon">
                                                </a>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="post3">
                            <div class="usrPost">
                                <div class="equipPost">
                                    <div class="pokemons">
                                        <p class="nom.equip">Exemple D'equip</p>
                                        <?php
                                            // Ruta a la carpeta de pokémons
                                            $ruta = '../../img/pokemons';

                                            // Obtenir totes les imatges de la carpeta (formats comuns)
                                            $fitxers = glob($ruta . '/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);

                                            // Barreja aleatòriament les imatges
                                            shuffle($fitxers);

                                            // Agafem només les 6 primeres (si n’hi ha prou)
                                            $seleccionades = array_slice($fitxers, 0, 6);
                                        ?>

                                        <div class="fila1">
                                            <?php for ($i = 0; $i < 3; $i++): ?>
                                                <a href="#">
                                                    <img src="<?php echo $seleccionades[$i]; ?>" alt="Pokemon">
                                                </a>
                                            <?php endfor; ?>
                                        </div>
                                        <div class="fila2">
                                            <?php for ($i = 3; $i < 6; $i++): ?>
                                                <a href="#">
                                                    <img src="<?php echo $seleccionades[$i]; ?>" alt="Pokemon">
                                                </a>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3>Crea el Teu Equip!</h3>
                    <div class="mirames">
                            <div class="btn-conteiner">
                                <a href="builder.php" class="btn-content builder-btn">Builder</a>
                            </div>
                        </div>
                </div>
            </div>
        </section>
        <!-- SECCIÓ POKEDEX -->
        <section class="pokedex_section">
            <div class="pokdex">
                <div class="carrousel_pkdx" >
                    <div class="titol">
                        <h2>Pokedex</h2>
                        <p>Aqui pots veure alguns dels Pokémons que tenim disponibles per a fer equips personalitzats.</p>
                        <div class="layout_carrusel">
                            <div class="fblanc">    
                                <div class="anterior"> 
                                    <div class="btn-conteiner" style="rotate: 180deg;">
                                        <a href="#" class="btn-content">
                                            <span class="icon-arrow">
                                                <svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 66 43" height="30px" width="30px">
                                                    <g fill-rule="evenodd" fill="none" stroke-width="1" stroke="none" id="arrow">
                                                        <path d="M40.1543933,3.89485454 L43.9763149,0.139296592 C44.1708311,-0.0518420739 44.4826329,-0.0518571125 44.6771675,0.139262789 L65.6916134,20.7848311 C66.0855801,21.1718824 66.0911863,21.8050225 65.704135,22.1989893 C65.7000188,22.2031791 65.6958657,22.2073326 65.6916762,22.2114492 L44.677098,42.8607841 C44.4825957,43.0519059 44.1708242,43.0519358 43.9762853,42.8608513 L40.1545186,39.1069479 C39.9575152,38.9134427 39.9546793,38.5968729 40.1481845,38.3998695 C40.1502893,38.3977268 40.1524132,38.395603 40.1545562,38.3934985 L56.9937789,21.8567812 C57.1908028,21.6632968 57.193672,21.3467273 57.0001876,21.1497035 C56.9980647,21.1475418 56.9959223,21.1453995 56.9937605,21.1432767 L40.1545208,4.60825197 C39.9574869,4.41477773 39.9546013,4.09820839 40.1480756,3.90117456 C40.1501626,3.89904911 40.1522686,3.89694235 40.1543933,3.89485454 Z" id="arrow-icon-one"></path>
                                                        <path d="M20.1543933,3.89485454 L23.9763149,0.139296592 C24.1708311,-0.0518420739 24.4826329,-0.0518571125 24.6771675,0.139262789 L45.6916134,20.7848311 C46.0855801,21.1718824 46.0911863,21.8050225 45.704135,22.1989893 C45.7000188,22.2031791 45.6958657,22.2073326 45.6916762,22.2114492 L24.677098,42.8607841 C24.4825957,43.0519059 24.1708242,43.0519358 23.9762853,42.8608513 L20.1545186,39.1069479 C19.9575152,38.9134427 19.9546793,38.5968729 20.1481845,38.3998695 C20.1502893,38.3977268 20.1524132,38.395603 20.1545562,38.3934985 L36.9937789,21.8567812 C37.1908028,21.6632968 37.193672,21.3467273 37.0001876,21.1497035 C36.9980647,21.1475418 36.9959223,21.1453995 36.9937605,21.1432767 L20.1545208,4.60825197 C19.9574869,4.41477773 19.9546013,4.09820839 20.1480756,3.90117456 C20.1501626,3.89904911 20.1522686,3.89694235 20.1543933,3.89485454 Z" id="arrow-icon-two"></path>
                                                        <path d="M0.154393339,3.89485454 L3.97631488,0.139296592 C4.17083111,-0.0518420739 4.48263286,-0.0518571125 4.67716753,0.139262789 L25.6916134,20.7848311 C26.0855801,21.1718824 26.0911863,21.8050225 25.704135,22.1989893 C25.7000188,22.2031791 25.6958657,22.2073326 25.6916762,22.2114492 L4.67709797,42.8607841 C4.48259567,43.0519059 4.17082418,43.0519358 3.97628526,42.8608513 L0.154518591,39.1069479 C-0.0424848215,38.9134427 -0.0453206733,38.5968729 0.148184538,38.3998695 C0.150289256,38.3977268 0.152413239,38.395603 0.154556228,38.3934985 L16.9937789,21.8567812 C17.1908028,21.6632968 17.193672,21.3467273 17.0001876,21.1497035 C16.9980647,21.1475418 16.9959223,21.1453995 16.9937605,21.1432767 L0.15452076,4.60825197 C-0.0425130651,4.41477773 -0.0453986756,4.09820839 0.148075568,3.90117456 C0.150162624,3.89904911 0.152268631,3.89694235 0.154393339,3.89485454 Z" id="arrow-icon-three"></path>
                                                    </g>
                                                </svg>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="cuntanidorimgs">
                                    <div class="imglateral" id="leftImg">
                                        <a href="#"><img src="" alt="Pokémon esquerra"></a>
                                    </div>
                                    <div class="imgcentre" id="centerImg">
                                        <a href="#"><img src="" alt="Pokémon centre"></a>
                                    </div>
                                    <div class="imglateral" id="rightImg">
                                        <a href="#"><img src="" alt="Pokémon dreta"></a>
                                    </div>
                                </div>
                                <div class="seguent">
                                    <div class="btn-conteiner">
                                        <a href="#" class="btn-content">
                                            <span class="icon-arrow">
                                                <svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 66 43" height="30px" width="30px">
                                                    <g fill-rule="evenodd" fill="none" stroke-width="1" stroke="none" id="arrow">
                                                        <path d="M40.1543933,3.89485454 L43.9763149,0.139296592 C44.1708311,-0.0518420739 44.4826329,-0.0518571125 44.6771675,0.139262789 L65.6916134,20.7848311 C66.0855801,21.1718824 66.0911863,21.8050225 65.704135,22.1989893 C65.7000188,22.2031791 65.6958657,22.2073326 65.6916762,22.2114492 L44.677098,42.8607841 C44.4825957,43.0519059 44.1708242,43.0519358 43.9762853,42.8608513 L40.1545186,39.1069479 C39.9575152,38.9134427 39.9546793,38.5968729 40.1481845,38.3998695 C40.1502893,38.3977268 40.1524132,38.395603 40.1545562,38.3934985 L56.9937789,21.8567812 C57.1908028,21.6632968 57.193672,21.3467273 57.0001876,21.1497035 C56.9980647,21.1475418 56.9959223,21.1453995 56.9937605,21.1432767 L40.1545208,4.60825197 C39.9574869,4.41477773 39.9546013,4.09820839 40.1480756,3.90117456 C40.1501626,3.89904911 40.1522686,3.89694235 40.1543933,3.89485454 Z" id="arrow-icon-one"></path>
                                                        <path d="M20.1543933,3.89485454 L23.9763149,0.139296592 C24.1708311,-0.0518420739 24.4826329,-0.0518571125 24.6771675,0.139262789 L45.6916134,20.7848311 C46.0855801,21.1718824 46.0911863,21.8050225 45.704135,22.1989893 C45.7000188,22.2031791 45.6958657,22.2073326 45.6916762,22.2114492 L24.677098,42.8607841 C24.4825957,43.0519059 24.1708242,43.0519358 23.9762853,42.8608513 L20.1545186,39.1069479 C19.9575152,38.9134427 19.9546793,38.5968729 20.1481845,38.3998695 C20.1502893,38.3977268 20.1524132,38.395603 20.1545562,38.3934985 L36.9937789,21.8567812 C37.1908028,21.6632968 37.193672,21.3467273 37.0001876,21.1497035 C36.9980647,21.1475418 36.9959223,21.1453995 36.9937605,21.1432767 L20.1545208,4.60825197 C19.9574869,4.41477773 19.9546013,4.09820839 20.1480756,3.90117456 C20.1501626,3.89904911 20.1522686,3.89694235 20.1543933,3.89485454 Z" id="arrow-icon-two"></path>
                                                        <path d="M0.154393339,3.89485454 L3.97631488,0.139296592 C4.17083111,-0.0518420739 4.48263286,-0.0518571125 4.67716753,0.139262789 L25.6916134,20.7848311 C26.0855801,21.1718824 26.0911863,21.8050225 25.704135,22.1989893 C25.7000188,22.2031791 25.6958657,22.2073326 25.6916762,22.2114492 L4.67709797,42.8607841 C4.48259567,43.0519059 4.17082418,43.0519358 3.97628526,42.8608513 L0.154518591,39.1069479 C-0.0424848215,38.9134427 -0.0453206733,38.5968729 0.148184538,38.3998695 C0.150289256,38.3977268 0.152413239,38.395603 0.154556228,38.3934985 L16.9937789,21.8567812 C17.1908028,21.6632968 17.193672,21.3467273 17.0001876,21.1497035 C16.9980647,21.1475418 16.9959223,21.1453995 16.9937605,21.1432767 L0.15452076,4.60825197 C-0.0425130651,4.41477773 -0.0453986756,4.09820839 0.148075568,3.90117456 C0.150162624,3.89904911 0.152268631,3.89694235 0.154393339,3.89485454 Z" id="arrow-icon-three"></path>
                                                    </g>
                                                </svg>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mirames">
                            <div class="btn-conteiner">
                                <a href="pokedex.php" class="btn-content pokedex-btn">Pokedex</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- SECCIO POSTS -->
        <section>
            <div class="posts">
                <div class="imag">
                    <img src="../../IMG/movil.png" alt="">
                </div>
                <div class="posts_cont">
                    <h2>Comunitat</h2>
                    <p>Mira tot tipus de combinacions posibles amb equips que la gent crea</p>
                    <p>Si creus que el teu equip és digne, pots publicar-ho per a que la gent ho vegi</p>
                    <div class="btn-conteiner">
                        <a href="posts.php" class="btn-content post-btn">Comunitat</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECCIÓ PREMIUM i UNEIXTE -->
        <section class="premium_uneixte">
            <div class="premium">
                <div class="contingut_premium">
                    <h2>Comença sent el millor</h2>
                    <div class="cont">
                        <div class="titol_foto">
                            <a href="https://pokemondb.net/pokedex/meowth">
                                <img src="https://img.pokemondb.net/sprites/black-white/normal/meowth.png" alt="Meowth">
                            </a>
                        </div>
                        <div class="text_premium">
                            <p>Aprofita a obtenir tot el contingut i aprofitar al maxim tot el que t’oferim.</p>
                            <p>Agafa el nostre pack premium i comença sent el millor</p>
                            <div class="btn-conteiner btn-conteiner_premium">
                                <a href="premium.php" class="btn-content premium-btn">Plans Premium</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="uneixte">
                <div class="uneixte_cont">
                    <h2>Uneix-te i demostre qui té el millor equip del món</h2>
                    <div class="btn-conteiner">
                        <a href="register.php" class="btn-content regis-btn">Registre't</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- FOOTER -->
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
    <script src="../JavaScript/carrousel.js"></script>
</body>
</html>
