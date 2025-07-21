document.getElementById('product-form').addEventListener('submit', function (event) {
  event.preventDefault();

  const form = document.getElementById('product-form');
  const formData = new FormData(form); // Cria o FormData com todos os campos automaticamente

  // Checkbox: garantir valor 0 se não marcado
  formData.set('destaque', document.getElementById('destaque').checked ? 0 : 1);
  formData.set('mais_vendido', document.getElementById('mais_vendido').checked ? 0 : 1);
  formData.set('indisponivel', document.getElementById('indisponivel').checked ? 0 : 1);

  fetch('/Catalog/manager/php/add_product.php', {
    method: 'POST',
    body: formData // Envia o FormData diretamente
  })
    .then(response => response.json())
    .then(data => {
      const mensage = document.getElementById('mensage');
      mensage.textContent = data.message;
      mensage.style.color = data.success ? 'green' : 'red';

      if (data.success) limparFormularioAddProduto(); // Limpa completamente o formulário

      // Limpa a mensage após 5 segundos
      setTimeout(() => {
        mensage.textContent = '';
      }, 5000);
    })
    .catch(error => {
      console.error('Erro ao enviar produto:', error);
    });
});

function atualizarPreview(inputId, previewId) {
  const input = document.getElementById(inputId);
  const preview = document.getElementById(previewId);
  if (!input || !preview) return;

  input.addEventListener('change', () => {
    const file = input.files[0];
    if (file) {
      // Libera URL antiga para evitar vazamento de memória
      if (preview.src) {
        URL.revokeObjectURL(preview.src);
      }
      const url = URL.createObjectURL(file);
      preview.src = url;
      preview.style.display = 'block';
    } else {
      preview.src = '';
      preview.style.display = 'none';
    }
  });
}

// Inicializa previews para todas as imagens
atualizarPreview('imagem', 'preview-imagem');
atualizarPreview('imagem_2', 'preview-imagem_2');
atualizarPreview('imagem_3', 'preview-imagem_3');
atualizarPreview('imagem_4', 'preview-imagem_4');
atualizarPreview('imagem_5', 'preview-imagem_5');
atualizarPreview('imagem_6', 'preview-imagem_6');
atualizarPreview('imagem_7', 'preview-imagem_7');
atualizarPreview('imagem_8', 'preview-imagem_8');

function limparFormularioAddProduto() {
  const form = document.getElementById('product-form');
  form.reset();

  // Limpa os campos ocultos com nomes de arquivos
  ['imagem', 'imagem_2', 'imagem_3', 'imagem_4', 'imagem_5', 'imagem_6', 'imagem_7', 'imagem_8'].forEach(id => {
    const input = document.getElementById(id);
    if (input) input.value = '';
  });

  // Limpa os previews de imagem
  ['preview-imagem', 'preview-imagem_2', 'preview-imagem_3', 'preview-imagem_4', 'preview-imagem_5', 'preview-imagem_6', 'preview-imagem_7', 'preview-imagem_8'].forEach(id => {
    const img = document.getElementById(id);
    if (img) {
      img.src = '';
      img.style.display = 'none';
    }
  });

  // Limpa mensagens após 5 segundos
  setTimeout(() => {
    const mensage = document.getElementById('mensage');
    if (mensage) mensage.textContent = '';
  }, 5000);
}

