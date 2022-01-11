<div class="shadow pb-5 mb-4">
    <?= view("custom/$path/proposta/proposta_view.php") ?>
</div>
<div class="px-5">
    <form class="was-validated" action="<?= base_url("proposta/save/$code") ?>" method="post">
        <div class="my-3 text-center">
            <a href="<?= base_url("$path/proposta/dados/$code") ?>" class="btn btn-dark py-3 px-5">Cancelar</a>
            <button class="btn btn-primary py-3 px-5" name="dadosProposta" value='<?= json_encode($d) ?>' type="submit">
                
                <?php if (getEmpresa(CODEEMPRESA, 'assinatura') == 1) : ?>
                    <i class="lni lni-pencil-alt"></i> ASSINAR E GERAR PROPOSTA
                <?php else : ?>
                    <i class="lni lni-checkmark-circle"></i> SALVAR E GERAR PROPOSTA
                <?php endif; ?>
            </button>
        </div>
    </form>
</div>