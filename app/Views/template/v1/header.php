<!doctype html>

<html lang="pt-BR" class="<?= getEmpresa(CODEEMPRESA, 'cor') ?>">

<head>

	<!-- Required meta tags -->

	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!--favicon-->

	<link rel="icon" href="<?= base_url() ?>/assets/uploads/<?= getEmpresa(CODEEMPRESA, 'icone') ?>" type="image/png" />

	<!--plugins-->
	
	<link href="<?= base_url() ?>/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />

	<link href="<?= base_url() ?>/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />

	<link href="<?= base_url() ?>/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />

	<link href="<?= base_url() ?>/assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />

	<link href="<?= base_url() ?>/assets//plugins/bootstrap-cookie-alert/cookiealert.css" rel="stylesheet">

	<!-- loader-->

	<link href="<?= base_url() ?>/assets/css/pace.min.css" rel="stylesheet" />

	<script src="<?= base_url() ?>/assets/js/pace.min.js"></script>

	<!-- Bootstrap CSS -->

	<link href="<?= base_url() ?>/assets/css/bootstrap.min.css" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

	<link href="<?= base_url() ?>/assets/css/app.css" rel="stylesheet">

	<link href="<?= base_url() ?>/assets/css/icons.css" rel="stylesheet">

	<link href="<?= base_url() ?>/assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

	<!-- Theme Style CSS -->

	<link rel="stylesheet" href="<?= base_url() ?>/assets/css/dark-theme.css" />

	<link rel="stylesheet" href="<?= base_url() ?>/assets/css/semi-dark.css" />

	<link rel="stylesheet" href="<?= base_url() ?>/assets/css/header-colors.css" />

	<link rel="stylesheet" href="<?= base_url() ?>/assets/css/style.css" />
	
	<link rel="stylesheet" href="<?= base_url() ?>/assets/css/custom.css" />

	<link href="<?= base_url() ?>/assets/plugins/fancybox/jquery.fancybox.css" rel="stylesheet">

	<link href="<?= base_url() ?>/assets/plugins/select2/css/select2.min.css" rel="stylesheet">
	
	<link href="<?= base_url() ?>/assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet">

	<link href="<?= base_url('assets/summernote/summernote.min.css')?>" rel="stylesheet">
	
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

	<script src="<?= base_url() ?>/assets/js/jquery.min.js"></script>

	<title>Gestão | <?= $_SESSION['empresaNome'] ?></title>


</head>