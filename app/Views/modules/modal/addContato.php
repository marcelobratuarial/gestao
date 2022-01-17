<div class="modal modal-md fade" id="addContato" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-body pb-0" style="overflow-y: hidden;">
				<div class="row">
					<div class="col-10">
						<h5 class="modal-title" id="staticBackdropLabel">Adicionar contato</h5>
					</div>
					<div class="col-2 text-end">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
				</div>
			</div>
			<div class="modal-body border-1 border-top" style="overflow-y: hidden;">
				<form id="statusForm" action="<?php echo site_url('contato/save'); ?>" method="post">

					<label><b>Novo contato</b></label>
					<div class="row g-3">
						<div class="col-md-6">
							<label class="form-label">Nome</label>
							<input type="text" class="form-control" name="nome" value='' required>
						</div>
						<div class="col-md-6">
							<label class="form-label">Telefone</label>
							<input class="form-control" name="telefone" value='' required>
						</div>
						<div class="col-md-6">
							<label class="form-label">Email</label>
							<input class="form-control" name="email" value='' required>
						</div>


						<div class="col-md-6">
							<label class="form-label">Celular</label>
							<input class="form-control" name="celular" value=''>
						</div>
						
						<div class="col-md-6">
							<label class="form-label">Whatsapp</label>
							<input class="form-control" name="whatsapp" value=''>
						</div>
						<div class="col-md-6">
							<input type="hidden" name="codeEmpresa" value="<?= $empresa->code; ?>">
							<label class="form-label">Observações</label>
							<input type="hidden" name="redirect" value="<?= current_url(); ?>">
							<input type="hidden" name="codeStatus" value="<?= $empresa->codeStatus; ?>">
							<textarea rows="8" max="1600" name="obs" class="form-control" style="resize: none"></textarea>
						</div>
					</div>
					
					<input type="submit" value="Salvar" class="btn btn-primary mt-2 d-block" />

				</form>

			</div>

		</div>
	</div>
</div>