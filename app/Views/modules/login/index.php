<!DOCTYPE html>
<html lang="pt">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="<?= base_url() ?>/assets/images/favicon-32x32.png" type="image/png" />
    <!-- loader-->
    <link href="<?= base_url() ?>/assets/css/pace.min.css" rel="stylesheet" />
    <script src="<?= base_url() ?>/assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="<?= base_url() ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="<?= base_url() ?>/assets/css/app.css" rel="stylesheet">
    <link href="<?= base_url() ?>/assets/css/icons.css" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <title>Acessar Admin</title>
</head>

<body class="bg-login">
    <?= getSwal(); ?>
    <!-- wrapper -->
    <div class="wrapper">
        <div class="authentication-lock-screen d-flex align-items-center justify-content-center">
            <div class="card shadow border-0 bg-white">
                <div class="card-body p-md-5 text-center">
                    <h5 class="text-black"><?= utf8_encode(strftime('<span style="text-transform:capitalize">%A</span>, %d de <span style="text-transform:capitalize">%B</span> de %Y', strtotime('today'))) ?></h5>
                    <div class="">
                        <?php if (LOGOEMPRESA == null) : ?>
                            <img src="<?= base_url('/assets/images/icons/user.png') ?>" class="my-2" width="120" alt="" />
                        <?php else : ?>
                            <img src="<?= base_url('assets/uploads/' . LOGOEMPRESA) ?>" class="my-2" width="120" alt="" />
                        <?php endif; ?>
                    </div>
                    <form action="<?= base_url('login/auth') ?>" method="post">
                        <p class="mt-2 text-white"><?= (LOGOEMPRESA == null) ? NOMEEMPRESA : null ?></p>
                        <div class="mb-3 mt-3">
                            <input type="email" class="form-control" value="" name="login" placeholder="Email" />
                        </div>
                        <div class="mb-3 mt-3">
                            <input type="password" class="form-control" value="" name="password" placeholder="Senha" />
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-white">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end wrapper -->
</body>

</html>