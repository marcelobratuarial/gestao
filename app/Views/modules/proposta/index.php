<!-- <a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#modalFiltro" class="btn btn-secondary btn-sm float-end m-1">Filtros</a> -->
<a href="<?= base_url('lead/adicionar') ?>" class="btn btn-dark btn-sm float-end m-1">Adicionar</a>




<h4 class="mb-0 text-uppercase">Propostas</h4>


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
							if (configColunas('proposta', $k)) :
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
					foreach ($propostas as $u) :

					?>

						<tr>
							<td>
								<div onclick="changeStatus('proposta', '<?= $u->code ?>')" class="cursor-pointer badge rounded-pill 
                    	text-<?= getStatus('proposta', $u->status, 'cor') ?> bg-light-<?= getStatus('proposta', $u->status, 'cor') ?> p-2 text-uppercase px-3">
									<i class="bx bxs-circle me-1"></i><?= getStatus('proposta', $u->status, 'nome') ?>
								</div>
							</td>
							<td><?= date('Y/m/d H:i H:i', strtotime($u->created_at)); ?></td>

							<?php foreach ($colunas  as $k => $v) : ?>
								<?php if (configColunas('proposta', $k)) : ?>
									<?php if ($k == 'nome') : ?>
										<td><?= $u->dadosProposta->nome; ?></td>

									<?php elseif ($k == 'email') : ?>
										<td><?= $u->dadosProposta->email; ?></td>

									<?php elseif ($k == 'telefone') : ?>
										<td><?= $u->dadosProposta->telefone; ?></td>

									<?php elseif ($k == 'codeUsuario') : ?>
										<td><?= getUsuario($u->$k, 'nome'); ?></td>

									<?php elseif ($k == 'codeProduto') : ?>
										<td><?= getProduto($u->$k, 'nome'); ?></td>

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

							<td class="text-end">
								<a href="<?= base_url('portal/proposta/' . $u->code) ?>" target="_blank" class="shareButton btn btn-sm btn-dark"><i class="bx bx-share-alt"></i>Compartilhar</a>
								<a href="<?= base_url('/proposta/visualizar/' . $u->code) ?>" class="btn btn-sm btn-primary">Visualizar</a>
							</td>
						</tr>

					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php if (permissao('admin')) : ?>
	<a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#configStatus" class="btn btn-sm btn-danger">Configurar Status</a>
<?php endif; ?>
<a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#configColunas" class="btn btn-sm btn-primary m-1">Configurar Colunas</a>


<?php

$data['tabela'] = 'proposta';
$data['colunas'] = $colunas;
echo view('modules/modal/configColunas', $data);
unset($data);

echo view('modules/modal/configStatus');
unset($data);

?>