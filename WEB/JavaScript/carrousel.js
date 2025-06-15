document.addEventListener('DOMContentLoaded', () => {
    // Array amb les 9 primeres imatges de Pokémon (003M és especial)
    const pokemons = Array.from({ length: 9 }, (_, i) => {
        const id = String(i + 1).padStart(3, '0');
        if (id === '003') return `../../IMG/Pokemons/003M.png`;
        return `../../IMG/Pokemons/${id}.png`;
    });

    let currentIndex = 1; // Índex central

    // Elements contenedor on insertarem l'estructura HTML completa
    const leftDiv = document.querySelector('#leftImg');
    const centerDiv = document.querySelector('#centerImg');
    const rightDiv = document.querySelector('#rightImg');

    // Funció per extreure l'id numèric de la ruta de la imatge
    function getIdFromPath(path) {
        // Busca 3 dígits seguits possiblement de "M" i l'extensió .png
        const match = path.match(/(\d{3})M?\.png$/i);
        return match ? parseInt(match[1], 10) : null;
    }

    // Funció que crea l'HTML de cada Pokémon per posar dins el div
    function crearHTMLPokemon(imgPath) {
        const id = getIdFromPath(imgPath);
        const idStr = String(id).padStart(3, '0');
        return `
            <a href="pokedexDetall.php?id=${id}">
                <div class="divPkmn">
                    <p>#${idStr}</p>
                    <img src="${imgPath}" alt="Pokemon ${idStr}">
                    <p>Pokemon ${idStr}</p>
                </div>
            </a>
        `;
    }

    // Actualitza les imatges i els enllaços dins dels divs
    function updateImages() {
        const left = (currentIndex - 1 + pokemons.length) % pokemons.length;
        const center = currentIndex;
        const right = (currentIndex + 1) % pokemons.length;

        leftDiv.innerHTML = crearHTMLPokemon(pokemons[left]);
        centerDiv.innerHTML = crearHTMLPokemon(pokemons[center]);
        rightDiv.innerHTML = crearHTMLPokemon(pokemons[right]);
    }

    // Botons per canviar d'imatge
    const prevBtn = document.querySelector('.anterior .btn-content');
    const nextBtn = document.querySelector('.seguent .btn-content');

    prevBtn.addEventListener('click', (e) => {
        e.preventDefault();
        currentIndex = (currentIndex - 1 + pokemons.length) % pokemons.length;
        updateImages();
    });

    nextBtn.addEventListener('click', (e) => {
        e.preventDefault();
        currentIndex = (currentIndex + 1) % pokemons.length;
        updateImages();
    });

    // Inicialitza el carrusel
    updateImages();
});
