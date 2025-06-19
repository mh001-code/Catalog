// Função para remover acentos e normalizar texto
function normalizarTexto(texto) {
    return texto.normalize('NFD').replace(/[\u0300-\u036f]/g, "").toLowerCase();
}

const sugestoesUl = document.getElementById('sugestoes');

// Buscar sugestões enquanto digita
document.getElementById('busca-nome').addEventListener('input', function () {
    const termo = this.value.trim();

    if (termo.length < 2) {
        sugestoesUl.innerHTML = '';
        return;
    }

    fetch(`/Catalog/manager/php/search_products.php?termo=${encodeURIComponent(termo)}`)
        .then(res => res.json())
        .then(produtos => {
            sugestoesUl.innerHTML = '';

            produtos.forEach(produto => {
                const li = document.createElement('li');
                li.textContent = produto.nome;
                li.style.cursor = 'pointer';
                li.style.padding = '5px 10px';
                li.style.border = '1px solid #ccc';
                li.style.marginTop = '5px';
                li.style.background = '#fff';
                li.addEventListener('click', () => carregarProduto(produto.id));
                sugestoesUl.appendChild(li);
            });
        })
        .catch(err => console.error('Erro ao buscar sugestões:', err));
});

// Função que carrega o produto para edição
function carregarProduto(id) {
    fetch(`/Catalog/manager/php/get_product_by_id.php?id=${id}`)
        .then(res => res.json())
        .then(produto => {
            if (!produto || !produto.id) {
                document.getElementById('mensagem').textContent = 'Produto não encontrado.';
                return;
            }

            // Preencher formulário
            document.getElementById('id').value = produto.id;
            document.getElementById('nome').value = produto.nome;
            document.getElementById('preco').value = produto.preco;
            document.getElementById('descricao').value = produto.descricao;
            document.getElementById('imagem').value = produto.imagem;
            document.getElementById('imagem_2').value = produto.imagem_2 || '';
            document.getElementById('imagem_3').value = produto.imagem_3 || '';
            document.getElementById('imagem_4').value = produto.imagem_4 || '';

            // Mostrar imagens atuais
            const mostrarPreview = (idImg, caminho) => {
                const img = document.getElementById(idImg);
                if (!img) return; // se o elemento <img> não existir, sai da função

                if (caminho) {
                    img.src = caminho;
                    img.style.display = 'block';
                } else {
                    img.style.display = 'none';
                }
            };


            const caminhoImagem = nome => {
                if (!nome) return '';
                // Se o nome já contém '/img/product_images/', não concatena
                if (nome.includes('/img/product_images/')) return nome;
                return `/Catalog/img/product_images/${nome}`;
            };


            console.log('Caminho da imagem:', caminhoImagem(produto.imagem));
            mostrarPreview('preview-imagem', caminhoImagem(produto.imagem));

            mostrarPreview('preview-imagem', caminhoImagem(produto.imagem));
            mostrarPreview('preview-imagem_2', caminhoImagem(produto.imagem_2));
            mostrarPreview('preview-imagem_3', caminhoImagem(produto.imagem_3));
            mostrarPreview('preview-imagem_4', caminhoImagem(produto.imagem_4));


            document.getElementById('categoria').value = produto.categoria;
            document.getElementById('categoria').dispatchEvent(new Event('change')); // força o carregamento

            // Aguarda um pequeno tempo para garantir que as <option> já foram adicionadas
            setTimeout(() => {
                document.getElementById('subcategoria').value = produto.subcategoria || '';
            }, 50);

            document.getElementById('subcategoria').value = produto.subcategoria || '';
            document.getElementById('destaque').checked = produto.destaque == 1;
            document.getElementById('mais_vendido').checked = produto.mais_vendido == 1;
            document.getElementById('indisponivel').checked = produto.indisponivel == 1;

            document.getElementById('editar-form').style.display = 'block';
            sugestoesUl.innerHTML = '';
        })
        .catch(err => {
            console.error(err);
            document.getElementById('mensagem').textContent = 'Erro ao buscar produto.';
        });
}

function uploadImagem(inputFileId, hiddenInputId) {
    return new Promise((resolve, reject) => {
        const fileInput = document.getElementById(inputFileId);
        const file = fileInput.files[0];
        if (!file) return resolve(); // se nenhuma imagem nova foi enviada

        const formData = new FormData();
        formData.append('imagem', file);

        fetch('/Catalog/manager/php/upload_image.php', {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(hiddenInputId).value = data.filename;
                    resolve();
                } else {
                    reject(data.message);
                }
            })
            .catch(err => reject('Erro ao enviar imagem: ' + err));
    });
}

