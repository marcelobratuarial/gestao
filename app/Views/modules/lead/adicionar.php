<div class="card border-top border-0 border-4 border-primary">
	<div class="card-body p-5">
		<div class="card-title d-flex align-items-center">
			<div>
				<i class="bx bxs-user-check me-1 font-22 text-primary"></i>
			</div>
			<h5 class="mb-0 text-primary">Adicionar <?= customWord('lead', false) ?></h5>
		</div>
		<hr>
		<form method="post" action="<?= base_url('lead/save') ?>">
			<div class="row g-3">
				<div class="col-md-6">
					<label for="inputName" class="form-label">Nome</label>
					<input type="text" name="nome" class="form-control" id="inputName" required>
				</div>
				<div class="col-md-6">
					<label for="inputEmail" class="form-label">Empresa</label>
					<input type="text" name="empresa" class="form-control" id="inputEmail">
				</div>
				
				<div class="col-md-6">
					<label for="inputTelefone" class="form-label">Telefone</label>
					<input type="text" name="telefone" class="form-control" id="inputTelefone">
				</div>
				
				<div class="col-md-6">
					<label for="inputEmail" class="form-label">Email</label>
					<input type="email" name="email" class="form-control" id="inputEmail">
				</div>
				
				<div class="col-md-3">
					<label for="selectOrigem" class="form-label">Responsável</label>
					<select name="codeUsuario" class="form-select" id="selectOrigem" required>
						<option value="<?= $_SESSION['usuarioCode'] ?>"><?= $_SESSION['usuarioNome'] ?></option>
					</select>
				</div>
				<div class="col-md-3">
					<label for="selectProduto" class="form-label">Produto</label>
					<select name="codeProduto" class="form-select" id="selectProduto" required>

						<?php
						$produtos = getProduto();
						$nProdutos = count($produtos);
						if ($nProdutos > 1) : ?>
							<option value="">Selecione o produto</option>
						<?php
						endif;
						foreach ($produtos as $p) :
						?>
							<option value="<?= $p->code ?>"><?= $p->nome ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-md-3">
					<label for="selectOrigem" class="form-label">Origem</label>
					<select name="origem" class="form-select" id="selectOrigem" required>
						<option value="">Selecione a origem</option>
						<option value="whatsapp">Whatsapp</option>
						<option value="telefone">Telefone</option>
						<option value="email">Email</option>
						<!-- <option value="site">Site</option> -->
						<option value="pessoalmente">Pessoalmente</option>
					</select>
				</div>

				<?php
				$ce = camposExtras('lead');
				if (isset($ce)) :
					foreach ($ce as $c) :
				?>
						<div class="col-md-6">
							<label for="input<?= ucfirst($c) ?>" class="form-label"><?= ucfirst($c) ?></label> <input type="text" name="camposExtras[<?= $c ?>]" class="form-control" id="input<?= ucfirst($c) ?>">
						</div>
				<?php endforeach;
				endif; ?>
			
		
			<div class="col-md-3">

				<?php if (permissao('superadmin')) : ?>
			
						<label for="selectStatus" class="form-label">Status</label> 
						<select name="codeStatus" class="form-control" id="selectStatus">
							<?php foreach (getStatus('lead') as $k => $p) : ?>
								<option value="<?= $p->code ?>"><?= $p->nome ?></option>
							<?php endforeach; ?>
						</select>
					
				<?php else : ?>
					<input name="codeUsuario" value="<?= $_SESSION['usuarioCode'] ?>" class="d-none"> <input name="codeFilial" value="<?= $_SESSION['usuarioFilial'] ?>" class="d-none"> <input name="codeFunil" value="padrao" class="d-none"> <input name="codeStatus" value="inicial" class="d-none">
				<?php endif; ?>


			</div>
			<div class="row g-3 mt-4"> 
				<div class="col-12">
					<a href="<?= base_url('lead') ?>" class="btn btn-danger px-5 m-1"> Cancelar </a>
						<button type="submit" name="proposta" value="1" class="btn btn-primary px-5 float-end m-1">Salvar e ir para proposta</button>
			
					<button type="submit" class="btn btn-success px-5 float-end m-1">Salvar lead</button>
					</div>
			</div>
		</form>
	</div>
</div>