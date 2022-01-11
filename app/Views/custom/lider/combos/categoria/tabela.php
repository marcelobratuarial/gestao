<div class="card border-top border-0 border-4 border-primary">
    <div class="card-body p-5">
        <div class="card-title d-flex align-items-center">
            <div>
                <i class="bx bxs-user-check me-1 font-22 text-primary"></i>
            </div>
            <h5 class="mb-0 text-primary">Tabela de preços</h5>
            <div class="ms-auto d-flex">
                <form enctype="multipart/form-data" action="<?= base_url("$path/save/importar_tabela/$code"); ?>" method="post">
                    <div class="input-group input-group-sm mb-3">
                        <input type="file" name="file" class="form-control" aria-describedby="button-addon2">
                        <button class="btn btn-outline-primary" type="submit" id="button-addon2"><i class="bx bx-upload"></i> Importar CSV</button>
                    </div>
                </form>
            </div>

        </div>
        <ul class="nav nav-tabs nav-primary" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" data-bs-toggle="tab" href="#tabIntervalo" role="tab" aria-selected="true">
                    <div class="d-flex align-items-center">
                        <div class="tab-icon"><i class="bx bx-home font-18 me-1"></i>
                        </div>
                        <div class="tab-title">Intervalo</div>
                    </div>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" data-bs-toggle="tab" href="#tabPlanos" role="tab" aria-selected="false">
                    <div class="d-flex align-items-center">
                        <div class="tab-icon"><i class="bx bx-user-pin font-18 me-1"></i>
                        </div>
                        <div class="tab-title">Planos</div>
                    </div>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" data-bs-toggle="tab" href="#tabDescontos" role="tab" aria-selected="false">
                    <div class="d-flex align-items-center">
                        <div class="tab-icon"><i class="bx bx-microphone font-18 me-1"></i>
                        </div>
                        <div class="tab-title">Descontos</div>
                    </div>
                </a>
            </li>
        </ul>
        <form method="post" action="<?= base_url("$path/save/tabela"); ?>">
            <div class="tab-content py-3">
                <div class="tab-pane fade active show" id="tabIntervalo" role="tabpanel">
                    <table>
                        <thead>
                            <tr>
                                <th>
                                    <label for="inputValorDe" class="form-label">Intervalo de</label>
                                </th>

                                <th>
                                    <label for="InputValorAte" class="form-label">Até</label>
                                </th>
                                <th>
                                    <label for="inputAdesao" class="form-label">Adesão</label>
                                </th>
                                <th class="col-1">

                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($tabela as $t) :  ?>
                                <tr>
                                    <td>
                                        <input type="hidden" name="linha[<?= $t->id; ?>][id]" value="<?= $t->id; ?>">
                                        <input type="text" name="linha[<?= $t->id; ?>][valor_de]" onclick="this.select()" onchange="valorDe(<?= $t->id; ?>, this.value)" class="maskMoney form-control" id="inputValorDe" value="<?= money($t->valor_de, true); ?>">
                                    </td>
                                    <td>
                                        <input type="text" name="linha[<?= $t->id; ?>][valor_ate]" onclick="this.select()" onchange="valorAte(<?= $t->id; ?>, this.value)" class="maskMoney form-control" id="InputValorAte" value="<?= money($t->valor_ate, true); ?>">
                                    </td>
                                    <td>
                                        <input type="text" name="linha[<?= $t->id; ?>][adesao]" onclick="this.select()" class="maskMoney form-control" id="inputAdesao" value="<?= money($t->adesao, true); ?>">
                                    </td>
                                    <td>
                                        <a href="<?= base_url($path . '/delete/tabela/' . $t->id) ?>" class="confirm btn btn-link text-danger btn-sm px-2 py-1"><i class="bx bx-trash m-0"></i></a>
                                    </td>

                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="tabPlanos" role="tabpanel">
                    <table>
                        <thead>
                            <tr>
                                <th>
                                    <label class="form-label">Intervalo</label>
                                </th>
                                <?php foreach ($planos as $p) : ?>
                                    <th>
                                        <label for="input-<?= $p->slug ?>" class="form-label"><?= $p->titulo ?></label>
                                    </th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($tabela as $t) :  ?>
                                <tr>
                                    <td data-linha="<?= $t->id; ?>" style="padding-right:20px">
                                        de <span class="valorDe"><?= money($t->valor_de); ?></span> até <span class="valorAte"><?= money($t->valor_ate); ?></span>
                                    </td>
                                    <?php foreach ($planos as $p) : $slug = $p->slug ?>
                                        <td>
                                            <input type="text" name="linha[<?= $t->id; ?>][<?= $slug ?>][valor]" onclick="this.select()" class="maskMoney form-control" id="input-<?= $slug ?>" value="<?= isset($t->planos->$slug->valor) ? money($t->planos->$slug->valor, true) : 0 ?>">
                                        </td>
                                    <?php endforeach; ?>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="tabDescontos" role="tabpanel">
                    <table>
                        <thead>
                            <tr>
                                <th>
                                    <label class="form-label">Intervalo</label>
                                </th>
                                <?php foreach ($planos as $p) : ?>
                                    <th>
                                        <label for="input-<?= $p->slug ?>" class="form-label"><?= $p->titulo ?></label>
                                    </th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($tabela as $t) :  ?>
                                <tr>
                                    <td data-linha="<?= $t->id; ?>" style="padding-right:20px">
                                        de <span class="valorDe"><?= money($t->valor_de); ?></span> até <span class="valorAte"><?= money($t->valor_ate); ?></span>
                                    </td>
                                    <?php foreach ($planos as $p) : $slug = $p->slug ?>
                                        <td>
                                            <input type="text" name="linha[<?= $t->id; ?>][<?= $slug ?>][desconto]" onclick="this.select()" max="100" data-mask="000%" data-mask-reverse="true" class="form-control" id="input-<?= $slug ?>" value="<?= isset($t->planos->$slug->desconto) ? $t->planos->$slug->desconto : 0 ?>">
                                        </td>
                                    <?php endforeach; ?>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if (count($tabela)) { ?>
                <div class="row g-3 mt-4">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary px-5">Atualizar Tabela</button>
                    </div>
                </div>
            <?php } else {

                echo "<p style='padding:30px; text-align:center; background-color:#f2f2f2;'>Nenhum registro nesta tabela</p>";
            } ?>
        </form>
    </div>
