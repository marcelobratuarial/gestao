<div class="row mb-2">
    <div class="col-auto">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Proposta</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Histórico</button>
            </li>
        </ul>
    </div>
    <div class="col text-end">
        <?php if ($status->code != 'final') : ?>
            <div onclick="changeStatus('proposta', '<?= $proposta->code ?>')" class="cursor-pointer badge rounded-pill	text-<?= $status->cor ?> bg-light-<?= $status->cor ?> p-2 text-uppercase px-3">
                <i class="bx bxs-circle me-1"></i><?= $status->nome ?>
            </div>
        <?php else : ?>
            <div class="badge rounded-pill	text-<?= $status->cor ?> bg-light-<?= $status->cor ?> p-2 text-uppercase px-3">
                <i class="bx bxs-circle me-1"></i><?= $status->nome ?>
            </div>
        <?php endif; ?>
        <a href="<?= base_url('portal/download/' . $code) ?>" target="_blank" class="badge cursor-pointer bg-dark rounded-pill p-2 text-uppercase px-3"><i class="lni lni-download"></i> Baixar em PDF</a>
        <a href="<?= base_url('portal/proposta/' . $code) ?>" target="_blank" class="shareButton badge cursor-pointer bg-dark rounded-pill p-2 text-uppercase px-3"><i class="bx bx-share-alt"></i> Compartilhar</a>
        <?php if (date('Y-m-d') > date('Y-m-d', strtotime($proposta->created_at . " +{$produto->validade} days"))) : ?>
            <a href="<?= base_url('proposta/validade/' . $code) ?>" target="_blank" class="badge cursor-pointer bg-danger rounded-pill p-2 text-uppercase px-3"><i class="lni lni-cross-circle"></i> Proposta Vencida</a>
        <?php endif; ?>
    </div>
</div>

<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <?= view($include) ?>
    </div>

    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <div class="card-body p-5" style="background:#fff;">
            <div class="card-title d-flex align-items-center">
                <div>
                    <i class="bx bxs-calendar me-1 font-22 text-primary"></i>
                </div>
                <h5 class="mb-0 text-primary">Histórico da proposta - <?= $code ?></h5>
            </div>
            <hr>
            <div class="container py-2">

                <?php $i = count($historico); ?>
                <?php $iter = 1; ?>
                <?php
                foreach ($historico as $h) :
                    $status = getStatus('proposta', $h->codeStatus);
                ?>


                    <!-- timeline item 1 -->
                    <div class="row g-0">
                        <?php if ($iter % 2 == 1) : ?>
                            <div class="col-sm">
                                <!--spacer-->
                            </div>
                            <!-- timeline item 1 center dot -->
                            <div class="col-sm-1 text-center flex-column d-none d-sm-flex">
                                <div class="row h-50">
                                    <div class="col <?= $iter == 1 ? '' : 'border-end' ?>">&nbsp;</div>
                                    <div class="col">&nbsp;</div>
                                </div>
                                <h5 class="m-2">
                                    <span class="badge rounded-pill <?= $iter == 1 ? 'bg-primary' : 'bg-light border'; ?>">&nbsp;</span>
                                </h5>
                                <div class="row h-50">
                                    <div class="col <?= $iter == $i ? '' : 'border-end' ?>">&nbsp;</div>
                                    <div class="col">&nbsp;</div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <!-- timeline item 1 event content -->
                        <div class="col-sm py-2">
                            <div class="card radius-15">
                                <div class="card-body">
                                    <div class="float-end text-<?= $iter == 1 ? 'primary' : 'muted'; ?>"><?= inTime($h->data_atualizacao) ?></div>
                                    <h4 class="card-title text-<?= $iter == 1 ? 'primary' : 'muted'; ?>"><?= $status->nome ?></h4>
                                    <p class="card-text">Atualizado por: <?= getUsuario($h->codeUsuario, 'nome') ?></p>
                                    <?php if ($h->mensagem != null) : ?>
                                        <p class="card-text">Obs: <?= $h->mensagem ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php if ($iter % 2 == 0) : ?>
                            <!-- timeline item 1 center dot -->
                            <div class="col-sm-1 text-center flex-column d-none d-sm-flex">
                                <div class="row h-50">
                                    <div class="col <?= $iter == 1 ? '' : 'border-end' ?>">&nbsp;</div>
                                    <div class="col">&nbsp;</div>
                                </div>
                                <h5 class="m-2">
                                    <span class="badge rounded-pill <?= $iter == 1 ? 'bg-primary' : 'bg-light border'; ?>">&nbsp;</span>
                                </h5>
                                <div class="row h-50">
                                    <div class="col <?= $iter == $i ? '' : 'border-end' ?>">&nbsp;</div>
                                    <div class="col">&nbsp;</div>
                                </div>
                            </div>
                            <div class="col-sm">
                                <!--spacer-->
                            </div>
                        <?php endif; ?>
                    </div>
                    <!--/row-->


                    <?php $iter++; ?>
                <?php endforeach; ?>

            </div>
        </div>
    </div>