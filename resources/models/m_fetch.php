<?php
/* Model ini berisikan fungsi untuk mengambil data dari database untuk user, admin */

    include '../config/database.php';

    function get_product_stock() {
        /* Query total produk yang tersedia */

        global $conn;

        $sql = 'SELECT total_stock FROM tb_product WHERE id_product = 1';
        $result = $conn->query($sql);

        return mysqli_fetch_assoc($result);
    }
    
    function get_data($id = NULL) {
        /* Query data untuk admin dan user
        Jika $id = Null, query data admin dimana order_status = 0 (pending)
        Jika $id != Null, query data user berdasarkan id_user */

        global $conn;

        if ($id != NULL) {
            $sql = 
                "SELECT id_order, tb_orders.id_product, id_user, total, date_purchased, target_address, order_status, total*product_price AS total_harga
                FROM tb_orders
                JOIN tb_product ON tb_product.id_product = tb_orders.id_product
                WHERE id_user = "."'".$id."'"."";

            $result = $conn->query($sql);
            // $row = mysqli_fetch_assoc($result);
            return $result;

        } else {
            $sql = 
                "SELECT id_order, tb_orders.id_product, tb_orders.id_user,name, total, date_purchased, target_address, order_status, total*product_price AS total_harga
                FROM tb_orders
                JOIN tb_product ON tb_product.id_product = tb_orders.id_product
                JOIN tb_users ON tb_orders.id_user = tb_users.id_user
                WHERE order_status = 0";

            $result = $conn->query($sql);
            // $row = mysql_fetch_assoc($result);
            return $result;
        }

    }

?>