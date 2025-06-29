function toggleMenu() {
    const menu = document.querySelector('.menu-category-inner');
    console.log("Toggle menu clicked"); // Log para verificar se a função é chamada
    menu.classList.toggle('active');
    console.log("Menu active class toggled:", menu.classList.contains('active')); // Log para verificar se a classe 'active' está sendo aplicada
}

document.addEventListener("DOMContentLoaded", function () {
    if (window.innerWidth <= 768) { // Somente em telas menores ou iguais a 768px
        const menuItems = document.querySelectorAll(".menu-category-list > li > a");

        menuItems.forEach(item => {
            item.addEventListener("click", function (e) {
                console.log("Menu item clicked:", this); // Log para ver qual item do menu foi clicado
                const submenu = this.nextElementSibling;

                if (submenu && submenu.tagName === "UL") {
                    e.preventDefault(); // Impede redirecionamento só se tiver submenu

                    const allSubmenus = document.querySelectorAll(".menu-category-list ul");

                    allSubmenus.forEach(openSubmenu => {
                        if (openSubmenu !== submenu) {
                            closeSubmenu(openSubmenu);
                        }
                    });

                    // Verifica se o submenu já está aberto e alterna entre aberto/fechado
                    if (submenu.style.maxHeight) {
                        closeSubmenu(submenu);
                    } else {
                        openSubmenu(submenu);
                    }
                } else {
                    // Caso não seja um submenu, faz o redirecionamento normalmente
                    const href = this.getAttribute('href');
                    console.log("Redirecting to:", href); // Log de redirecionamento
                    if (href && href.includes('index.php')) {
                        window.location.href = "../pages/index.php"; // Redireciona para Home
                    } else {
                        window.location.href = href; // Redireciona normalmente
                    }
                }
            });
        });
    }
});

function openSubmenu(submenu) {
    console.log("Opening submenu:", submenu); // Log para verificar quando o submenu é aberto
    submenu.classList.add('visible');
    submenu.style.maxHeight = submenu.scrollHeight + "px"; // Anima a altura para abrir
}

function closeSubmenu(submenu) {
    console.log("Closing submenu:", submenu); // Log para verificar quando o submenu é fechado
    submenu.classList.remove('visible');
    submenu.style.maxHeight = null; // Remove a altura para fechar
}

let count = 1;
document.getElementById("radio1").checked = true;

let interval = setInterval(nextImage, 5000);

function nextImage() {
    count++;
    if (count > 2) {
        count = 1;
    }
    document.getElementById("radio" + count).checked = true;
}

// Função para resetar o temporizador ao clicar em um botão manualmente
function resetTimer(selected) {
    clearInterval(interval); // Para o intervalo atual
    count = selected; // Define a imagem correta
    document.getElementById("radio" + count).checked = true;
    interval = setInterval(nextImage, 5000); // Reinicia o intervalo
}

// Adiciona eventos de clique para cada botão de rádio
document.querySelectorAll('input[name="radio-btn"]').forEach((radio, index) => {
    radio.addEventListener("click", function () {
        resetTimer(index + 1);
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.carousel-container').forEach(container => {
        const carousel = container.querySelector('.carousel');
        const prevBtn = container.querySelector('.prev-btn');
        const nextBtn = container.querySelector('.next-btn');

        function checkScrollLimits() {
            prevBtn.classList.toggle("disabled", carousel.scrollLeft === 0);
            nextBtn.classList.toggle("disabled",
                carousel.scrollLeft + carousel.clientWidth >= carousel.scrollWidth
            );
        }

        // Adiciona evento ao passar o mouse sobre os botões
        [prevBtn, nextBtn].forEach(btn => {
            btn.addEventListener("mouseenter", () => {
                if (btn.classList.contains("disabled")) {
                    btn.style.cursor = "not-allowed"; // Ícone de bloqueio
                } else {
                    btn.style.cursor = "pointer"; // Ícone padrão de clique
                }
            });

            btn.addEventListener("mouseleave", () => {
                btn.style.cursor = ""; // Retorna ao padrão
            });
        });

        // Verifica limites ao rolar
        carousel.addEventListener("scroll", checkScrollLimits);

        // Verifica ao carregar a página
        checkScrollLimits();

        let scrollAmount = 0;
        const scrollStep = window.innerWidth < 768 ? 200 : 400;

        prevBtn.addEventListener('click', () => {
            carousel.scrollBy({ left: -scrollStep, behavior: 'smooth' });
        });

        nextBtn.addEventListener('click', () => {
            carousel.scrollBy({ left: scrollStep, behavior: 'smooth' });
        });

        // Suporte a swipe em dispositivos móveis
        let startX;

        carousel.addEventListener("touchstart", (e) => {
            startX = e.touches[0].clientX;
        });

        carousel.addEventListener("touchmove", (e) => {
            if (!startX) return;

            const currentX = e.touches[0].clientX;
            const diffX = startX - currentX;

            if (Math.abs(diffX) > 50) { // Define um limite para evitar swipes acidentais
                if (diffX > 0) {
                    // Swipe para a esquerda → próxima imagem
                    carousel.scrollBy({ left: scrollStep, behavior: 'smooth' });
                } else {
                    // Swipe para a direita → imagem anterior
                    carousel.scrollBy({ left: -scrollStep, behavior: 'smooth' });
                }

                startX = null; // Reseta após o swipe
            }
        });

        carousel.addEventListener("touchend", () => {
            startX = null;
        });

        carousel.addEventListener("touchmove", (e) => {
            // e.preventDefault(); // use com cautela, pois pode quebrar o scroll normal da página
        }, { passive: false });
    });
});