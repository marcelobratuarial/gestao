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
                            <label for="inputColisaoPP" class="form-label">Colisão PP</label>
                        </th>

                        <th>
                            <label for="inputColisaoPT" class="form-label">Colisão PT</label>
                        </th>

                        <th>
                            <label for="inputRouboFurto" class="form-label">Roubo e Furto</label>
                        </th>
                        <th>
                            <label for="inputIncendio" class="form-label">Incêndio</label>
                        </th>
                        <th>
                            <label for="inputCompleto" class="form-label">Completo</label>
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
                                <input type="text" name="linha[<?= $t->id; ?>][valor_de]"  onclick="this.select()" class="form-control" data-mask="#0.00" data-mask-reverse="true" id="inputValorDe" value="<?= $t->valor_de; ?>">
                            </td>

                            <td>
                                <input type="text" name="linha[<?= $t->id; ?>][valor_ate]"  onclick="this.select()" class="form-control" data-mask="#0.00" data-mask-reverse="true" id="InputValorAte" value="<?= $t->valor_ate; ?>">
                            </td>
                            <td>
                                <input type="text" name="linha[<?= $t->id; ?>][colisaopp]"  onclick="this.select()" class="form-control" data-mask="#0.00" data-mask-reverse="true" id="inputColisaoPP" value="<?= $t->colisaopp; ?>">
                            </td>
                            <td>
                                <input type="text" name="linha[<?= $t->id; ?>][colisaopt]"  onclick="this.select()" class="form-control" data-mask="#0.00" data-mask-reverse="true" id="inputColisaoPT" value="<?= $t->colisaopt; ?>">
                            </td>
                            <td>
                                <input type="text" name="linha[<?= $t->id; ?>][roubofurto]"  onclick="this.select()" class="form-control" data-mask="#0.00" data-mask-reverse="true" id="inputRouboFurto" value="<?= $t->roubofurto; ?>">
                            </td>
                            <td>
                                <input type="text" name="linha[<?= $t->id; ?>][incendio]"  onclick="this.select()" class="form-control" data-mask="#0.00" data-mask-reverse="true" id="inputIncendio" value="<?= $t->incendio; ?>">
                            </td>
                            <td>
                                <input type="text" name="linha[<?= $t->id; ?>][completo]"  onclick="this.select()" class="form-control" data-mask="#0.00" data-mask-reverse="true" id="inputCompleto" value="<?= $t->completo; ?>">
                            </td>
                            <td>
                                <input type="text" name="linha[<?= $t->id; ?>][desconto]"  onclick="this.select()" class="form-control" id="inputDesconto" value="<?= $t->desconto; ?>">
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
                            <label for="inputValorDe2" class="form-label">De</label>
                        </th>

                        <th>
                            <label for="inputValorAte2" class="form-label">Até</label>
                        </th>

                        <th>
                            <label for="inputColisaoPP2" class="form-label">Colisão PP</label>
                        </th>

                        <th>
                            <label for="inputColisaoPT2" class="form-label">Colisão PT</label>
                        </th>

                        <th>
                            <label for="inputRouboFurto2" class="form-label">Roubo e Furto</label>
                        </th>
                        <th>
                            <label for="inputIncendio2" class="form-label">Incêndio</label>
                        </th>
                        <th>
                            <label for="inputCompleto2" class="form-label">Completo</label>
                        </th>
                        <th>
                            <label for="inputDesconto2" class="form-label">Desconto %</label>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>
                            <input type="hidden" name="codeCategoria" value="<?= $code; ?>">
                            <input type="text" name="valor_de"  class="form-control" data-mask="#0.00" data-mask-reverse="true" id="inputValorDe2" value="">
                        </td>
                        <td>
                            <input type="text" name="valor_ate" class="form-control" data-mask="#0.00" data-mask-reverse="true" id="inputValorAte2" value="">
                        </td>
                        <td>
                            <input type="text" name="colisaopp" class="form-control" data-mask="#0.00" data-mask-reverse="true" id="inputColisaoPP2" value="">
                        </td>
                        <td>
                            <input type="text" name="colisaopt" class="form-control" data-mask="#0.00" data-mask-reverse="true" id="inputColisaoPT2" value="">
                        </td>
                        <td>
                            <input type="text" name="roubofurto" class="form-control" data-mask="#0.00" data-mask-reverse="true" id="inputRouboFurto2" value="">
                        </td>
                        <td>
                            <input type="text" name="incendio" class="form-control" data-mask="#0.00" data-mask-reverse="true" id="inputIncendio2" value="">
                        </td>
                        <td>
                            <input type="text" name="completo" class="form-control" data-mask="#0.00" data-mask-reverse="true" id="inputCompleto2" value="">
                        </td>
                        <td>
                            <input type="text" name="desconto" class="form-control" id="inputDesconto2" value="">
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