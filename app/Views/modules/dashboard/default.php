<div class="row">
	<div class="col-12">
		<a href="#" class="btn col btn-primary btn-sm mb-4 float-end">
			<b>Período:</b> <?php echo date('d/m/Y') . " a " . date('d/') . (date('m') + 1) . "/" . date('Y'); ?>
		</a>
	</div>
</div>

<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
	<div class="col">
		<div class="card radius-10 border-start border-0 border-3 border-info">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div>
						<p class="mb-0 text-secondary">Leads</p>
						<h4 class="my-1 text-info">4805</h4>
						<p class="mb-0 font-13">Editar | Remover</p>
					</div>
					<div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i class="bx bxs-cart"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col">
		<div class="card radius-10 border-start border-0 border-3 border-danger">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div>
						<p class="mb-0 text-secondary">Vendas</p>
						<h4 class="my-1 text-danger">842</h4>
						<p class="mb-0 font-13">Editar | Remover</p>
					</div>
					<div class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto"><i class="bx bxs-wallet"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col">
		<div class="card radius-10 border-start border-0 border-3 border-success">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div>
						<p class="mb-0 text-secondary">Usuários Ativos</p>
						<h4 class="my-1 text-success">34.6%</h4>
						<p class="mb-0 font-13">Editar | Remover</p>
					</div>
					<div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i class="bx bxs-bar-chart-alt-2"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col">
		<div class="card radius-10 border-start border-0 border-3 border-warning">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div>
						<p class="mb-0 text-secondary">Adicionar</p>
						<h4 class="my-1 text-warning">Widget</h4>
						<p class="mb-0 font-13"> &nbsp </p>
					</div>
					<div class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto"><i class="bx bx-plus"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--end row-->

<div class="row">
	<div class="col-12 col-lg-8">
		<div class="card radius-10">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div>
						<h6 class="mb-0">Leads x Vendas (últimos 12 meses)</h6>
					</div>
					<div class="dropdown ms-auto">
						<a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
						</a>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="javascript:;">Editar</a>
							</li>
							<li><a class="dropdown-item" href="javascript:;">Remover</a>
							</li>

						</ul>
					</div>
				</div>
				<div class="d-flex align-items-center ms-auto font-13 gap-2 my-3">
					<span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1" style="color: #14abef"></i>Vendas</span>
					<span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1" style="color: #ffc107"></i>Leads</span>
				</div>
				<div class="chart-container-1">
					<div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
						<div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
						</div>
						<div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
						</div>
					</div>
					<canvas id="chart1" width="714" height="260" style="display: block; width: 714px; height: 260px;" class="chartjs-render-monitor"></canvas>
				</div>
			</div>
			<div class="row row-cols-1 row-cols-md-3 row-cols-xl-3 g-0 row-group text-center border-top">
				<div class="col">
					<div class="p-3">
						<h5 class="mb-0">32%</h5>
						<small class="mb-0">Taxa de Conversão </small>
					</div>
				</div>
				<div class="col">
					<div class="p-3">
						<h5 class="mb-0">1238</h5>
						<small class="mb-0">Total de vendas </small>
					</div>
				</div>
				<div class="col">
					<div class="p-3">
						<h5 class="mb-0">6382</h5>
						<small class="mb-0">Total de Leads </small>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-12 col-lg-4">
		<div class="card radius-10">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div>
						<h6 class="mb-0">Vendas por Produto</h6>
					</div>
					<div class="dropdown ms-auto">
						<a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
						</a>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="javascript:;">Editar</a>
							</li>
							<li><a class="dropdown-item" href="javascript:;">Remover</a>
							</li>

						</ul>
					</div>
				</div>
				<div class="chart-container-2 mt-4">
					<div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
						<div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
						</div>
						<div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
						</div>
					</div>
					<canvas id="chart2" width="714" height="220" style="display: block; width: 714px; height: 220px;" class="chartjs-render-monitor"></canvas>
				</div>
			</div>
			<ul class="list-group list-group-flush">
				<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Funeral <span class="badge bg-success rounded-pill">25</span>
				</li>
				<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Residencial <span class="badge bg-danger rounded-pill">10</span>
				</li>
				<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Pet <span class="badge bg-primary rounded-pill">65</span>
				</li>
				<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Bike <span class="badge bg-warning text-dark rounded-pill">14</span>
				</li>
			</ul>
		</div>
	</div>
