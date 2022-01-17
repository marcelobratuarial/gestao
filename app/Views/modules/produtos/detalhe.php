<?php
$status = getStatus('produtos', $produtos->codeStatus);
// var_dump($empresa);
// var_dump($status);
?>
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab"
      aria-controls="home" aria-selected="true">Informações</button>
  </li>
  
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
    <div class="card-body p-5" style="background:#fff;">
      <div class="card-title">
        <div class="row">
          <div class="col d-flex align-items-center">
            <i class="bx bxs-info-square me-1 font-22 text-primary"></i>

            <h5 class="mb-0 text-primary">Informações do <?= customWord('produtos', false) ?></h5>
          </div>
          <div class="col text-end">
            <?php if ($status->code != 'final') : ?>
            <div onclick="changeStatus('produtos', '<?= $produtos->code ?>')"
              class="cursor-pointer badge rounded-pill	text-<?= $status->cor ?> bg-light-<?= $status->cor ?> p-2 text-uppercase px-3">
              <i class="bx bxs-circle me-1"></i><?= $status->nome ?>
            </div>
            <?php else : ?>
            <div
              class="badge rounded-pill	text-<?= $status->cor ?> bg-light-<?= $status->cor ?> p-2 text-uppercase px-3">
              <i class="bx bxs-circle me-1"></i><?= $status->nome ?>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <hr>

      <form method="post" action="<?= base_url('produtos/save') ?>">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nome</label>
            <input type="text" class="form-control" name="nome" value='<?= $produtos->nome; ?>'>
          </div>
          <div class="col-md-6">
            <label class="form-label">Validade</label>
            <input class="form-control" name="validade" value='<?= $produtos->validade ?>'>
          </div>
          <div class="col-md-6">
            <label class="form-label">Tipo</label>
            <input class="form-control" name="tipo" value='<?= $produtos->tipo ?>'>
          </div>
          <div class="col-md-6">
            <label class="form-label">Valor</label>
            <input class="form-control" name="valor" value='<?= money($produtos->valor); ?>'>
          </div>


          

    </div>
    <br>
    <br>
    
    <div class="card-title d-flex align-items-center">
      <div>
        <i class="bx bxs-message-alt-edit me-1 font-22 text-primary"></i>
      </div>
      <h5 class="mb-0 text-primary">Descrição do <?= customWord('produto', false) ?></h5>
    </div>
    <hr>
    <div class="row g-3">
      <div class="col-md-6">
        <input type="hidden" name="code" value="<?= $produtos->code; ?>">
        <label class="form-label">Descrição</label>
        <input type="hidden" name="redirect" value="<?= current_url(); ?>">
        <input type="hidden" name="codeStatus" value="<?= $produtos->codeStatus; ?>">
        <textarea rows="8" max="1600" name="obs" class="form-control" style="resize: none"></textarea>
      </div>

      
    </div>
    <div class="row g-3 mt-4">
      <div class="col-12">
        <button type="submit" class="btn btn-primary px-5">Atualizar</button>
        <a href="<?= base_url('produtos') ?>" class="btn btn-light px-5"> Cancelar </a>
      </div>
    </div>

    </form>
  </div>
</div>

</div>





<?php if (permissao('admin')) : ?>
<a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#configCampos" class="btn btn-sm btn-danger">Configurar Campos</a>

<?php endif; ?>
<a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#configColunas" class="btn btn-sm btn-primary m-1">Configurar Colunas</a>



<?php
$data['tabela'] = 'contato';

// carega as modais

// $data['camposExtras'] = $camposExtras;
// echo view('modules/modal/configCampos', $data);

// $data['colunas'] = $colunas;
// echo view('modules/modal/configColunas', $data);

// echo view('modules/modal/addContato', $data);



?>