fetch('../php/get_equips.php')
  .then(response => response.json())
  .then(data => {
    const container = document.getElementById('caixes');
    container.innerHTML = ''; // Netejar el contenidor abans d'afegir els equips

    data.forEach((equip, index) => {
      // Crear div principal
      const caixa = document.createElement('div');
      caixa.classList.add('caixa');

      // Capçalera amb nom i menú
      const nomMiniMenu = document.createElement('div');
      nomMiniMenu.classList.add('nomMiniMenu');

      const h3 = document.createElement('h3');
      h3.textContent = `Equip ${index + 1}`;

      const menuOpcionsContainer = document.createElement('div');
      menuOpcionsContainer.classList.add('menuOpcionsContainer');

      const icona = document.createElement('i');
      icona.className = 'bx bx-md bx-dots-horizontal-rounded miniMenu';

      const menuOpcions = document.createElement('div');
      menuOpcions.classList.add('menuOpcions');
      
        // Crear opció de compartir
        const share = document.createElement('p');
        share.innerHTML = "<i class='bx bx-link'></i> Compartir";

        // Crear opció d'eliminar
        const eliminar = document.createElement('p');
        eliminar.innerHTML = "<i class='bx bx-trash'></i> Eliminar";

      // Funció per eliminar l'equip
      eliminar.addEventListener('click', () => {
        const confirmat = confirm('Segur que vols eliminar aquest equip?');
        if (!confirmat) return;

        fetch('../php/delete_equip.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ id_equip: equip.id }) // Assegura't que equip.id està present
        })
        .then(res => res.json())
        .then(response => {
          if (response.success) {
            alert('Equip eliminat correctament');
            location.reload(); // Refrescar la pàgina
          } else {
            alert('Error en eliminar l\'equip');
          }
        })
        .catch(error => {
          console.error('Error eliminant equip:', error);
        });
      });

      // Muntar menú
      menuOpcions.appendChild(share);
      menuOpcions.appendChild(eliminar);
      menuOpcionsContainer.appendChild(icona);
      menuOpcionsContainer.appendChild(menuOpcions);
      nomMiniMenu.appendChild(h3);
      nomMiniMenu.appendChild(menuOpcionsContainer);

      // Contenidor de Pokémon
      const equipDiv = document.createElement('div');
      equipDiv.classList.add('equip');

      for (let i = 0; i < 6; i++) {
        const img = document.createElement('img');
        img.classList.add('equipPokemon');
        img.id = `pokemon${i + 1}`;
        if (equip.pokemons[i]) {
          img.src = equip.pokemons[i].imatge_final;
          img.alt = equip.pokemons[i].pokedex.nom;
        }
        equipDiv.appendChild(img);
      }

      // Muntar tot
      caixa.appendChild(nomMiniMenu);
      caixa.appendChild(equipDiv);
      container.appendChild(caixa);
    });
  })
  .catch(error => {
    console.error('Error carregant els equips:', error);
  });



  ///////////////////// MODAL CANVI IMATGE /////////////////////
document.getElementById('fotoPerfil').onclick = function () {
  document.getElementById('modalCanviImatge').style.display = 'block';
};

document.querySelector('.tancar-modal').onclick = function () {
  document.getElementById('modalCanviImatge').style.display = 'none';
};

window.onclick = function (e) {
  if (e.target == document.getElementById('modalCanviImatge')) {
    document.getElementById('modalCanviImatge').style.display = 'none';
  }
};

// Selecció d’imatge
const imatges = document.querySelectorAll('.img-opcio');
const inputImatge = document.getElementById('inputImatgeSeleccionada');

imatges.forEach(img => {
  img.addEventListener('click', () => {
    imatges.forEach(i => i.classList.remove('seleccionada'));
    img.classList.add('seleccionada');
    inputImatge.value = img.getAttribute('data-path');
  });
});