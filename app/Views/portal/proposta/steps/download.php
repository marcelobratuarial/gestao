<div class="card border-top border-0 border-4 border-primary">
    <div class="card-body p-5">
        <div class="card-title d-flex align-items-center">
            <div>
                <i class="bx bxs-save me-1 font-22 text-primary"></i>
            </div>
            <h5 class="mb-0 text-primary">Download do Contrato </h5>
        </div>
        <hr>
        <form method="post" action="<?= base_url('portal/assinar') ?>">
            <div class="row g-3">
                <div class="col-md-12">
                    <?php if ($propostaassinada) : ?>
                        <a href="<?= base_url('portal/download') . '/' . $proposta->code . '-ASSINADA.pdf' ?>" target="_blank" class="btn btn-primary px-5">
                            Baixar Proposta Assinada
                        </a>
                    <?php else : ?>
                        <a href="<?= base_url('portal/download') . '/' . $proposta->code ?>.pdf" target="_blank" class="btn btn-primary px-5">
                            Baixar Proposta Original
                        </a>
                    <?php endif; ?>
                </div>

            </div>
            <br><br>


    </div>
</div>