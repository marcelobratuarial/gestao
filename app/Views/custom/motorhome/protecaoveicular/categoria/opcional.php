<div class="card border-top border-0 border-4 border-primary">
	<div class="card-body p-5">
		<div class="card-title d-flex align-items-center">
			<div>
				<i class="bx bxs-user-check me-1 font-22 text-primary"></i>
			</div>
			<h5 class="mb-0 text-primary">Editando Opcional</h5>
		</div>
		<hr>
		<form method="post" action="<?= base_url("$path/save/opcionais"); ?>">
			<div class="row g-3 my-3">
				<div class="col-md-4">
					<label class="form-label">Categoria</label>
					<select class="form-select" name="codeCategoria">
						<option value="">Todas as Categorias</option>
						<?php foreach ($categorias as $c) : ?>
							<option value="<?= $c->code; ?>" <?= $c->code == $opcional->codeCategoria ? 'selected' : null ?>><?= $c->titulo; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-md-4">
					<label class="form-label">Tipo</label>
					<select onchange="makeSelect(this.value)" class="form-select" name="tipo">
						<option value="checkbox" <?= $opcional->tipo == 'checkbox' ? 'selected' : null ?>>Checkbox</option>
						<option value="select" <?= $opcional->tipo == 'select' ? 'selected' : null ?>>Select</option>
						<option value="oculto" <?= $opcional->tipo == 'oculto' ? 'selected' : null ?>>Oculto</option>
					</select>
				</div>
			</div>
			<div class="row g-3">
				<div id="mkSelectOptions" class="col-12 my-3 border p-3 rounded <?= $opcional->tipo != 'select' ? "d-none" : null ?> ">
					<h5>Opções Selecionáveis</h5>
					<?php $n = count((array)$opcional->options); ?>
					<?php if ($n > 0) :
						foreach ($opcional->options as $k => $opt) : ?>
							<div id="mkSelectOption<?= $k ?>" class="row">
								<div class="col">
									<label for="inputOptTitulo<?= $k ?>" class="form-label">Titulo</label>
									<input type="text" name="options[<?= $k ?>][titulo]" class="form-control" id="inputOptTitulo" required value="<?= $opt->titulo ?>">
								</div>

								<div class="col">
									<label for="inputOptValor<?= $k ?>" class="form-label">Valor</label>
									<input type="text" name="options[<?= $k ?>][valor]" data-mask="#00.00" data-mask-reverse="true" class="form-control" id="inputOptValor" required value="<?= $opt->valor ?>">
								</div>

								<div class="col">
									<label for="inputOptCota<?= $k ?>" class="form-label">Cota</label>
									<input type="text" name="options[<?= $k ?>][cota]" data-mask="#00.00" data-mask-reverse="true" class="form-control" id="inputOptCota" required value="<?= $opt->cota ?>">
								</div>

								<div class="col">
									<label for="inputOptCotaMin<?= $k ?>" class="form-label">Cota Min</label>
									<input type="text" name="options[<?= $k ?>][cota_min]" data-mask="#00.00" data-mask-reverse="true" class="form-control" id="inputOptCotaMin" required value="<?= $opt->cota_min ?>">
								</div>
								<div id="mkSelectFirstOption" class="col">
									<br>
									<button type="button" class="btn btn-link btn-sm p-0" onclick="addSelectOption(<?= $n ?>)"><i class="bx fs-2 bx-plus-circle m-0"></i></button>
									<?php if ($k > 0) : ?>
										<button type="button" class="btn btn-link btn-sm text-danger p-0" onclick="removeSelectOption(<?= $k ?>)"><i class="bx fs-2 bx-minus-circle m-0"></i></button>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach;
					else : $k = 0; ?>
						<div id="mkSelectOption<?= $k ?>" class="row">
							<div class="col">
								<label for="inputOptTitulo<?= $k ?>" class="form-label">Titulo</label>
								<input type="text" name="options[<?= $k ?>][titulo]" class="form-control" id="inputOptTitulo" value="">
							</div>

							<div class="col">
								<label for="inputOptValor<?= $k ?>" class="form-label">Valor</label>
								<input type="text" name="options[<?= $k ?>][valor]" data-mask="#00.00" data-mask-reverse="true" class="form-control" id="inputOptValor" value="">
							</div>

							<div class="col">
								<label for="inputOptCota<?= $k ?>" class="form-label">Cota</label>
								<input type="text" name="options[<?= $k ?>][cota]" data-mask="#00.00" data-mask-reverse="true" class="form-control" id="inputOptCota" value="">
							</div>

							<div class="col">
								<label for="inputOptCotaMin<?= $k ?>" class="form-label">Cota Min</label>
								<input type="text" name="options[<?= $k ?>][cota_min]" data-mask="#00.00" data-mask-reverse="true" class="form-control" id="inputOptCotaMin" value="">
							</div>
							<div id="mkSelectFirstOption" class="col">
								<br>
								<button type="button" class="btn btn-link btn-sm p-0" onclick="addSelectOption(1)"><i class="bx fs-2 bx-plus-circle m-0"></i></button>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="row g-3 my-3">
				<div class="col-md-4">
					<label for="inputName" class="form-label">Titulo</label>
					<input type="text" name="titulo" class="form-control" id="inputName" value="<?= $opcional->titulo ?>" required>
				</div>

				<div class="col-md-8">
					<label for="inputName" class="form-label">Descricao</label>
					<input type="text" name="descricao" class="form-control" id="inputName" value="<?= $opcional->descricao ?>">
				</div>
			</div>

			<div class="row g-3 my-3">
				<div class="col-md-4">
					<label for="inputName" class="form-label">Valor</label>
					<input type="text" name="valor" required data-mask="#00.00" data-mask-reverse="true" class="form-control" id="inputName" value="<?= $opcional->valor ?>">
				</div>

				<div class="col-md-4">
					<label for="inputName" class="form-label">Cota</label>
					<input type="text" name="cota" data-mask="#00.00" data-mask-reverse="true" class="form-control" id="inputName" value="<?= $opcional->cota ?>">
				</div>

				<div class="col-md-4">
					<label for="inputName" class="form-label">Cota Min</label>
					<input type="text" name="cota_min" data-mask="#00.00" data-mask-reverse="true" class="form-control" id="inputName" value="<?= $opcional->cota_min ?>">
				</div>


			</div>

			<div class="row g-3 mt-4">
				<div class="col-12">
					<button type="submit" name="id" value="<?= $opcional->id ?>" class="btn btn-primary px-5">Salvar</button>
					<a href="<?= base_url($path . '/delete/opcional/' . $opcional->id) ?>" class="confirm btn btn-danger px-5">Excluir</a>
				</div>
			</div>
		</form>
	</div>
</div>