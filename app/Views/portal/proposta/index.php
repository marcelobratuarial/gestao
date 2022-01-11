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

	<!--plugins-->
	<link href="<?= base_url() ?>/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="<?= base_url() ?>/assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />

	<link href="<?= base_url() ?>/assets/plugins/smart-wizard/css/smart_wizard_all.min.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url() ?>/assets/css/bootstrap.min.css" rel="stylesheet">


	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Yellowtail" rel="stylesheet" type="text/css">

	<link href="https://fonts.googleapis.com/css2?family=Satisfy" rel="stylesheet" type="text/css">
	<link href="<?= base_url() ?>/assets/css/app.css" rel="stylesheet">
	<link href="<?= base_url() ?>/assets/css/icons.css" rel="stylesheet">
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="<?= base_url() ?>/assets/css/header-colors.css" />
	<link rel="stylesheet" href="<?= base_url() ?>/assets/css/mypdf.css" media="mpdf" />

	<style>
		.invalid-tooltip {
			font-size: 10px !important;
		}

		.myValid {
			background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
			background-repeat: no-repeat;
			background-position: right calc(0.375em + 0.1875rem) center;
			background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
		}

		.myWait {
			background-image: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgaGVpZ2h0PSIxNiIgZmlsbD0iY3VycmVudENvbG9yIiBjbGFzcz0iYmkgYmktY2xvY2siIHZpZXdCb3g9IjAgMCAxNiAxNiI+CiAgPHBhdGggZD0iTTggMy41YS41LjUgMCAwIDAtMSAwVjlhLjUuNSAwIDAgMCAuMjUyLjQzNGwzLjUgMmEuNS41IDAgMCAwIC40OTYtLjg2OEw4IDguNzFWMy41eiIvPgogIDxwYXRoIGQ9Ik04IDE2QTggOCAwIDEgMCA4IDBhOCA4IDAgMCAwIDAgMTZ6bTctOEE3IDcgMCAxIDEgMSA4YTcgNyAwIDAgMSAxNCAweiIvPgo8L3N2Zz4=");
			background-repeat: no-repeat;
			background-position: right calc(0.375em + 0.1875rem) center;
			background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
		}
	</style>



	<title>Portal de Propostas</title>
</head>

<body>

	<!--start page wrapper -->
	<div class="wrapper">
		<div class="container">
			<div class="row">
				<div class="col-xl-12 mx-auto">
					<br>

					<div class="row">
						<div class="col-md-2">
							<div id="logo" class="d-flex">


								<?php if (LOGOEMPRESA != null) : ?>
									<img src="<?= base_url('assets/uploads/' . LOGOEMPRESA) ?>" class="img-fluid text-center" style="display:block; margin:auto; max-height:55px" alt="logo icon">
								<?php else : ?>
									<?= (LOGOEMPRESA != null) ? NOMEEMPRESA : null ?>
								<?php endif; ?>
							</div>
						</div>

						<div class="col-md-10 text-center">
							<h4>Portal de Propostas - <?= (LOGOEMPRESA != null) ? NOMEEMPRESA : null ?></h4>
						</div>
					</div>

					<hr />
					<div class="card">
						<div class="card-body">

							<!-- SmartWizard html -->
							<div id="smartwizard" class="sw sw-justified sw-theme-dots">
								<ul class="nav d-print-none">
									<li class="nav-item">
										<a class="nav-link <?= $step == 'autenticacao' || $step == 'visualizacao' || $step == 'documentos' || $step == 'ultimaetapa'  ? 'active' : '' ?>">
											<?php if ($step == 'visualizacao' || $step == 'ultimaetapa' || $step == 'documentos') : ?>
												<strong>Informações Validadas</strong>
											<?php else : ?>
												<strong>Validar Informações</strong>
												<br>Confirme alguma informações pessoais para acessar a proposta
											<?php endif; ?>
										</a>
									</li>

									<li class="nav-item">
										<a class="nav-link <?= $step == 'visualizacao' || $step == 'documentos' || $step == 'ultimaetapa' ? 'active' : '' ?>" href="<?= $step ==  'ultimaetapa' ? base_url('portal/voltar') : current_url() ?>">
											<strong>Descrição da proposta</strong>
										</a>
									</li>
									<?php if (getEmpresa(CODEEMPRESA, 'assinatura')) : ?>
										<li class="nav-item">
											<a class="nav-link <?= $step == 'documentos' ? 'active' : '' ?>" href="<?= $step ==  'ultimaetapa' ? base_url('portal/voltar') : current_url() ?>">
												<strong>Documentos e Vistoria</strong>
											</a>
										</li>

										<li class="nav-item">
											<a class="nav-link <?= $step == 'ultimaetapa' ? 'active' : '' ?>"> <strong>Finalizar</strong>
											</a>
										</li>
									<?php endif; ?>
								</ul>
								<div class="tab-content">
									<?= view($path . $step) ?>
								</div>
							</div>
						</div>
					</div>
					</div:>
				</div>
				<!--end row-->
			</div>
		</div>

		<span id="cfg" data-baseUrl="<?= base_url() ?>" data-accessToken="<?= isset($_SESSION['accessToken']) ? $_SESSION['accessToken'] : null ?>"></span>
		<!--end page wrapper -->
		<?= getSwal() ?>
		<!-- Bootstrap JS -->
		<script src="<?= base_url() ?>/assets/js/bootstrap.bundle.min.js"></script>
		<!--plugins-->
		<script src="<?= base_url() ?>/assets/js/jquery.min.js"></script>

		<script src="<?= base_url() ?>/assets/plugins/jquery-mask/jquery.mask.js"></script>

		<script src="<?= base_url() ?>/assets/js/custom.js"></script>

		<script src="<?= base_url() ?>/assets/js/portal.js"></script>

		<script>
			(function() {
				'use strict'

				// Fetch all the forms we want to apply custom Bootstrap validation styles to
				var forms = document.querySelectorAll('.needs-validation')

				// Loop over them and prevent submission
				Array.prototype.slice.call(forms)
					.forEach(function(form) {
						form.addEventListener('submit', function(event) {
							if ($('input[name="nomecompleto"]').val()) {
								console.log('Verificar nome completo');
								checkName();
							}
							if (!form.checkValidity()) {
								event.preventDefault()
								event.stopPropagation()
							}

							form.classList.add('was-validated')
						}, false)
					})
			})()
		</script>

</body>





</html>