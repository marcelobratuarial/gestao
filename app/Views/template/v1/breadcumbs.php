<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">


					<?php 
		
					if(isset($tituloPagina)){
					?>
					<div class="breadcrumb-title pe-3"><?=$tituloPagina;?></div>
					<?php 
					}
					?>

					<?php 
					if(isset($subtituloPagina)){
					?>
					<div class="ps-3">


						<nav aria-label="breadcrumb">


							<ol class="breadcrumb mb-0 p-0">


								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>


								</li>


								<li class="breadcrumb-item active" aria-current="page"><?=$subtituloPagina;?></li>


							</ol>


						</nav>


					</div>
					
					<?php 
					}
					?>

					


				</div>


				