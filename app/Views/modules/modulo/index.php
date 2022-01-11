
<h4 class="mb-0 text-uppercase"></h4>

<br>
<div class="row">
<?php
/* ACESSO RESTRITO */
if (permissao('superadmin')) :
	$modulos = getSysModulos();
	?>
<!-- modulos padroes -->
	<div class="col-12 col-lg-6 d-flex">
		<div class="card w-100 radius-10">
			<div class="card-header bg-transparent pt-3">
				<h5>Módulos Padrões</h5>
			</div>
			<div class="card-body">

				<ul class="modulosSortable list-unstyled" data-action="<?=base_url('modulo/order/padrao'); ?>">
				<?php foreach($modulos as $m):?>
				<?php $submodulos = getSysModulos($m->code); ?>
					<li id="CD#<?=$m->code?>" class="ui-state-default radius-10 card border shadow-none my-1">
						<div class="card-body py-0 px-0 d-flex align-items-center">
							<div class="input-group">
								<a href="#" data-bs-toggle="modal" data-bs-code="<?= $m->code?>"
									data-bs-icon="<?= $m->icone?>" data-bs-target="#iconModal"
									class="bg-primary text-white fs-5 px-2 radius-10 btn-sm"><i class="bx <?=$m->icone?>"></i></a>
								<input type="text" class="form-control border-0 radius-0" onchange="updateNome(this)"
									data-code="<?= $m->code ?>" value="<?=$m->nome?>">
							</div>

							<span class="btn btn-sm mb-0"><i class="lni lni-arrows-vertical"></i></span> <a
								href="javascript:addModulo('<?= $m->code ?>')" class="btn btn-sm cursor-pointer"><i
								class="bx bx-arrow-from-left"></i></a>

						</div>
						<?php if($submodulos):?>
						<ul class="modulosSortable my-1" data-action="<?=base_url('modulo/order/padrao'); ?>">
						<?php foreach($submodulos as $s):?>
						<li id="CD#<?=$s->code?>" class="ui-state-default radius-10 card border shadow-none my-1">
								<div class="card-body py-0 px-0 d-flex align-items-center">
									<div class="input-group">
										<a href="#" data-bs-toggle="modal" data-bs-code="<?= $s->code?>"
											data-bs-icon="<?= $s->icone?>" data-bs-target="#iconModal"
											class="bg-primary text-white fs-5 px-2 radius-10 btn-sm"><i class="bx <?=$s->icone?>"></i></a>
										<input type="text" class="form-control border-0 radius-0" onchange="updateNome(this)"
											data-code="<?= $s->code ?>" value="<?=$s->nome?>">
									</div>
									<span class="btn btn-sm mb-0"><i class="lni lni-arrows-vertical"></i></span> <a
										href="javascript:addModulo('<?= $s->code ?>', '<?= $m->code ?>')"
										class="btn btn-sm cursor-pointer"><i class="bx bx-arrow-from-left"></i></a>

								</div>
							</li>
						<?php endforeach;?>
						</ul>
						<?php endif;?>
					</li>
				<?php endforeach;?>
				</ul>
				<form action="<?= base_url('modulo/save') ?>" method="post">
					<div class="input-group">
						<a href="#" data-bs-toggle="modal" data-bs-code="" data-bs-icon="bx-chevron-right-square"
							data-bs-target="#iconModal" class="bg-primary text-white fs-5 px-2 radius-10 btn-sm">
					<?php ?><i id="moduloIcone" class="bx bx-chevron-right-square"></i>
						</a>
						<!-- input -->
						<input id="inputModuloIcone" name="icone" class="d-none" value="bx-chevron-right-square">
						<!-- input -->
						<input type="text" name="nome" class="form-control radius-0" placeholder="Adicionar novo">
						<!-- select -->
						<select name="pai" class="form-control radius-0">
							<option value="">Submenu de: Nenhum</option>
							<?php foreach ($modulos as $m):?>
							<option value="<?= $m->code ?>">Submenu de: <?= $m->nome ?></option>
							<?php endforeach;?>
						</select>
						<button type="submit" class="btn btn-success btn-sm">Adicionar</button>
					</div>
				</form>
			</div>

		</div>

	</div>
	<!-- end modulos padroes -->
