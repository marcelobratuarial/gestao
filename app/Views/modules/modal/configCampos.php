<div class="modal modal-md fade" id="configCampos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<form id="camposForm" action="<?= base_url('configuracao/adicionarCampoExtra/' . $tabela) ?>" method="post" >

				<div class="modal-body pb-0" style="overflow-y: hidden;">
					<div class="row">
						<div class="col">
							<h5 class="modal-title" id="staticBackdropLabel">Campos Extras</h5>
						</div>
						<div class="col text-end">
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
					</div>
				</div>
				<div class="modal-body border-1 border-top" style="overflow-y: hidden;">
					<ul id="sortableCampoExtra" class="sortable" data-tabela='<?= $tabela ?>'>
						<?php
						if ($camposExtras) :
							foreach ($camposExtras as $ce) :

								echo "<li id='$ce' class='ui-state-default text-center'><span class='btn btn-primary w-60 me-2'>$ce</span><a href='" . base_url("configuracao/apagarCampoExtra/$tabela/$ce") . "' class='confirm text-danger'><i class='bx bx-trash'></i></a></li>";

							endforeach;
						else :
							echo "<li>Nenhum campo extra cadastrado.</li>";
						endif;
						?>
					</ul>
					<br>
					<br>

					<label><b>Adicionar novo campo</b></label>

					<input type="text" name="extra" class="form-control" value="">

					<a href="javascript:{}" onclick="document.getElementById('camposForm').submit();" class="btn btn-primary mt-2 d-block">
						Salvar
					</a>

				</div>

			</form>
		</div>
	</div>
</div>
