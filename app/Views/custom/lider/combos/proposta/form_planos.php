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
                <h5 class="mb-0 text-primary">Selecione o plano</h5>
            </div>
            <hr>
            <div class="row my-3">
                <?php foreach ($planos as $p) : ?>
                    <div class="col">
                        <div class="card mb-5 mb-lg-0">
                            <div class="card-header bg-primary py-3">
                                <h5 class="card-title text-white text-uppercase text-center"><?= $p->titulo ?></h5>

                                <?php if ($p->desconto > 0) : ?>
                                    <h3 class="card-price text-white text-center"><?= money($p->valor_recorrente, true) ?><span class="term">/mês*</span></h3>
                                    <h6 class="card-price text-white text-center"><?= money($p->valor, true) ?><span class="term">/mês</span></h6>
                                <?php else : ?>
                                    <h3 class="card-price text-white text-center"><?= money($p->valor, true) ?><span class="term">/mês</span></h3>
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <?= nl2br($p->descricao) ?>

                                <div class="d-grid">
                                    <input type="hidden" name="json" value='<?= $post ?>'>
                                    <button type="submit" name="plano" value="<?= $p->slug ?>" class="btn btn-primary my-2 radius-30">Selecionar</button>
                                </div>
                            </div>
                        </div>
                        <?php if ($p->desconto > 0) : ?>
                            <small>*Valor com desconto de <?= $p->desconto ?>% para pagamento recorrente no cartão de crédito.</small>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </form>
    </div>
</div>