<div class="card border-top border-0 border-4 border-primary">
    <div class="card-body p-5">
        <div class="card-title d-flex align-items-center">
            <div>
                <i class="bx bxs-user-check me-1 font-22 text-primary"></i>
            </div>
            <h5 class="mb-0 text-primary">Adesão</h5>
        </div>
        <hr>
        <div class="row my-3">
            <div class="col-3 pe-5">
                <input type="text" name="adesao" value="" class="form-control" id="inputAdesao">
            </div>
        </div>
        <div class="card-title d-flex align-items-center">
            <div>
                <i class="bx bxs-user-check me-1 font-22 text-primary"></i>
            </div>
            <h5 class="mb-0 text-primary">Selecionar opcionais</h5>
        </div>
        <hr>
        <form class="mt-5" action="<?= base_url("$path/proposta/gerar/{$lead->code}") ?>" method="post">
            <!-- servicos -->
            <div class="row my-3">
                <?php foreach ($opcionais as $opt) : ?>
                    <?php if ($opt->tipo == 'checkbox') : ?>
                        <div class="col-md-3 p-2 m-2 border">
                            <label class="form-label h5" for="<?= $opt->slug ?>">
                                <?= $opt->titulo ?>

                            </label>
                            <div class="form-check">
                                <input type="checkbox" name="opt[<?= $opt->slug ?>]" value="<?= $opt->valor ?>" class="form-check-input" id="<?= $opt->slug ?>" style="height:30px; width:30px;">
                                <?php if ($opt->exibe_valor) : ?>
                                    <label class="ms-3 mt-1 fs-5 form-label-check">+ <?= money($opt->valor) ?></label>
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
                            <select class="form-select py-1 px-1" style="font-size:1.05rem" name="opt[<?= $opt->slug ?>]" id="<?= $opt->slug ?>">
                                <option value="">Não contratar</option>
                                <?php foreach (json_decode($opt->options) as $k => $v) : ?>
                                    <option value='<?= json_encode($v) ?>'> <?php if ($opt->exibe_valor) : ?> + <?= money($v->valor) ?> <?php endif; ?><?= $v->titulo ?></option>
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