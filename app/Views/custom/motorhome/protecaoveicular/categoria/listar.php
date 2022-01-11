



<a href="<?=base_url("produto/configuracao/$produto->code")?>" class="btn btn-dark btn-sm btn-sm float-end m-1">Configurar</a>
<a href="<?=base_url("$path/categorias/adicionar")?>" class="btn btn-primary btn-sm btn-sm float-end m-1">Cadastrar novo</a>

<h4 class="mb-0 text-uppercase"><?= $subtituloPagina ?></h4>

<br>

<div class="card">

	<div class="card-body">
		<div class="row">
	
			<div class="col-md-12">
				<div class="tab-content">
					
					
					<ul class="list-group">
					
							<?php foreach($categoria as $c): ?>
							<li class="list-group-item d-flex justify-content-between align-items-center"><?=$c->titulo;?>
								<a href="<?=base_url("$path/categoria/{$c->code}");?>" class="btn btn-primary btn-sm">EDITAR</a>
							</li>
							<?php endforeach; ?>
							
						</ul>
					
				</div>
			</div>
		</div>
	</div>
</div>