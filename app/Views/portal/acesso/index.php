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

    <title>Portal de Propostas  </title>
</head>

<body class="bg-login">

	<!--wrapper-->
	<div class="wrapper">
		<div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
			<div class="container-fluid">
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
					<div class="col mx-auto">
						<div class="mb-4 text-center">
							<div id="logo" class="d-flex">
							<?php if (LOGOEMPRESA != null) : ?>
									<img src="<?= base_url('assets/uploads/' . LOGOEMPRESA) ?>" class="img-fluid text-center" style="display:block; margin:auto; max-height:150px" alt="logo icon">
								<?php else : ?>
									<?= (LOGOEMPRESA != null) ? NOMEEMPRESA : null ?>
								<?php endif; ?>
							</div>
						</div>
						<div class="card">
							<div class="card-body">
								<div class="border p-4 rounded">
									<div class="text-center">
										<h3 class="">Portal de Propostas - <?= (NOMEEMPRESA != null) ? NOMEEMPRESA : null ?></h3>
                                       
									</div>
                                    <hr>
									<div class="form-body">
										<form class="row g-3" action="<?= base_url('portal/proposta')?>" method="post">
											<div class="col-12">
												<label class="form-label">Código da Proposta</label>
												<input type="text" class="form-control" placeholder="Digite o código da Proposta. Ex: HKUI1192882189" name="code">
											</div>
											<div class="col-12">
												<div class="d-grid">
														<button type="submit" class="btn btn-primary"><i class="bx bxs-lock-open"></i>Acessar Proposta</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
			</div>
		</div>
	</div>
	<!--end wrapper-->
	<?= getSwal() ?>
</body>

</html>