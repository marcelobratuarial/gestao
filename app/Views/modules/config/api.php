<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column align-items-center text-center">
                    <div class="mt-3">
                        <h4>API Brasil Platafomas</h4>
                        <p class="text-secondary mb-1">Versão: 1.0a</p>
                        <p class="text-muted font-size-sm">Url Base: <?= base_url('api/v1') ?></p>
                        <!-- <button class="btn btn-primary">Follow</button>
                        <button class="btn btn-outline-primary">Message</button> -->
                    </div>
                </div>
                <hr class="my-4">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0 w-25">ApiKey</h6>
                        <span class="text-secondary w-75"><input class="form-control" readonly value="<?= $empresa->apiKey ?>"></span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0 w-25">ApiSecretKey</h6>
                        <div class="text-secondary w-75"><input class="form-control" readonly value="<?= $empresa->apiSecretKey ?>"></div>
                    </li>
                    <a href="<?= base_url('configuracao/api/update') ?>" class="btn btn-outline-primary">Atualizar Keys</a>
                </ul>
            </div>
        </div>
    </div>

</div>