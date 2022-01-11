<!-- <a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#modalFiltro" class="btn btn-secondary btn-sm float-end m-1">Filtros</a> -->


<a href="<?= base_url() ?>/cliente/adicionar" class="btn btn-primary btn-sm float-end m-1">Adicionar novo <?= customWord('cliente', false) ?></a>

<h4 class="mb-0 text-uppercase"><?= customWord('cliente', true) ?></h4>

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


							if (configColunas('Cliente', $k)) :



						?>

								<th><?= $v; ?></th>

						<?php
							endif;
						endforeach; ?>

						<th></th>
					</tr>

				</thead>

				<tbody>

					<?php foreach ($cliente as $u) :

						//dados do campo extra
						$dados = json_decode($u->camposExtras);
						$dados = (array) $dados;
						$status = getStatus('cliente', $u->codeStatus);

					?>

						<tr>
							<td>
								<?php if ($status->code != 'final') : ?>
									<div onclick="changeStatus('cliente', '<?= $u->code ?>')" class="cursor-pointer badge rounded-pill	text-<?= $status->cor ?> bg-light-<?= $status->cor ?> p-2 text-uppercase px-3">
										<i class="bx bxs-circle me-1"></i><?= $status->nome ?>
									</div>
								<?php else : ?>
									<div class="badge rounded-pill	text-<?= $status->cor ?> bg-light-<?= $status->cor ?> p-2 text-uppercase px-3">
										<i class="bx bxs-circle me-1"></i><?= $status->nome ?>
									</div>
								<?php endif; ?>
							</td>
							<td><?= date('d/m/Y H:i', strtotime($u->created_at)); ?></td>
							<?php foreach ($colunas  as $k => $v) : ?>
								<?php if (configColunas('lead', $k)) : ?>
									<?php if ($k == 'perfil') : ?>
										<td><?= perfilUsuario($u->perfil); ?></td>

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

							<td>

								<a href="<?= base_url() ?>/usuario/detalhe/<?= $u->code ?>" class="btn btn-primary btn-sm">Detalhes</a>

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
<a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#configColunas" class="btn btn-sm btn-primary m-1">Configurar Colunas</a>



<?php
$data['tabela'] = 'cliente';

// carega as modais

$data['camposExtras'] = $camposExtras;
echo view('modules/modal/configCampos', $data);

$data['colunas'] = $colunas;
echo view('modules/modal/configColunas', $data);

if (isset($_SESSION['filtroCliente']))
	$data['filtros'] = $_SESSION['filtroCliente'];

echo view('modules/modal/filtro', $data);

unset($data);
$data['tabela'] = 'cliente';
$data['status'] = $status->MeusStatus('cliente');
echo view('modules/modal/configStatus', $data);


?>