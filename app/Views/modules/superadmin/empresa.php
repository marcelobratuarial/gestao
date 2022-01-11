<a href="<?=base_url() ?>/superadmin/adicionar-empresa" class="btn btn-primary btn-sm float-end m-1">Adicionar nova empresa?</a>

<h4 class="mb-0 text-uppercase">Empresas</h4>

<br>

<div class="card">

	<div class="card-body">

		<div class="table-responsive">

			<table id="table-primary" class="table table-striped table-bordered" style="width:100%">

				<thead>

					<tr>

						<th>CODE</th>						
						<th>Status</th>
						<th>Nome</th>
						<th></th>

					</tr>

				</thead>

				<tbody>
					<?php foreach($empresas as $e):
						?>
					<tr>
						<td><?= $e -> code ?></td>
						<td><?= $e -> status ?>//FAZER UM SWITCH</td>
						<td><?= $e -> nome ?></td>
						<td> 
							<?php if($_SESSION['usuarioEmpresa'] != $e->code): ?>
							<a href="<?=base_url('/superadmin/selecionarEmpresa/' . $e -> code) ?>" class="btn btn-light btn-sm"><i class="bx bx-checkbox"></i> Selecionar</a>
							<?php else: ?>
							<a href="javascript:void();" class="btn btn-primary btn-sm"><i class="bx bx-checkbox-checked"></i> Selecionada</a>
							<?php endif; ?>
						</td>
					</tr>
					<?php endforeach; ?>

				</tbody>

			</table>

		</div>

	</div>

</div>
