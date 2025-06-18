const subcategoriasPorCategoria = {
    quarto: [
        "guarda-roupas",
        "sapateira-multiuso",
        "beliche",
        "comodas",
        "cabeceiras_casal",
        "cabeceira_solteiro",
        "mesa_de_cabeceira",
        "penteadeira",
        "camas_casal",
        "colchao",
        "bases_box",
        "cama_de_solteiro",
        "infantil"
    ],
    cozinha: [
        "balcao",
        "banqueta",
        "bancadas_para_cooktop",
        "fruteiras",
        "cozinhas_kits"
    ],
    sala_de_jantar: [
        "mesas",
        "decoracao"
    ],
    escritorio: [
        "mesas_escrivaninha",
        "cadeiras",
        "livreiro_multiuso"
    ],
    sala_de_estar: [
        "sofas",
        "paineis",
        "estantes",
        "racks",
        "racks_com_paineis",
        "poltronas",
        "mesa_de_centro_apoios"
    ],
    eletrodomesticos: [
        "fogoes",
        "fogoes_cooktop",
        "lavadoras",
        "fornos_eletricos",
        "climatizadores"
    ]
};

const categoriaSelect = document.getElementById("categoria");
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