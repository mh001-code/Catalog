<?php
$configPath = __DIR__ . '/../manager/config/video_config.json';
$videoDir = '/Catalog/manager/videos/';
$config = json_decode(file_get_contents($configPath), true);

if (
    !empty($config['visivel']) &&
    !empty($config['arquivo']) &&
    file_exists($_SERVER['DOCUMENT_ROOT'] . $videoDir . $config['arquivo'])
):
?>
  <div id="promo-video-container">
    <video id="promo-video" controls autoplay muted>
      <source src="<?= $videoDir . htmlspecialchars($config['arquivo']) ?>?v=<?= filemtime($_SERVER['DOCUMENT_ROOT'] . $videoDir . $config['arquivo']) ?>" type="video/mp4">
      Seu navegador não suporta vídeo.
    </video>
    <button id="promo-close-btn" title="Fechar">&times;</button>
    <button id="promo-fullscreen-btn" title="Tela cheia">&#x26F6;</button>
    <button id="promo-unmute-btn" title="Ativar áudio">🔊 Ativar áudio</button>
  </div>
<?php endif; ?>
