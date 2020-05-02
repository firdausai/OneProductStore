<?php
    include '../models/m_auth.php';
    include '../models/m_fetch.php';

    $base_url = 'http://localhost/OneProductStore/';

    $header = check_login_status();
    $product_total = get_product_stock();

?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Store Name</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link rel="stylesheet" href="<?php echo $base_url ?>assets/libs/fontawesome/css/all.css?v=<?php echo filemtime('../../assets/libs/fontawesome/css/all.css') ?>">
		<link rel="stylesheet" href="<?php echo $base_url ?>assets/css/style.css?v=<?php echo filemtime('../../assets/css/style.css') ?>">
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <header id="header-wrapper" class="header-wrapper">
            <div class="header-item text-primary container d-flex">
                <div class="header-logo font-weight-bold mr-auto">
                    <a href="<?php echo $base_url?>">Store Name</a>
                </div>
                <div class="header-item">
                    <?php echo $header ?>
                </div>
            </div>
        </header>
        <main id="content-wrapper" class="content-wrapper container">
            <div class="product-wrapper mx-5 pb-5">
                <div class="product row mb-5 pb-5">
                    <div class="product-img col-6">
                        <img src="<?php echo $base_url ?>assets/img/product.png" alt="Nama Produk">
                    </div>
                    <div class="col-6">
                        <div class="product-detail px-4">
                            <div class="row">
                                <div class="col-8">
                                    <div class="product-title">Nama Produk</div>
                                    <div class="product-info">Produk Slogan</div>
                                </div>
                                <div class="col-4 align-self-center text-right">
                                    <div class="product-price">Rp Harga</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="product-desc">Deskripsi produk <br>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas molestie metus vitae interdum auctor. Vivamus nisl dui, efficitur eu velit ut, luctus dapibus quam. Nullam vulputate orci vitae nisi tincidunt, vel vestibulum enim ornare. Nullam velit eros, dignissim et porttitor quis, ultrices vel tortor.</div>
                                </div>
                            </div>
                            <form action="../models/m_user_order.php" method = 'post'>
                                <div class="my-4 py-2">
                                    <div class="product-qty-ctr input-group">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-number" data-type="minus" data-field="total">-</button>
                                        </span>
                                        <input type="text" name="total" class="form-control input-number text-center" value="1" min="1" max="<?php echo $product_total['total_stock']?>">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-number" data-type="plus" data-field="total">+</button>
                                        </span>
                                    </div>
                                    <div class="product-qty mt-2">Tersedia : <?php echo $product_total['total_stock']?></div>
                                </div>
                                <button type="submit" name = 'index' value = 'order' class="btn btn-primary w-100">Beli</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer id="footer-wrapper" class="footer-wrapper text-white text-center">
            2020 Store Name. All rights reserved
        </footer>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="<?php echo $base_url ?>assets/js/main.js?v=<?php echo filemtime('../../assets/js/main.js') ?>" type="text/javascript"></script>
    </body>
</html>