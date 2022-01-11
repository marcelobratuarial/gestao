

<a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#modalFiltro"
	class="btn btn-secondary btn-sm float-end m-1">Filtros</a>



<h4 class="mb-0 text-uppercase">Veículos Leves</h4>

<br>


<div class="row mb-2">
	<div class="col-md-12">
		<ul class="nav nav-pills">

			<li class="nav-item "><a class="nav-link active" data-bs-toggle="tab" href="#config">Configurações</a></li>
			<li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tabelaPreco">Tabela</a></li>
			<li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#listaAdicionais">Opcionais</a></li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="tab-content">
			<div class="tab-pane active" id="config">

				<div class="card border-top border-0 border-4 border-primary">
					<div class="card-body p-5">
						<div class="card-title d-flex align-items-center">
							<div>
								<i class="bx bxs-user-check me-1 font-22 text-primary"></i>
							</div>
							<h5 class="mb-0 text-primary">Configurações</h5>
						</div>
						<hr>
						<form method="post" action="http://brasilplataformas.com.br/bp-acesso/cliente/save">
							<div class="row g-3">
								<div class="col-md-12">
									<label for="inputName" class="form-label">Título</label> <input type="text" name="nome"
										class="form-control" id="inputName">
								</div>
								<div class="col-md-12">
									<label for="inputEmail" class="form-label">Descricao</label>
									<textarea name="descricao" class="form-control"></textarea>
								</div>

								<div class="col-md-12">
									<label for="inputEmail" class="form-label">Benefícios</label>
									<textarea name="descricao" class="form-control" style="height: 200px;"></textarea>
								</div>


							</div>

							<div class="row g-3 mt-4">
								<div class="col-12">
									<button type="submit" class="btn btn-primary px-5">Salvar</button>
								</div>
							</div>
						</form>
					</div>
				</div>

			</div>
			<div class="tab-pane" id="tabelaPreco">


				<div class="card border-top border-0 border-4 border-primary">
					<div class="card-body p-5">
						<div class="card-title d-flex align-items-center">
							<div>
								<i class="bx bxs-user-check me-1 font-22 text-primary"></i>
							</div>
							<h5 class="mb-0 text-primary">Tabela de preços</h5>
						</div>
						<hr>
						<form method="post" action="#">
							<div class="row g-3">
								<div class="col-md-3">
									<label for="inputName" class="form-label">De</label> <input type="text" name="nome"
										class="form-control" id="inputName" value="0">
								</div>

								<div class="col-md-3">
									<label for="inputName" class="form-label">Até</label> <input type="text" name="nome"
										class="form-control" id="inputName" value="R$10.000">
								</div>

								<div class="col-md-2">
									<label for="inputName" class="form-label">Mensalidade</label> <input type="text"
										name="nome" class="form-control" id="inputName" value="R$90">
								</div>

								<div class="col-md-2">
									<label for="inputName" class="form-label">Cota</label> <input type="text" name="nome"
										class="form-control" id="inputName" value="4%">
								</div>

								<div class="col-md-2">
									<label for="inputName" class="form-label">Cota Min</label> <input type="text" name="nome"
										class="form-control" id="inputName" value="R$1.000">
								</div>


							</div>

							<div class="row g-3 mt-4">
								<div class="col-12">
									<button type="submit" class="btn btn-primary px-5">Salvar</button>
								</div>
							</div>
						</form>
					</div>
				</div>



			</div>
			<div class="tab-pane" id="listaAdicionais">


				<div class="card border-top border-0 border-4 border-primary">
					<div class="card-body p-5">

						<div class="card-title d-flex align-items-center">
							<div>
								<i class="bx bxs-user-check me-1 font-22 text-primary"></i>
							</div>
							<h5 class="mb-0 text-primary">Opcionais</h5>
						</div>

						<li class="list-group-item d-flex justify-content-between align-items-center">Proteção Total
							para Vidros <span class="btn btn-primary btn-sm">EDITAR</span>
						</li>
						<li class="list-group-item d-flex justify-content-between align-items-center">Carro Reserva 20
							dias <span class="btn btn-primary btn-sm">EDITAR</span>
						</li>


					</div>
				</div>


				<div class="card border-top border-0 border-4 border-primary">
					<div class="card-body p-5">
						<div class="card-title d-flex align-items-center">
							<div>
								<i class="bx bxs-user-check me-1 font-22 text-primary"></i>
							</div>
							<h5 class="mb-0 text-primary">Adicionar Opcional</h5>
						</div>
						<hr>
						<form method="post" action="">
							<div class="row g-3">
								<div class="col-md-12">
									<label for="inputName" class="form-label">Titulo</label> <input type="text" name="nome"
										class="form-control" id="inputName" value="">
								</div>

								<div class="col-md-12">
									<label for="inputName" class="form-label">Descricao</label> <input type="text" name="nome"
										class="form-control" id="inputName" value="">
								</div>

								<div class="col-md-12">
									<label for="inputName" class="form-label">Valor</label> <input type="text" name="nome"
										class="form-control" id="inputName" value="">
								</div>

								<div class="col-md-12">
									<label for="inputName" class="form-label">Cota</label> <input type="text" name="nome"
										class="form-control" id="inputName" value="">
								</div>

								<div class="col-md-12">
									<label for="inputName" class="form-label">Cota Min</label> <input type="text" name="nome"
										class="form-control" id="inputName" value="">
								</div>


							</div>

							<div class="row g-3 mt-4">
								<div class="col-12">
									<button type="submit" class="btn btn-primary px-5">Salvar</button>
								</div>
							</div>
						</form>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
