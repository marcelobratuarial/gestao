<div class="card border-top border-0 border-4 border-primary">
    <div class="card-body p-5">
        <form id="formWithPassword" method="post" action="<?= base_url('produto/save') ?>">
            <div class="card-title d-flex align-items-center">
                <div>
                    <i class="bx bxs-user me-1 h5 text-primary"></i>
                </div>
                <div class="h5 mb-0 text-primary w-100">
                    Configurar produto
                    <?php if ($produto->status == 1) : ?>
                        <a href="<?= base_url('produto/desativar/' . $produto->code) ?>" class="text-success ms-5"><i class="lni lni-checkmark-circle me-0"></i></a>
                    <?php else : ?>
                        <a href="<?= base_url('produto/ativar/' . $produto->code) ?>" class="text-warning ms-5"><i class="lni lni-cross-circle me-0"></i></a>
                    <?php endif; ?>
                </div>
            </div>
            <hr>

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="inputName" class="form-label">Nome</label>
                    <input type="text" name="nome" class="form-control" id="inputName" value="<?= $produto->nome ?>">
                </div>

                <div class="col-md-6">
                    <label for="inputName" class="form-label">Validade para as propostas <span class="text-muted">(dias)</span></label><br>
                    <input type="number" name="validade" class="form-control" id="inputName" value="<?= $produto->validade ?>">
                </div>
            </div>
            <div class="row g-3 mt-4">
                <div class="col-md-6">
                    <label for="assinaturaDados" class="form-label ">Checkbox Dados</label>
                    <textarea name="assinaturaDados" rows="7" class="form-control summernote" id="assinaturaDados"><?= $produto->assinaturaDados ?></textarea>
                </div>
                <div class="col-md-6">
                    <label for="assinaturaExtra" class="form-label">Checkbox Extra</label>
                    <textarea name="assinaturaExtra" rows="7" class="form-control" id="assinaturaDados"><?= $produto->assinaturaExtra ?></textarea>
                </div>
            </div>
            <div class="row g-3 mt-4">
                <div class="col-12">
                    <a href="<?= base_url('produto') ?>" class="btn btn-light px-5"> Cancelar </a>
                    <button id="buttonSubmit" type="submit" name="code" value="<?= $produto->code ?>" class="btn btn-primary px-5">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</div>

