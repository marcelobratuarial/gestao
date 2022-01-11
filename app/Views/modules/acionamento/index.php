<a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#modalFiltro" class="btn btn-secondary btn-sm float-end m-1">Filtros</a>




<br><br><br>

<div class="card">

	<div class="card-body">

		<div class="table-responsive">

			<table id="table-primary" class="table table-striped table-bordered" style="width:100%">

				<thead>

					<tr>

						<?php
						foreach ($colunas  as $k => $v) :
							if (configColunas('Acionamento', $k)) :
						?>

								<th><?= $v; ?></th>

						<?php
							endif;
						endforeach; ?>

						<th></th>

					</tr>

				</thead>

				<tbody>

					<?php foreach ($acionamentos as $u) :


					?>

						<tr>

							<?php
							foreach ($colunas  as $k => $v) :



								if (configColunas('Acionamento', $k)) :


									if ($k == 'code') {
							?><td>#<?= $u->$k; ?></td><?php
													} elseif ($k == 'created_at') {
														?><td><?= date('d/m/Y H:i', strtotime($u->created_at)) ?></td><?php

																						} elseif ($k == 'codeCliente') {
																							?><td><?= getCliente($u->$k, 'nome'); ?></td><?
																						} elseif ($k == 'codeStatus') {
																			?><td>
											<?= status($u->codeStatus);

											?>

										</td><?php
																						} else {
												?><td><?

																							if (isset($u->$k)) {
																								echo $u->$k;
																							} else {

																								if (isset($dados[$k])) {
																									echo $dados[$k];
																								} else {
																								}
																							}

										?></td><?php
																						}
										?>



							<?php
								endif;
							endforeach;
							?>




							<td>

								<a href="<?= base_url() ?>/acionamento/detalhe/<?= $u->code ?>" class="btn btn-primary btn-sm">Detalhes</a>

							</td>

						</tr>

					<?php endforeach; ?>


				</tbody>



			</table>

		</div>

	</div>

</div>

<?php if (permissao('admin')) : ?>
	<a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#configCampos" class="btn btn-sm btn-danger">Configurar Campos</a>
	<a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#configStatus" class="btn btn-sm btn-danger">Configurar Status</a>
<?php endif; ?>
<a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#configColunas" class="btn btn-sm btn-primary">Configurar Colunas</a>


<?php
$data['tabela'] = 'acionamento';
$data['camposExtras'] = $camposExtras;
$data['colunas'] = $colunas;

echo view('modules/modal/configCampos', $data);
echo view('modules/modal/configColunas', $data);
echo view('modules/modal/filtro');
unset($data);

echo view('modules/modal/configStatus');



?>