<div class="shadow pb-5 mb-4">
    <?= view("custom/$path/proposta/proposta_view.php") ?>
</div>
<div class="px-5">
    <form class="was-validated" action="<?= base_url("proposta/save/$code") ?>" method="post">
        <div class="my-3 text-center">
            <button class="btn btn-primary py-3 px-5" name="dadosProposta" value='<?= json_encode($d) ?>' type="submit">
                <i class="lni lni-pencil-alt"></i>
                ASSINAR E SALVAR PROPOSTA
            </button>
        </div>
    </form>
</div>