<div class="row g-3">
    <div class="col-md-4 position-relative">
        <label class="form-label">Estado</label>
        <select name="uf" class="single-select form-select radius-square" onchange="carregaCidades(this.value)" required>
            <option value="">Escolha o estado</option>
            <?php foreach (getApi("estados", true) as $estado) : ?>
                <option value="<?= $estado->uf ?>" <?= (exibe($d, 'uf') == $estado->uf) ? 'selected' : null ?>><?= $estado->nome ?></option>
            <?php endforeach; ?>
        </select>
        <div class="invalid-tooltip">Selecione o ESTADO.</div>
    </div>
    <div class="col-md-4 position-relative">
        <label class="form-label">Cidade</label>
        <select name="cidade" class="single-select form-select radius-square" required>
            <option value="">Escolha a cidade</option>
            <?php if (exibe($d, 'uf')) : ?>
                <?php foreach (getApi("cidades/" . exibe($d, 'uf'), true) as $cidade) : ?>
                    <option value="<?= $cidade->nome ?>" <?= (exibe($d, 'cidade') == $cidade->nome) ? 'selected' : null ?>><?= $cidade->nome ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
        <div class="invalid-tooltip">Selecione a CIDADE.</div>
    </div>
    <div class="col-md-4 position-relative">
        <label for="inputName" class="form-label">CEP</label>
        <input type="text" name="cep" data-mask="00000-000" class="form-control" id="inputName" value="<?= old('cep') ? old('cep') : exibe($d, 'cep', true) ?>" required>
        <div class="invalid-tooltip">Preencha o CEP.</div>
    </div>
    <div class="col-md-3 position-relative">
        <label for="inputName" class="form-label">Bairro</label>
        <input type="text" name="bairro" class="form-control" id="inputName" value="<?= old('bairro') ? old('bairro') : exibe($d, 'bairro', true) ?>" required>
        <div class="invalid-tooltip">Preencha o BAIRRO.</div>
    </div>
    <div class="col-md-5 position-relative">
        <label for="inputName" class="form-label">Endereço</label>
        <input type="text" name="endereco" class="form-control" id="inputName" value="<?= old('endereco') ? old('endereco') : exibe($d, 'endereco', true) ?>" required>
        <div class="invalid-tooltip">Preencha o ENDEREÇO.</div>
    </div>
    <div class="col-md-1 position-relative">
        <label for="inputName" class="form-label">Nº</label>
        <input type="text" name="numero" class="form-control" id="inputName" value="<?= old('numero') ? old('numero') : exibe($d, 'numero', true) ?>" required>
        <div class="invalid-tooltip" style="margin-right:-50px">Preencha o NÚMERO.</div>
    </div>
    <div class="col-md-3 position-relative">
        <label for="inputName" class="form-label">Complemento</label>
        <input type="text" name="complemento" class="form-control" id="inputName" value="<?= old('complemento') ? old('complemento') : exibe($d, 'complemento', true) ?>">
    </div>

</div>

<div class="row mt-1 g-3">
    <div class="col-md-12">
        <h5>DADOS DO(S) VEÍCULO(S)</h5>
    </div>
