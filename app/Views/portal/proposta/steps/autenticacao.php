<div class="row">
	<div class="col-xl-8 mx-auto">


		<div class="card border-top border-0 border-4 border-info">
			<div class="card-body">
				<div class="border p-4 rounded">
					<div class="card-title d-flex align-items-center">
						<div><i class="bx bxs-user me-1 font-22 text-info"></i>
						</div>
						<h5 class="mb-0 text-info">Segurança do cliente</h5>
					</div>
					<hr>
					<div class="row mb-3">
						<form class="row g-3" action="<?= base_url('portal/validar')?>" method="post">
							<label for="inputPhoneNo2" class="col-sm-5 col-form-label">Confirme os 4 últimos dígitos do seu telefone</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" placeholder="4 últimos dígitos do telefone" name="codigoseguranca">
							</div>
							<div class="col-sm-3">
								<button type="submit" name="code" value="<?= $code ?>" class="btn btn-info px-5">Validar</button>
							</div>
						</form>
					</div>
					



				</div>
			</div>
		</div>
	</div>
</div>