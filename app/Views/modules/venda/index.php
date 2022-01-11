<!-- <a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#modalFiltro" class="btn btn-secondary btn-sm float-end m-1">Filtros</a> -->


<h4 class="mb-0 text-uppercase">Vendas</h4>

<br>

<div class="card">

	<div class="card-body">

		<div class="table-responsive">

			<table id="table-primary" class="table table-striped table-bordered" style="width:100%">

				<thead>

					<tr>
						<th>Status</th>
						<th>Data</th>

						<?php
						foreach ($colunas  as $k => $v) :
							if (configColunas('venda', $k)) :
						?>

								<th><?= $v; ?></th>

						<?php
							endif;
						endforeach; ?>

						<th></th>

					</tr>

				</thead>


				<tbody>

					<?php

					foreach ($vendas as $u) :
						$dados = (isset($u->camposExtras)) ? json_decode($u->camposExtras, true) : null;
						$status = getStatus('venda', $u->codeStatus);
					?>

						<tr>
							<td>
								<?php if ($status->code != 'final') : ?>
									<div onclick="changeStatus('venda', '<?= $u->code ?>')" class="cursor-pointer badge rounded-pill	text-<?= $status->cor ?> bg-light-<?= $status->cor ?> p-2 text-uppercase px-3">
										<i class="bx bxs-circle me-1"></i><?= $status->nome ?>
									</div>
								<?php else : ?>
									<div class="badge rounded-pill	text-<?= $status->cor ?> bg-light-<?= $status->cor ?> p-2 text-uppercase px-3">
										<i class="bx bxs-circle me-1"></i><?= $status->nome ?>
									</div>
								<?php endif; ?>
							</td>
							<td><?= date('Y/m/d H:i', strtotime($u->created_at)); ?></td>

							<?php foreach ($colunas  as $k => $v) : ?>
								<?php if (configColunas('venda', $k)) : ?>
									<?php if ($k == 'perfil') : ?>
										<td><?= perfilUsuario($u->perfil); ?></td>

									<?php elseif ($k == 'codeUsuario') : ?>
										<td><?= getUsuario($u->$k, 'nome'); ?></td>

									<?php elseif ($k == 'produto') : ?>
										<td><?= getProduto(getProposta($u->codeProposta, 'codeProduto'), 'nome'); ?></td>

									<?php elseif ($k == 'nome') : ?>
										<td><?= getDadosProposta($u->codeProposta, 'nome') ?></td>

									<?php else : ?>
										<td>
											<?php
											if (isset($u->$k)) :
												echo $u->$k;
											else :
												if (isset($dados[$k])) :
													echo $dados[$k];
												endif;
											endif;
											?>
										</td>
									<?php endif; ?>
								<?php endif; ?>
							<?php endforeach; ?>


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


<a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#configColunas" class="btn btn-sm btn-primary m-1">Configurar Colunas</a>






<?php
$data['tabela'] = 'venda';
$data['colunas'] = $colunas;
echo view('modules/modal/configColunas', $data);
unset($data);

echo view('modules/modal/configStatus');
unset($data);




?>