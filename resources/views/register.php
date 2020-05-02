<?php 
    session_start();
    $base_url = 'http://localhost/OneProductStore/';

    if (!isset($_SESSION['input_error'])) {
        $status = null;
    } else {
        $status = $_SESSION['input_error'];
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
        <title>Login</title>
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
        <main id="content-wrapper" class="content-wrapper container d-flex vh-100 m-0 mx-auto">
            <div class="sign-wrapper mx-auto py-4 px-5 align-self-center">
                <div class="content-title font-weight-bold mb-5">
                <a href="<?php echo $base_url?>">Millenis Corporation</a>
                </div>
                <?php if ($status == 'Email') { ?>
                    <div class="text-danger text-center mb-3" role="alert">Email yang kamu masukkan sudah terdaftar.<br/>Silakan coba lagi.</div>
                <?php } else if ($status == 'Baris') {?>
                    <div class="text-danger text-center mb-3" role="alert">Seluruh data wajib diisi.</div>
                <?php  } ?>
                <form action="../models/m_auth.php" method = 'post' class="sign-form mx-3">
                    <div class="form-group">
                        <label for="name" class="m-0">Nama</label>
                        <input type="text" name = 'name' class="form-control" id="name" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="email" class="m-0">Email</label>
                        <input type="email" name = 'email' class="form-control" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="m-0">Password</label>
                        <input type="password" name = 'password' class="form-control" id="password" required>
                    </div>
                    <div class="form-group">
                        <label for="address" class="m-0">Alamat</label>
                        <input type="text" name = 'address' class="form-control" id="address" required>
                    </div>
                    <button name = 'register' value = 'register' type="submit" class="btn btn-primary w-100 mt-4">Daftar</button>
                    <a href="login.php" type="button" class="btn btn-link w-100 mt-3">Masuk</a>
                </form>
            </div>
        </main>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="<?php echo $base_url ?>assets/js/main.js?v=<?php echo filemtime('../../assets/js/main.js') ?>" type="text/javascript"></script>
    </body>
</html>