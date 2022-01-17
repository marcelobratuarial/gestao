<div class="card border-top border-0 border-4 border-primary">
  <div class="card-body p-5">
    <div class="card-title d-flex align-items-center">
      <div>
        <i class="bx bxs-user-check me-1 font-22 text-primary"></i>
      </div>
      <h5 class="mb-0 text-primary">Adicionar <?= customWord('produto', false) ?></h5>
    </div>
    <hr>
    <form method="post" action="<?= base_url('produtos/save') ?>">
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Nome</label>
          <input type="text" class="form-control" name="nome" value=''>
        </div>
        <div class="col-md-6">
          <label class="form-label">Tipo</label>
          <input class="form-control" name="tipo" value=''>
        </div>
        <div class="col-md-6">
          <label class="form-label">Valor</label>
          <input class="form-control" name="valor" value=''>
        </div>
      </div>
      <br>

      <div class="card-title d-flex align-items-center">
        <div>
          <i class="bx bxs-message-alt-edit me-1 font-22 text-primary"></i>
          <h5 class="mb-0 text-primary">Descrição do <?= customWord('produto', false) ?></h5>
        </div>
      </div>
      <hr>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Descrição</label>
          <textarea rows="8" max="1600" name="obs" class="form-control" style="resize: none"></textarea>
        </div>
      </div>
      <div class="row g-3 mt-4">
        <div class="col-12">
          <a href="<?= base_url('empresa')?>" class="btn btn-light px-5">
            Cancelar
          </a>
          <button type="submit" class="btn btn-primary px-5">
            Salvar
          </button>
        </div>
      </div>
    </form>
  </div>
</div>