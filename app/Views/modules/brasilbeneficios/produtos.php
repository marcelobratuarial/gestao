<h4 class="mb-0 text-uppercase">Produtos</h4>

<br>

<div class="card">

    <div class="card-body">

        <div class="table-responsive">

            <table id="table-primary" class="table table-striped table-bordered" style="width:100%">

                <thead>

                    <tr>
                        
                        <th>ID</th>
                        <th>Nome</th>
						<th>Status</th>

                        <th></th>
                    </tr>

                </thead>

                <tbody>

                    <?php 
					foreach ($produtos as $u) :
                    ?>

                            <tr>

                                <td><?= $u->code ?></td>
                                <td><?= $u->nome ?></td>
                                <td><?= statusProduto($u->status) ?></td>
                               
                                <td class="text-end">

                                    <a href="<?= base_url() ?>/brasilbeneficios/detalhe/<?= $u->code ?>" class="btn btn-primary btn-sm">Detalhes</a>
                                    <a href="<?= base_url() ?>/brasilbeneficios/configuracao/<?= $u->code ?>" class="btn btn-dark btn-sm">Configurar</a>

                                </td>

                            </tr>

                    <?php
                    endforeach; ?>


                </tbody>



            </table>

        </div>

    </div>

</div>

<?php if (permissao('admin')) : ?>
    <a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#configCampos" class="btn btn-sm btn-danger">Configurar Campos para Assinatura</a>
<?php endif; ?>

<a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#configColunas" class="btn btn-sm btn-primary m-1">Configurar Colunas</a>

