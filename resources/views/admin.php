<?php
    include '../models/m_auth.php';
    include '../models/m_fetch.php';
    
    $base_url = 'http://localhost/OneProductStore/';

    $header = check_login_status();

    if (isset($_SESSION['role']) === False) {
        header("Location: ../views/login.php");
        exit();
    } else if ($_SESSION['role'] == 0) {
        header("Location: ../views/dashboard.php");
        exit();
    }

    $rows = get_data();
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
            <div class="content-title">Pemesanan Barang</div>
            <div class="admin-wrapper">
            <?php if ($status == 'accept') {?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Barang berhasil dikirim
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php } else if ($status == 'decline') {?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Barang berhasil ditolak
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php } else if ($status == 'stock') {?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Barang berhasil ditambah
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php } else if ($status == 'over') {?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Stok barang tidak cukup untuk memenuhi pesan
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php } ;unset($_SESSION['success']);?>
                <div class="admin row">
                    <div class="col-2">
                        <div class="admin-ctrl">
                            <div class="ctrl-head">Update Barang</div>
                            <div class="ctrl-body">
                                <form action="../models/m_admin.php" method = 'post'>
                                    <div class="form-group m-0">
                                        <label for="product-qty" class="m-0">total Barang</label>
                                        <input type="number" min="0" class="form-control" id="product-qty" name="product-qty">
                                    </div>
                                    <div>Tersedia : <?php echo $product_total['total_stock']?></div>
                                    <input type="hidden" name="total" value="<?php echo $product_total['total_stock']?>">
                                    <button type="submit" name = 'admin' value = 'add' class="btn btn-primary w-100 mt-2">Update</button>
                                </form>    
                            </div>
                        </div>
                    </div>
                    <div class="col-10">
                        <table class="admin-table w-100">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Barang</th>
                                    <th>Qty</th>
                                    <th>Dikirim Ke</th>
                                    <th>Tanggal Pembelian</th>
                                    <th>ID Pesanan</th>
                                    <th>Harga</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if ($rows->num_rows != NULL) { ?>
                                <?php while ($row = mysqli_fetch_assoc($rows)) { ?>
                                    <tr>
                                        <td><?php echo $row['name'] ?></td>
                                        <td>Nama Produk</td>
                                        <td><?php echo $row['total'] ?></td>
                                        <td><?php echo $row['target_address'] ?></td>
                                        <td><?php echo $row['date_purchased'] ?></td>
                                        <td><?php echo $row['id_order'] ?></td>
                                        <td>Rp<?php echo number_format($row['total_harga'], 0, ',', '.') ?></td>
                                        <td>
                                            <div class="trans-action align-self-center text-center">
                                                <a href="../models/m_admin.php?accept=<?php echo $row['id_order'] ?>" class="trans-send fa-stack fa-1x">
                                                    <i class="fas fa-circle fa-stack-2x"></i>
                                                    <i class="fas fa-truck fa-stack-1x fa-inverse"></i>
                                                </a>
                                                <a href="../models/m_admin.php?reject=<?php echo $row['id_order'] ?>" class="trans-delete fa-stack fa-1x">
                                                    <i class="fas fa-circle fa-stack-2x"></i>
                                                    <i class="fas fa-trash fa-stack-1x fa-inverse"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php }?>
                            <?php } else { ?>
                                <tr>
                                    <td class="text-center" colspan="8">Tidak ada pesanan</td>
                                </tr>
                            <?php }?>
                            </tbody>
                        </table>
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