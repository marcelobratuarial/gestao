<div class="card border-top border-0 border-4 border-primary">
	<div class="card-body p-5">
		<div class="card-title d-flex align-items-center">
			<div>
				<i class="bx bxs-add-to-queue me-1 font-22 text-primary"></i>
			</div>
			<h5 class="mb-0 text-primary">Adicionar Categoria</h5>
		</div>
		<hr>
		<form method="post" action="<?= base_url('motorhome/protecaoveicular/save') ?>">
		<input type="hidden" name="status" value="0">
			<div class="row g-3">
				<div class="col-md-12">
					<label for="inputTitulo" class="form-label">Título</label>
					<input type="text" name="titulo" class="form-control" id="inputTitulo" required>
				</div>
				<div class="col-md-12">
					<label for="textareaDescricao" class="form-label">Descrição</label>
					<textarea name="descricao" maxlength="500" class="form-control" id="textareaDescricao"></textarea>
				</div>
				<div class="col-md-12">
					<label for="textareaBeneficio" class="form-label">Benefícios</label>
					<textarea name="beneficio" maxlength="500" class="form-control" id="textareaBeneficio"></textarea>
				</div>
			</div>
			<div class="row g-3 mt-4">
				<div class="col-12">
					<a href="<?=base_url('motorhome/protecaoveicular');?>" class="btn btn-light px-5">
						Voltar
					</a>
					<button type="submit" class="btn btn-primary px-5">
						Adicionar
					</button>
				</div>
			</div>
		</form>
	</div>
</div>

