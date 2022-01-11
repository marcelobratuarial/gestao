<div class="card border-top border-0 border-4 border-primary">
	<div class="card-body p-5">
		<div class="card-title d-flex align-items-center">
			<div>
				<i class="bx bxs-user me-1 font-22 text-primary"></i>
			</div>
			<h5 class="mb-0 text-primary">Adicionar Usuário</h5>
		</div>
		<hr>
		<form method="post" action="<?= base_url('usuario/save') ?>">
			<div class="row g-3">
				<div class="col-md-6">
					<label for="inputName" class="form-label">Nome</label>
					<input type="text" name="nome" class="form-control" id="inputName" required>
				</div>
				<div class="col-md-6">
					<label for="inputUserIF" class="form-label">CPF</label>
					<input type="text" name="userIf" data-mask="000.000.000-00" class="form-control" id="inputUserIF">
				</div>
				<div class="col-md-6">
					<label for="inputTelefone" class="form-label">Telefone</label>
					<input type="text" name="telefone" class="telMask form-control" id="inputTelefone">
				</div>
				<div class="col-md-6">
					<label for="inputEmail" class="form-label">Email</label>
					<input type="email" name="email" class="form-control" id="inputEmail" required>
				</div>
				<div id="formWithPassword" class="col-md-12">
					<div class="row">
						<div class="col-md-6">
							<label for="inputPassword" class="form-label">Senha</label>
							<input type="password" name="password" class="form-control" id="inputPassword" required>
						</div>
						<div class="col-md-6">
							<label for="inputPasswordConfirm" class="form-label">Senha confirmação</label>
							<input type="password" class="form-control" id="inputPasswordConfirm" required>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<label for="selectFilial" class="form-label">Filial</label> <select name="codeFilial[]" class="multiple-select form-control" data-placeholder="Selecione uma filial" id="selectFilial" multiple="multiple" required>
						<?php $filiaisJson = getFilial(); ?>
						<?php foreach ($filiaisJson as $k => $p) : ?>
							<option value="<?= $p->code ?>"><?= $p->nome ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<?php
				$ce = camposExtras('usuario');
				if (isset($ce)) :
					foreach ($ce as $c) :
				?>
						<div class="col-md-6">
							<label for="input<?= ucfirst($c) ?>" class="form-label"><?= ucfirst($c) ?></label>
							<input type="text" name="camposExtras[<?= slug($c) ?>]" class="form-control" id="input<?= ucfirst($c) ?>">
						</div>
				<?php endforeach;
				endif; ?>
			</div>
			<div class="g-3 mt-4">
				<div class="card-title d-flex align-items-center">
					<div>
						<i class="bx bxs-lock me-1 font-22 text-primary"></i>
					</div>
					<h5 class="mb-0 text-primary">Permissões do Usuário</h5>
				</div>
				<hr>
				<select name="perfil" onchange="selectPermissoes(this)" class="form-control" required>
					<option id="perfilDefault">Selecione um perfil</option>
					<?php foreach (getPerfil() as $p) : ?>
						<?php if ((!permissao('admin') && $p->code == usuario('perfil')) || permissao('admin')) : ?>
							<option value="<?= $p->code ?>" data-permissoes='<?= $p->permissoes ?>'><?= $p->nome ?></option>
						<?php endif; ?>
					<?php endforeach; ?>
				</select>
				<div id="permissoesCheckboxes" class="row g-3 mt-4 d-none">

					<?php foreach (getPermissoes() as $p) :
						if (in_array($p->acesso, (array) usuario('permissoes')) || permissao('admin')) : ?>
							<div class="col-3">
								<div class="form-check">
									<input class="form-check-input" name="permissoes[]" value="<?= $p->acesso ?>" type="checkbox" id="<?= $p->acesso ?>">
									<label class="form-check-label" for="<?= $p->acesso ?>"><?= $p->nome ?></label>
								</div>
							</div>
					<?php endif;
					endforeach; ?>
					<hr>
					<?php foreach (getModulos() as $p) :
						if (in_array($p->codeModulo, (array) usuario('permissoes')) || permissao('admin')) : ?>
							<?php $subModulo = getModulos($p->codeModulo); ?>
							<?php $codeModulo = str_replace('/', '_', $p->codeModulo); ?>
							<div class="col-3">

								<div class="form-check">
									<input class="form-check-input" name="permissoes[]" onclick="checkModuloFilhos('<?= $p->codeModulo ?>')" <?= (in_array($p->codeModulo, $permissoes)) ? 'checked' : null ?> value="<?= $codeModulo ?>" type="checkbox" id="<?= $codeModulo ?>"> <label class="form-check-label" for="<?= $codeModulo ?>"><?= $p->nome ?></label>
								</div>


								<ul class="list-unstyled">
									<?php foreach ($subModulo as $p) :
										if (in_array($p->codeModulo, (array) usuario('permissoes')) || permissao('admin')) : ?>
											<?php $codeModulo = str_replace('/', '_', $p->codeModulo); ?>
											<li>
												<div class="form-check">
													<input class="form-check-input" data-pai="<?= $p->pai ?>" onclick="checkModuloPai('<?= $p->pai ?>')" name="permissoes[]" <?= (in_array($codeModulo, $permissoes)) ? 'checked' : null ?> value="<?= $codeModulo ?>" type="checkbox" id="<?= $codeModulo ?>"> <label class="form-check-label" for="<?= $codeModulo ?>"><?= $p->nome ?></label>
												</div>
											</li>
									<?php endif;
									endforeach; ?>
								</ul>
							</div>
					<?php endif;
					endforeach; ?>
				</div>
			</div>
			<div class="row g-3 mt-4">
				<div class="col-12">
					<a href="<?= base_url('usuario') ?>" class="btn btn-light px-5">
						Cancelar
					</a>
					<button id="buttonSubmit" type="submit" class="btn btn-primary px-5">
						Salvar
					</button>
				</div>
			</div>
		</form>
	</div>
</div>