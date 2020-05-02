<?php
/*  Model ini berisikan fungsi-fungsi untuk mengautentifikasi user,
fungsionalitas login dan logout, register, serta inisialisasi session user/admin */

    session_start();
    include '../config/database.php';

    if(isset($_POST['register'])) {
        register();
    } else if (isset($_POST['login'])) {
        login();
    }

    if (isset($_GET['logout'])) {
        logout();
    }

    function register() {
        /* Cek apakah semua field sudah terisi dan cek apakah email unik
        Jika semua sudah benar, set session id, name dan role. Redirect ke user_dashboard
        jika ada yang salah, redirect ke login page */

        global $conn;

        $required = array('name', 'password', 'email', 'address');

        $error = false;
        foreach($required as $field) {
            if (empty($_POST[$field])) {
                $error = true;
            }
        }

        if ($error == True) {
            $_SESSION['input_error'] = 'Baris';
            header("Location: ../views/register.php");
            exit();
        }

        $sql =
            'SELECT email
            FROM tb_users
            WHERE email = '.'"'.$_POST['email'].'"';

        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $_SESSION['input_error'] = 'Email';
            header("Location: ../views/register.php");
            exit();
        } else {

            $sql =
                "INSERT INTO tb_users (name, email, password, address)
                VALUES ("."'".$_POST['name']."'".","."'".$_POST['email']."'".","."'".$_POST['password']."'".","."'".$_POST['address']."'".")";

            $result = $conn->query($sql);

            if ($result === TRUE) {

                $sql =
                    'SELECT id_user
                    FROM tb_users
                    WHERE email = '.'"'.$_POST['email'].'"'.'';

                $result = $conn->query($sql);
                $row = mysqli_fetch_assoc($result);

                $_SESSION['id_user'] = $row['id_user'];
                $_SESSION['name'] = $_POST['name'];
                $_SESSION['role'] = 0;
                
                header("Location: ../views/dashboard.php");
                exit();
            } else {
                $_SESSION['input_error'] = 'Gagal memasukan data';
                header("Location: ../views/register.php");
                exit();
            }
        }

    }

    function login() {
        /* Cek apakah email dan password sama dengan salah satu row di database
        Jika sama, masukan id_user, name dan role ke session dan redirect ke user_dashboard / admin_dashboard
        Jika tidak, kembalikan ke form login */

        global $conn;

        $sql =
            'SELECT id_user, name, role
            FROM tb_users
            WHERE password = '.'"'.$_POST['password'].'"'.'and email = '.'"'.$_POST['email'].'"'.'';

        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = mysqli_fetch_assoc($result);

            $_SESSION['id_user'] = $row['id_user'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['role'] = $row['role'];

            if (isset($_SESSION["input_error"])) {
                unset($_SESSION["input_error"]);
            }

            if ($row['role'] == 0) {
                header("Location: ../views/dashboard.php");
                exit();
            } else {
                header("Location: ../views/admin.php");
                exit();
            }
            
        } else {
            $_SESSION["input_error"] = 'login error';
            header("Location: ../views/login.php");
            exit();
        }
    }

    function logout() {
        /* Unset dan destroy session saat user ingin logout*/

        session_unset();
        session_destroy();

        header("Location: ../views/login.php");
        exit();
    }

    function check_login_status() {
        /* Cek apakah user sudah login atau belum
        Jika sudah, return header user
        Jika belum, return header login */

        global $conn;

        if (isset($_SESSION['id_user']) == False) {
            return '
            <div class="header-link">
                <a href="login.php">Masuk</a>
                <a href="register.php"><b>Daftar</b></a>
            </div>';
        } else {

            $sql =
                'SELECT name
                FROM tb_users
                WHERE id_user = '.'"'.$_SESSION['id_user'].'"';

            $result = $conn->query($sql);
            $row = mysqli_fetch_assoc($result);

            return '
            <div class="header-user">Selamat datang, <b>'.$row['name'].'</b>
                <ul class="list-unstyled m-0">
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="../models/m_auth.php?logout=logout">Logout</a></li>
                </ul>
            </div>';
        }
    }
?>