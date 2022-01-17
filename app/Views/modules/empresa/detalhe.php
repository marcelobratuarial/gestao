<?php
$status = getStatus('empresa', $empresa->codeStatus);
// var_dump($empresa);
// var_dump($status);
?>
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab"
      aria-controls="home" aria-selected="true">Informações</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="historico-tab" data-bs-toggle="tab" data-bs-target="#historico" type="button"
      role="tab" aria-controls="historico" aria-selected="false">Histórico</button>
  </li>

</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
    <div class="card-body p-5" style="background:#fff;">
      <div class="card-title">
        <div class="row">
          <div class="col d-flex align-items-center">
            <i class="bx bxs-info-square me-1 font-22 text-primary"></i>

            <h5 class="mb-0 text-primary">Informações da <?= customWord('empresa', false) ?></h5>
          </div>
          <div class="col text-end">
            <?php if ($status->code != 'final') : ?>
            <div onclick="changeStatus('empresa', '<?= $empresa->code ?>')"
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

      <form method="post" action="<?= base_url('empresa/save') ?>">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Razão social</label>
            <input type="text" class="form-control" name="razao_social" value='<?= $empresa->razao_social; ?>'>
          </div>
          <div class="col-md-6">
            <label class="form-label">CNPJ</label>
            <input class="form-control" name="cnpj" value='<?= $empresa->cnpj ?>'>
          </div>
          <div class="col-md-6">
            <label class="form-label">Email</label>
            <input class="form-control" name="email" value='<?= $empresa->email; ?>'>
          </div>


          <div class="col-md-6">
            <label class="form-label">Telefone</label>
            <input class="form-control" name="telefone" value='<?= telMask($empresa->telefone) ?>'>
          </div>
          <div class="col-md-4">
            <label class="form-label">CEP</label>
            <input class="form-control" name="cep" value='<?= $empresa->cep; ?>'>
          </div>
          <div class="col-md-4">
            <label class="form-label">Estado</label>
            <select name="uf" class="single-select form-select radius-square" onchange="carregaCidades(this.value)"
              required>
              <option value="">Escolha o estado</option>
              <?php foreach ($estados as $estado) : ?>
              <option value="<?= $estado->uf ?>" <?= (exibe($empresa, 'uf') == $estado->uf) ? 'selected' : null ?>>
                <?= $estado->nome ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label">Cidade</label>
            <select name="cidade" class="single-select form-select radius-square" required>
              <option value="">Escolha a cidade</option>
              <?php if (exibe($empresa, 'uf')) : ?>
              <?php foreach (getApi("cidades/" . exibe($empresa, 'uf'), true) as $cidade) : ?>
              <option value="<?= $cidade->nome ?>"
                <?= (exibe($empresa, 'cidade') == $cidade->nome) ? 'selected' : null ?>><?= $cidade->nome ?></option>
              <?php endforeach; ?>
              <?php endif; ?>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Endereço</label>
            <input class="form-control" name="logradouro" value='<?= $empresa->logradouro; ?>'>
          </div>
          <div class="col-md-3">
            <label class="form-label">Número</label>
            <input class="form-control" name="numero" value='<?= $empresa->numero; ?>'>
          </div>
          <div class="col-md-3">
            <label class="form-label">Complemento</label>
            <input class="form-control" name="complemento" value='<?= $empresa->complemento; ?>'>
          </div>

          <?php /**
          <div class="col-md-4">
            <label class="form-label">Produto</label>
            <select class="form-select" name="codeProduto">
              <?php foreach (getProduto() as $produto) : ?>
          <option value="<?= $produto->code ?>" <?= $lead->codeProduto == $produto->code ? 'selected' : null ?>>
            <?= $produto->nome ?></option>
          <?php endforeach; ?>
          </select>
        </div>
        */ ?>

        <?php /**
        foreach (json_decode($lead->camposExtras) as $k => $c) :
          if ($k != 'codeLead') :
        ?>
        <div class="col-md-6">
          <label for="input<?= ucfirst($k) ?>"
            class="form-label"><?= ucfirst(str_replace('_', ' ', str_replace('userIf', 'CPF', $k))) ?></label>
          <input type="text" name="camposExtras[<?= $c ?>]" class="form-control" id="input<?= ucfirst($c) ?>"
            value="<?= $c ?>" disabled>
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
      <h5 class="mb-0 text-primary">Contatos da <?= customWord('empresa', false) ?></h5>
    </div>
    <hr>
    <div class="card">

      <div class="card-body">

        <div class="table-responsive">

          <table id="table-primary" class="table table-striped table-bordered" style="width:100%">
            <thead>
              <tr>
                <!-- <th>Status</th> -->
                <th>Data</th>
                <?php foreach ($colunas  as $k => $v) : ?>
                  <?php if (configColunas('contato', $k)) : ?>
                    <th><?= $v; ?></th>

                  <?php endif; ?>
                <?php endforeach; ?>

                <th>#</th>
              </tr>

            </thead>

            <tbody>

              <?php 
                  // print_r($empresas);
                  foreach ($contatos as $u) :
                    // print_r($u);
                    //dados do campo extra
                    // $dados = json_decode($u->camposExtras);
                    // $dados = (array) $dados;
                    // $status = getStatus('cliente', $u->codeStatus);

                  ?>

              <tr>
                <td><?= date('d/m/Y H:i', strtotime($u->created_at)); ?></td>
                <?php  foreach ($colunas  as $k => $v) : ?>
                  <?php if (configColunas('contato', $k)) : ?>
                  <td>
                    <?php
                      if (isset($u->$k)) :
                        echo $u->$k;
                      else :
                        echo "n";
                      endif;
                    ?>
                  </td>
                <?php endif; ?>
                <?php endforeach; ?>
                <td>
                  <a href="http://localhost/gestao-bp-git/bp-acesso/contato/remover/<?= $u->code ?>" class="confirm text-danger"><i class="bx bx-trash"></i></a>
                  <a href="<?= base_url() ?>/empresa/detalhe/<?= $u->code ?>"
                    class="btn btn-primary btn-sm">Detalhes</a>
                </td>

              </tr>

              <?php endforeach; ?>


            </tbody>



          </table>
          <?php if (permissao('admin')) : ?>
          <a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#configCampos" class="btn btn-sm btn-danger">Configurar Campos</a>

          <?php endif; ?>
          <a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#configColunas" class="btn btn-sm btn-primary m-1">Configurar Colunas</a>
          <a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#addContato" class="btn btn-sm btn-primary m-1">Adicionar contato</a>

        </div>

      </div>

    </div>
    <div class="card-title d-flex align-items-center">
      <div>
        <i class="bx bxs-message-alt-edit me-1 font-22 text-primary"></i>
      </div>
      <h5 class="mb-0 text-primary">Observações da <?= customWord('empresa', false) ?></h5>
    </div>
    <hr>
    <div class="row g-3">
      <div class="col-md-6">
        <input type="hidden" name="code" value="<?= $empresa->code; ?>">
        <label class="form-label">Observações</label>
        <input type="hidden" name="redirect" value="<?= current_url(); ?>">
        <input type="hidden" name="codeStatus" value="<?= $empresa->codeStatus; ?>">
        <textarea rows="8" max="1600" name="obs" class="form-control" style="resize: none"></textarea>
      </div>

      <div class="col-md-6">

        <label class="form-label">Resumo do histórico</label>
        <ul class="list-group">
          <?php
              foreach ($historico as $k => $h) :
                if ($k <= 5) :
                  $status = getStatus('empresa', $h->codeStatus);
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
          <a class="btn btn-info btn-sm mt-4 text-white" onclick="document.getElementById('historico-tab').click();">Ver
            histórico completo</a>
        </div>
      </div>
    </div>
    <div class="row g-3 mt-4">
      <div class="col-12">
        <button type="submit" class="btn btn-primary px-5">Atualizar</button>
        <a href="<?= base_url('empresa') ?>" class="btn btn-light px-5"> Cancelar </a>
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
      <h5 class="mb-0 text-primary">Histórico do <?= customWord('empresa', false) ?></h5>
    </div>
    <hr>
    <div class="container py-2">

      <?php $i = count($historico); ?>
      <?php $iter = 1; ?>
      <?php
        foreach ($historico as $h) :
          $status = getStatus('empresa', $h->codeStatus);
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
              <div class="float-end text-<?= $iter == 1 ? 'primary' : 'muted'; ?>"><?= inTime($h->data_atualizacao) ?>
              </div>
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





<?php if (permissao('admin')) : ?>
<a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#configCampos" class="btn btn-sm btn-danger">Configurar Campos</a>

<?php endif; ?>
<a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#configColunas" class="btn btn-sm btn-primary m-1">Configurar Colunas</a>



<?php
$data['tabela'] = 'contato';

// carega as modais

$data['camposExtras'] = $camposExtras;
echo view('modules/modal/configCampos', $data);

$data['colunas'] = $colunas;
echo view('modules/modal/configColunas', $data);

echo view('modules/modal/addContato', $data);



?>