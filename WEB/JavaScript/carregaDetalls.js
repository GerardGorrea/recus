document.addEventListener("DOMContentLoaded", async () => {
  const params = new URLSearchParams(window.location.search);
  const idPublicacio = params.get('id');

  if (!idPublicacio) {
    document.getElementById("detallsContainer").innerText = "ID no trobat a la URL.";
    return;
  }

  try {
    // 1. Obtenir informació del post
    const postRes = await fetch(`../php/get_publicacions.php?id=${idPublicacio}`);
    if (!postRes.ok) throw new Error("Error al carregar la publicació.");

    const postText = await postRes.text();
    let post;
    try {
      post = JSON.parse(postText);
      console.log("Resposta de get_publicacions.php:", post);
    } catch (e) {
      throw new Error("La resposta de get_publicacions.php no és un JSON vàlid:\n" + postText);
    }

    // 2. Obtenir informació de l'equip Pokémon
    const equipId = post.fk_equipPokemon || post.id_equip || post.equip_id || '';
    const equipRes = await fetch(`../php/get_equip_infoPost.php?id=${equipId}`);

    if (!equipRes.ok) {
      const errorText = await equipRes.text();
      try {
        const errorJson = JSON.parse(errorText);
        throw new Error(errorJson.error || "Error desconegut carregant l'equip.");
      } catch {
        throw new Error("Resposta inesperada de get_equip_infoPost.php:\n" + errorText);
      }
    }

    const equipText = await equipRes.text();
    let equip;
    try {
      equip = JSON.parse(equipText);
    } catch (e) {
      throw new Error("La resposta de get_equip_infoPost.php no és un JSON vàlid:\n" + equipText);
    }

    if (equip.error) throw new Error(equip.error);

    if (!equip || !Array.isArray(equip.pokemons) || equip.pokemons.length === 0) {
      throw new Error("No s'ha trobat l'equip o no té pokémons.");
    }

    // 3. Injectar contingut del post
    const container = document.querySelector(".sectDesc");
    container.innerHTML = `
      <div class="fons1 divDescripcio">
        <div class="descripcioEquip">
          <div>
            <h2>${post.titol}</h2>
            <p>${post.descripcio}</p>
          </div>
          <div class="detallEquipDe">
            <img src="${post.imatge_usuari || '../../IMG/default-user.png'}" alt="Usuari">
            <p>${post.nom_usuari || 'Usuari desconegut'}</p>
          </div>
        </div>
      </div>
    `;

    // 4. Mostrar pokémons i preparar clics
    mostraPokemonsEquip(equip.pokemons);

  } catch (err) {
    console.error("Error carregant dades:", err);
    const cont = document.getElementById("detallsContainer");
    if (cont) {
      cont.innerText = "Error carregant el contingut: " + err.message;
    }
  }
});

function mostraPokemonsEquip(pokemons) {
  for (let i = 0; i < 6; i++) {
    const imgElem = document.getElementById(`img_slot0${i+1}`);
    const nomElem = document.getElementById(`nom_slot0${i+1}`);
    const divSlot = document.getElementById(`slot0${i+1}`);

    if (pokemons[i]) {
      imgElem.src = pokemons[i].imatge_final || '../../IMG/pkball.png';
      imgElem.alt = pokemons[i].pokedex?.nom || 'Pokémon';
      nomElem.textContent = pokemons[i].pokedex?.nom || 'Nom desconegut';

      // Afegir atributs data-id i data-slot
      divSlot.setAttribute('data-id', pokemons[i].dades.fk_pokemon);
      console.log("Pokémon ID:", pokemons[i].dades.fk_pokemon);
      divSlot.setAttribute('data-slot', i + 1);

      // Afegir listener per mostrar detalls
      divSlot.addEventListener('click', () => {
        const id = divSlot.getAttribute('data-id');
        const slot = divSlot.getAttribute('data-slot');
        carregarDetallsPokemon(id, slot);
      });

    } else {
      imgElem.src = '../../IMG/pkball.png';
      imgElem.alt = 'Slot buit';
      nomElem.textContent = 'Slot buit';

      divSlot.removeAttribute('data-id');
      divSlot.removeAttribute('data-slot');
    }
  }
}

