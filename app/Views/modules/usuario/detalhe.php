<?php
$permissoes = ($usuario->permissoes) ? json_decode($usuario->permissoes) : array();
?>
<div class="card border-top border-0 border-4 border-primary">
	<div class="card-body p-5">
		<form id="formWithPassword" method="post" action="<?= base_url('usuario/save') ?>">
			<div class="card-title d-flex align-items-center">
				<div>
					<i class="bx bxs-user me-1 h5 text-primary"></i>
				</div>
				<div class="h5 mb-0 text-primary w-100">
					Editar Usuário
					<?php if ($usuario->code != $_SESSION['usuarioCode']) : ?>
						<?php if ($usuario->status == 1) : ?>
							<a href="<?= base_url('usuario/desativar/' . $usuario->code) ?>" class="text-success ms-5"><i class="lni lni-checkmark-circle me-0"></i></a>
						<?php else : ?>
							<a href="<?= base_url('usuario/ativar/' . $usuario->code) ?>" class="text-warning ms-5"><i class="lni lni-cross-circle me-0"></i></a>
						<?php endif; ?>

						<a href="<?= base_url('usuario/excluir/' . $usuario->code) ?>" class="confirm text-danger ms-2"><i class="lni lni-trash me-0"></i></a>
						<div id="newPassword" class="w-25 float-end text-end">
							<button type="button" name="password" onclick="newPassword(this);" class="btn btn-warning btn-sm w-100"><i class="lni lni-lock me-0"></i> Gerar nova senha</button>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<hr>

			<div class="row g-3">
				<div class="col-md-6">
					<label for="inputName" class="form-label">Nome</label> <input type="text" name="nome" class="form-control" id="inputName" value="<?= $usuario->nome ?>" required>
				</div>
				<div class="col-md-6">
					<label for="inputUserIf" class="form-label">CPF</label> <input type="text" name="userIf" data-mask="000.000.000-00" class="form-control" id="inputUserIf" value="<?= $userIf ?>">
				</div>
				<div class="col-md-6">
					<label for="inputTelefone" class="form-label">Telefone</label> <input type="text" name="telefone" class="telMask form-control" id="inputTelefone" value="<?= $usuario->telefone ?>">
				</div>
				<div class="col-md-6">
					<label for="inputEmail" class="form-label">Email</label> <input type="email" name="email" class="form-control" id="inputEmail" value="<?= $usuario->email ?>" required>
				</div>
				<div class="col-md-6">
					<label for="selectFilial" class="form-label">Filial</label> <select name="codeFilial[]" class="multiple-select form-control" data-placeholder="Selecione uma filial" id="selectFilial" multiple="multiple" required>
						<?php $filiaisJson = getFilial(); ?>
						<?php foreach ($filiaisJson as $k => $p) : ?>
							<option value="<?= $p->code ?>" <?= in_array($p->code, json_decode($usuario->codeFilial)) ? 'selected' : null ?>><?= $p->nome ?></option>
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
			<?php if ($usuario->perfil == $_SESSION['usuarioPerfil']->code && !permissao('usuario')) : ?>
				<h3>-</h3>
			<?php else : ?>
				<div id='permissaoModulos' class="g-3 mt-4">
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
							<?php if ((!permissao('admin') && $p->code == $usuario->perfil) || permissao('admin')) : ?>
								<option value="<?= $p->code ?>" <?= ($p->code == $usuario->perfil) ? 'selected' : null; ?> data-permissoes='<?= $p->permissoes ?>'><?= $p->nome ?></option>
							<?php endif; ?>
						<?php endforeach; ?>
					</select>
					<div id="permissoesCheckboxes" class="row g-3 mt-4">
						<?php foreach (getPermissoes() as $p) :
							if (in_array($p->acesso, (array) usuario('permissoes')) || permissao('admin')) : ?>
								<div class="col-3">
									<div class="form-check">
										<input class="form-check-input" name="permissoes[]" <?= (in_array($p->acesso, $permissoes)) ? 'checked' : null ?> value="<?= $p->acesso ?>" type="checkbox" id="<?= $p->acesso ?>"> <label class="form-check-label" for="<?= $p->acesso ?>"><?= $p->nome ?></label>
									</div>
								</div>
						<?php endif;
						endforeach; ?>
						<div class="card-title d-flex align-items-center mt-4">
							<div>
								<i class="bx bx-customize me-1 font-22 text-primary"></i>
							</div>
							<h5 class="mb-0 text-primary">Módulos permitidos</h5>
						</div>
						<hr>
						<?php
						foreach (getModulos() as $p) :
							if (in_array($p->codeModulo, (array) usuario('permissoes')) || permissao('admin')) :
						?>
								<?php $subModulo = getModulos($p->codeModulo); ?>
								<?php $codeModulo = str_replace('/', '_', $p->codeModulo); ?>
								<div class="col-3">

									<div class="form-check">
										<input class="form-check-input" name="permissoes[]" onclick="checkModuloFilhos('<?= $p->codeModulo ?>')" <?= (in_array($p->codeModulo, $permissoes)) ? 'checked' : null ?> value="<?= $codeModulo ?>" type="checkbox" id="<?= $codeModulo ?>"> <label class="form-check-label" for="<?= $codeModulo ?>"><?= $p->nome ?></label>
									</div>


									<ul class="list-unstyled">
										<?php foreach ($subModulo as $p) :
											if (in_array($p->codeModulo, (array) usuario('permissoes')) || permissao('admin')) :
										?>
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
			<?php endif; ?>
			<div class="row g-3 mt-4">
				<div class="col-12">
					<a href="<?= base_url('usuario') ?>" class="btn btn-light px-5"> Cancelar </a>
					<button id="buttonSubmit" type="submit" name="code" value="<?= $usuario->code ?>" class="btn btn-primary px-5">Salvar</button>
				</div>
			</div>
		</form>
	</div>
</div>