document.addEventListener("DOMContentLoaded", () => {

  console.log("URL Path:", window.location.pathname);

  // Captura o caminho da URL
  const path = window.location.pathname; // ex: /produtos/quarto/guarda-roupas
  const partes = path.split("/").filter(p => p); // remove elementos vazios

  let categoria = null;
  let subcategoria = null;

  const produtosIndex = partes.indexOf("produtos");
  if (produtosIndex !== -1) {
    categoria = partes[produtosIndex + 1] || null;
    subcategoria = partes[produtosIndex + 2] || null;
  }

  console.log("Categoria:", categoria);
  console.log("Subcategoria:", subcategoria);


  // Função para formatar título
  function formatarTitulo(texto) {
    return texto
      .replaceAll('_', ' ')
      .split(' ')
      .map(palavra => palavra.charAt(0).toUpperCase() + palavra.slice(1))
      .join(' ');
  }

  // Atualizar título da página
  const titulo = document.getElementById("titulo-categoria");
  let tituloPagina = "Produtos";

  if (categoria) {
    tituloPagina = formatarTitulo(categoria);
  }

  if (subcategoria) {
    tituloPagina += " - " + formatarTitulo(subcategoria);
  }

  document.title = `${tituloPagina} - Baby-di Magazine`;
  titulo.textContent = tituloPagina;

  // Buscar produtos do PHP
  let url = `/php/get_products.php?categoria=${encodeURIComponent(categoria)}`;
  if (subcategoria) {
    url += `&subcategoria=${encodeURIComponent(subcategoria)}`;
  }


  fetch(url)
    .then(response => response.json())
    .then(produtos => {
      renderizarProdutos(produtos);
    })
    .catch(erro => {
      console.error("Erro ao buscar produtos:", erro);
    });
});

// Função para renderizar os produtos na tela
function renderizarProdutos(produtos) {
  const container = document.getElementById("produtos-container");
  container.innerHTML = "";

  if (!produtos || produtos.length === 0) {
    container.innerHTML = "<h2>Nenhum produto encontrado.</h2>";
    return;
  }

  // Função para remover acentos de strings
function removerAcentos(texto) {
  return texto.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
}

function slugify(texto) {
  return texto
    .normalize("NFD").replace(/[\u0300-\u036f]/g, "") // remove acentos
    .toLowerCase()
    .replace(/[^a-z0-9\s-]/g, '')                    // remove caracteres especiais
    .replace(/\s+/g, '-')                            // troca espaços por hífen
    .replace(/-+/g, '-')                             // evita hífens duplicados
    .trim();                                         // remove espaços das pontas
}

  produtos.forEach(produto => {
    let preco = parseFloat(produto.preco);
    let valorFormatado = preco.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    let valorParcela = Math.floor((produto.preco / 5) * 100) / 100;
    let valorParcelaFormatado = valorParcela.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

    let imgClass = "";
    let precoHTML = `
      <p class="preco"><strong>R$ ${valorFormatado}</strong></p>
      <p class="parcelamento">em 5x de R$ ${valorParcelaFormatado} no cartão!</p>
    `;
    let entrega_montagemHTML = `<span class="entrega_montagem">Entrega e Montagem Grátis!</span>`;
    let crediarioHTML = '<p class = "crediario">Ou em até 12x no Crediário!</p>';
    let nomeSlug = slugify(produto.nome);

    let detalhesHTML = `<a href="/produto/${produto.id}/${nomeSlug}">
                      <button class="btn-ver-mais">Detalhes</button>
                    </a>`;


    let br = '<br>';

    if (produto.indisponivel == 1) {
      imgClass = "img-indisponivel";
      precoHTML = "";  // Remove o preço
      entrega_montagemHTML = "";
      crediarioHTML = "";
      indisponivelTexto = `<p class="indisponivel-text">Produto Indisponível</p>`;
      detalhesHTML = `<button class="btn-ver-mais indisponivel" disabled>Indisponível</button>`;
    } else {
      indisponivelTexto = "";  // Quando estiver disponível, não mostra
    }

    const card = document.createElement("div");
    card.className = "product";

    card.innerHTML = `
      <img src="${produto.imagem}" alt="${produto.nome}" class="${imgClass}">
      <h3>${produto.nome}</h3>
      ${precoHTML}
      ${crediarioHTML}
      ${entrega_montagemHTML}
      ${indisponivelTexto}
      ${detalhesHTML}
    `;

    container.appendChild(card);
  });
}


const form = document.getElementById('product-form');

if (form) {
  form.addEventListener('submit', function (event) {
    event.preventDefault();

    const produto = {
      nome: document.getElementById('nome').value,
      preco: document.getElementById('preco').value,
      descricao: document.getElementById('descricao').value,
      imagem: document.getElementById('imagem').value,
      categoria: document.getElementById('categoria').value,
      subcategoria: document.getElementById('subcategoria').value
    };

    console.log("Produto a ser enviado:", produto);

    fetch('../php/add_product.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(produto)
    })
      .then(response => response.json())
      .then(data => {
        const mensagem = document.getElementById('mensagem');
        mensagem.textContent = data.message;

        if (data.success) {
          mensagem.style.color = 'green';
          form.reset(); // ✅ Correto agora!
        } else {
          mensagem.style.color = 'red';
        }
      })
      .catch(error => console.error('Erro ao enviar produto:', error));
  });
}