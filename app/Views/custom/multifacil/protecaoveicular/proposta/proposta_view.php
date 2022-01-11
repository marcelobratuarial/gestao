<?php
$dadosEmpresa = getEmpresa(CODEEMPRESA);
?>
<div id="invoice" class="bg-white px-2">
    <div class="invoice overflow-auto">
        <div style="min-width: 600px">
            <table>
                <thead>
                    <tr>
                        <th style="background:none;">
                            <?php if (LOGOEMPRESA != null) : ?>
                                <img src="<?= base_url('assets/uploads/' . LOGOEMPRESA) ?>" class="img-fluid" style="max-height:8.0rem" alt="NOMEEMPRESA">
                            <?php else : ?>
                                <?= (LOGOEMPRESA != null) ? NOMEEMPRESA : null ?>
                            <?php endif; ?>
                        </th>

                        <th style="background:none; text-align:right">
                            <?= nl2br($d['categoria']['cabecalho']) ?>
                        </th>
                    </tr>
                </thead>
            </table>
            <div style="border: 1px solid #999; margin: 4px 0;"></div>
            <table>
                <thead>
                    <tr>
                        <th class="invoice-to" style="background:none;">
                            <div class="text-gray-light">PROPOSTA PARA:</div>
                            <div class="to"><?= $d['nome'] ?></div>
                            <div class="address"><?= $d['cidade'] ?>/<?= $d['uf'] ?></div>
                            <div class="email"><?= $d['email'] ?></div>
                            <div class="telefone"><?= telMask($d['telefone']) ?></div>
                        </th>
                        <th class="invoice-details" style="background:none;">
                            <div class="proposta"><?= $code ?></div>
                            <div class="name"><?= strtoupper($d['placa']) . ' - ' . $d['veiculo_marca'] ?></div>
                            <div class="name"><?= $d['veiculo_ano']  . ' - ' . $d['veiculo_modelo']  ?></div>
                        </th>
                    </tr>
                </thead>
            </table>
            <table>
                <thead>
                    <tr style="border-bottom: 5px solid #fff;">
                        <th colspan="2" class="text-center"><?= strtoupper($d['plano']['titulo']) ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2">
                            <?= $d['plano']['descricao'] ?>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td style="text-align:right"><br></td>
                    </tr>
                    <tr style="border-top: 2px solid #999;">
                        <td></td>
                        <td style="text-align:right">

                            <div style="font-size:22pt; font-weight:bold; color:#363636">
                                <br>


                                <?php if ($d['plano']['desconto'] > 0) : ?>
                                    <?= money($d['plano']['valor_recorrente'] + ($d['plano']['valor'] * $d['categoria']['agravo'] / 100), true) ?>
                                    <span style="font-size:14pt">/mês *</span>
                                    <br>
                                    <small><?= money($d['plano']['valor'] + ($d['plano']['valor'] * $d['categoria']['agravo'] / 100), true) ?></small>
                                    <span style="font-size:14pt">/mês</span>

                                <?php else : ?>
                                    <?= money($d['plano']['valor'] + ($d['plano']['valor'] * $d['categoria']['agravo'] / 100), true) ?>
                                    <span style="font-size:14pt">/mês</span>
                                <?php endif; ?>

                                <br>

                                <span style="font-size:14pt">Adesão:</span>
                                <?= money($d['plano']['adesao'], true) ?>
                                <div>
                                    <?php if ($d['plano']['desconto'] > 0) : ?>
                                        <span style="font-size:9pt;  font-weight:normal">*Valor com desconto de <?= $d['plano']['desconto'] ?>% para pagamento recorrente no cartão de crédito.</small>
                                        <?php endif; ?>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <table>
                <tr>
                    <td style="font-size:9pt"> <?= nl2br($d['categoria']['rodape']) ?></td>
                    <td class="text-end" style="vertical-align:bottom;font-size:9pt">
                        <div class="date">Data da proposta: <?= date('d/m/Y', strtotime($proposta->created_at)) ?></div>
                        <div class="date">Validade da proposta: <?= date('d/m/Y', strtotime($proposta->created_at . '+ 15 days')) ?></div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>