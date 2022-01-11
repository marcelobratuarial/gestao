
<h4 class="mb-0 text-uppercase">Nomenclaturas</h4>

<br>

<div class="card">

    <div class="card-body">
			
			<form action="<?=base_url('config/salvar')?>" method="post">

            <table class="table" style="width:100%">

                <thead>

                    <tr>

                        <th>#REF</th>

                        <th>DESCRIÇÃO</th>

                        <th>VALOR</th>


                    </tr>

                </thead>

                <tbody>
				
				

                    <?php foreach($nomenclaturas as $u): ?>

                    <tr>

                        <td>#<?=$u->code?></td> 

                        <td><?=$u->nome?></td>

                        <td width="40%">
						<input name="<?=$u->code?>" type="text" value="<?=$u->valor?>" class="form-control">
						</td>


                    </tr>
                
                    <?php endforeach; ?>
                
				
                </tbody>



            </table>
			
			   <a href="<?php echo site_url('config/reset/NOMENCLATURA'); ?>" class="btn btn-danger btn-sm " >Restaurar Padrões</a>
			   
			   <button class="btn btn-primary btn-sm float-end" type="submit" value="Salvar">SALVAR</button>

 
			</form>
    </div>

</div>