<div class="card border-top border-0 border-4 border-primary">
	<div class="card-body p-5">
		<div class="card-title d-flex align-items-center">
			<div>
				<i class="bx bxs-user-check me-1 font-22 text-primary"></i>
			</div>
			<h5 class="mb-0 text-primary">Adicionar <?= customWord('cliente', false) ?></h5>
		</div>
		<hr>
		<form method="post" action="<?= base_url('cliente/save') ?>">
			<div class="row g-3">
				<div class="col-md-6">
					<label for="inputName" class="form-label">Nome</label>
					<input type="text" name="nome" class="form-control" id="inputName">
				</div>
				<div class="col-md-6">
					<label for="inputEmail" class="form-label">Email</label>
					<input type="email" name="email" class="form-control" id="inputEmail">
				</div>
				<div class="col-md-6">
					<label for="inputPassword" class="form-label">Senha</label>
					<input type="password" name="password" class="form-control" id="inputPassword">
				</div>
				<div class="col-md-6">
					<label for="inputPasswordConfirm" class="form-label">Senha confirmação</label>
					<input type="passwordConfirm" class="form-control" id="inputPasswordConfirm">
				</div>
				<?php 
				$ce = camposExtras('cliente');
				if(isset($ce)):
				foreach($ce as $c):
				?>
				<div class="col-md-6">
					<label for="input<?= ucfirst($c) ?>" class="form-label"><?= ucfirst($c) ?></label>
					<input type="text" name="camposExtras[<?= $c ?>]" class="form-control" id="input<?= ucfirst($c) ?>">
				</div>
				<?php endforeach; endif; ?>
			</div>
			
			<div class="row g-3 mt-4">
				<div class="col-12">
					<a href="<?= base_url('cliente')?>" class="btn btn-light px-5">
						Cancelar
					</a>
					<button type="submit" class="btn btn-primary px-5">
						Salvar
					</button>
				</div>
			</div>
		</form>
	</div>
</div>

