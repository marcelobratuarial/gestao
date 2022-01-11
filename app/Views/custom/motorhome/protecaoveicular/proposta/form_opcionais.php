<div class="card border-top border-0 border-4 border-primary">

    <form class="mt-5" action="<?= base_url("$path/proposta/gerar/{$lead->code}") ?>" method="post">
        <div class="card-body p-5">
            <div class="card-title d-flex align-items-center">
                <div>
                    <i class="bx bxs-user-check me-1 font-22 text-primary"></i>
                </div>
                <h5 class="mb-0 text-primary">Adesão</h5>
            </div>
            <hr>
            <div class="row my-3">
                <div class="col-md-3">
                    <label class="form-label h5" for="inputAdesao"></label> <input type="text" name="adesao" value="R$ 0,00" class="maskMoney form-control" id="inputAdesao">
                </div>
            </div>
            <div class="card-title d-flex align-items-center">
                <div>
                    <i class="bx bxs-user-check me-1 font-22 text-primary"></i>
                </div>
                <h5 class="mb-0 text-primary">Selecionar opcionais</h5>
            </div>
            <hr>
            <!-- servicos -->
            <div id="opcionais" class="row my-3">
                <?php foreach ($opcionais as $opt) :
                    if ($opt->tipo == 'checkbox') :
                        $valor = $opt->valor; ?>
                        <div class="col-md-3 p-2 m-2 border">
                            <label class="form-label h5" for="<?= $opt->slug ?>">
                                <?= $opt->titulo ?>

                            </label>
                            <div class="form-check">
                                <input type="checkbox" name="opt[<?= $opt->slug ?>]" value="<?= $valor ?>" class="opt form-check-input" id="<?= $opt->slug ?>" style="height:30px; width:30px;">
                                <?php if ($opt->exibe_valor) : ?>
                                    <label class="ms-3 mt-1 fs-5 form-label-check">+ <?= money($valor) ?></label>
                                <?php endif; ?>
                                <?php if ($opt->descricao) : ?>
                                    <i data-bs-toggle="tooltip" title="<?= $opt->descricao ?>" class="text-info bx bx-info-circle"></i>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php elseif ($opt->tipo == 'select') : ?>
                        <div class="col-md-3 m-2 p-2 border">
                            <label class="form-label h5" for="<?= $opt->slug ?>">
                                <?= $opt->titulo ?>
                                <?php if ($opt->descricao) : ?>
                                    <i data-bs-toggle="tooltip" title="<?= $opt->descricao ?>" class="small text-info bx bx-info-circle"></i>
                                <?php endif; ?>
                            </label>
                            <select class="opt form-select py-1 px-1" style="font-size:1.05rem" name="opt[<?= $opt->slug ?>]" id="<?= $opt->slug ?>">
                                <option value="">Não contratar</option>
                                <?php foreach (json_decode($opt->options) as $k => $v) :
                                    $valor = $v->valor; ?>
                                    <option value='<?= json_encode($v) ?>'> <?php if ($opt->exibe_valor) : ?> + <?= money($valor) ?> <?php endif; ?><?= $v->titulo ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <!-- end servicos -->

            <!-- botão final -->
            <div class="row my-3">
                <div class="col-12 text-end">
                    <?php if ($tabela) :
                        $mensalidade =  number_format($mensalidade + $tabela->mensalidade + ($tabela->mensalidade * $categoria->agravo / 100), 2, '.', ''); ?>
                        <h3>
                            <small class="fs-6">Mensalidade:</small>
                            <span class="valor_mensalidade">
                                <?= money($tabela->mensalidade + ($tabela->mensalidade * $categoria->agravo / 100), true) ?>
                            </span>
                        </h3>
                    <?php endif; ?>
                    <?php if ($tabela_carreta) :
                        foreach ($tabela_carreta as $k => $carreta) :
                            $carreta = json_decode($carreta);
                            $mensalidade = number_format($mensalidade + $carreta->mensalidade + ($carreta->mensalidade * $categoria->agravo / 100), 2, '.', ''); ?>
                            <h3>
                                <small class="fs-6">Mensalidade Carreta <?= $k + 1 ?>:</small>
                                <span class="valor_mensalidade">
                                    <?= money($carreta->mensalidade + ($carreta->mensalidade * $categoria->agravo / 100), true) ?>
                                </span>
                            </h3>
                    <?php
                        endforeach;
                    endif; ?>
                    <h3>
                        <small class="fs-6">Opcionais:</small>
                        <span id="valor_opcionais">
                            <?= money(0, true) ?>
                        </span>
                    </h3>
                    <h3>
                        <small class="fs-6">Total:</small>
                        <span id="valor_total">
                            <?= money($mensalidade, true) ?>
                        </span>
                    </h3>
                    <p class="fs--1 fw-300 color-3 mt-2">
                        <button type="submit" name="json" value='<?= $post ?>' class="btn btn-primary float-right">Gerar Proposta</button>
                    </p>
                </div>
            </div>
            <!-- end botão final -->
        </div>
    </form>
</div>