<?php if ($propostaassinada == false) : ?>
    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body p-5">
            <div class="card-title d-flex align-items-center">
                <div>
                    <i class="bx bxs-edit me-1 font-22 text-primary"></i>
                </div>
                <h5 class="mb-0 text-primary">Assinatura eletrônica </h5>
            </div>
            <hr>

            <form method="post" id="assinatura" action="<?= base_url('portal/assinar') ?>" class="needs-validation" novalidate>

                <div class="row g-3">
                    <div class="col-md-5">
                        Para garantir a legitimidade da assinatura eletrônica da proposta, precisamos validar algumas informações do signatário do contrato.
                        Por gentileza solicite um código de autenticação de segundo fator e confirme os dados abaixo.
                    </div>
                    <div class="col-md-7">

                        <label for="inputName" class="form-label">Email</label>
                        <div class="input-group">
                            <input type="text" name="email" class="form-control" value="<?= $proposta->email ?>" id="inputName" required>
                            <input type="hidden" name="codeProposta" value="<?= $proposta->code ?>">
                            <button type='button' onclick="sendCodeEmail()" class="btn btn-primary">
                                Solicitar código via e-mail
                            </button>
                        </div>
                    </div>
                </div>

                <br>
                <hr>
                <br>

                <div class="row g-3 pb-4">
                    <div class="col-md-4 position-relative">
                        <label for="inputCode" class="form-label">Código de segundo fator</label>
                        <input type="text" name="codigo_email" class="form-control" onchange="checkCodeEmail(this.value)" id="inputCode" required placeholder="Digite aqui o código recebido por e-mail">
                        <div class="invalid-tooltip">Código inválido ou expirado, solicite novamente.</div>
                    </div>
                    <div class="col-md-4 position-relative">
                        <label for="inputName" class="form-label">Nome Completo</label>
                        <?php $nomecompleto = old('nomecompleto') ? old('nomecompleto') : exibe($d, 'nome', true) ?>
                        <input type="text" name="nomecompleto" class="form-control <?= (count(array_filter(explode(' ', $nomecompleto))) >= 2) ? 'is-valid' : 'is-invalid' ?>" id="inputName" onkeyup="checkName()" value="<?= $nomecompleto ?>" required>
                        <div class="invalid-tooltip">Preencha seu NOME COMPLETO.</div>
                    </div>
                    <div class="col-md-4 position-relative">
                        <label for="inputCpf" class="form-label">CPF</label>
                        <input type="text" name="cpf" data-mask="000.000.000-00" class="form-control" value="<?= old('cpf') ? old('cpf') : base64_decode(exibe($d, 'userIf')) ?>" id="inputCpf" required>
                        <div class="invalid-tooltip">Preencha seu CPF.</div>
                    </div>
                    <div class="col-md-4 position-relative">
                        <label class="form-label">Data de nascimento</label>
                        <input class="form-control" type="date" name="data_nascimento" value="<?= old('data_nascimento') ? old('data_nascimento') : exibe($d, 'data_nascimento') ?>" required>
                        <div class="invalid-tooltip">Preencha sua DATA DE NASCIMENTO.</div>
                    </div>
                    <div class="col-md-4 position-relative">
                        <label for="inputName" class="form-label">Telefone</label>
                        <input type="text" name="telefone" class="form-control" id="inputName" value="<?= old('telefone') ? old('telefone') : exibe($d, 'telefone', true) ?>" required>
                        <div class="invalid-tooltip">Preencha seu TELEFONE.</div>
                    </div>
                    <div class="col-md-4 position-relative">
                        <label class="form-label">Dia de vencimento dos boletos</label>
                        <select name="vencimento" class="form-select">
                            <?php foreach ($vencimento as $v) : ?>
                                <option value="<?= $v ?>"><?= $v ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <?= view($form_assinatura) ?>
                <hr>

                <div class="row g-3 mt-4">
                    <div class="col-12 form-check mb-3">
                        <input id="formCheck1" type="checkbox" value="true" class="form-check-input" required>
                        <label class="form-check-label" for="formCheck1">
                            <?= nl2br($produto->assinaturaDados) ?>
                        </label>

                    </div>
                </div>
                <?php if ($produto->assinaturaExtra) : ?>
                    <div class="row g-3 mt-4">
                        <div class="col-12 form-check mb-3">
                            <input id="formCheck2" type="checkbox" value="true" class="form-check-input" required>
                            <label class="form-check-label" for="formCheck2">
                                <?= nl2br($produto->assinaturaExtra) ?>
                            </label>

                        </div>
                    </div>
                <?php endif; ?>
                <div class="row g-3 mt-4">
                    <div class="col-12">
                        <a href="<?= base_url('portal/voltar') ?>" class="btn btn-light px-5">
                            Voltar
                        </a>
                        <button type="submit" name="codeProposta" value="<?= $proposta->code ?>" class="btn btn-primary px-5">
                            Assinar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php else : ?>

    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body p-5">
            <div class="card-title d-flex align-items-center">
                <div>
                    <i class="bx bxs-edit me-1 font-22 text-primary"></i>
                </div>
                <h5 class="mb-0 text-primary">Assinatura eletrônica já realizada</h5>
            </div>
            <hr>
            <?= view('portal/proposta/assinatura'); ?>
        </div>
    </div>

<?php endif; ?>

<?= $pagamento == true ? view('portal/proposta/steps/pagamento') : null; ?>
<?= view('portal/proposta/steps/download'); ?>