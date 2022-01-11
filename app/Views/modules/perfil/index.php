<a href="<?= base_url() ?>/perfil/adicionar" class="btn btn-primary btn-sm float-end">Adicionar novo perfil</a>

<h4 class="mb-0 text-uppercase">Perfis de Acesso</h4>

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
                            if (configColunas('perfil', $k)) :
                        ?>

                                <th><?= $v; ?></th>

                        <?php
                            endif;
                        endforeach; ?>

                        <th></th>

                    </tr>

                </thead>

                <tbody>

                    <?php
                    foreach ($perfis as $u) :
                        if ($u->code != perfilAdmin('code') || permissao('superadmin')) :
                    ?>

                            <tr>
                                <td><a href="<?= base_url('perfil/changeStatus/' . $u->code . '/' . $u->status) ?>" class="confirm"><?= statusPerfil($u->status); ?></a></td>
                                <td><?= date('d/m/Y H:i', strtotime($u->created_at)); ?></td>

                                <?php foreach ($colunas  as $k => $v) : ?>
                                    <?php if (configColunas('perfil', $k)) : ?>
                                        <?php if ($k == 'perfil') : ?>
                                            <td><?= perfilUsuario($u->perfil); ?></td>

                                        <?php elseif ($k == 'totalUsuarios') : ?>
                                            <td> <span class="badge rounded-pill bg-primary"><?= $u->totalUsuarios ?></span> </td>

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

                                    <a href="<?= base_url() ?>/perfil/detalhe/<?= $u->code ?>" class="btn btn-primary btn-sm">Detalhes</a>

                                    <?php if ($u->totalUsuarios == 0 && permissao('excluir_perfil')) : ?>
                                        <a href="<?= base_url() ?>/perfil/excluir/<?= $u->code ?>" class="confirm btn btn-danger btn-sm">Excluir</a>
                                    <?php endif; ?>
                                </td>

                            </tr>

                    <?php endif;
                    endforeach; ?>


                </tbody>



            </table>

        </div>

    </div>

</div>

<a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#configColunas" class="btn btn-sm btn-primary m-1">Configurar Colunas</a>





<?php
$data['tabela'] = 'perfil';
$data['colunas'] = $colunas;
echo view('modules/modal/configColunas', $data);
unset($data);


?>