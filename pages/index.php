<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baby-di Magazine</title>
    <link rel="stylesheet" href="/Catalog/css/styles.css">
    <link rel="icon" href="/Catalog/img/icons/favicon1.png" type="image/x-icon">

</head>

<body>
    <div>
        <?php include '../tools/header.html'; ?>
    </div>


    <div>
        <?php include '../tools/menu.html'; ?>
    </div>


    <div class="slider-container">
        <div class="slider-track">
            <!-- Clone do último (antes do primeiro real) -->
            <div class="slide" data-clone="last"><img src="/Catalog/img/banner_images/entrega.png" alt="Slide 3"></div>

            <!-- Slides reais -->
            <div class="slide"><img src="/Catalog/img/banner_images/parcelamento.png" alt="Slide 1"></div>
            <div class="slide"><img src="/Catalog/img/banner_images/crediario.png" alt="Slide 2"></div>
            <div class="slide"><img src="/Catalog/img/banner_images/entrega.png" alt="Slide 3"></div>

            <!-- Clone do primeiro (após o último real) -->
            <div class="slide" data-clone="first"><img src="/Catalog/img/banner_images/parcelamento.png" alt="Slide 1 clone"></div>
        </div>
    </div>

    <div>
        <?php include '../php/vitrine.php'; ?>
    </div>

    <div>
        <?php include '../tools/promo-video.php'; ?>
    </div>

    <div>
        <?php include '../tools/footer.html'; ?>
    </div>

    <script src="/Catalog/js/script.js?v=<?= time() ?>"></script>
    <script src="/Catalog/js/promo-video.js?v=<?= time() ?>"></script>

</body>

</html>