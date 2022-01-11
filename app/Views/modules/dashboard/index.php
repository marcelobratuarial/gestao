<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
	<div class="col">
		<div class="card radius-10 border-bottom border-0 border-3 border-info">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div>
						<p class="mb-0 text-secondary">Leads</p>
						<h4 class="my-1 text-info"><?= $leads ?></h4>
					</div>
					<div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i class="bx bxs-cart"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col">
		<div class="card radius-10 border-bottom border-0 border-3 border-danger">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div>
						<p class="mb-0 text-secondary">Propostas</p>
						<h4 class="my-1 text-danger"><?= $propostas ?></h4>
					</div>
					<div class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto"><i class="bx bx-book-reader"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col">
		<div class="card radius-10 border-bottom border-0 border-3 border-success">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div>
						<p class="mb-0 text-secondary">Vendas</p>
						<h4 class="my-1 text-success"><?= $vendas ?></h4>
					</div>
					<div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i class="bx bxs-wallet"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col">
		<div class="card radius-10 border-bottom border-0 border-3 border-success">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div>
						<p class="mb-0 text-secondary">Taxa de conversão</p>
						<h4 class="my-1 text-success"><?= $conversao ?>%</h4>
					</div>
					<div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i class="bx bxs-bar-chart-alt-2"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--end row-->
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 justify-content-between">
	<div class="col-3">
		<div class="card border-primary border-bottom border-3 border-0 radius-10">
			<div class="card-header bg-transparent">
				<div class="d-flex align-items-center">
					<div>
						<h6 class="mb-0">Atalhos</h6>
					</div>

				</div>
			</div>
			<div class="card-body">
				<div class="">
					<a href="<?= base_url('lead/adicionar') ?>" class="btn btn-outline-primary w-100 px-5 my-2"><i class="bx bx-edit mr-1"></i>Gerar proposta</a>
					<a href="<?= base_url('usuario/meus-dados') ?>" class="btn btn-outline-primary w-100 px-5 my-2"><i class="bx bx-user mr-1"></i>Meus Dados</a>
				</div>
			</div>
		</div>
	</div>
	<div class="col-12 col-lg-4">
		<div class="card border-primary border-bottom border-3 border-0 radius-10">
			<div class="card-header bg-transparent">
				<div class="d-flex align-items-center">
					<div>
						<h6 class="mb-0">Leads</h6>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="my-3 row justify-content-center row-cols-1 row-cols-md-4 row-cols-xl-4 g-0 row-group text-center">
					<div class="col">
						<div class="p-3">
							<h5 class="mb-0"><?= $whatsapp_leads ?> <i class="lni lni-whatsapp fs-6"></i></h5>
							<small class="mb-0">Whatsapp</small>
						</div>
					</div>
					<div class="col">
						<div class="p-3">
							<h5 class="mb-0"><?= $telefone_leads ?> <i class="lni lni-mobile fs-6"></i></h5>
							<small class="mb-0">Telefone</small>
						</div>
					</div>
					<div class="col">
						<div class="p-3">
							<h5 class="mb-0"><?= $email_leads ?> <i class="lni lni-envelope fs-6"></i></h5>
							<small class="mb-0">Email</small>
						</div>
					</div>
					<div class="col">
						<div class="p-3">
							<h5 class="mb-0"><?= $pessoalmente_leads ?> <i class="lni lni-user fs-6"></i></h5>
							<small class="mb-0">Pessoal</small>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-12 col-lg-5">
		<div class="card border-primary border-bottom border-3 border-0 radius-10">
			<div class="card-header bg-transparent">
				<div class="d-flex align-items-center">
					<div>
						<h6 class="mb-0">Link de divulgação</h6>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="row mb-3">
					<div class="col">
						<div class="input-group"> <span onclick="copyToClipboard('<?= $leadPageLink ?>?u=<?= md5($usuario->code) ?>')" class="cursor-pointer input-group-text bg-transparent"><i class="bx bx-copy"></i></span>
							<input type="text" class="form-control" value="<?= $leadPageLink ?>?u=<?= md5($usuario->code) ?>" readonly>
						</div>
					</div>
				</div>
				<div class="row justify-content-center row-cols-1 row-cols-md-3 row-cols-xl-3 g-0 row-group text-center border-top">
					<div class="col">
						<div class="p-3">
							<h5 class="mb-0"><?= $usuario->leadPageLink ?></h5>
							<small class="mb-0">Acessos</small>
						</div>
					</div>
					<div class="col">
						<div class="p-3">
							<h5 class="mb-0"><?= $leadPageLink_leads ?></h5>
							<small class="mb-0">Leads</small>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>