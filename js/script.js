function toggleMenu() {
    const menu = document.querySelector('.menu-category-inner');
    const botaoMenu = document.querySelector('.menu-icon');

    // Alterna visibilidade do menu
    menu.classList.toggle('active');
    botaoMenu.classList.toggle('active');

    // Se o menu foi fechado, também fechamos todos os submenus
    if (!menu.classList.contains('active')) {
        const allSubmenus = document.querySelectorAll(".menu-category-list ul");

        allSubmenus.forEach(submenu => {
            closeSubmenu(submenu); // fecha todos
        });
    }

    console.log("Toggle menu clicked. Menu is active:", menu.classList.contains('active'));
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
                        window.location.href = "/index.php"; // Redireciona para Home
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

(() => {
    document.addEventListener('DOMContentLoaded', () => {
        const track = document.querySelector('.slider-track');
        const slides = document.querySelectorAll('.slide');
        const totalSlides = slides.length;
        let index = 1;
        let isTransitioning = false;
        let interval;

        function moveToSlide(i, transitionType = 'auto') {
            isTransitioning = true;

            if (transitionType === 'auto') {
                track.style.transition = "transform 2s cubic-bezier(0.77, 0, 0.175, 1)";
            } else if (transitionType === 'touch') {
                track.style.transition = "transform 0.3s ease";
            }

            track.style.transform = `translateX(-${i * 100}%)`;
        }


        function nextSlide() {
            if (isTransitioning) return;
            index++;
            moveToSlide(index, 'auto');
        }


        function startAutoSlide() {
            interval = setInterval(nextSlide, 4000);
        }

        function stopAutoSlide() {
            clearInterval(interval);
        }

        startAutoSlide();

        track.addEventListener('transitionend', () => {
            isTransitioning = false;

            const currentSlide = slides[index];
            const cloneType = currentSlide.dataset.clone;

            if (cloneType) {
                track.style.transition = "none";
                if (cloneType === "first") {
                    index = 1;
                } else if (cloneType === "last") {
                    index = totalSlides - 2;
                }
                track.style.transform = `translateX(-${index * 100}%)`;
            }
        });

        track.addEventListener('mouseenter', stopAutoSlide);
        track.addEventListener('mouseleave', startAutoSlide);

        // === TOUCH HANDLING ===
        let startX = 0;
        let currentX = 0;
        let isDragging = false;

        const getTranslatePercent = () => -index * 100;

        const setTranslatePercent = (percent, withTransition = false) => {
            track.style.transition = withTransition ? 'transform 0.4s ease' : 'none';
            track.style.transform = `translateX(${percent}%)`;
        };

        track.addEventListener('touchstart', (e) => {
            if (isTransitioning) return;

            stopAutoSlide();
            isDragging = true;
            startX = e.touches[0].clientX;
            currentX = startX;
            track.style.transition = 'none';
        }, { passive: false }); // <-- aqui

        track.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            currentX = e.touches[0].clientX;
            const deltaX = currentX - startX;
            const percent = getTranslatePercent() + (deltaX / window.innerWidth) * 100;
            setTranslatePercent(percent);
            e.preventDefault(); // <-- aqui
        }, { passive: false }); // <-- aqui

        track.addEventListener('touchend', () => {
            if (!isDragging) return;
            isDragging = false;
            const deltaX = currentX - startX;

            if (slides[index].dataset.clone === "first") {
                index = 1;
                setTranslatePercent(-index * 100, false);
                return;
            }

            if (slides[index].dataset.clone === "last") {
                index = totalSlides - 2;
                setTranslatePercent(-index * 100, false);
                return;
            }

            if (deltaX > 50 && index > 0) {
                index--;
            } else if (deltaX < -50 && index < totalSlides - 1) {
                index++;
            }

            moveToSlide(index, 'touch');
            startAutoSlide();
        }, { passive: false }); // <-- também pode adicionar

        window.addEventListener('resize', () => {
            track.style.transition = 'none';
            track.style.transform = `translateX(-${index * 100}%)`;
        });
    });
})();

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('.carousel-container').forEach(container => {
        const track = container.querySelector('.carousel');
        const prevBtn = container.querySelector('.prev-btn');
        const nextBtn = container.querySelector('.next-btn');

        // Configura rolagem por clique nos botões
        prevBtn.addEventListener("click", () => {
            track.scrollBy({ left: -400, behavior: "smooth" });
        });

        nextBtn.addEventListener("click", () => {
            track.scrollBy({ left: 400, behavior: "smooth" });
        });

        // Lógica de arraste com mouse e toque
        let isDragging = false;
        let startX = 0;
        let scrollStart = 0;

        const startDrag = (clientX) => {
            isDragging = true;
            startX = clientX;
            scrollStart = track.scrollLeft;
            track.classList.add("dragging");
        };

        const onMove = (clientX) => {
            if (!isDragging) return;
            const distance = (clientX - startX);
            track.scrollLeft = scrollStart - distance;
        };

        const endDrag = () => {
            isDragging = false;
            track.classList.remove("dragging");
        };

        // Eventos para mouse
        track.addEventListener("mousedown", (e) => startDrag(e.pageX));
        track.addEventListener("mousemove", (e) => onMove(e.pageX));
        track.addEventListener("mouseup", endDrag);
        track.addEventListener("mouseleave", endDrag);

        // Eventos para touch
        track.addEventListener("touchstart", (e) => startDrag(e.touches[0].pageX));
        track.addEventListener("touchmove", (e) => onMove(e.touches[0].pageX));
        track.addEventListener("touchend", endDrag);
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("SearchFilter");
    const sugestoes = document.getElementById("sugestoes");

    if (input && sugestoes) {
        input.addEventListener("input", async () => {
            const query = input.value.trim();

            if (query.length < 2) {
                sugestoes.innerHTML = '';
                sugestoes.classList.add('vazio');
                return;
            }

            const response = await fetch(`/php/search_suggestion.php?q=${encodeURIComponent(query)}`);
            const dados = await response.json();

            sugestoes.innerHTML = '';

            if (dados.length === 0) {
                sugestoes.classList.add('vazio');
                return;
            }

            sugestoes.classList.remove('vazio');

            dados.forEach(produto => {
                const item = document.createElement("div");
                item.textContent = produto.nome;
                item.style.cursor = 'pointer';

                item.addEventListener("click", () => {
                    const slug = produto.nome
                        .normalize("NFD").replace(/[\u0300-\u036f]/g, "") // remove acentos
                        .toLowerCase()
                        .replace(/[^a-z0-9\s-]/g, "") // remove caracteres especiais
                        .replace(/\s+/g, "-") // substitui espaços por hífens
                        .replace(/-+/g, "-") // evita múltiplos hífens

                    window.location.href = `/produto/${produto.id}/${slug}`;
                });

                sugestoes.appendChild(item);
            });
        });

        document.addEventListener("click", (e) => {
            if (!sugestoes.contains(e.target) && e.target !== input) {
                sugestoes.innerHTML = '';
                sugestoes.classList.add('vazio');
            }
        });
    }
});





