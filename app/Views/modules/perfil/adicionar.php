<div class="card border-top border-0 border-4 border-primary">
	<div class="card-body p-5">
		<div class="card-title d-flex align-items-center">
			<div>
				<i class="bx bxs-user me-1 font-22 text-primary"></i>
			</div>
			<h5 class="mb-0 text-primary">Adicionar Perfil</h5>
		</div>
		<hr>
		<form method="post" action="<?= base_url('perfil/save') ?>">
			<div class="row g-3">
				<div class="col-md-6">
					<label for="inputName" class="form-label">Nome</label> <input type="text" name="nome" class="form-control" id="inputName">
				</div>
				<!-- <div class="col-md-6">
					<label for="" class="form-label">Nível de acesso</label>
					<select name="" class="form-select" id="">
						<option value="5">Nível 5</option>
						<option value="4">Nível 4</option>
						<option value="3">Nível 3</option>
						<option value="2">Nível 2</option>
						<option value="1" selected>Nível 1</option>
					</select>
				</div> -->
			</div>
			<div id='permissaoModulos' class="row g-3 mt-4">
				<div class="card-title d-flex align-items-center mt-4">
					<div>
						<i class="bx bxs-lock me-1 font-22 text-primary"></i>
					</div>
					<h5 class="mb-0 text-primary">Permissões do Usuário</h5>
				</div>
				<hr>
				<div id="permissoesCheckboxes" class="row g-3 mt-4">
					<?php foreach (getPermissoes() as $p) :
						if (in_array($p->acesso, (array) $_SESSION['usuarioPermissoes']) || permissao('superadmin')) : ?>
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
					<?php foreach (getModulos() as $p) :
						if (in_array($p->codeModulo, (array) $_SESSION['usuarioPermissoes']) || permissao('superadmin')) : ?>
							<?php $subModulo = getModulos($p->codeModulo); ?>
							<?php $codeModulo = str_replace('/', '_', $p->codeModulo); ?>
							<div class="col-3">

								<div class="form-check">
									<input class="form-check-input" name="permissoes[]" onclick="checkModuloFilhos('<?= $p->codeModulo ?>')" <?= (in_array($p->codeModulo, $permissoes)) ? 'checked' : null ?> value="<?= $codeModulo ?>" type="checkbox" id="<?= $codeModulo ?>"> <label class="form-check-label" for="<?= $codeModulo ?>"><?= $p->nome ?></label>
								</div>


								<ul class="list-unstyled">
									<?php foreach ($subModulo as $p) :
										if (in_array($p->codeModulo, (array) $_SESSION['usuarioPermissoes']) || permissao('superadmin')) :
									?>
											<?php $codeModulo = str_replace('/', '_', $p->codeModulo); ?>
											<li>
												<div class="form-check">
													<input class="form-check-input" data-pai="<?= $p->pai ?>" onclick="checkModuloPai('<?= $p->pai ?>')" name="permissoes[]" value="<?= $codeModulo ?>" type="checkbox" id="<?= $codeModulo ?>"> <label class="form-check-label" for="<?= $codeModulo ?>"><?= $p->nome ?></label>
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
					<button id="buttonSubmit" type="submit" class="btn btn-primary px-5">Salvar</button>
				</div>
			</div>
		</form>
	</div>
</div>