</div>

<div class="card border-top border-0 border-4 border-primary">
    <div class="card-body p-5">
        <div class="card-title d-flex align-items-center">
            <div>
                <i class="bx bxs-user-check me-1 font-22 text-primary"></i>
            </div>
            <h5 class="mb-0 text-primary">Adicionar linha </h5>
        </div>
        <hr>
        <form method="post" action="<?= base_url("$path/save/tabela"); ?>">
            <table>
                <thead>
                    <tr>
                        <th>
                            <label for="inputValorDeAdd" class="form-label">De</label>
                        </th>

                        <th>
                            <label for="inputValorAteAdd" class="form-label">Até</label>
                        </th>
                        <?php foreach ($planos as $p) : ?>
                            <th>
                                <label for="input-<?= $p->slug ?>-add" class="form-label"><?= $p->titulo ?></label>
                            </th>
                        <?php endforeach; ?>
                        <th>
                            <label for="inputAdesaoAdd" class="form-label">Adesao</label>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>
                            <input type="hidden" name="codeCategoria" value="<?= $code; ?>">
                            <input type="text" name="valor_de" class="maskMoney form-control" id="inputValorDeAdd" value="">
                        </td>
                        <td>
                            <input type="text" name="valor_ate" class="maskMoney form-control" id="inputValorAteAdd" value="">
                        </td>
                        <?php foreach ($planos as $k => $p) :
                            if ($k <= 3) : ?>
                                <td>
                                    <input type="text" name="<?= $p->slug ?>[valor]" class="maskMoney form-control" id="input-<?= $p->slug ?>-add" value="">
                                </td>
                        <?php endif;
                        endforeach; ?>
                        <td>
                            <input type="text" name="adesao" class="maskMoney form-control" id="inputAdesaoAdd" value="">
                        </td>
                    </tr>
                </tbody>
            </table>


            <div class="row g-3 mt-4">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary px-5">Inserir Linha</button>
                </div>
            </div>
        </form>
    </div>
</div>