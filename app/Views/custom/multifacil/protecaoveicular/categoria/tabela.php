<div class="card border-top border-0 border-4 border-primary">
    <div class="card-body p-5">
        <div class="card-title d-flex align-items-center">
            <div>
                <i class="bx bxs-user-check me-1 font-22 text-primary"></i>
            </div>
            <h5 class="mb-0 text-primary">Tabela de preços</h5>
        </div>
        <hr>
        <form method="post" action="<?= base_url("$path/save/tabela"); ?>">


            <table>
                <thead>
                    <tr>
                        <th>
                            <label for="inputValorDe" class="form-label">De</label>
                        </th>

                        <th>
                            <label for="InputValorAte" class="form-label">Até</label>
                        </th>

                        <th>
                            <label for="inputBronze" class="form-label">Bronze</label>
                        </th>

                        <th>
                            <label for="inputPrata" class="form-label">Prata</label>
                        </th>

                        <th>
                            <label for="inputOuro" class="form-label">Ouro</label>
                        </th>

                        <th>
                            <label for="inputDiamante" class="form-label">Diamante</label>
                        </th>

                        <th>
                            <label for="inputAdesao" class="form-label">Adesão</label>
                        </th>
                        <th>
                            <label for="inputDesconto" class="form-label">Desconto %</label>
                        </th>
                        <th class="col-1">

                        </th>

                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($tabela as $t) : ?>
                        <tr>
                            <td>
                                <input type="hidden" name="linha[<?= $t->id; ?>][id]" value="<?= $t->id; ?>">
                                <input type="text" name="linha[<?= $t->id; ?>][valor_de]" onclick="this.select()" class="form-control" data-mask="#0.00" data-mask-reverse="true" id="inputValorDe" value="<?= $t->valor_de; ?>">
                            </td>
                            <td>
                                <input type="text" name="linha[<?= $t->id; ?>][valor_ate]" onclick="this.select()" class="form-control" data-mask="#0.00" data-mask-reverse="true" id="InputValorAte" value="<?= $t->valor_ate; ?>">
                            </td>
                            <td>
                                <input type="text" name="linha[<?= $t->id; ?>][bronze]" onclick="this.select()" class="form-control" data-mask="#0.00" data-mask-reverse="true" id="inputBronze" value="<?= $t->bronze; ?>">
                            </td>
                            <td>
                                <input type="text" name="linha[<?= $t->id; ?>][prata]" onclick="this.select()" class="form-control" data-mask="#0.00" data-mask-reverse="true" id="inputPrata" value="<?= $t->prata; ?>">
                            </td>
                            <td>
                                <input type="text" name="linha[<?= $t->id; ?>][ouro]" onclick="this.select()" class="form-control" data-mask="#0.00" data-mask-reverse="true" id="inputOuro" value="<?= $t->ouro; ?>">
                            </td>
                            <td>
                                <input type="text" name="linha[<?= $t->id; ?>][diamante]" onclick="this.select()" class="form-control" data-mask="#0.00" data-mask-reverse="true" id="inputDiamante" value="<?= $t->diamante; ?>">
                            </td>
                            <td>
                                <input type="text" name="linha[<?= $t->id; ?>][adesao]" onclick="this.select()" class="form-control" data-mask="#0.00" data-mask-reverse="true" id="inputAdesao" value="<?= $t->adesao; ?>">
                            </td>
                            <td>
                                <input type="text" name="linha[<?= $t->id; ?>][desconto]" onclick="this.select()" class="form-control" id="inputDesconto" value="<?= $t->desconto; ?>">
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
            <table>
                <thead>
                    <tr>
                        <th>
                            <label for="inputValorDeAdd" class="form-label">De</label>
                        </th>

                        <th>
                            <label for="inputValorAteAdd" class="form-label">Até</label>
                        </th>

                        <th>
                            <label for="inputBronzeAdd" class="form-label">Bronze</label>
                        </th>

                        <th>
                            <label for="inputPrataAdd" class="form-label">Prata</label>
                        </th>

                        <th>
                            <label for="inputOuroAdd" class="form-label">Ouro</label>
                        </th>

                        <th>
                            <label for="inputDiamanteAdd" class="form-label">Diamante</label>
                        </th>

                        <th>
                            <label for="inputAdesaoAdd" class="form-label">Adesao</label>
                        </th>

                        <th>
                            <label for="inputDescontoAdd" class="form-label">Desconto %</label>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>
                            <input type="hidden" name="codeCategoria" value="<?= $code; ?>">
                            <input type="text" name="valor_de" class="form-control" data-mask="#0.00" data-mask-reverse="true" id="inputValorDeAdd" value="">
                        </td>
                        <td>
                            <input type="text" name="valor_ate" class="form-control" data-mask="#0.00" data-mask-reverse="true" id="inputValorAteAdd" value="">
                        </td>
                        <td>
                            <input type="text" name="bronze" class="form-control" data-mask="#0.00" data-mask-reverse="true" id="inputBronzeAdd" value="">
                        </td>
                        <td>
                            <input type="text" name="prata" class="form-control" data-mask="#0.00" data-mask-reverse="true" id="inputPrataAdd" value="">
                        </td>
                        <td>
                            <input type="text" name="ouro" class="form-control" data-mask="#0.00" data-mask-reverse="true" id="inputOuroAdd" value="">
                        </td>
                        <td>
                            <input type="text" name="diamante" class="form-control" data-mask="#0.00" data-mask-reverse="true" id="inputDiamanteAdd" value="">
                        </td>
                        <td>
                            <input type="text" name="adesao" class="form-control" data-mask="#0.00" data-mask-reverse="true" id="inputAdesaoAdd" value="">
                        </td>
                        <td>
                            <input type="text" name="desconto" class="form-control" id="inputDescontoAdd" value="">
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