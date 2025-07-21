window.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById("promo-video-container");
    const closeBtn = document.getElementById("promo-close-btn");
    const fullscreenBtn = document.getElementById("promo-fullscreen-btn");
    const unmuteBtn = document.getElementById("promo-unmute-btn");
    const video = document.getElementById("promo-video");

    if (!container || !video) return;

    closeBtn?.addEventListener("click", () => {
        container.style.display = "none";
        video.pause();
    });

    fullscreenBtn?.addEventListener("click", () => {
        if (video.requestFullscreen) {
            video.requestFullscreen();
        } else if (video.webkitRequestFullscreen) {
            video.webkitRequestFullscreen();
        } else if (video.msRequestFullscreen) {
            video.msRequestFullscreen();
        }
    });

    // Tentativa de autoplay com som
    video.play().then(() => {
        if (video.muted) {
            unmuteBtn.style.display = "block";
        }
    }).catch(err => {
        console.warn("Autoplay bloqueado pelo navegador:", err);
    });

    unmuteBtn?.addEventListener("click", () => {
        video.muted = false;
        unmuteBtn.style.display = "none";
    });
});