<?php 
endif;

	/* ACESSO PERMITIDO */

$modulos = getModulos();
?>
<!-- meus modulos -->
	<div class="col-12 col-lg-6 d-flex">
		<div class="card w-100 radius-10">
			<div class="card-header bg-transparent pt-3">
				<h5>Meus Módulos - <?= CODEEMPRESA ?></h5>
			</div>
			<div class="card-body">

				<ul class="modulosSortable list-unstyled" data-action="<?=base_url('modulo/order/empresa'); ?>">
				<?php foreach($modulos as $m):?>
				<?php $submodulos = getModulos($m->codeModulo); ?>
					<li id="CD#<?=$m->code?>" class="ui-state-default radius-10 card border shadow-none my-1">
						<div class="card-body py-0 px-0 d-flex align-items-center">
							<div class="input-group">
								<a href="#" data-bs-toggle="modal" data-bs-code="<?= $m->code?>"
									data-bs-icon="<?= $m->icone?>" data-bs-target="#iconModal"
									class="bg-primary text-white fs-5 px-2 radius-10 btn-sm"><i class="bx <?=$m->icone?>"></i></a>
								<input type="text" class="form-control border-0 radius-0" onchange="updateNome(this)"
									data-code="<?= $m->code ?>" value="<?=$m->nome?>">
							</div>
							<?php if($m->status == 1):?>
							<a href="<?= base_url('modulo/status/'.$m->code.'/desativar') ?>"
								class="btn btn-sm cursor-pointer text-success"><i class="bx bx-checkbox-checked"></i></a>
							<?php elseif($m->status == 2):?>
							<a href="<?= base_url('modulo/status/'.$m->code.'/ativar') ?>"
								class="btn btn-sm cursor-pointer"><i class="bx bx-checkbox"></i></a>
							<?php endif;?>	
							<span class="btn btn-sm mb-0"><i class="lni lni-arrows-vertical"></i></span>

						</div>
						<?php if($submodulos):?>
						<ul class="modulosSortable my-1" data-action="<?=base_url('modulo/order/empresa'); ?>">
						<?php foreach($submodulos as $s):?>
						<li id="CD#<?=$s->code?>" class="ui-state-default radius-10 card border shadow-none my-1">
								<div class="card-body py-0 px-0 d-flex align-items-center">
									<div class="input-group">
										<a href="#" data-bs-toggle="modal" data-bs-code="<?= $s->code?>"
											data-bs-icon="<?= $s->icone?>" data-bs-target="#iconModal"
											class="bg-primary text-white fs-5 px-2 radius-10 btn-sm"><i class="bx <?=$s->icone?>"></i></a>
										<input type="text" class="form-control border-0 radius-0" onchange="updateNome(this)"
											data-code="<?= $s->code ?>" value="<?=$s->nome?>">
									</div>
									<?php if($s->status == 1):?>
									<a href="<?= base_url('modulo/status/'.$s->code.'/desativar') ?>"
										class="btn btn-sm cursor-pointer text-success"><i class="bx bx-checkbox-checked"></i></a>
									<?php elseif($s->status == 2):?>
									<a href="<?= base_url('modulo/status/'.$s->code.'/ativar') ?>"
										class="btn btn-sm cursor-pointer"><i class="bx bx-checkbox"></i></a>
									<?php endif;?>	
									<span class="btn btn-sm mb-0"><i class="lni lni-arrows-vertical"></i></span>
								</div>
							</li>
						<?php endforeach;?>
						</ul>
						<?php endif;?>
					</li>
				<?php endforeach;?>
				</ul>

			</div>

		</div>

	</div>
	<!-- end meus modulos -->
</div>

<div class="modal fade" id="iconModal" tabindex="-1" aria-labelledby="iconModal" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Selecione o icone</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">

				<?php echo view('modules/modal/icons')?>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>