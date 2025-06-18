document.getElementById('product-form').addEventListener('submit', function (event) {
  event.preventDefault();

  const form = document.getElementById('product-form');
  const formData = new FormData(form); // Cria o FormData com todos os campos automaticamente

  // Checkbox: garantir valor 0 se não marcado
  formData.set('destaque', document.getElementById('destaque').checked ? 0 : 1);
  formData.set('mais_vendido', document.getElementById('mais_vendido').checked ? 0 : 1);
  formData.set('indisponivel', document.getElementById('indisponivel').checked ? 0 : 1);

  fetch('/FurnitureCatalog/manager/php/add_product.php', {
    method: 'POST',
    body: formData // Envia o FormData diretamente
  })
    .then(response => response.json())
    .then(data => {
      const mensagem = document.getElementById('mensagem');
      mensagem.textContent = data.message;
      mensagem.style.color = data.success ? 'green' : 'red';

      if (data.success) form.reset(); // Limpa o formulário

      // Limpa a mensagem após 5 segundos
      setTimeout(() => {
        mensagem.textContent = '';
      }, 5000);
    })
    .catch(error => {
      console.error('Erro ao enviar produto:', error);
    });
});
