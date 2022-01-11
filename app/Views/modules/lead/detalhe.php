<?php
$status = getStatus('lead', $lead->codeStatus);
?>
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Informações</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="historico-tab" data-bs-toggle="tab" data-bs-target="#historico" type="button" role="tab" aria-controls="historico" aria-selected="false">Histórico</button>
  </li>

</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
    <div class="card-body p-5" style="background:#fff;">
      <div class="card-title">
        <div class="row">
          <div class="col d-flex align-items-center">
            <i class="bx bxs-info-square me-1 font-22 text-primary"></i>

            <h5 class="mb-0 text-primary">Informações do <?= customWord('lead', false) ?></h5>
          </div>
          <div class="col text-end">
            <?php if ($status->code != 'final') : ?>
              <div onclick="changeStatus('lead', '<?= $lead->code ?>')" class="cursor-pointer badge rounded-pill	text-<?= $status->cor ?> bg-light-<?= $status->cor ?> p-2 text-uppercase px-3">
                <i class="bx bxs-circle me-1"></i><?= $status->nome ?>
              </div>
            <?php else : ?>
              <div class="badge rounded-pill	text-<?= $status->cor ?> bg-light-<?= $status->cor ?> p-2 text-uppercase px-3">
                <i class="bx bxs-circle me-1"></i><?= $status->nome ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <hr>

      <form method="post" action="<?= base_url('lead/save') ?>">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nome</label>
            <input type="text" class="form-control" disabled value='<?= $lead->nome; ?>'>
          </div>
		  
		   <div class="col-md-6">
            <label class="form-label">Empresa</label>
            <input class="form-control" disabled value='<?= $lead->empresa; ?>'>
          </div>
		  
          <div class="col-md-4">
            <label class="form-label">Email</label>
            <input class="form-control" disabled value='<?= $lead->email; ?>'>
          </div>
		  
		    <div class="col-md-4">
            <label class="form-label">Telefone</label>
            <input class="form-control" disabled value='<?= telMask($lead->telefone) ?>'>
          </div>
		  
          <div class="col-md-4">
            <label class="form-label">Produto</label>
            <select class="form-select" name="codeProduto">
              <?php foreach (getProduto() as $produto) : ?>
                <option value="<?= $produto->code ?>" <?= $lead->codeProduto == $produto->code ? 'selected' : null ?>><?= $produto->nome ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        

          <?php /**
        foreach (json_decode($lead->camposExtras) as $k => $c) :
          if ($k != 'codeLead') :
        ?>
            <div class="col-md-6">
              <label for="input<?= ucfirst($k) ?>" class="form-label"><?= ucfirst(str_replace('_', ' ', str_replace('userIf', 'CPF', $k))) ?></label>
              <input type="text" name="camposExtras[<?= $c ?>]" class="form-control" id="input<?= ucfirst($c) ?>" value="<?= $c ?>" disabled>
            </div>
        <?php
          endif;
        endforeach; /**/
          ?>

        </div>
        <br>

        <div class="card-title d-flex align-items-center">
          <div>
            <i class="bx bxs-message-alt-edit me-1 font-22 text-primary"></i>
          </div>
          <h5 class="mb-0 text-primary">Observações do <?= customWord('lead', false) ?></h5>
        </div>
        <hr>
        <div class="row g-3">
          <div class="col-md-6">
            <input type="hidden" name="code" value="<?= $lead->code; ?>">
            <label class="form-label">Observações</label>
            <input type="hidden" name="redirect" value="<?= current_url(); ?>">
            <input type="hidden" name="codeStatus" value="<?= $lead->codeStatus; ?>">
            <textarea rows="8" max="1600" name="obs" class="form-control" style="resize: none"></textarea>
          </div>

          <div class="col-md-6">

            <label class="form-label">Resumo do histórico</label>
            <ul class="list-group">
              <?php
              foreach ($historico as $k => $h) :
                if ($k <= 5) :
                  $status = getStatus('lead', $h->codeStatus);
              ?>
                  <li class="list-group-item d-flex justify-content-between align-items-center"><?= $h->mensagem ?>
                    <span class="badge bg-primary rounded-pill"><?= $status->nome ?></span>
                  </li>
              <?php
                endif;
              endforeach;
              ?>
            </ul>
            <div class="text-center">
              <a class="btn btn-info btn-sm mt-4 text-white" onclick="document.getElementById('historico-tab').click();">Ver histórico completo</a>
            </div>
          </div>
        </div>
        <div class="row g-3 mt-4">
          <div class="col-12">
            <button type="submit" class="btn btn-primary px-5">Atualizar</button>
            <a href="<?= base_url('lead') ?>" class="btn btn-light px-5"> Cancelar </a>
          </div>
        </div>

      </form>
    </div>
  </div>

  <div class="tab-pane fade" id="historico" role="tabpanel" aria-labelledby="historico-tab">
    <div class="card-body p-5" style="background:#fff;">
      <div class="card-title d-flex align-items-center">
        <div>
          <i class="bx bxs-calendar me-1 font-22 text-primary"></i>
        </div>
        <h5 class="mb-0 text-primary">Histórico do <?= customWord('lead', false) ?></h5>
      </div>
      <hr>
      <div class="container py-2">

        <?php $i = count($historico); ?>
        <?php $iter = 1; ?>
        <?php
        foreach ($historico as $h) :
          $status = getStatus('lead', $h->codeStatus);
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
                  <h4 class="card-title text-<?= $iter == 1 ? 'primary' : 'muted'; ?>">
                    <?= $status->nome ?>
                    <?php if ($status->code == 'final') : ?>
                      <a href="<?= base_url('proposta/visualizar/' . $h->codeRef) ?>"><i class="bx bx-link"></i></a>
                    <?php endif; ?>
                  </h4>
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
</div>