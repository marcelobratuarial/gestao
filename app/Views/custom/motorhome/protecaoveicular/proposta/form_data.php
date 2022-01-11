<?php
$implementoNomes = getApi('tabela-motorhome/implementos', false);
?>
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
                <div class="col-md-6">
                    <label class="form-label">Nome</label>
                    <input class="form-control radius-square" type="text" placeholder="Nome" required name="nome" value="<?= exibe($lead, 'nome') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">CPF</label>
                    <input class="form-control radius-square" type="text" data-mask="000.000.000-00" placeholder="CPF (opcional)" name="userIf" value="<?= exibe($lead, 'userIf') ?>">
                </div>
            </div>
            <div class="row my-3">
                <div class="col-md-6">
                    <label class="form-label">Celular</label>
                    <input class="form-control radius-square" type="text" placeholder="Celular" required name="telefone" value="<?= exibe($lead, 'telefone') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input class="form-control radius-square" type="email" placeholder="Email" name="email" value="<?= exibe($lead, 'email') ?>">
                </div>
            </div>
            <div class="row my-3">
                <div class="col-md-6">
                    <label class="form-label">Estado</label>
                    <select name="uf" class="single-select form-select radius-square" onchange="carregaCidades(this.value)" required>
                        <option value="">Escolha o estado</option>
                        <?php foreach ($estados as $estado) : ?>
                            <option value="<?= $estado->uf ?>" <?= (exibe($lead, 'uf') == $estado->uf) ? 'selected' : null ?>><?= $estado->nome ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Cidade</label>
                    <select name="cidade" class="single-select form-select radius-square" required>
                        <option value="">Escolha a cidade</option>
                        <?php if (exibe($lead, 'uf')) : ?>
                            <?php foreach (getApi("cidades/" . exibe($lead, 'uf'), true) as $cidade) : ?>
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

                <div class="row mb-3">

                    <div class="col-md-3 mt-3">
                        <label class="form-label">Tipo de veículo</label>
                        <select class="form-select radius-square" name="veiculo_tipo">
                            <option value="">Escolha a categoria</option>
                            <?php foreach ($categorias as $c) : ?>
                                <option value="<?= $c->apiRef ?>" data-code="<?= $c->code ?>" data-implemento="<?= $c->implemento ?>" <?= (exibe($lead, 'veiculo_tipo') == $c->code) ? 'selected' : null; ?>><?= $c->titulo ?></option>
                            <?php
                                if (exibe($lead, 'veiculo_tipo') == $c->code) :
                                    $tipo =  $c->apiRef;
                                    if ($c->implemento == 1) :
                                        $imp = true;
                                    endif;
                                endif;
                            endforeach; ?>
                        </select>
                    </div>

                    <div class="inputFipe col-md-3 mt-3 <?= !exibe($lead, 'placa') ? 'd-none' : null ?>">
                        <label class="form-label">Placa do veículo</label>
                        <input class="form-control radius-square" type="text" name="placa" placeholder="Placa" value="<?= exibe($lead, 'placa') ?>">
                    </div>

                    <div id="possuiCarreta" class="col-md-3 mt-3 <?= $tipo == 'caminhoes' || $tipo == 'semi-reboque' ? null : 'd-none' ?>">
                        <label class="form-label">Pussuí de carreta?</label>
                        <select class="form-select radius-square" name="">
                            <option value="nao">Não</option>
                            <option value="sim">Sim</option>
                        </select>
                    </div>

                    <div id="qtdCarreta" class="col-md-3 mt-3 d-none">
                        <label class="form-label">Quantidade de carretas</label>
                        <select class="form-select radius-square" name="">
                            <option value="">Selecione uma quantidade</option>
                            <option value="1">Uma carreta</option>
                            <option value="2">Duas carretas</option>
                            <option value="3">Três carretas</option>
                        </select>
                    </div>

                </div>


                <div id="groupCarreta" class="bg-light"></div>



                <div id="groupMotorhome" class="row my-3 d-none">
                    <div id="valorMotorhome" class="col-md-4">
                        <label class="form-label">Valor declarado</label>
                        <input class="maskMoney form-control radius-square" type="text" name="veiculo_valor" placeholder="Valor declarado" value="<?= exibe($lead, 'veiculo_valor') ?>">
                    </div>
                </div>

                <div id="groupImplemento" class="row my-3 <?= !$imp ? 'd-none' : null ?>">
                    <div class="col-md-4">
                        <label class="form-label">Possui Implemento?</label>
                        <select class="form-select radius-square" onchange="exibeImplemento(this.value)">
                            <option value="nao">Não</option>
                            <option value="sim" <?= exibe($lead, 'implemento_nome') ? 'selected' : null ?>>Sim</option>
                        </select>
                    </div>
                    <div id="nomeImplemento" class="d-none col-md-4">
                        <label class="form-label">Nome do Implemento</label>
                        <select class="form-select radius-square" name="implemento_nome">
                            <option value="">Selecione</option>
                            <?php foreach ($implementoNomes as $n) : ?>
                                <option value="<?= $n ?>" <?= exibe($lead, 'implemento_nome') == $n ? 'selected' : null ?>><?= $n ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div id="valorImplemento" class="d-none col-md-4">
                        <label class="form-label">Valor do Implemento</label>
                        <input class="maskMoney form-control radius-square" type="text" name="implemento_valor" placeholder="Valor" value="<?= exibe($lead, 'implemento_valor') ?>">
                    </div>
                </div>



                <div class="inputFipe row my-3 <?= !exibe($lead, 'veiculo_marca') ? 'd-none' : null ?>">
                    <div class=" col-md-3">
                        <label class="form-label">Marca do veículo</label>
                        <select class="single-select form-select radius-square" name="veiculo_marca" <?= !exibe($lead, 'veiculo_marca') ? 'disabled' : null ?>>
                            <?php if (exibe($lead, 'veiculo_tipo')) : ?>
                                <?php $marcas = json_decode(file_get_contents('https://parallelum.com.br/fipe/api/v1/' . $tipo . '/marcas')) ?>
                                <option value="">Selecione a marca</option>
                                <?php foreach ($marcas as $m) : ?>
                                    <option value="<?= $m->codigo ?>" <?= (exibe($lead, 'veiculo_marca') == $m->codigo) ? 'selected' : null; ?>><?= $m->nome ?></option>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <option value="">Marca</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Modelo do veículo</label>
                        <select class="single-select form-select radius-square" name="veiculo_modelo" <?= !exibe($lead, 'veiculo_modelo') ? 'disabled' : null ?>>
                            <?php if (exibe($lead, 'veiculo_tipo') && exibe($lead, 'veiculo_marca')) : ?>
                                <?php $modelos = json_decode(file_get_contents('https://parallelum.com.br/fipe/api/v1/' . $tipo . '/marcas/' . exibe($lead, 'veiculo_marca') . '/modelos')) ?>
                                <option value="">Selecione o modelo</option>
                                <?php foreach ($modelos->modelos as $m) : ?>
                                    <option value="<?= $m->codigo ?>" <?= (exibe($lead, 'veiculo_modelo') == $m->codigo) ? 'selected' : null; ?>><?= $m->nome ?></option>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <option value="">Modelo</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Ano do veículo</label>
                        <select class="single-select form-select radius-square" data-path="<?= $path ?>" name="veiculo_ano" <?= !exibe($lead, 'veiculo_ano') ? 'disabled' : null ?>>
                            <?php if (exibe($lead, 'veiculo_tipo') && exibe($lead, 'veiculo_marca') && exibe($lead, 'veiculo_modelo')) : ?>
                                <?php $anos = json_decode(file_get_contents('https://parallelum.com.br/fipe/api/v1/' . $tipo . '/marcas/' . exibe($lead, 'veiculo_marca') . '/modelos/' . exibe($lead, 'veiculo_modelo') . '/anos')) ?>
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
                    $fipe = json_decode(file_get_contents('https://parallelum.com.br/fipe/api/v1/' . $tipo . '/marcas/' . exibe($lead, 'veiculo_marca') . '/modelos/' . exibe($lead, 'veiculo_modelo') . '/anos/' . exibe($lead, 'veiculo_ano')));
                endif; ?>
                <div id="valorFipe">
                    <?php if (isset($fipe)) : ?>
                        <div class="row my-3">
                            <div class="col-md-3">
                                <label class="form-label">Valor do veículo</label>
                                <input class="form-control radius-square" type="text" name="veiculo_valor" placeholder="Valor" value="<?= $fipe->Valor ?>" readonly />
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- end fipe -->
                <hr>
                <!-- botão final -->
                <div class="row my-3">
                    <div class="col-12 text-end">
                        <p class="fs--1 fw-300 color-3 mt-2">
                            <?php if (!isset($fipe)) : ?>
                                <button id="btnSubmit" class="btn btn-primary float-right" disabled>Avançar</button>
                            <?php else : ?>
                                <button type="submit" class="btn btn-primary float-right">Avançar</button>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
            <!-- end botão final -->
        </form>
    </div>
</div>