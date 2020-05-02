<?php
    include '../models/m_auth.php';
    include '../models/m_fetch.php';

    $base_url = 'http://localhost/OneProductStore/';

    $header = check_login_status();

    if (isset($_SESSION['role']) == False) {
        header("Location: ../views/login.php");
        exit();
    } else if ($_SESSION['role'] == 1) {
        header("Location: ../views/admin.php");
        exit();
    }

    $rows = get_data($_SESSION['id_user']);
    $product_total = get_product_stock();

    if (!isset($_SESSION['success'])) {
        $status = null;
    } else {
        $status = $_SESSION['success'];
    }
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>User Dashboard</title>
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
                    <a href="<?php echo $base_url?>">Millenis Corporation</a>
                </div>
                <div class="header-item">
                    <?php echo $header ?>
                </div>
            </div>
        </header>
        <main id="content-wrapper" class="content-wrapper container">
            <div class="dashboard-wrapper">
                <div class="content-title">Pembelian Saya</div>
                <?php if ($status == 'Delete') { ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Barang berhasil dihapus
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php } else if ($status == 'Edit') { ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Barang berhasil diperbarui
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php } else if ($status == 'Fix') { ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Barang tidak bisa diperbarui karena sedang dalam perjalanan
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php } else if ($status == 'Denied') {; ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Barang tidak bisa dihapus karena sedang dalam perjalanan
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php } else if ($status == 'Useless') {?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Barang tidak bisa diperbarui karena ditolak
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php } ;unset($_SESSION['success']);?>
                <div class="product-list row">
                <?php while ($row = mysqli_fetch_assoc($rows)) { ?>
                    <div class="product-item col-3">
                        <div class="product-detail">
                        <?php if ($row['order_status'] == 0) {?>
                            <div class="product-status pending">Pending</div>
                        <?php } else if ($row['order_status'] == 1) {?>
                            <div class="product-status process">Dalam perjalanan</div>
                        <?php } else {?>
                            <div class="product-status reject">Pesanan ditolak</div>
                        <?php } ?>
                            <div class="product-thumb">
                                <img src="<?php echo $base_url ?>assets/img/product.png" alt="Nama Produk">
                            </div>
                            <div class="product-transdetail">
                                <div class="trans-data">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="trans-title">Barang</div>
                                            <div class="trans-desc">Nama Produk</div>
                                        </div>
                                        <div class="col-6">
                                            <div class="trans-title">total</div>
                                            <div class="trans-desc"><?php echo $row['total'] ?></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="trans-title">Dikirim ke</div>
                                            <div class="trans-desc"><?php echo $row['target_address'] ?></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="trans-title">Tanggal pembelian</div>
                                            <div class="trans-desc"><?php echo $row['date_purchased'] ?></div>
                                        </div>
                                        <div class="col-6">
                                            <div class="trans-title">Id pesanan</div>
                                            <div class="trans-desc"><?php echo $row['id_order'] ?></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="trans-title">Harga</div>
                                            <div class="trans-desc">Rp<?php echo number_format($row['total_harga'], 0, ',', '.') ?></div>
                                        </div>
                                        <div class="trans-action align-self-center text-center col-6">
                                            <a class="trans-edit fa-stack fa-1x">
                                                <i class="fas fa-circle fa-stack-2x"></i>
                                                <i class="fas fa-pen fa-stack-1x fa-inverse"></i>
                                            </a>
                                            <a href="../models/m_user_order.php?delete=<?php echo $row['id_order'] ?>" class="trans-delete fa-stack fa-1x">
                                                <i class="fas fa-circle fa-stack-2x"></i>
                                                <i class="fas fa-trash fa-stack-1x fa-inverse"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="trans-data2 d-none">
                                    <form action="../models/m_user_order.php" method = 'post'>
                                        <div class="product-qty-ctr input-group">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-number" data-type="minus" data-field="<?php echo $row['id_order']?>">-</button>
                                            </span>
                                            <input type="text" name="<?php echo $row['id_order']?>" class="form-control input-number text-center" value="<?php echo $row['total']?>" min="1" max="<?php echo $product_total['total_stock']?>">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-number" data-type="plus" data-field="<?php echo $row['id_order']?>">+</button>
                                            </span>
                                        </div>
                                        <div class="product-qty">Tersedia : <?php echo $product_total['total_stock']?></div>
                                        <div class="form-group my-4">
                                            <label for="destAddress" class="m-0">Dikirim ke</label>
                                            <input type="text" class="form-control" id="destAddress" name = 'address' placeholder="Masukkan Alamat" value = "<?php echo $row['target_address']?>">
                                        </div>
                                        <input type="hidden" name="id_order" value="<?php echo $row['id_order']?>">
                                        <button type="submit" name = 'user_dashboard' value = 'edit' class="btn btn-primary w-100">Simpan</button>
                                    </form>
                                    <button type="button" class="trans-back btn btn-link w-100">Kembali</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }?>
                </div>
            </div>
        </main>
        <footer id="footer-wrapper" class="footer-wrapper text-white text-center">
            2020 Millenis Corporation. All rights reserved
        </footer>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="<?php echo $base_url ?>assets/js/main.js?v=<?php echo filemtime('../../assets/js/main.js') ?>" type="text/javascript"></script>
    </body>
</html>