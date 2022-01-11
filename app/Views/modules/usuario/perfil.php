<?php
$permissoes = ($usuario->permissoes) ? $usuario->permissoes : array();
?>
<div class="card border-top border-0 border-4 border-primary">
	<div class="card-body p-5">
		<form id="formWithPassword" method="post" action="<?= base_url('usuario/save') ?>?current_url=<?= current_url() ?>">
			<div class="card-title d-flex align-items-center">
				<div>
					<i class="bx bxs-user me-1 h5 text-primary"></i>
				</div>
				<div class="h5 mb-0 text-primary w-100">
					<?= $subtituloPagina ?>
				</div>
			</div>
			<hr>
			<?php if (!permissao('superadmin')) : ?>
				<div class="row g-3">
					<div class="col-md-6">
						<label for="inputName" class="form-label">Nome</label> <input type="text" name="nome" class="form-control" id="inputName" value="<?= $usuario->nome ?>">
					</div>
					<div class="col-md-6">
						<label for="inputUserIf" class="form-label">CPF</label> <input type="text" name="userIf" data-mask="000.000.000-00" class="form-control" id="inputUserIf" value="<?= $usuario->cpf ?>">
					</div>
					<div class="col-md-6">
						<label for="inputTelefone" class="form-label">Telefone</label> <input type="text" name="telefone" class="telMask form-control" id="inputTelefone" value="<?= $usuario->telefone ?>">
					</div>
					<div class="col-md-6">
						<label for="inputEmail" class="form-label">Email</label> <input type="email" name="email" class="form-control" id="inputEmail" value="<?= $usuario->email ?>">
					</div>
					<div class="col-md-6">
						<label for="selectFilial" class="form-label">Filial</label> <select class="multiple-select form-control" data-placeholder="Selecione uma filial" id="selectFilial" multiple="multiple" disabled>
							<?php $filiaisJson = getFilial(); ?>
							<?php foreach ($filiaisJson as $k => $p) : ?>
								<option value="<?= $p->code ?>" <?= in_array($p->code, $usuario->codeFilial) ? 'selected' : null ?>><?= $p->nome ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<?php
					$ce = camposExtras('usuario');
					if (isset($ce)) :
						foreach ($ce as $c) :
							$c = slug($c);
					?>
							<div class="col-md-6">
								<label for="input<?= ucfirst($c) ?>" class="form-label"><?= ucfirst($c) ?></label>
								<input type="text" name="camposExtras[<?= $c ?>]" value="<?= (isset($usuario->camposExtras->$c)) ? $usuario->camposExtras->$c : null ?>" class="form-control" id="input<?= ucfirst($c) ?>">
							</div>
					<?php endforeach;
					endif; ?>
				</div>

				<div id="formWithPassword" class="col-md-12 mt-3">
					<div class="row">
						<div class="col-md-6">
							<label for="inputPassword" class="form-label">Nova senha</label>
							<input type="password" name="password" class="form-control" id="inputPassword">
						</div>
						<div class="col-md-6">
							<label for="inputPasswordConfirm" class="form-label">Senha confirmação</label>
							<input type="password" class="form-control" id="inputPasswordConfirm">
						</div>
					</div>
				</div>

				<div class="row g-3 mt-4">
					<div class="col-12">
						<div class="h5 mb-0 text-primary w-100">
							Link de compartilhamento
						</div>
						<div class="py-3">
							<div class="input-group"> <span onclick="copyToClipboard('<?= $leadPageLink ?>?u=<?= md5($usuario->code) ?>')" class="cursor-pointer input-group-text bg-transparent"><i class="bx bx-copy"></i></span>
								<input type="text" class="form-control" value="<?= $leadPageLink ?>?u=<?= md5($usuario->code) ?>" readonly>
							</div>
						</div>
					</div>
				</div>

				<div class="row g-3 mt-4">
					<div class="col-12">
						<a href="<?= base_url('usuario') ?>" class="btn btn-light px-5"> Cancelar </a>
						<button id="buttonSubmit" type="submit" name="code" value="<?= $usuario->code ?>" class="btn btn-primary px-5">Salvar</button>
					</div>
				</div>

			<?php endif; ?>
		</form>
	</div>
</div>