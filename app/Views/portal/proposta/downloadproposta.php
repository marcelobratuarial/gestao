<!DOCTYPE html>
<html lang="pt_BR">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="<?= base_url() ?>/assets/css/bootstrap.min.css" rel="stylesheet">


	<link href="<?= base_url() ?>/assets/css/app.css" rel="stylesheet">



	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Yellowtail" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css2?family=Satisfy" rel="stylesheet" type="text/css">


	<!-- Theme Style CSS -->
	<link href="<?= base_url() ?>/assets/css/mypdf.css" media="all" rel="stylesheet" />

</head>

<body>
	<img src="<?= base_url("$path/../img/capa.jpg") ?>" style="width:100%">
	<?= $assinada ? view("portal/proposta/assinatura") : view("$path/proposta_view") ?>
	<img src="<?= base_url("$path/../img/contracapa.jpg") ?>" style="width:100%">

	<!-- Bootstrap JS -->
	<script src="<?= base_url() ?>/assets/js/bootstrap.bundle.min.js"></script>
	<script src="<?= base_url() ?>/assets/js/jquery.min.js"></script>

</body>

</html>