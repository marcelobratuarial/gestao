<div class="modal modal-md fade" id="configStatus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-body pb-0" style="overflow-y: hidden;">
				<div class="row">
					<div class="col-10">
						<h5 class="modal-title" id="staticBackdropLabel">Configuração de Status</h5>
					</div>
					<div class="col-2 text-end">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
				</div>
			</div>
			<div class="modal-body border-1 border-top" style="overflow-y: hidden;">

				<ul id="sortableStatus" class="sortable" data-tabela='<?= $tabela ?>'>
					<?php foreach ($status as $u) :
					?>
					<li id='<?= $u -> code ?>' class='ui-state-default <?= ($u -> tipo == 2) ? null : 'ui-state-disabled' ?> text-center'><span class='btn btn-<?= $u -> cor ?> w-60 me-2'><?= $u -> nome ?></span>
						<?= ($u -> tipo == 2) ? "<a href='javascript:statusDelete(\"" . $tabela . "/" . $u->code . "\")' class='text-danger'><i class='bx bx-trash'></i></a>" : "<i class='bx bx-lock'></i>" ?>
					</li>

					<?php endforeach; ?>
				</ul>
				<hr>

				<br>
				<form id="statusForm" action="<?php echo site_url('configuracao/adicionarStatus/' . $tabela); ?>" method="post">

					<label><b>Adicionar novo Status</b></label>

					<div class="row">
						<div class="col-md-8">
							<input type="text" name="nome" class="form-control">
						</div>
						<div class="col-md-4">
							<select name="cor" class="form-control bg-light">					
								<option value="transparent" class="bg-light-transparent text-transparent">Cinza Claro</option>
								<option value="primary" class="bg-primary text-light">Azul</option>
								<option value="danger" class="bg-danger">Vermelho</option>
								<option value="success" class="bg-success">Verde</option>
								<option value="info" class="bg-info">Ciano</option>
								<option value="warning" class="bg-warning">Amarelo</option>
								<option value="dark" class="bg-dark text-light">Preto</option>
								<option value="secondary" class="bg-secondary text-light">Cinza</option>
							</select>
						</div>
					</div>
					<a href="javascript:{}" onclick="document.getElementById('statusForm').submit();" class="btn btn-primary mt-2 d-block">
						Salvar
					</a>

				</form>

			</div>

		</div>
	</div>
</div>