</div>
<!--end row-->





<div class="row row-cols-1 row-cols-lg-3">
	<div class="col d-flex">
		<div class="card radius-10 w-100">
			<div class="card-body">
				<p class="font-weight-bold mb-1 text-secondary">Vendas da Semana</p>
				<div class="d-flex align-items-center mb-4">
					<div>
						<h4 class="mb-0">R$8.540</h4>
					</div>
					<div class="">
						<p class="mb-0 align-self-center font-weight-bold text-success ms-2">4.4% <i class="bx bxs-up-arrow-alt mr-2"></i>
						</p>
					</div>
				</div>
				<div class="chart-container-0">
					<div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
						<div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
						</div>
						<div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
						</div>
					</div>
					<canvas id="chart3" width="714" height="320" style="display: block; width: 714px; height: 320px;" class="chartjs-render-monitor"></canvas>
				</div>
			</div>
		</div>
	</div>
	<div class="col d-flex">
		<div class="card radius-10 w-100">
			<div class="card-header bg-transparent">
				<div class="d-flex align-items-center">
					<div>
						<h6 class="mb-0">Funil Default</h6>
					</div>
					<div class="dropdown ms-auto">
						<a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
						</a>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="javascript:;">Editar</a>
							</li>
							<li><a class="dropdown-item" href="javascript:;">Remover</a>
							</li>

						</ul>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="chart-container-1">
					<div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
						<div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
						</div>
						<div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
						</div>
					</div>
					<canvas id="chart4" width="714" height="260" style="display: block; width: 714px; height: 260px;" class="chartjs-render-monitor"></canvas>
				</div>
			</div>
			<ul class="list-group list-group-flush">
				<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Completed <span class="badge bg-gradient-quepal rounded-pill">25</span>
				</li>
				<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Pending <span class="badge bg-gradient-ibiza rounded-pill">10</span>
				</li>
				<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Process <span class="badge bg-gradient-deepblue rounded-pill">65</span>
				</li>
			</ul>
		</div>
	</div>
	<div class="col-12 col-lg-4">
		<div class="card radius-10">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div>
						<h6 class="mb-0"></h6>
					</div>
					<div class="dropdown ms-auto">
						<a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
						</a>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="javascript:;">Configurar</a>
							</li>


						</ul>
					</div>
				</div>
				<div class="chart-container-0">
					<div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
						<div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
						</div>
						<div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
							<div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
						</div>
					</div>
					<canvas id="chart-order-status" width="302" height="320" style="display: block; width: 302px; height: 320px;" class="chartjs-render-monitor"></canvas>
				</div>
			</div>
		</div>
	</div>
</div>
<!--end row-->

<div class="card radius-10">
	<div class="card-body">
		<div class="d-flex align-items-center">
			<div>
				<h6 class="mb-0">Top 10 vendedores</h6>
			</div>
			<div class="dropdown ms-auto">
				<a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
				</a>
				<ul class="dropdown-menu">
					<li><a class="dropdown-item" href="javascript:;">Editar</a>
					</li>
					<li><a class="dropdown-item" href="javascript:;">Remover</a>
					</li>

				</ul>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table align-middle mb-0">
				<thead class="table-light">
					<tr>
						<th>Posição</th>
						<th>Nome</th>
						<th>Filial</th>
						<th>Leads</th>
						<th>Vendas</th>
						<th>Taxa de Conversão</th>
						<th></th>

					</tr>
				</thead>
				<tbody>
					<tr>
						<td>1º</td>
						<td>Ítalo Frade</td>
						<td>Matriz</td>
						<td>33</td>
						<td>11</td>
						<td>34%</td>
						<td>
							<a href="#" class="btn btn-sm btn-primary"> Detalhes</a>
						</td>
					</tr>


				</tbody>
			</table>
		</div>
	</div>
</div>