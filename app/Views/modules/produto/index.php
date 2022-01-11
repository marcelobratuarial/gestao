<h4 class="mb-0 text-uppercase">Produtos</h4>

<br>

<div class="card">

    <div class="card-body">

        <div class="table-responsive">

            <table id="table-primary" class="table table-striped table-bordered" style="width:100%">

                <thead>

                    <tr>
                        <th>Status</th>
                        <th>Data</th>
                        <?php
                        foreach ($colunas  as $k => $v) :


                            if (configColunas('Produto', $k)) :



                        ?>

                                <th><?= $v; ?></th>

                        <?php
                            endif;
                        endforeach; ?>

                        <th></th>
                    </tr>

                </thead>

                <tbody>

                    <?php foreach ($produtos as $u) :
                        if (permissao('admin')) :

                            //dados do campo extra
                            $dados = json_decode($u->camposExtras);
                            $dados = (array) $dados;

                    ?>

                            <tr>

                                <td><?= statusProduto($u->status) ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($u->created_at)) ?></td>
                                <?php foreach ($colunas  as $k => $v) : ?>
                                    <?php if (configColunas('produto', $k)) : ?>
                                        <?php if ($k == 'tipo') : ?>
                                            <td><?= $u->tipo == 1 ? 'Brasil Atuarial' : 'Próprio' ?></td>
                                        <?php else : ?>
                                            <td>
                                                <?php
                                                if (isset($u->$k)) :
                                                    echo $u->$k;
                                                else :
                                                    if (isset($dados[$k])) :
                                                        echo $dados[$k];
                                                    endif;
                                                endif;
                                                ?>
                                            </td>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                                <td class="text-end">

                                    <a href="<?= base_url() ?>/produto/detalhe/<?= $u->code ?>" class="btn btn-primary btn-sm">Detalhes</a>
                                    <a href="<?= base_url() ?>/produto/configuracao/<?= $u->code ?>" class="btn btn-dark btn-sm">Configurar</a>

                                </td>

                            </tr>

                    <?php endif;
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



<?php
$data['tabela'] = 'produto';

// carega as modais

$data['camposExtras'] = $camposExtras;
echo view('modules/modal/configCampos', $data);

$data['colunas'] = $colunas;
echo view('modules/modal/configColunas', $data);

?>