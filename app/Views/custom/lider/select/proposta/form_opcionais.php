<div class="card border-top border-0 border-4 border-primary">
    <div class="card-body p-5">
        <form class="mt-5" action="<?= base_url("$path/proposta/gerar/{$lead->code}") ?>" method="post">
            <div class="card-title d-flex align-items-center">
                <div>
                    <i class="bx bxs-user-check me-1 font-22 text-primary"></i>
                </div>
                <h5 class="mb-0 text-primary">Adesão</h5>
            </div>
            <hr>
            <div class="row my-3">
                <div class="col-3 pe-5">
                    <input type="text" name="adesao" value="<?= $tabela['adesao'] ?>" class="form-control" id="inputAdesao">
                </div>
            </div>
            <div class="card-title d-flex align-items-center">
                <div>
                    <i class="bx bxs-user-check me-1 font-22 text-primary"></i>
                </div>
                <h5 class="mb-0 text-primary">Selecionar benefícios</h5>
            </div>
            <hr>
            <div class="row my-3">
                <?php foreach ($beneficios as $bnf) : ?>
                    <div class="col-3 pe-5">
                        <label class="form-label h5" for="<?= $bnf->slug ?>">
                            <?= $bnf->titulo ?>
                        </label>
                        <div class="form-check">
                            <input type="checkbox" <?= $bnf->slug != 'incendio' ? 'data-required="bnf"' : null ?> name="bnf[<?= $bnf->slug ?>]" value="<?= $bnf->valor ?>" class="form-check-input" id="<?= $bnf->slug ?>" style="height:30px; width:30px;">
                            <label class="ms-3 mt-1 fs-5 form-label-check">+ <?= money($bnf->valor + ($bnf->valor * $categoria['agravo'] / 100)) ?></label>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="card-title d-flex mt-5 pt-5 align-items-center">
                <div>
                    <i class="bx bxs-user-check me-1 font-22 text-primary"></i>
                </div>
                <h5 class="mb-0 text-primary">Selecionar opcionais</h5>
            </div>
            <hr>

            <!-- servicos -->
            <div class="row my-3">
                <?php foreach ($opcionais as $opt) : ?>
                    <?php if ($opt->tipo == 'checkbox') : ?>
                        <div class="col-3 pe-5 my-3">
                            <label class="form-label h5" for="<?= $opt->slug ?>">
                                <?= $opt->titulo ?>
                                <?php if ($opt->descricao) : ?><i data-toggle="tooltip" title="<?= $opt->descricao ?>" class="small text-info bx bx-info-circle"></i><?php endif; ?>
                            </label>
                            <div class="form-check">
                                <input type="checkbox" <?= $opt->obrigatorio ? 'data-required="opt"' : null ?> name="opt[<?= $opt->slug ?>]" value="<?= $opt->valor ?>" class="form-check-input" id="<?= $opt->slug ?>" style="height:30px; width:30px;">
                                <label class="ms-3 mt-1 fs-5 form-label-check">+ <?= money($opt->valor) ?></label>
                            </div>
                        </div>
                    <?php elseif ($opt->tipo == 'select') : ?>
                        <div class="col-3 pe-5 my-3">
                            <label class="form-label h5" for="<?= $opt->slug ?>">
                                <?= $opt->titulo ?>
                                <?php if ($opt->descricao) : ?><i data-toggle="tooltip" title="<?= $opt->descricao ?>" class="small text-info bx bx-info-circle"></i><?php endif; ?>
                            </label>
                            <select class="form-select py-1 px-1" style="font-size:1.05rem" name="opt[<?= $opt->slug ?>]" id="<?= $opt->slug ?>">
                                <option value="">Não contratar</option>
                                <?php foreach (json_decode($opt->options) as $k => $v) : ?>
                                    <option value='<?= json_encode($v) ?>'> + <?= money($v->valor) ?> <?= $v->titulo ?></option>
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
                    <p class="fs--1 fw-300 color-3 mt-2">
                        <button type="submit" name="json" value='<?= $post ?>' class="btn btn-primary float-right">Gerar Proposta</button>
                    </p>
                </div>
            </div>
            <!-- end botão final -->
        </form>
    </div>
</div>