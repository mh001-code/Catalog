<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baby-di Móveis</title>
    <link rel="stylesheet" href="/Catalog/css/styles.css">
    <link rel="icon" href="../img/icons/favicon1.png" type="image/x-icon">

</head>

<body>
    <div>
        <?php include '../tools/header.html'; ?>
    </div>


    <div>
        <?php include '../tools/menu.html'; ?>
    </div>


    <div class="slider">

        <div class="slides">
            <input type="radio" name="radio-btn" id="radio1">
            <input type="radio" name="radio-btn" id="radio2">

            <div class="slide first">
                <img src='/Catalog/img/banner_images/Copilot_20250620_181933.png' alt="image 1">
            </div>

            <div class="slide">
                <img src='/Catalog/img/banner_images/Copilot_20250620_182029.png' alt="image 2">
            </div>

            <div class="navigation-auto">
                <div class="auto-btn1"></div>
                <div class="auto-btn2"></div>
            </div>
        </div>

        <div class="manual-navigation">
            <label for="radio1" class="manual-btn"></label>
            <label for="radio2" class="manual-btn"></label>
        </div>
    </div>

    <div>
        <?php include '../php/vitrine.php'; ?>
    </div>

    <div>
        <?php include '../tools/footer.html'; ?>
    </div>

    <script src="/Catalog/js/script.js"></script>
</body>

</html>