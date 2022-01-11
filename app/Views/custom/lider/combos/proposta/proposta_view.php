<?php
$dadosEmpresa = getEmpresa(CODEEMPRESA);
?>
<div id="invoice" class="bg-white px-2">
    <div class="invoice overflow-auto">
        <div style="min-width: 600px">
            
        <div style="width:100%">
                <div style="float:left; width:50%; background:none;">
                    <?php if (LOGOEMPRESA != null) : ?>
                        <img src="<?= base_url('assets/uploads/' . LOGOEMPRESA) ?>" class="img-fluid" style="max-height:8.0rem" alt="NOMEEMPRESA">
                    <?php else : ?>
                        <?= (LOGOEMPRESA != null) ? NOMEEMPRESA : null ?>
                    <?php endif; ?>
                </div>

                <div style="float:right; width:50%; padding-top:30px; background:none; text-align:right">
                    <?= nl2br($d['categoria']['cabecalho']) ?>
                </div>
                <div style="clear:both"></div>
            </div>
            <div style="border: 1px solid #999; margin: 4px 0;"></div>
            <div style="width:100%; padding:30px 0;">
                <div style="float:left; width:30%; background:none;">
                    <div style="font-weight:bold">CONSULTOR:</div>
                    <div class="to"><?= usuario('nome') ?></div>
                    <div class="email"><?= usuario('email') ?></div>
                    <div class="telefone"><?= telMask(usuario('telefone')) ?></div>
                </div>
                <div style="float:right; width:20%; background:none; text-align:right">
                    <div style="font-weight:bold">PROPOSTA PARA:</div>
                    <div class="to"><?= $d['nome'] ?></div>
                    <div class="address"><?= $d['cidade'] ?>/<?= $d['uf'] ?></div>
                    <div class="email"><?= $d['email'] ?></div>
                    <div class="telefone"><?= telMask($d['telefone']) ?></div>
                </div>
                <div style="clear:both"></div>
            </div>

            <div style="width:100%; padding:30px 0;">
                <div style="float:left; width:50%;"><span style="font-weight:bold">PROPOSTA:</span> <?= $code ?></div>
                <div style="float:right; width:50%; text-align:right"><span style="font-weight:bold">VEÍCULO:</span> <?= strtoupper($d['placa']) . ' - ' . $d['veiculo_marca'] ?> <?= $d['veiculo_modelo']  . ' - ' . $d['veiculo_ano']  ?></div>
                <div style="clear:both"></div>
            </div>
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

                            <div style="font-size:22pt; font-weight:bold; color:#363636; line-height:1.5rem">
                                <br>
                                <p>
                                    <span style="font-size:14pt">Adesão:</span>
                                    <?= money($d['plano']['adesao'], true) ?>
                                </p>

                                <?php if ($d['plano']['desconto'] > 0) : ?>
                                    <span style="font-size:14pt">Mensalidade no crédito recorrente:</span><br>
                                    <?= money($d['plano']['valor_recorrente'] + ($d['plano']['valor'] * $d['categoria']['agravo'] / 100), true) ?>
                                    <span style="font-size:14pt">/mês *</span>
                                    <br>
                                    <br>
                                    <span style="font-size:14pt">Mensalidade no boleto:</span><br>
                                    <small><?= money($d['plano']['valor'] + ($d['plano']['valor'] * $d['categoria']['agravo'] / 100), true) ?></small>
                                    <span style="font-size:14pt">/mês</span>

                                <?php else : ?>
                                    <?= money($d['plano']['valor'] + ($d['plano']['valor'] * $d['categoria']['agravo'] / 100), true) ?>
                                    <span style="font-size:14pt">/mês</span>
                                <?php endif; ?>

                                <br>


                                <?php if ($d['plano']['desconto'] > 0) : ?>
                                    <div>
                                        <span style="font-size:9pt;  font-weight:normal">*Valor com desconto de <?= $d['plano']['desconto'] ?>% para pagamento recorrente no cartão de crédito.</small></span>
                                    </div>
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