// Salvar alterações
document.getElementById('editar-form').addEventListener('submit', async function (e) {
    e.preventDefault();

    try {
        // Faz upload de cada imagem, se houver
        await uploadImagem('upload-imagem', 'imagem');
        await uploadImagem('upload-imagem_2', 'imagem_2');
        await uploadImagem('upload-imagem_3', 'imagem_3');
        await uploadImagem('upload-imagem_4', 'imagem_4');

        const produto = {
            id: document.getElementById('id').value,
            nome: document.getElementById('nome').value,
            preco: parseFloat(document.getElementById('preco').value),
            descricao: document.getElementById('descricao').value,
            imagem: document.getElementById('remover-imagem')?.checked ? '' : document.getElementById('imagem').value,
            imagem_2: document.getElementById('remover-imagem_2')?.checked ? '' : document.getElementById('imagem_2').value,
            imagem_3: document.getElementById('remover-imagem_3')?.checked ? '' : document.getElementById('imagem_3').value,
            imagem_4: document.getElementById('remover-imagem_4')?.checked ? '' : document.getElementById('imagem_4').value,
            categoria: document.getElementById('categoria').value,
            subcategoria: document.getElementById('subcategoria').value,
            destaque: document.getElementById('destaque').checked ? 1 : 0,
            mais_vendido: document.getElementById('mais_vendido').checked ? 1 : 0,
            indisponivel: document.getElementById('indisponivel').checked ? 1 : 0
        };


        const res = await fetch('/Catalog/manager/php/update_product.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(produto)
        });

        const data = await res.json();
        document.getElementById('mensagem').textContent = data.message;
        document.getElementById('mensagem').style.color = data.success ? 'green' : 'red';
        if (data.success) {
            limparFormulario(); // Limpa e oculta o formulário quando deu certo
        }
    } catch (err) {
        document.getElementById('mensagem').textContent = err;
        document.getElementById('mensagem').style.color = 'red';
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const btnExcluir = document.getElementById('btn-excluir');
    const inputId = document.getElementById('id');
    const mensagem = document.getElementById('mensagem');

    btnExcluir.addEventListener('click', async () => {
        const produtoId = inputId.value;

        if (!produtoId) {
            alert('Nenhum produto selecionado para excluir.');
            return;
        }

        const confirmar = confirm('Tem certeza que deseja excluir este produto?');
        if (!confirmar) return;

        try {
            const response = await fetch(`/Catalog/manager/php/delete_product.php?id=${encodeURIComponent(produtoId)}`, {
                method: 'GET'
            });

            const data = await response.json();

            if (data.success) {
                mensagem.textContent = 'Produto excluído com sucesso!';
                mensagem.style.color = 'green';
                limparFormulario();
            } else {
                mensagem.textContent = 'Erro ao excluir produto: ' + data.message;
                mensagem.style.color = 'red';
            }
        } catch (error) {
            mensagem.textContent = 'Erro na requisição: ' + error.message;
            mensagem.style.color = 'red';
        }
    });
});

function limparFormulario() {
    const form = document.getElementById('editar-form');
    form.reset(); // Reseta os campos do formulário

    // Limpar o form de busca também
    const formBusca = document.getElementById('buscar-form');
    if (formBusca) formBusca.reset();

    // Limpar campos hidden das imagens (que armazenam nomes dos arquivos)
    document.getElementById('imagem').value = '';
    document.getElementById('imagem_2').value = '';
    document.getElementById('imagem_3').value = '';
    document.getElementById('imagem_4').value = '';

    // Limpar inputs type="file"
    ['upload-imagem', 'upload-imagem_2', 'upload-imagem_3', 'upload-imagem_4'].forEach(id => {
        const inputFile = document.getElementById(id);
        if (inputFile) inputFile.value = '';
    });

    // Limpar campo ID (se quiser esconder produto carregado)
    document.getElementById('id').value = '';

    // Limpar lista de sugestões
    sugestoesUl.innerHTML = '';

    // Ocultar o formulário
    form.style.display = 'none';

    setTimeout(() => {
        document.getElementById('mensagem').textContent = '';
    }, 5000); // limpa após 5 segundos
}


