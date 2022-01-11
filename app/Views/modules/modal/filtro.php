
<div class="modal modal-md fade" id="modalFiltro" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
		 <form action="#" method="post">
            <div class="modal-body pb-0" style="overflow-y: hidden;">
                <div class="row">
                    <div class="col-9">
                        <h5 class="modal-title" id="staticBackdropLabel">Filtros</h5>
                    </div>
                    <div class="col-3 text-end">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body border-1 border-top" style="overflow-y: hidden;">
             

					<?php 

					if(isset($filtros)):
					foreach($filtros as $k => $v): ?>
						<?=$k;?>:<?=$v;?><br>
					<?php 
					endforeach; 
					endif;
					?>
			


				
            </div>
            <div class="modal-footer">
                <a  class="btn btn-secondary" href="<?=base_url('usuario/removerFiltro/'.$tabela);?>">Remover Filtros</a>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
			</form>	
        </div>
    </div>
</div>