const subcategoriasPorCategoria = {
    brinquedos: [
        "brinquedos",
        "carrinhos_de_passeio"
    ],
    cozinha: [
        "armarios_de_parede",
        "balcoes",
        "bancadas",
        "fruteiras",
        "kits"
    ],
    eletrodomesticos: [
        "climatizadores",
        "fogoes",
        "fornos_eletricos",
        "lavadoras",
        "utensilios_domesticos",
        "ventiladores"
    ],
    escritorio: [
        "armarios",
        "cadeiras",
        "mesas"
    ],
    quarto_adulto: [
        "camas",
        "colchoes",
        "comodas",
        "guarda-roupas",
        "mesa_de_cabeceira",
        "sapateira-multiuso"
    ],
    quarto_infantil: [
        "ambientes",
        "bercos",
        "camas_infantis",
        "colchoes_infantil",
        "comodas",
        "guarda-roupas_infantil",
        "penteadeiras_infantis",
        "poltrona_infantis"
    ],
    sala_de_estar: [
        "estantes",
        "estofados",
        "homes",
        "mesa_de_centro",
        "paineis",
        "racks"
    ],
    sala_de_jantar: [
        "mesas"
    ]
};

const categoriaSelect = document.getElementById('categoria');

// Obter as chaves (categorias) ordenadas
const categoriasOrdenadas = Object.keys(subcategoriasPorCategoria).sort();

categoriasOrdenadas.forEach(categoria => {
  const option = document.createElement('option');
  option.value = categoria;
  option.textContent = categoria.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
  categoriaSelect.appendChild(option);
});

const subcategoriaSelect = document.getElementById("subcategoria");

categoriaSelect.addEventListener("change", () => {
    const categoriaSelecionada = categoriaSelect.value;
    const subcategorias = subcategoriasPorCategoria[categoriaSelecionada] || [];

    // Limpar opções anteriores
    subcategoriaSelect.innerHTML = "";

    if (subcategorias.length > 0) {
        subcategoriaSelect.innerHTML += `<option value="">Selecione...</option>`;
        subcategorias.forEach(sub => {
            subcategoriaSelect.innerHTML += `<option value="${sub}">${sub.replace(/_/g, ' ')}</option>`;
        });
    } else {
        subcategoriaSelect.innerHTML = `<option value="">Nenhuma subcategoria disponível</option>`;
    }
});