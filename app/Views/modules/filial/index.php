<a href="<?= base_url() ?>/filial/adicionar" class="btn btn-sm btn-primary  float-end m-1">Adicionar nova filial</a>

<!-- <a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#modalFiltro" class="btn btn-secondary btn-sm float-end m-1">Filtros</a> -->


<h4 class="mb-0 text-uppercase">Filiais</h4>

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


							if (configColunas('Filial', $k)) :



						?>

								<th><?= $v; ?></th>

						<?php
							endif;
						endforeach; ?>

						<th></th>

					</tr>

				</thead>

				<tbody>

					<?php foreach ($filiais as $u) :

						//dados do campo extra
						$dados = json_decode($u->camposExtras);
						$dados = (array) $dados;



					?>

						<tr>
							<td><?= statusFilial($u->status) ?></td>
							<td><?= date('d/m/Y H:i', strtotime($u->created_at)); ?></td>
							<?php foreach ($colunas  as $k => $v) : ?>
								<?php if (configColunas('Filial', $k)) : ?>
									<?php if ($k == 'totalUsuarios') : ?>
										<td>
											<a href="<?php /*base_url('usuario/filtroRapido/usuario/codeFilial/' . $u->code);*/ ?>">
												<span class="badge rounded-pill bg-primary"><?= $u->totalUsuarios ?></span>
											</a>
										</td>
									<?php else : ?>
										<td>
											<?php if (isset($u->$k)) :
												echo $u->$k;
											else :
												if (isset($dados[$k])) :
													echo $dados[$k];
												endif;
											endif; ?>
										</td>
									<?php endif; ?>
								<?php endif; ?>
							<?php endforeach; ?>

							<td>

								<a href="<?= base_url() ?>/filial/detalhe/<?= $u->code ?>" class="btn btn-primary btn-sm">Detalhes</a>

								<?php if ($u->totalUsuarios == 0 && permissao('excluir_filial')) : ?>
									<a href="<?= base_url() ?>/filial/excluir/<?= $u->code ?>" class="confirm btn btn-danger btn-sm">Excluir</a>
								<?php endif; ?>
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
<?php endif; ?>
<a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#configColunas" class="btn btn-sm btn-primary">Configurar Colunas</a>






<?php
$data['tabela'] = 'filial';

// carega as modais

$data['camposExtras'] = $camposExtras;
echo view('modules/modal/configCampos', $data);

$data['colunas'] = $colunas;
echo view('modules/modal/configColunas', $data);

if (isset($_SESSION['filtroFilial']))
	$data['filtros'] = $_SESSION['filtroFilial'];

echo view('modules/modal/filtro', $data);
?>