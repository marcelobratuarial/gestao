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
        <hr>
        <form method="post" action="<?= base_url("$path/save/tabela"); ?>">
            <table>
                <thead>
                    <th>
                        <label for="inputName" class="form-label">De</label>
                    </th>

                    <th>
                        <label for="inputName" class="form-label">Até</label>
                    </th>

                    <th>
                        <label for="inputName" class="form-label">Mensalidade</label>
                    </th>

                    <th>
                        <label for="inputName" class="form-label">Cota participativa (%)</label>
                    </th>
                    <th>
                        <label for="inputName" class="form-label">Cota Min (R$)</label>
                    </th>
                    <th>

                    </th>
                </thead>

                <tbody>
                    <?php foreach ($tabela as $t) : ?>
                        <tr>
                            <td>
                                <input type="hidden" name="linha[<?= $t->id; ?>][id]" value="<?= $t->id; ?>">
                                <input type="text" name="linha[<?= $t->id; ?>][valor_de]" class="form-control" id="inputName" value="<?= $t->valor_de; ?>">
                            </td>

                            <td>
                                <input type="text" name="linha[<?= $t->id; ?>][valor_ate]" class="form-control" id="inputName" value="<?= $t->valor_ate; ?>">
                            </td>
                            <td>
                                <input type="text" name="linha[<?= $t->id; ?>][mensalidade]" class="form-control" id="inputName" value="<?= $t->mensalidade; ?>">
                            </td>
                            <td>
                                <input type="text" name="linha[<?= $t->id; ?>][cota_participativa]" class="form-control" id="inputName" value="<?= $t->cota_participativa; ?>">
                            </td>
                            <td>
                                <input type="text" name="linha[<?= $t->id; ?>][cota_min]" class="form-control" id="inputName" value="<?= $t->cota_min; ?>">
                            </td>
                            <td>
                                <a href="<?= base_url($path . '/delete/tabela/' . $t->id) ?>" class="confirm btn btn-link text-danger btn-sm px-2 py-1"><i class="bx bx-trash m-0"></i></a>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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

            <div class="row g-3">
                <div class="col-md-3">
                    <label for="inputValorDe" class="form-label">De</label>
                </div>

                <div class="col-md-3">
                    <label for="inputValorAte" class="form-label">Até</label>
                </div>

                <div class="col-md-2">
                    <label for="inputMensalidade" class="form-label">Mensalidade</label>
                </div>

                <div class="col-md-2">
                    <label for="inputCotaParticipativa" class="form-label">Cota Participativa (%)</label>
                </div>
                <div class="col-md-2">
                    <label for="inputCotaMin" class="form-label">Cota min (R$)</label>
                </div>


            </div>


            <div class="row g-3 pt-3">
                <div class="col-md-3">
                    <input type="hidden" name="codeCategoria" value="<?= $code; ?>">
                    <input type="text" name="valor_de" class="form-control" id="inputValorDe" value="">
                </div>
                <div class="col-md-3">
                    <input type="text" name="valor_ate" class="form-control" id="inputValorAte" value="">
                </div>
                <div class="col-md-2">
                    <input type="text" name="mensalidade" class="form-control" id="inputMensalidade" value="">
                </div>

                <div class="col-md-2">
                    <input type="text" name="cota_participativa" class="form-control" id="inputCotaParticipativa" value="">
                </div>
                <div class="col-md-2">
                    <input type="text" name="cota_min" class="form-control" id="inputCotaMin" value="">
                </div>
            </div>


            <div class="row g-3 mt-4">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary px-5">Inserir Linha</button>
                </div>
            </div>
        </form>
    </div>
</div>