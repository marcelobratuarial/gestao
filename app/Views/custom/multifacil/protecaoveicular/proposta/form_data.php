<div class="card border-top border-0 border-4 border-primary">
    <div class="card-body p-5">
        <div class="card-title d-flex align-items-center">
            <div>
                <i class="bx bxs-user-check me-1 font-22 text-primary"></i>
            </div>
            <h5 class="mb-0 text-primary">Gerar proposta</h5>
        </div>
        <hr>
        <form action="<?= base_url("$path/proposta/opcionais/{$lead->code}") ?>" class="mt-5" method="post">
            <div class="row my-3">
                <div class="col-6">
                    <label class="form-label">Nome</label>
                    <input class="form-control radius-square" type="text" placeholder="Nome" required name="nome" value="<?= exibe($lead, 'nome') ?>">
                </div>
                <div class="col-6">
                    <label class="form-label">CPF</label>
                    <input class="form-control radius-square" type="text" data-mask="000.000.000-00" placeholder="CPF" name="userIf" value="<?= exibe($lead, 'userIf') ?>">
                </div>
            </div>
            <div class="row my-3">
                <div class="col-6">
                    <label class="form-label">Celular</label>
                    <input class="form-control radius-square" type="text" placeholder="Celular" required name="telefone" value="<?= exibe($lead, 'telefone') ?>">
                </div>
                <div class="col-6">
                    <label class="form-label">Email</label>
                    <input class="form-control radius-square" type="email" placeholder="Email" required name="email" value="<?= exibe($lead, 'email') ?>">
                </div>
            </div>
            <div class="row my-3">
                <div class="col-6">
                    <label class="form-label">Estado</label>
                    <select name="uf" class="form-select radius-square" onchange="carregaCidades(this.value)" required>
                        <option value="">Escolha o estado</option>
                        <?php foreach ($estados as $estado) : ?>
                            <option value="<?= $estado->uf ?>" <?= (exibe($lead, 'uf') == $estado->uf) ? 'selected' : null ?>><?= $estado->nome ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-6">
                    <label class="form-label">Cidade</label>
                    <select name="cidade" class="form-select radius-square" required>
                        <option value="">Escolha a cidade</option>
                        <?php if (exibe($lead, 'uf')) : ?>
                            <?php foreach (getApi("cidades/" . exibe($lead, 'uf')) as $cidade) : ?>
                                <option value="<?= $cidade->nome ?>" <?= (exibe($lead, 'cidade') == $cidade->nome) ? 'selected' : null ?>><?= $cidade->nome ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <!-- end dados -->
            <hr>
            <!-- fipe -->
            <div id="fipe" class="">
                <div class="row my-3">
                    <div class="col-6">
                        <label class="form-label">Placa do veículo</label>
                        <input class="form-control radius-square" type="text" name="placa" placeholder="Placa" required value="<?= exibe($lead, 'placa') ?>" />
                    </div>

                    <div class="col-6">
                        <label class="form-label">Tipo de veículo</label>
                        <select class="form-select radius-square" name="veiculo_tipo" required>
                            <option value="">Escolha a categoria</option>
                            <?php foreach ($categorias as $c) : ?>
                                <option value="<?= $c->apiRef ?>" <?= (exibe($lead, 'veiculo_tipo') == $c->apiRef) ? 'selected' : null; ?>><?= $c->titulo ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col-3">
                        <label class="form-label">Marca do veículo</label>
                        <select class="form-select radius-square" name="veiculo_marca" required>
                            <?php if (exibe($lead, 'veiculo_tipo')) : ?>
                                <?php $marcas = json_decode(file_get_contents('https://parallelum.com.br/fipe/api/v1/' . exibe($lead, 'veiculo_tipo') . '/marcas')) ?>
                                <option value="">Selecione a marca</option>
                                <?php foreach ($marcas as $m) : ?>
                                    <option value="<?= $m->codigo ?>" <?= (exibe($lead, 'veiculo_marca') == $m->codigo) ? 'selected' : null; ?>><?= $m->nome ?></option>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <option value="">Marca</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="col-6">
                        <label class="form-label">Modelo do veículo</label>
                        <select class="form-select radius-square" name="veiculo_modelo" required>
                            <?php if (exibe($lead, 'veiculo_tipo') && exibe($lead, 'veiculo_marca')) : ?>
                                <?php $modelos = json_decode(file_get_contents('https://parallelum.com.br/fipe/api/v1/' . exibe($lead, 'veiculo_tipo') . '/marcas/' . exibe($lead, 'veiculo_marca') . '/modelos')) ?>
                                <option value="">Selecione o modelo</option>
                                <?php foreach ($modelos->modelos as $m) : ?>
                                    <option value="<?= $m->codigo ?>" <?= (exibe($lead, 'veiculo_modelo') == $m->codigo) ? 'selected' : null; ?>><?= $m->nome ?></option>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <option value="">Modelo</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-3">
                        <label class="form-label">Ano do veículo</label>
                        <select class="form-select radius-square" name="veiculo_ano" data-path="<?= $path ?>" required>
                            <?php if (exibe($lead, 'veiculo_tipo') && exibe($lead, 'veiculo_marca') && exibe($lead, 'veiculo_modelo')) : ?>
                                <?php $anos = json_decode(file_get_contents('https://parallelum.com.br/fipe/api/v1/' . exibe($lead, 'veiculo_tipo') . '/marcas/' . exibe($lead, 'veiculo_marca') . '/modelos/' . exibe($lead, 'veiculo_modelo') . '/anos')) ?>
                                <option value="">Selecione o ano</option>
                                <?php foreach ($anos as $m) : ?>
                                    <option value="<?= $m->codigo ?>" <?= (exibe($lead, 'veiculo_ano') == $m->codigo) ? 'selected' : null; ?>><?= $m->nome ?></option>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <option value="">Ano</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <?php if (exibe($lead, 'veiculo_tipo') && exibe($lead, 'veiculo_marca') && exibe($lead, 'veiculo_modelo') && exibe($lead, 'veiculo_ano')) :
                    $fipe = json_decode(file_get_contents('https://parallelum.com.br/fipe/api/v1/' . exibe($lead, 'veiculo_tipo') . '/marcas/' . exibe($lead, 'veiculo_marca') . '/modelos/' . exibe($lead, 'veiculo_modelo') . '/anos/' . exibe($lead, 'veiculo_ano')));
                endif; ?>
                <div id="valorFipe">
                    <?php if (isset($fipe)) : ?>
                        <div class="row my-3">
                            <div class="col-3">
                                <label class="form-label">Valor do veículo</label>
                                <input class="form-control radius-square" type="text" name="veiculo_valor" placeholder="Valor" required value="<?= $fipe->Valor ?>" readonly />
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- <div class="row my-3">
                    <div class="col-3">
                        <p class="fs--1 fw-300 color-3 mt-2">
                            <input type="checkbox" value="1" name="leilao" <?= (exibe($lead, 'leilao')) ? 'checked' : null; ?>>
                            Veículo de leilão
                        </p>
                    </div>
                    <div class="col-3">
                        <p class="fs--1 fw-300 color-3 mt-2">
                            <input type="checkbox" value="1" name="multa" <?= (exibe($lead, 'multa')) ? 'checked' : null; ?>>
                            Impedimento de multa no documento
                        </p>
                    </div>
                </div> -->
                <!-- end fipe -->
                <hr>
                <!-- botão final -->
                <div class="row my-3">
                    <div class="col-12 text-end">
                        <p class="fs--1 fw-300 color-3 mt-2">
                            <button type="submit" class="btn btn-primary float-right">Avançar</button>
                        </p>
                    </div>
                </div>
            </div>
            <!-- end botão final -->
        </form>
    </div>
</div>