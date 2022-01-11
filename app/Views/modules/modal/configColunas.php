<?php $colunasTabela = configColunas($tabela) ?>
<div class="modal modal-md fade <?= (!$colunasTabela)? 'show' : null ?>" style="<?= (!$colunasTabela)? 'display:block;' : null ?>" id="configColunas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable <?= (!$colunasTabela)? 'modal-fullscreen' : null ?>">
        <div class="modal-content" style="<?= (!$colunasTabela)? 'padding:10%;' : null ?>">
		 <form action="<?=base_url('usuario/colunas');?>" method="post">
            <div class="modal-body pb-0" style="overflow-y: hidden;">
                <div class="row">
                    <div class="col-10">
                        <h5 class="modal-title" id="staticBackdropLabel">Configuração de Colunas</h5>
                    </div>
                    <div class="col-2 text-end">
                    <?php if($colunasTabela): ?>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="modal-body border-1 border-top" style="overflow-y: hidden;">
              
			 
				<div class="row">
					<input type="hidden" name="tabela" value="<?=ucfirst($tabela);?>">
				<?php foreach($colunas  as $k => $v): 
				
			
				?>
				
					<div class="col-md-6">
						<input type="checkbox" name="colunas[]" value="<?=$k;?>" <?php if(configColunas($tabela,$k)){ echo "checked";}?>> <?=$v;?>
					</div>
					
				<?php 
				endforeach; 
				?>
			  
					

				
				</div>

				
            </div>
            <div class="modal-footer">
                <?php if($colunasTabela): ?>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
			</form>	
        </div>
    </div>
</div>