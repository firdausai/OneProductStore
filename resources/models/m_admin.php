<?php
/* Model ini berisikan fungsionalitas admin menerima dan membatalkan pesanan
serta menambah stok barang */

    session_start();
    include '../config/database.php';

    if (isset($_POST['admin'])) {
        add_stock();
    }

    if (isset($_GET['reject'])) {
        decline();
    } else if (isset($_GET['accept'])){
        accept();
    }
    
    function add_stock() {
        /* Menambah total stok barang */

        global $conn;

        $total = $_POST['product-qty'] + $_POST['total'];
        
        $sql = "UPDATE tb_product SET total_stock = ".$total." WHERE id_product = 1";

        $result = $conn->query($sql);
        if ($result == TRUE) {
            $_SESSION['success'] = 'stock';
            header("Location: ../views/admin.php");
            exit();
        } else {
            $_SESSION['edit_error'] = 'Gagal menambah stock';
            header("Location: ../views/admin.php");
            exit();
        }
    }

    function accept() {
        /* Menerima pesanan user, merubah kolom order_status menjadi 1
        Cek apakah stok yang dimiliki sekarang cukup untuk memenuhi pesanan
        Jika tidak, muncul error message
        Jika cukup, ubah total stok dan order_status*/

        global $conn;

        $sql = '
                SELECT total AS total
                FROM `tb_orders`
                WHERE id_order = '.$_GET['accept'].'';

        $result = $conn->query($sql);
        $requested = mysqli_fetch_assoc($result);

        $sql = 'SELECT total_stock FROM tb_product WHERE id_product = 1';
        $result = $conn->query($sql);
        $total_stock = mysqli_fetch_assoc($result);

        $stock_left = $total_stock['total_stock'] - $requested['total'];

        if ($stock_left >= 0) {
            $sql = "UPDATE tb_orders SET order_status = 1 WHERE id_order = "."'".$_GET['accept']."'"."";

            $result = $conn->query($sql);
            if ($result === TRUE) {
                $_SESSION['success'] = 'accept';

                $sql = "UPDATE tb_product SET total_stock = ".$stock_left." WHERE id_product = 1";

                $result = $conn->query($sql);
                if ($result === TRUE) {
                    header("Location: ../views/admin.php");
                    exit();
                } else {
                    $_SESSION['edit_error'] = 'Gagal merubah pesanan';
                    header("Location: ../views/admin.php");
                    exit();
                }
            } else {
                $_SESSION['edit_error'] = 'Gagal merubah pesanan';
                header("Location: ../views/admin.php");
                exit();
            }
        } else {
            $_SESSION['success'] = 'over';
            header("Location: ../views/admin.php");
            exit();
        }
    }

    function decline() {
        /* Menolak pesanan user, merubah kolom order_status menjadi -1 */

        global $conn;

        $sql = "UPDATE tb_orders SET order_status = -1 WHERE id_order = "."'".$_GET['reject']."'"."";

        $result = $conn->query($sql);
        if ($result === TRUE) {
            $_SESSION['success'] = 'decline';
            header("Location: ../views/admin.php");
            exit();
        } else {
            $_SESSION['edit_error'] = 'Gagal merubah pesanan';
            header("Location: ../views/admin.php");
            exit();
        }
    }
?>