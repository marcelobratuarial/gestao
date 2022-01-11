<a href="<?= base_url($path); ?>" class="btn btn-secondary btn-sm float-end m-1">Voltar</a>



<h4 class="mb-0 text-uppercase"><?= $subtituloPagina ?></h4>

<br>


<div class="row mb-2">
	<div class="col-md-12">
		<ul class="nav nav-pills">
			<li class="nav-item "><a class="nav-link <?= ($display == 'configuracoes') ? "active" : null ?>" href="<?= base_url("$path/categoria/$code/configuracoes") ?>">Configurações</a></li>
			<li class="nav-item"><a class="nav-link <?= ($display == 'tabela') ? "active" : null ?>" href="<?= base_url("$path/categoria/$code/tabela") ?>">Tabela</a></li>
			<!-- <li class="nav-item"><a class="nav-link <?= ($display == 'opcionais') ? "active" : null ?>" href="<?= base_url("$path/categoria/$code/opcionais") ?>">Opcionais</a></li> -->
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<?= view("custom/$path/categoria/$display") ?>
	</div>
</div>