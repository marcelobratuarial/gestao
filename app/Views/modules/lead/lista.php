<a href="<?= base_url('lead/adicionar') ?>" class="btn btn-dark btn-sm float-end m-1">Adicionar</a>



<h4 class="mb-0 text-uppercase">Leads</h4>


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
							if (configColunas('Lead', $k)) :
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
					foreach ($leads as $u) :
						$dados = (isset($u->camposExtras)) ? json_decode($u->camposExtras) : null;
						$dados = (array) $dados;
						$status = getStatus('lead', $u->codeStatus);
					?>

						<tr>


							<td>
								<?php if ($status->code != 'final') : ?>
									<div onclick="changeStatus('lead', '<?= $u->code ?>')" class="cursor-pointer badge rounded-pill	text-<?= $status->cor ?> bg-light-<?= $status->cor ?> p-2 text-uppercase px-3">
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
								<?php if (configColunas('lead', $k)) : ?>
									<?php if ($k == 'perfil') : ?>
										<td><?= perfilUsuario($u->perfil); ?></td>

									<?php
									elseif ($k == 'codeUsuario') :
										$responsavel = getUsuario($u->codeUsuario, 'nome');
									?>
										<td><?= $responsavel ? $responsavel : ' - - '; ?></td>

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
								<?php if ($status->code != 'final') : ?>
									<a href="<?= base_url('proposta/gerar/' . $u->code) ?>" class="btn btn-sm btn-success">Gerar proposta</a>
								<?php else : ?>
									<a href="<?= base_url('proposta/gerar/' . $u->code) ?>" class="btn btn-sm btn-info text-white">Gerar nova proposta</a>
								<?php endif; ?>
								<a href="<?= base_url('lead/detalhe/' . $u->code) ?>" class="btn btn-sm btn-primary">Detalhes</a>
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
$data['tabela'] = 'lead';
$data['colunas'] = $colunas;
echo view('modules/modal/configColunas', $data);
unset($data);

echo view('modules/modal/configStatus');
unset($data);




?>