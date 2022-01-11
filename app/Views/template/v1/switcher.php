<?php if(permissao('superadmin')): ?>
<div class="switcher-wrapper">

	<div class="switcher-btn">
		<i class='bx bx-cog bx-spin'></i>
	</div>

	<div class="switcher-body vh-100" data-simplebar="true">

		<div class="d-flex align-items-center">

			<h5 class="mb-0 text-uppercase">Customização</h5>

			<?/*button type="button" class="btn-close ms-auto close-switcher" aria-label="Close"></button*/?>

		</div>

		

		<hr/>
		<h6 class="mb-0">Estilos de tema</h6>

		<hr/>

		<div class="d-flex align-items-center justify-content-between">

			<div class="form-check">

				<input class="form-check-input" onclick="changeColor('light-theme')" type="radio" name="flexRadioDefault" id="lightmode" <?= ($_SESSION['empresaCor'] == 'light-theme') ? 'checked' : null ?>>

				<label class="form-check-label" for="lightmode">Claro</label>

			</div>

			<div class="form-check">

				<input class="form-check-input" onclick="changeColor('semi-dark')" type="radio" name="flexRadioDefault" id="semidark" <?= ($_SESSION['empresaCor'] == 'semi-dark') ? 'checked' : null ?>>

				<label class="form-check-label" for="semidark">Semi Escuro</label>

			</div>

		</div>

		<hr/>

		<div class="form-check">

			<input class="form-check-input" onclick="changeColor('minimal-theme')" type="radio" id="minimaltheme" name="flexRadioDefault" <?= ($_SESSION['empresaCor'] == 'minimal-theme') ? 'checked' : null ?>>

			<label class="form-check-label" for="minimaltheme">Tema minimalista</label>

		</div>

		<hr/>

		<h6 class="mb-0">Cor do menu lateral</h6>

		<hr/>

		<div class="header-colors-indigators">

			<div class="row row-cols-auto g-3">

				<div class="col">

					<div onclick="changeColor('color-sidebar '+this.id)" class="indigator sidebarcolor1" id="sidebarcolor1"></div>

				</div>

				<div class="col">

					<div onclick="changeColor('color-sidebar '+this.id)" class="indigator sidebarcolor2" id="sidebarcolor2"></div>

				</div>

				<div class="col">

					<div onclick="changeColor('color-sidebar '+this.id)" class="indigator sidebarcolor3" id="sidebarcolor3"></div>

				</div>

				<div class="col">

					<div onclick="changeColor('color-sidebar '+this.id)" class="indigator sidebarcolor4" id="sidebarcolor4"></div>

				</div>

				<div class="col">

					<div onclick="changeColor('color-sidebar '+this.id)" class="indigator sidebarcolor5" id="sidebarcolor5"></div>

				</div>

				<div class="col">

					<div onclick="changeColor('color-sidebar '+this.id)" class="indigator sidebarcolor6" id="sidebarcolor6"></div>

				</div>

				<div class="col">

					<div onclick="changeColor('color-sidebar '+this.id)" class="indigator sidebarcolor7" id="sidebarcolor7"></div>

				</div>

				<div class="col">

					<div onclick="changeColor('color-sidebar '+this.id)" class="indigator sidebarcolor8" id="sidebarcolor8"></div>

				</div>

			</div>

		</div>
		<hr/>

		<h6 class="mb-0">Logo</h6>

		<hr/>

		<div id="logoUpload" class="">
			<div class="p-3 bg-light">
				<img src="<?= ($_SESSION['empresaLogo']) ? base_url('assets/uploads/' . $_SESSION['empresaLogo']) : base_url('assets/images/selecione-imagem.png') ?>" class="img-fluid">
			</div>
			<div class="btn-group d-flex justify-content-end">
				<label class="btn btn-primary"> Selecionar
					<input type="file" onchange="changeLogo()" name="logo" hidden>
				</label>
				<a href="<?= base_url('configuracao/removeLogo') ?>" class="btn btn-danger split-bg-danger"> <i class="bx bx-trash"></i> </a>

			</div>

		</div>
		<hr/>

		<h6 class="mb-0">Icone</h6>

		<hr/>

		<div id="logoUpload" class="">
			<div class="p-3 bg-light">
				<img src="<?= ($_SESSION['empresaIcone']) ? base_url('assets/uploads/' . $_SESSION['empresaIcone']) : base_url('assets/images/selecione-imagem.png') ?>" class="img-fluid">
			</div>
			<div class="btn-group d-flex justify-content-end">
				<label class="btn btn-primary"> Selecionar
					<input type="file" onchange="changeIcone()" name="icone" hidden>
				</label>
				<a href="<?= base_url('configuracao/removeIcone') ?>" class="btn btn-danger split-bg-danger"> <i class="bx bx-trash"></i> </a>

			</div>

		</div>

	</div>

</div>
<?php endif; ?>