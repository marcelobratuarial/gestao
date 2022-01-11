<div class="card border-top border-0 border-4 border-primary">
    <div class="card-body p-5">
        <div class="card-title d-flex align-items-center">
            <div>
                <i class="bx bxs-credit-card-front me-1 font-22 text-primary"></i>
            </div>
            <h5 class="mb-0 text-primary">Documentos </h5>
        </div>
        <hr>
        <form method="post" action="<?= base_url('api/publico/documentos/create') ?>" enctype="multipart/form-data" class="needs-validation was-validated" novalidate>
            <input type="hidden" name="redirect_url" value="<?= current_url() ?>">
            <input type="hidden" name="codeProposta" value="<?= $code ?>">
            <div class="row g-3">
                <?php foreach ($documentos as $doc) : ?>
                    <div class="col-md-4 position-relative">
                        <label for="inputFile" class="form-label">
                            <?= $doc->titulo ?>
                            <br>
                            <small><?= $doc->instrucoes ?></small>
                        </label>

                        <?php if ($doc->nomeArquivo && $doc->status == 3) : ?>
                            <div class=" my-2 p-2 border border-2">
                                <div id="<?= url_title($doc->titulo) ?>" style="background-image:url('<?= base_url('upload/' . $doc->nomeArquivo) ?>'); background-size:cover">
                                    <img src="<?= $doc->foto ?>" class="img-fluid" style="opacity: 0;">
                                </div>
                            </div>

                            <div type="text" class="form-control myValid text-success"><?= $doc->nomeArquivo ?></div>
                            <div class="text-success small mt-1">Documento aprovado.</div>
                        <?php elseif ($doc->nomeArquivo && $doc->status == 1) : ?>
                            <div class=" my-2 p-2 border border-2">
                                <div id="<?= url_title($doc->titulo) ?>" style="background-image:url('<?= base_url('upload/' . $doc->nomeArquivo) ?>'); background-size:cover">
                                    <img src="<?= $doc->foto ?>" class="img-fluid" style="opacity: 0;">
                                </div>
                            </div>
                            <div type="text" class="form-control myWait"><?= $doc->nomeArquivo ?></div>
                            <div class="text-dark small mt-1">Documento em analise.</div>
                        <?php else : ?>
                            <div class=" my-2 p-2 border border-2">
                                <div id="<?= url_title($doc->titulo) ?>" style="background-image:url(<?= $doc->foto ?>); background-size:cover">
                                    <img src="<?= $doc->foto ?>" class="img-fluid" style="opacity: 0;">
                                </div>
                            </div>
                            <input type="file" name="file[<?= $doc->etapa ?>]" class="form-control" value="<?= $doc->foto ?>" onchange="loadFile(event, '<?= url_title($doc->titulo) ?>')" accept="image/*" required>
                            <div class="invalid-feedback"><?= $doc->motivo_rejeicao ? $doc->motivo_rejeicao : 'Aguardando envio.' ?></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>


            <div class="row mt-5 bg-primary p-5 text-white rounded-20">
                <div class="col-md-5 d-flex align-items-center justify-content-center">
                    <img class="img-fluid w-50" src="<?= base_url('assets/images/celular.png') ?>" alt="">
                </div>
                <div class="col-md-7 d-flex flex-column">

                    <h2>Auto-Vistoria</h2>
                    <h5>Veja como realizar a autovistoria:</h5>
                    <ul class="align-self-start">
                        <li>Baixe o aplicativo Grupo Motorhome</li>
                        <li>Acesse o menu "Realizar uma vistoria"</li>
                        <li>Informe o código abaixo</li>
                        <li>Siga o passo a instruções do aplicativo.</li>
                        <li>Escolha um ambiente claro para tirar os retratos necessários,</li>
                        <li>Pronto! Aguarde a aprovação!</li>
                    </ul>
                    <div class="align-self-start bg-info text-white rounded px-4 py-2 rounded">
                        <small>Código da Vistoria</small><br>
                        <b class="fs-2 "><?= $code ?></b>
                    </div>
                    <div class="mt-5">
                        <small>Baixe em:</small><br>
                        <img class="img-fluid w-25" src="<?= base_url('assets/images/googleplay.png') ?>" alt="">
                        <img class="img-fluid w-25" src="<?= base_url('assets/images/appstore.png') ?>" alt="">
                    </div>
                </div>

            </div>

            <div class="row g-3">
                <div class="col-md-12 text-center">
                    <?php if ($docsEnviados) : ?>
                        <div class="mt-5">
                            <span class="py-3 px-4 bg-dark text-white fs-5 rounded-0 mt-5"><i class="lni lni-search"></i> Documentos em análise</span>
                        </div>
                    <?php else : ?>
                        <button type="submit" class="btn btn-primary btn-lg rounded-0 mt-5"><i class="lni lni-checkmark"></i> Enviar documentos</button>
                    <?php endif; ?>
                </div>
            </div>
        </form>


    </div>
</div>