</div>
<div class="row mt-1 g-3">
    <?php if (isset($d['veiculo_marca'])) : ?>
        <div class="col-md-8 position-relative">
            <label for="inputName" class="form-label">Veículo</label>
            <input type="text" class="form-control" id="inputName" value="<?= exibe($d, 'veiculo_marca', true) ?> - <?= exibe($d, 'veiculo_modelo', true) ?> <?= exibe($d, 'veiculo_ano', true) ?>" readonly>
        </div>
        <div class="col-md-4 position-relative">
            <label for="inputName" class="form-label">Ano</label>
            <input type="text" class="form-control" id="inputName" value="<?= exibe($d, 'veiculo_ano', true) ?>" readonly>
        </div>
        <div class="col-md-4 position-relative">
            <label for="inputName" class="form-label">Placa</label>
            <input type="text" name="veiculo[0][placa]" class="form-control" id="inputName" value="<?= old('veiculo.0.placa') ? old('veiculo.0.placa') : exibe($d, 'placa', true) ?>" required>
            <div class="invalid-tooltip">Preencha a PLACA do veículo.</div>
        </div>
        <div class="col-md-4 position-relative">
            <label for="inputName" class="form-label">Renavam</label>
            <input type="text" name="veiculo[0][renavam]" class="form-control" id="inputName" value="<?= old('veiculo.0.renavam') ? old('veiculo.0.renavam') : exibe($d, 'renavam', true) ?>" required>
            <div class="invalid-tooltip">Preencha o RENAVAM.</div>
        </div>
        <div class="col-md-4 position-relative">
            <label for="inputName" class="form-label">Chassi</label>
            <input type="text" name="veiculo[0][chassi]" class="form-control" id="inputName" value="<?= old('veiculo.0.chassi') ? old('veiculo.0.chassi') : exibe($d, 'chassi', true) ?>" required>
            <div class="invalid-tooltip">Preencha o CHASSI.</div>
        </div>
        <div class="col-md-4 position-relative">
            <label for="inputName" class="form-label">Código FIPE</label>
            <input type="text" class="form-control" id="inputName" value="<?= exibe($d, 'fipe', true) ?>" readonly>
        </div>
        <div class="col-md-4 position-relative">
            <label for="inputName" class="form-label">Valor</label>
            <input type="text" class="form-control" id="inputName" value="<?= exibe($d, 'veiculo_valor', true) ?>" readonly>
        </div>
        <div class="col-md-4 position-relative">
            <label for="inputName" class="form-label">Cota de participação</label>
            <input type="text" class="form-control" id="inputName" value="<?= exibe($d, 'tabela', true)['cota_participativa'] ?>" readonly>
        </div>
    <?php endif; ?>
    <?php if (isset($d['carreta'])) :
        foreach ($d['carreta'] as $key => $carreta) : ?>
            <div class="row mt-2">
                <div class="col-md-2 position-relative">
                    <label for="inputName" class="form-label">Tipo</label>
                    <input type="text" name="carreta[<?= $key ?>][tipo]" class="form-control" id="inputName" value="<?= $carreta['tipo'] ?>" readonly>
                </div>
                <div class="col-md-2 position-relative">
                    <label for="inputName" class="form-label">Placa</label>
                    <input type="text" name="carreta[<?= $key ?>][placa]" class="form-control" id="inputName" value="<?= old("carreta.$key.placa") ? old("carreta.$key.placa") : exibe($carreta, 'placa', true) ?>" required>
                    <div class="invalid-tooltip">Preencha a PLACA do veículo.</div>
                </div>
                <div class="col-md-3 position-relative">
                    <label for="inputName" class="form-label">Renavam</label>
                    <input type="text" name="carreta[<?= $key ?>][renavam]" class="form-control" id="inputName" value="<?= old("carreta.$key.renavam") ? old("carreta.$key.renavam") : exibe($carreta, 'renavam', true) ?>" required>
                    <div class="invalid-tooltip">Preencha o RENAVAM.</div>
                </div>
                <div class="col-md-3 position-relative">
                    <label for="inputName" class="form-label">Chassi</label>
                    <input type="text" name="carreta[<?= $key ?>][chassi]" class="form-control" id="inputName" value="<?= old("carreta.$key.chassi") ? old("carreta.$key.chassi") : exibe($carreta, 'chassi', true) ?>" required>
                    <div class="invalid-tooltip">Preencha o CHASSI.</div>
                </div>
                <div class="col-md-2 position-relative">
                    <label for="inputName" class="form-label">Valor</label>
                    <input type="text" name="carreta[<?= $key ?>][valor]" class="form-control" id="inputName" value="<?= exibe($carreta, 'valor', true) ?>" readonly>
                </div>
            </div>
    <?php endforeach;
    endif; ?>
</div>