// Crida AJAX a get_pokemon_detall.php
async function carregarDetallsPokemon(id, slot) {
  try {
    const res = await fetch(`../php/get_pokemon_detall.php?id=${id}&slot=${slot}`);
    const text = await res.text(); // llegim com a text per veure què diu exactament

    let data;
    try {
      data = JSON.parse(text);
    } catch (e) {
      throw new Error("Resposta no vàlida:\n" + text);
    }

    if (data.error) throw new Error(data.error);

    console.log("Detalls del Pokémon:", data);
    // alert(`Detalls de ${data.nom}\nNivell: ${data.nivell}\nShiny: ${data.shiny ? 'Sí' : 'No'}\nMoviments: ${data.moviments.join(', ')}`);
    carregarDadesPkmn(data);
    
  } catch (e) {
    console.error("Error carregant detalls del Pokémon:", e);
    alert("No s'han pogut carregar els detalls del Pokémon:\n" + e.message);
  }
}


function carregarDadesPkmn(data) {
  // CANVI LA IMATGE I EL NOM DEL POKÉMON
  const img = document.getElementById("imgPokemon");
  const nom = document.getElementById("nom_pkmn");

  if (!img || !nom) {
    console.warn("Elements de visualització del Pokémon no trobats");
    return;
  }

  img.src = data.imatge_final || '../../IMG/shilluette.png';
  img.alt = data.nom || 'Pokémon';
  nom.textContent = data.nom || 'Sense nom';
  // CANVI LA IMATGE I EL NOM DEL POKÉMON

  // IVs i EVs
  const ivs = data.ivs || {};
  const evs = data.evs || {};

  const correspondencies = [
    { ivId: 'IvPS', evId: 'EvPS', clau: 'hp' },
    { ivId: 'IvAt', evId: 'EvAt', clau: 'atac' },
    { ivId: 'IvDe', evId: 'EvDe', clau: 'defensa' },
    { ivId: 'IvAtEs', evId: 'EvAtEs', clau: 'sp_atac' },
    { ivId: 'IvDeEs', evId: 'EvDeEs', clau: 'sp_defensa' },
    { ivId: 'IvVel', evId: 'EvVel', clau: 'velocitat' },
  ];

  correspondencies.forEach(({ ivId, evId, clau }) => {
    const inputIv = document.getElementById(ivId);
    const inputEv = document.getElementById(evId);

    if (inputIv) inputIv.value = ivs[clau] ?? 0;
    if (inputEv) inputEv.value = evs[clau] ?? 0;
  });
  // IVs i EVs

  // Moviments, nivell, genere i shiny
  const nivellInput = document.getElementById('nivell');
  if (nivellInput) nivellInput.value = data.nivell ?? 50;

  const radioHome = document.getElementById('signeHome');
  const radioDona = document.getElementById('signeDona');

  if (data.sexe === 'home') {
    radioHome.checked = true;
  } else if (data.sexe === 'dona') {
    radioDona.checked = true;
  }

  const shinyCheckbox = document.getElementById('shiny');
  if (shinyCheckbox) shinyCheckbox.checked = !!data.shiny;

  const moviments = data.moviments || [];

  for (let i = 1; i <= 4; i++) {
    const select = document.getElementById(`move${i}`);
    if (select) {
      select.innerHTML = '';
      const moviment = moviments[i - 1] || '';
      const option = document.createElement('option');
      option.value = moviment;
      option.textContent = moviment || `Moviment ${i}`;
      option.selected = true;
      select.appendChild(option);
    }
  }
  // Moviments, nivell, genere i shiny

  // Estadístiques base del Pokémon (de la pokedex)
  const pokemonId = data.id;  // Aquí sí que has de definir pokemonId

  if (!pokemonId) {
    console.warn('No s\'ha trobat l\'id del Pokémon per carregar les estadístiques base');
    return;
  }

  // Petició AJAX per agafar les estadístiques base
  fetch(`../php/get_bstats.php?id=${pokemonId}`)
    .then(res => res.json())
    .then(baseStatsData => {  // Aquí la resposta la guardem a baseStatsData (no 'data' per evitar conflictes)
      if (!baseStatsData) {
        console.warn("No s'han trobat estadístiques base per a l'id:", pokemonId);
        return;
      }

      // Creem baseStats a partir de la resposta del PHP
      const baseStats = {
        hp: Number(baseStatsData.ps ?? 0),
        atac: Number(baseStatsData.atac ?? 0),
        defensa: Number(baseStatsData.defensa ?? 0),
        sp_atac: Number(baseStatsData.atEspecial ?? 0),
        sp_defensa: Number(baseStatsData.defEspecial ?? 0),
        velocitat: Number(baseStatsData.velocitat ?? 0),
      };

      // Mostrar estadístiques base a la taula
      document.getElementById('statBasePS').textContent = baseStats.hp;
      document.getElementById('statBaseAt').textContent = baseStats.atac;
      document.getElementById('statBaseDe').textContent = baseStats.defensa;
      document.getElementById('statBaseAtEs').textContent = baseStats.sp_atac;
      document.getElementById('statBaseDeEs').textContent = baseStats.sp_defensa;
      document.getElementById('statBaseVel').textContent = baseStats.velocitat;

      // Càlcul de stats modificades
      const var_lvl = Number(data.nivell ?? 50);

      const ivs = data.ivs || {};
      const evs = data.evs || {};

      const var_IvPs = Number(ivs.hp ?? 0);
      const var_IvAt = Number(ivs.atac ?? 0);
      const var_IvDe = Number(ivs.defensa ?? 0);
      const var_IvAtEs = Number(ivs.sp_atac ?? 0);
      const var_IvDefEs = Number(ivs.sp_defensa ?? 0);
      const var_IvVel = Number(ivs.velocitat ?? 0);

      const var_EvPs = Number(evs.hp ?? 0);
      const var_EvAt = Number(evs.atac ?? 0);
      const var_EvDef = Number(evs.defensa ?? 0);
      const var_EvAtEs = Number(evs.sp_atac ?? 0);
      const var_EvDefEs = Number(evs.sp_defensa ?? 0);
      const var_EvVel = Number(evs.velocitat ?? 0);

      const var_calculPs = Math.floor(((2 * baseStats.hp + var_IvPs + Math.floor(var_EvPs / 4)) * var_lvl) / 100) + var_lvl + 10;
      const var_calculAt = Math.floor(((2 * baseStats.atac + var_IvAt + Math.floor(var_EvAt / 4)) * var_lvl) / 100) + 5;
      const var_calculDef = Math.floor(((2 * baseStats.defensa + var_IvDe + Math.floor(var_EvDef / 4)) * var_lvl) / 100) + 5;
      const var_calculAtEs = Math.floor(((2 * baseStats.sp_atac + var_IvAtEs + Math.floor(var_EvAtEs / 4)) * var_lvl) / 100) + 5;
      const var_calculDefEs = Math.floor(((2 * baseStats.sp_defensa + var_IvDefEs + Math.floor(var_EvDefEs / 4)) * var_lvl) / 100) + 5;
      const var_calculVel = Math.floor(((2 * baseStats.velocitat + var_IvVel + Math.floor(var_EvVel / 4)) * var_lvl) / 100) + 5;

      // Mostrar estadístiques modificades
      document.getElementById('numStatPS').textContent = var_calculPs;
      document.getElementById('numStatAt').textContent = var_calculAt;
      document.getElementById('numStatDe').textContent = var_calculDef;
      document.getElementById('numStatAtEs').textContent = var_calculAtEs;
      document.getElementById('numStatDeEs').textContent = var_calculDefEs;
      document.getElementById('numStatVel').textContent = var_calculVel;

      // Suma estadístiques modificades
      const sumaStats = var_calculPs + var_calculAt + var_calculDef + var_calculAtEs + var_calculDefEs + var_calculVel;
      document.getElementById('statBaseTotal').textContent = Object.values(baseStats).reduce((a,b) => a + b, 0);

      // Actualitzar amplada de cada barra segons l'estadística
      const maxStat = 255;
      const statsCalculades = {
        hp: var_calculPs,
        atac: var_calculAt,
        defensa: var_calculDef,
        sp_atac: var_calculAtEs,
        sp_defensa: var_calculDefEs,
        velocitat: var_calculVel,
      };

      const idBarres = {
        hp: 'barraStatPS',
        atac: 'barraStatAtac',
        defensa: 'barraStatDefensa',
        sp_atac: 'barraStatAtEspecial',
        sp_defensa: 'barraStatDefEspecial',
        velocitat: 'barraStatVelocitat',
      };

      Object.entries(idBarres).forEach(([nomStat, idBarra]) => {
        const barra = document.getElementById(idBarra);
        if (barra && statsCalculades[nomStat] !== undefined) {
          let valorLimitat = Math.min(statsCalculades[nomStat], maxStat);
          let percent = (valorLimitat / maxStat) * 100;
          barra.style.width = percent + '%';
        }
      });
    })
    .catch(err => console.error('Error carregant les estadístiques base:', err));
}

