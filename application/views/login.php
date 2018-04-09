<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Survei Kepuasan Mahasiswa</title>
    <link rel="shortcut icon" type="image/png" href="<?= base_url( 'assets/img/logo_unsri.png' ) ?>"/>

    <link href="<?= base_url('assets') ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('assets') ?>/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?= base_url('assets') ?>/css/animate.css" rel="stylesheet">
    <link href="<?= base_url('assets') ?>/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="loginColumns animated fadeInDown">
        <div class="row">

            <div class="col-md-6 text-center">
                <img src="<?= base_url( 'assets/img/logo_unsri.png' ) ?>" width="170" height="150">
                <h2 class="font-bold">Selamat Datang di Sistem Survei Mahasiswa<br> Universitas Sriwijaya</h2>
            </div>
            <div class="col-md-6">
                <div class="ibox-content">
                    <?= form_open( 'login', [ 'class' => 'm-t', 'role' => 'form' ] ) ?>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Username" name="username" required="">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Password" name="password" required="">
                        </div>
                        <button type="submit" name="login" value="Login" class="btn btn-primary block full-width m-b">Login</button>

                        <a href="#">
                            <small>Lupa password?</small>
                        </a>
                        
                    <?= form_close() ?>
                    <p class="m-t">
                        <small>Silahkan login menggunakan akun yang telah terdaftar</small>
                    </p>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-6">
                Hak Cipta Universitas Sriwijaya
            </div>
            <div class="col-md-6 text-right">
               <small>© 2018</small>
            </div>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?= base_url('assets') ?>/js/jquery-3.1.1.min.js"></script>
    <script src="<?= base_url('assets') ?>/js/bootstrap.min.js"></script>

</body>


</html>
