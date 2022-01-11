<div class="card border-top border-0 border-4 border-primary">
	<div class="card-body p-5">
		<div class="card-title d-flex align-items-center">
			<div>
				<i class="bx bxs-building-house me-1 font-22 text-primary"></i>
			</div>
			<h5 class="mb-0 text-primary">Editar Filial
				<?php if ($filial->tipo == 2) : ?>
					<?php if ($filial->status == 1) : ?>
						<a href="<?= base_url('filial/desativar/' . $filial->code) ?>" class="text-success ms-5"><i class="lni lni-checkmark-circle me-0"></i></a>
					<?php else : ?>
						<a href="<?= base_url('filial/ativar/' . $filial->code) ?>" class="text-warning ms-5"><i class="lni lni-cross-circle me-0"></i></a>
					<?php endif; ?>
					<a href="<?= base_url('filial/excluir/' . $filial->code) ?>" class="confirm text-danger ms-2"><i class="lni lni-trash me-0"></i></a>
				<?php endif; ?>
			</h5>
		</div>
		<hr>
		<form method="post" action="<?= base_url('filial/save') ?>">
			<div class="row g-3">
				<div class="col-md-6">
					<label for="inputName" class="form-label">Nome</label> <input type="text" name="nome" class="form-control" id="inputName" value="<?= $filial->nome ?>">
				</div>
				<div class="col-md-6">
					<label for="inputEndereco" class="form-label">Endereco</label> <input type="text" name="endereco" class="form-control" id="inputEndereco" value="<?= $filial->endereco ?>">
				</div>
				<div class="col-md-6">
					<label for="inputTelefone" class="form-label">Telefone</label> <input type="text" name="telefone" class="form-control" id="inputTelefone" value="<?= $filial->telefone ?>">
				</div>
				<div class="col-md-6">
					<label for="inputEmail" class="form-label">Email</label> <input type="email" name="email" class="form-control" id="inputEmail" value="<?= $filial->email ?>">
				</div>

				<?php
				$dados = json_decode($filial->camposExtras);
				$ce = camposExtras('filial');
				if (isset($ce)) :
					foreach ($ce as $c) :
						$slug = slug($c);
				?>
						<div class="col-md-6">
							<label for="input<?= ucfirst($c) ?>" class="form-label"><?= ucfirst($c) ?></label>
							<input type="text" name="camposExtras[<?= $slug ?>]" value="<?= (isset($dados->$slug)) ? $dados->$slug : null; ?>" class="form-control" id="input<?= ucfirst($c) ?>">
						</div>
				<?php endforeach;
				endif; ?>
			</div>

			<div class="row g-3 mt-4">
				<div class="col-12">
					<a href="<?= base_url('filial') ?>" class="btn btn-light px-5"> Cancelar </a>
					<button type="submit" name="code" value="<?= $filial->code ?>" class="btn btn-primary px-5">Salvar</button>
				</div>
			</div>
		</form>
	</div>
</div>