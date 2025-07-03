document.addEventListener("DOMContentLoaded", () => {
  let id;

  // Tenta obter o id da query string primeiro
  const params = new URLSearchParams(window.location.search);
  id = params.get("id");

  // Se não houver id na query, tenta extrair da URL amigável
  if (!id) {
    const pathParts = window.location.pathname.split('/');
    const indexProduto = pathParts.indexOf('produto');

    if (indexProduto !== -1 && pathParts.length > indexProduto + 1) {
      id = pathParts[indexProduto + 1];
    }
  }

  if (!id) {
    document.body.innerHTML = "<p>ID do produto não encontrado.</p>";
    return;
  }

  function slugify(texto) {
    return texto
  }


  fetch('/Catalog/php/get_product_by_id.php?id=' + id)
    .then(response => response.json())
    .then(produto => {
      const whatsappDiv = document.getElementById("whatsapp-link");
      const numeroWhatsApp = "556298337222";
      const mensagem = `Olá, tenho interesse no produto "${produto.nome}". Poderia me dar mais detalhes?`;
      const linkWhatsApp = `https://wa.me/${numeroWhatsApp}?text=${encodeURIComponent(mensagem)}`;

      whatsappDiv.innerHTML = `
        <a href="${linkWhatsApp}" target="_blank" class="btn-whatsapp">
          Falar sobre este produto
          <img src="/Catalog/img/icons/whatsapp_icon.svg" alt="WhatsApp" class="icon-whatsapp" />
        </a>
      `;

      const crediarioDiv = document.getElementById("crediario-link");
      const crediarioMensagem = `Olá, tenho interesse em fazer a simulação no Crediário do produto "${produto.nome}".`;
      const linkCrediario = `https://wa.me/${numeroWhatsApp}?text=${encodeURIComponent(crediarioMensagem)}`;

      crediarioDiv.innerHTML = `
      <a href="${linkCrediario}" target="_blank" class="btn-crediario">
      💳 Simular Crediário!
      </a>
      `;

      if (!produto || !produto.nome) {
        document.body.innerHTML = "<p>Produto não encontrado.</p>";
        return;
      }

      const imagens = [];
      if (produto.imagem) imagens.push(produto.imagem);
      if (produto.imagem_2) imagens.push(produto.imagem_2);
      if (produto.imagem_3) imagens.push(produto.imagem_3);
      if (produto.imagem_4) imagens.push(produto.imagem_4);

      document.title = produto.nome + " - Baby-di Móveis";
      document.getElementById("nome-produto").textContent = produto.nome;

      const imagemPrincipal = document.getElementById("imagem-principal");
      imagemPrincipal.src = imagens[0] || "";

      const modal = document.getElementById("zoomModal");
      const imagemZoomada = document.getElementById("imagemZoomada");

      imagemPrincipal.addEventListener("click", () => {
        imagemZoomada.src = imagemPrincipal.src;
        modal.style.display = "flex";
      });

      imagemZoomada.style.position = "absolute";
      imagemZoomada.setAttribute("draggable", "false");

      let isDragging = false;
      let arrastou = false;
      let startX = 0;
      let startY = 0;
      let initialLeft = 0;
      let initialTop = 0;

      imagemZoomada.addEventListener("mousedown", (e) => {
        if (!imagemZoomada.classList.contains("zoomed")) return;

        startX = e.clientX;
        startY = e.clientY;
        initialLeft = parseInt(imagemZoomada.style.left) || 0;
        initialTop = parseInt(imagemZoomada.style.top) || 0;
        isDragging = true;
        arrastou = false;

        imagemZoomada.style.cursor = "grabbing";

        const onMouseMove = (moveEvent) => {
          if (!isDragging) return;

          const dx = moveEvent.clientX - startX;
          const dy = moveEvent.clientY - startY;

          if (Math.abs(dx) > 5 || Math.abs(dy) > 5) {
            arrastou = true;
          }

          let newLeft = initialLeft + dx;
          let newTop = initialTop + dy;

          // ✅ Limites
          const modalRect = modal.getBoundingClientRect();
          const imgRect = imagemZoomada.getBoundingClientRect();

          const maxLeft = 0;
          const maxTop = 0;
          const minLeft = modalRect.width - imgRect.width;
          const minTop = modalRect.height - imgRect.height;

          // Mantém dentro dos limites
          if (newLeft < minLeft) newLeft = minLeft;
          if (newLeft > maxLeft) newLeft = maxLeft;

          if (newTop < minTop) newTop = minTop;
          if (newTop > maxTop) newTop = maxTop;

          imagemZoomada.style.left = `${newLeft}px`;
          imagemZoomada.style.top = `${newTop}px`;
        };

        const onMouseUp = () => {
          isDragging = false;
          imagemZoomada.style.cursor = "grab";
          document.removeEventListener("mousemove", onMouseMove);
          document.removeEventListener("mouseup", onMouseUp);
        };

        document.addEventListener("mousemove", onMouseMove);
        document.addEventListener("mouseup", onMouseUp);
      });

      imagemZoomada.addEventListener("click", (e) => {
        if (arrastou) {
          e.preventDefault();
          return;
        }

        imagemZoomada.classList.toggle("zoomed");

        if (imagemZoomada.classList.contains("zoomed")) {
          imagemZoomada.style.width = "120%";
          imagemZoomada.style.height = "100%";
          imagemZoomada.style.left = "20";
          imagemZoomada.style.top = "20";
          imagemZoomada.style.cursor = "grab";
        } else {
          imagemZoomada.style.width = "";
          imagemZoomada.style.height = "";
          imagemZoomada.style.left = "";
          imagemZoomada.style.top = "";
          imagemZoomada.style.cursor = "";
        }
      });

      const miniaturasContainer = document.querySelector(".miniaturas");
      miniaturasContainer.innerHTML = "";

      imagens.forEach((src, index) => {
        const miniatura = document.createElement("img");
        miniatura.src = src;
        miniatura.alt = `Imagem ${index + 1}`;
        miniatura.className = "miniatura";
        if (index === 0) miniatura.classList.add("ativa");
        miniatura.onclick = () => trocarImagem(miniatura);
        miniaturasContainer.appendChild(miniatura);
      });

      const descricaoFormatada = produto.descricao
        .replace(/([.?!:])\s*/g, '$1<br>')
        .replace(/\n/g, '<br>');
      document.getElementById("descricao-produto").innerHTML = descricaoFormatada;

      const preco = parseFloat(produto.preco);
      const aviso = document.getElementById("aviso-parcelamento");
      aviso.textContent = "Atenção: para parcelamentos acima de 5x, poderá haver acréscimo no valor total.";
      aviso.classList.add("aviso-parcelamento");

      const crediario = document.getElementById("crediario");
      crediario.textContent = "Ou em até 12x no Crediário!"
      crediario.classList.add("crediario");

      const valorParcela = Math.floor((preco / 5) * 100) / 100;
      const valorParcelaFormatado = valorParcela.toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });

      const valorDesconto = preco - (preco * 0.10);
      const valorDescontoFormatado = valorDesconto.toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });

      const precoFormatado = preco.toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL'
      });

      document.getElementById("preco-produto").innerHTML = `
        <strong>${precoFormatado}</strong><br>
        <span class="parcelamento">ou em 5x de R$ ${valorParcelaFormatado}</span><br>
      `;

      const navCategorias = document.getElementById("navegacao-categorias");

      const categoriaNomeFormatada = produto.categoria.replace(/_/g, " ");
      const categoriaSlug = slugify(produto.categoria);
      const linkCategoria = `<a href="/Catalog/produtos/${categoriaSlug}">${categoriaNomeFormatada}</a>`;


      let linkSubcategoria = "";

      if (produto.subcategoria) {
        const subcategoriaNomeFormatada = produto.subcategoria.replace(/_/g, " ");
        const subcategoriaSlug = slugify(produto.subcategoria);
        linkSubcategoria = ` > <a href="/Catalog/produtos/${categoriaSlug}/${subcategoriaSlug}">${subcategoriaNomeFormatada}</a>`;

      }

      navCategorias.innerHTML = linkCategoria + linkSubcategoria;

    })
    .catch(erro => {
      console.error("Erro ao buscar produto:", erro);
      document.body.innerHTML = "<p>Erro ao carregar produto.</p>";
    });
});

function trocarImagem(miniaturaClicada) {
  document.getElementById("imagem-principal").src = miniaturaClicada.src;
  document.querySelectorAll('.miniatura').forEach(img => img.classList.remove('ativa'));
  miniaturaClicada.classList.add('ativa');
}

function fecharZoom(event) {
  const modal = document.getElementById("zoomModal");
  if (event.target === modal || event.target.classList.contains('fechar-btn')) {
    modal.style.display = "none";
  }
}
