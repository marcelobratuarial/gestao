<div class="card border-top border-0 border-4 border-primary">
  <div class="card-body p-5">
    <div class="card-title d-flex align-items-center">
      <div>
        <i class="bx bxs-user-check me-1 font-22 text-primary"></i>
      </div>
      <h5 class="mb-0 text-primary">Adicionar <?= customWord('empresa', false) ?></h5>
    </div>
    <hr>
    <form method="post" action="<?= base_url('empresa/save') ?>">
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Razão social</label>
          <input type="text" class="form-control" name="razao_social" value=''>
        </div>
        <div class="col-md-6">
          <label class="form-label">CNPJ</label>
          <input class="form-control" name="cnpj" value=''>
        </div>
        <div class="col-md-6">
          <label class="form-label">Email</label>
          <input class="form-control" name="email" value=''>
        </div>


        <div class="col-md-6">
          <label class="form-label">Telefone</label>
          <input class="form-control" name="telefone" value=''>
        </div>
        <div class="col-md-4">
          <label class="form-label">CEP</label>
          <input class="form-control" name="cep" value=''>
        </div>
        <div class="col-md-4">
          <label class="form-label">Estado</label>
          <select name="uf" class="single-select form-select radius-square" onchange="carregaCidades(this.value)"
            required>
            <option value="">Escolha o estado</option>
            <?php foreach ($estados as $estado) : ?>
            <option value="<?= $estado->uf ?>">
              <?= $estado->nome ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label">Cidade</label>
          <select name="cidade" class="single-select form-select radius-square" required>
            <option value="">Escolha a cidade</option>
            
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Endereço</label>
          <input class="form-control" name="logradouro" value=''>
        </div>
        <div class="col-md-3">
          <label class="form-label">Número</label>
          <input class="form-control" name="numero" value=''>
        </div>
        <div class="col-md-3">
          <label class="form-label">Complemento</label>
          <input class="form-control" name="complemento" value=''>
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
    <h5 class="mb-0 text-primary">Observações da <?= customWord('empresa', false) ?></h5>
  </div>
  <hr>
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Observações</label>
      <textarea rows="8" max="1600" name="obs" class="form-control" style="resize: none"></textarea>
    </div>

    <div class="col-md-6">

      <label class="form-label">Resumo do histórico</label>
      <ul class="list-group">
        
        <li class="list-group-item d-flex justify-content-between align-items-center">
          Nenhum histórico
        </li>
        
      </ul>
      
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