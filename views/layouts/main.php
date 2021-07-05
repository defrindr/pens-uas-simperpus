<html>
    <head>
        <title><?= $this->title ?></title>
        <?php include_once 'assets/topAsset.php' ?>
    </head>
    <body>
        <div class="container">
            <?php include_once 'header.php' ?>
            <?="\n"?>
            <?php include 'content.php' ?>
            <?="\n"?>
            <?php include_once 'footer.php' ?>
            <?="\n"?>
        </div>
        <?php include_once 'assets/bottomAsset.php' ?>
        <?="\n"?>
    </body>
</html>