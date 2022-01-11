<!-- <a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#modalFiltro" class="btn btn-secondary btn-sm float-end m-1">Filtros</a> -->


<a href="<?= base_url() ?>/usuario/adicionar" class="btn btn-primary btn-sm float-end m-1">Adicionar novo usuário</a>


<h4 class="mb-0 text-uppercase">Usuários</h4>

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


							if (configColunas('Usuario', $k)) :



						?>

								<th><?= $v; ?></th>

						<?php
							endif;
						endforeach; ?>

						<th></th>
					</tr>

				</thead>

				<tbody>

					<?php foreach ($usuarios as $u) :
						if ($u->perfil != perfilAdmin('code') || $_SESSION['usuarioPerfil']->code == $u->perfil || permissao('superadmin')) :

							//dados do campo extra
							$dados = json_decode($u->camposExtras);
							$dados = (array) $dados;

					?>

							<tr>

								<td><?= statusUsuario($u->status) ?></td>
								<td><?= date('d/m/Y H:i', strtotime($u->created_at)) ?></td>
								<?php foreach ($colunas  as $k => $v) : ?>
									<?php if (configColunas('Usuario', $k)) : ?>
										<?php if ($k == 'perfil') : ?>
											<td><?= perfilUsuario($u->perfil, $u->permissoes) ?></td>
										<?php elseif ($k == 'codeFilial') : ?>
											<!-- arrumar isso aqui -->
											<?php $codeFilial = json_decode($u->codeFilial)[0]; ?>
											<td>
												<?= getFilial($codeFilial, 'nome'); ?>
											</td>
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

					<?php endif;
					endforeach; ?>


				</tbody>



			</table>

		</div>

	</div>

</div>

<?php if (permissao('admin')) : ?>
	<a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#configCampos" class="btn btn-sm btn-danger">Configurar Campos</a>
<?php endif; ?>

<a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#configColunas" class="btn btn-sm btn-primary m-1">Configurar Colunas</a>



<?php
$data['tabela'] = 'usuario';

// carega as modais

$data['camposExtras'] = $camposExtras;
echo view('modules/modal/configCampos', $data);

$data['colunas'] = $colunas;
echo view('modules/modal/configColunas', $data);

if (isset($_SESSION['filtroUsuario']))
	$data['filtros'] = $_SESSION['filtroUsuario'];

echo view('modules/modal/filtro', $data);
?>