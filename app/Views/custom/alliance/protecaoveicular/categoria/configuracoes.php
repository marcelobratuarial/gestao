<div class="card border-top border-0 border-4 border-primary">
    <div class="card-body p-5">
        <div class="card-title d-flex align-items-center">
            <div>
                <i class="bx bxs-user-check me-1 font-22 text-primary"></i>
            </div>
            <h5 class="mb-0 text-primary">Configurações</h5>
        </div>
        <hr>
        <form method="post" action="<?= base_url("$path/save/configuracoes"); ?>">
            <div class="row g-3">
                <div class="col-md-8">
                    <input type="hidden" name="id" value="<?= $categoria->code; ?>">
                    <label for="inputName" class="form-label">Título</label> <input type="text" name="titulo" class="form-control" id="inputName" value="<?= $categoria->titulo; ?>">
                </div>
                <div class="col-md-4">
                    <label for="inputApiRef" class="form-label">Referencia API</label> <input type="text" name="apiRef" class="form-control" id="inputApiRef" value="<?= $categoria->apiRef; ?>">
                </div>
                <div class="col-md-12">
                    <label for="inputEmail" class="form-label">Descricao</label>
                    <textarea name="descricao" class="form-control"><?= $categoria->descricao; ?></textarea>
                </div>

                <div class="col-md-12">
                    <label for="inputEmail" class="form-label">Benefícios</label>
                    <textarea name="beneficio" class="form-control" style="height: 200px;"><?= $categoria->beneficio; ?></textarea>
                </div>


            </div>

            <div class="row g-3 mt-4">
                <div class="col-12">
                    <button type="submit" name="code" value="<?= $code ?>" class="btn btn-primary px-5">Salvar</button>
                    <a href="<?= base_url($path . '/delete/categoria/' . $code) ?>" class="confirm btn btn-danger px-5">Excluir</a>
                </div>
            </div>
        </form>
    </div>
</div>