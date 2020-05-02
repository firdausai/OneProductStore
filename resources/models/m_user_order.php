<?php
/* Model ini berisikan fungsionalitas saat user membeli, edit dan hapus barang */

    session_start();
    include '../config/database.php';

    if(isset($_POST['index'])) {
        buy();
    } else if (isset($_POST['user_dashboard'])) {
        edit();
    }

    if (isset($_GET['delete'])) {
        delete();
    }

    function delete() {
        /* Hapus barang pesanan berdasarkan id_order
        Jika pesanan sudah dikirim, user tidak bisa menghapus pesanan
        Jika pesanan pending atau ditolak, user bisa menghapus pesanan */

        global $conn;

        $sql = "SELECT order_status FROM tb_orders WHERE id_order = ".$_GET['delete']."";
        $result = $conn->query($sql);
        $row = mysqli_fetch_assoc($result);

        if ($row['order_status'] == 0 || $row['order_status'] == -1) {
            $sql = 'DELETE FROM tb_orders WHERE id_order='.'"'.$_GET['delete'].'"'.'';

            $result = $conn->query($sql);
            if ($result === TRUE) {
                $_SESSION['success'] = 'Delete';
                header("Location: ../views/dashboard.php");
                exit();
            } else {
                $_SESSION['edit_error'] = 'Gagal merubah pesanan';
                header("Location: ../views/dashboard.php");
                exit();
            }
        } else {
            $_SESSION['success'] = 'Denied';
            header("Location: ../views/dashboard.php");
            exit();
        }
    }

    function edit() {
        /* Simpan perubahan address dan total pesanan berdasarkan id_order 
        Jika pesanan sudah dikirim atau ditolak, user tidak bisa memperbarui pesanan */

        global $conn;

        $sql = "SELECT order_status FROM tb_orders WHERE id_order = ".$_POST['id_order']."";
        $result = $conn->query($sql);
        $row = mysqli_fetch_assoc($result);

        if ($row['order_status'] == 0) {

            $sql = "UPDATE tb_orders SET target_address = "."'".$_POST['address']."'".", total = "."'".$_POST[$_POST['id_order']]."'"." WHERE id_order = "."'".$_POST['id_order']."'"."";

            $result = $conn->query($sql);
            if ($result === TRUE) {
                $_SESSION['success'] = 'Edit';
                header("Location: ../views/dashboard.php");
                exit();
            } else {
                $_SESSION['edit_error'] = 'Gagal merubah pesanan';
                header("Location: ../views/dashboard.php");
                exit();
            }
        } else if ($row['order_status'] == -1) {
            $_SESSION['success'] = 'Useless';
            header("Location: ../views/dashboard.php");
            exit();
        } else {
            $_SESSION['success'] = 'Fix';
            header("Location: ../views/dashboard.php");
            exit();
        }
    }

    function buy() {
        /* Cek apakah session id_user ada
        Jika ada, berarti user sudah login. Tambah data belanja ke database
            dan redirect ke user_dashboard
        Jika tidak ada, berarti user belum login. Redirect ke login page */

        if (isset($_SESSION['id_user']) == True) {

            global $conn;

            $sql =
                'SELECT address
                FROM tb_users
                WHERE id_user = '.'"'.$_SESSION['id_user'].'"';

            $result = $conn->query($sql);
            $row = mysqli_fetch_assoc($result);

            $sql =
                "INSERT INTO tb_orders (id_user, total, date_purchased, target_address, order_status)
                VALUES ("."'".$_SESSION['id_user']."'".","."'".$_POST['total']."'".","."'".date('Y/m/d')."'".","."'".$row['address']."'".",0)";

            $result = $conn->query($sql);

            if ($result === TRUE) {
                header("Location: ../views/dashboard.php");
                exit();
            } else {
                $_SESSION['buy_error'] = 'Gagal memasukan pesanan';
                header("Location: ../views/login.php");
                exit();
            }
        } else {
            header("Location: ../views/login.php");
            exit();
        }
    }
?>

