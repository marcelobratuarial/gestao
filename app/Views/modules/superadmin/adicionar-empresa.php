<div class="card border-top border-0 border-4 border-primary">
	<div class="card-body p-5">
		<div class="card-title d-flex align-items-center">
			<div>
				<i class="bx bxs-user me-1 font-22 text-primary"></i>
			</div>
			<h5 class="mb-0 text-primary">Adicionar Empresa</h5>
		</div>
		<hr>
		<form method="post" action="<?= base_url('superadmin/save-empresa') ?>">
			<div class="row my-3">
				<div class="col-md-4">
					<label for="inputName" class="form-label">Empresa</label>
					<input type="text" name="nome" class="form-control" id="inputName">
				</div>
				<div class="col-md-4">
					<label for="inputDominio" class="form-label">Domínio</label>
					<input type="text" name="dominio" class="form-control" id="inputDominio">
				</div>
				<div class="col-md-4">
					<label for="inputEmpresaIF" class="form-label">CNPJ</label>
					<input type="text" name="empresaIf" data-mask="00.000.000/0000-00" class="form-control" id="inputEmpresaIF">
				</div>
			</div>
			<div class="row my-3">
				<div class="col-md-4">
					<label for="inputEnderecoFilial" class="form-label">Endereço</label>
					<input type="text" name="endereco_filial" class="form-control" id="inputEnderecoFilial">
				</div>
				<div class="col-md-4">
					<label for="inputEmailFilial" class="form-label">Email</label>
					<input type="text" name="email_filial" class="form-control" id="inputEmailFilial">
				</div>
				<div class="col-md-4">
					<label for="inputTelefoneFilial" class="form-label">Telefone</label>
					<input type="text" name="telefone_filial" class="telMask form-control" id="inputTelefoneFilial">
				</div>
			</div>
			<div class="row my-3">
				<div class="col-md-3">
					<label for="inputUserNome" class="form-label">Nome</label>
					<input type="text" name="nome_usuario" class="form-control" id="inputUserNome">
				</div>
				<div class="col-md-3">
					<label for="inputUserIF" class="form-label">CPF</label>
					<input type="text" name="userIf" data-mask="000.000.000-00" class="form-control" id="inputUserIF">
				</div>
				<div class="col-md-3">
					<label for="inputUserEmail" class="form-label">Email</label>
					<input type="text" name="email_usuario" class="form-control" id="inputUserEmail">
				</div>
				<div class="col-md-3">
					<label for="inputUserTelefone" class="form-label">Telefone</label>
					<input type="text" name="telefone_usuario" class="celMask form-control" id="inputUserTelefone">
				</div>
			</div>

			<div class="row g-3 mt-4">
				<div class="col-12">
					<a href="<?= base_url('superadmin/empresa') ?>" class="btn btn-light px-5">
						Cancelar
					</a>
					<button id="buttonSubmit" type="submit" class="btn btn-primary px-5">
						Salvar
					</button>
				</div>
			</div>
		</form>
	</div>
</div>