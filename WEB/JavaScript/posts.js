const openBtn = document.getElementById("openModalButton");
const modal = document.getElementById("customModal");
const closeBtn = document.querySelector(".modal .close");

openBtn.addEventListener("click", () => {
    modal.style.display = "block";
});
closeBtn.addEventListener("click", () => {
    modal.style.display = "none";
});
// Tancar si es fa clic fora del contingut
window.addEventListener("click", (event) => {
    if (event.target === modal) {
        modal.style.display = "none";
    }
});

document.addEventListener('DOMContentLoaded', function () {
  const select = document.getElementById('category');
  fetch('../php/get_equips.php')
    .then(response => response.json())
    .then(data => {
      // Netejar el <select>
      select.innerHTML = '<option value="" disabled selected>Selecciona una opció</option>';

      data.forEach(equip => {
        const option = document.createElement('option');
        option.value = equip.id;

        // Generar un text curt amb els noms dels Pokémon
        const nomsPokemons = equip.pokemons.map(p => p.pokedex.nom).join(', ');
        option.textContent = `Equip ${equip.id}: ${nomsPokemons}`;

        select.appendChild(option);
      });
    })
    .catch(error => {
      console.error('Error carregant equips:', error);
    });
});

document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('modalForm');

  form.addEventListener('submit', function(e) {
    e.preventDefault(); // Evitem recàrrega

    const title = document.getElementById('title').value;
    const description = document.getElementById('description').value;
    const category = document.getElementById('category').value;

    fetch('../php/guardar_publicacio.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ title, description, category })
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        console.log('Publicació guardada!');
        form.reset();
        document.getElementById('customModal').style.display = 'none';
        // Aquí podries afegir recarregar posts o afegir el nou post directament
      } else {
        console.log('Error: ' + data.message);
      }
    })
    .catch(err => {
      console.error('Error AJAX:', err);
      console.log('Error de xarxa');
    });
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const container = document.getElementById('posts');
  container.innerHTML = ''; // Netejar el contenidor abans de carregar els posts

  // Funció per obtenir l'equip per ID (retorna un objecte o null)
    async function getEquip(idEquip) {
    if (!idEquip) {
        console.warn('getEquip: idEquip no proporcionat o fals:', idEquip);
        return null;
    }

    try {
        const res = await fetch(`../php/get_equips_post.php?id=${idEquip}`);
        console.log(`getEquip: resposta de fetch per id=${idEquip}:`, res);

        if (!res.ok) {
            console.error('getEquip: resposta no OK:', res.status, res.statusText);
        return null;
        }

        const data = await res.json();
        // console.log('getEquip: dades JSON rebudes:', data);

        if (!data || data.error) {
        console.warn('getEquip: dades errònies o error:', data?.error);
        return null;
        }

        if (!data.pokemons || !Array.isArray(data.pokemons)) {
        console.warn('getEquip: dades.pokemons no és un array o no existeix:', data.pokemons);
        return null;
        }

        return data;
    } catch (err) {
        console.error('getEquip: error atrapant la petició:', err);
        return null;
    }
    }


  async function carregarPublicacions() {
    try {
      const res = await fetch('../php/get_publicacions.php');
      if (!res.ok) throw new Error('Error carregant publicacions');
      const posts = await res.json();

      for (const post of posts) {
        const equip = await getEquip(post.id_equip);  
        // console.log('Equip rebut:', equip, 'per al post:', post.id_equip);


        const div = document.createElement('div');
        div.classList.add('post');
        console.log(post);

        div.innerHTML = `
  <div class="titolPost">
    <h2>${post.titol}</h2>
    <div class="UserPost">
      <img src="${post.imatge_usuari}" alt="Usuari">
      <h3>${post.nom_usuari}</h3>
    </div>
  </div>
  <div class="equipDescripcioPost">
    <div class="equipPost">
      <div class="titolEquipDetalls">
        <h3>Equip</h3>
        <a href="mesDetalls.php?id=${post.ID_publicacio}">+ detalls</a>
      </div>
      <div class="equipUserPost">
        ${
          equip && Array.isArray(equip.pokemons) && equip.pokemons.length > 0
            ? equip.pokemons.map(pokemon => 
                `<div class="pokemonsPost">
                  <img src="${pokemon.imatge_final}" alt="${pokemon.pokedex.nom}">
                </div>`
              ).join('')
            : '<p>no carga els pokemons</p>'
        }
      </div>
    </div>
    <div class="descripcioPost">
      <p>${post.descripcio}</p>
    </div>
  </div>
`;


        container.appendChild(div);
      }

      // Afegim aquí el listener per a tots els botons + DETALLS
      document.querySelectorAll('.btn-mes-detalls').forEach(boto => {
        boto.addEventListener('click', event => {
          event.preventDefault();
          const idEquip = boto.getAttribute('data-id-equip');
        //   console.log('Clicat + DETALLS per l\'equip amb ID:', idEquip);

          // Aquí pots posar la funció per fer la crida AJAX i mostrar els detalls
          // Exemple:
          // carregarDetallsEquip(idEquip);
        });
      });

    } catch (err) {
      console.error('Error carregant publicacions:', err);
    }
  }

  carregarPublicacions();
});
