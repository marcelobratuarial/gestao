<?php
$dadosEmpresa = getEmpresa(CODEEMPRESA);
helper('custom_lider');
?>
<div id="invoice" class="bg-white px-5">
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
                    <tr>
                        <th colspan="2" class="text-center">BENEFÍCIOS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $mensalidade = 0;
                    foreach ($d['beneficios'] as $k => $o) :
                    ?>
                        <tr>
                            <td class="no" style="font-size:1rem">Incluído</td>
                            <td class="text-left" style="width:85%">
                                <h3>
                                    <a target="_blank" href="javascript:;">
                                        <?= $o['titulo'] ?>
                                    </a>
                                    <?= $o['descricao'] ?>
                                </h3>
                            </td>
                        </tr>
                    <?php
                        $mensalidade = $mensalidade + ($o['valor'] + ($o['valor'] * $d['categoria']['agravo'] / 100));
                    endforeach;
                    if (count($d['beneficios']) == 4) :
                        // v($d);
                        $mensalidade = $mensalidade + ($d['beneficiosCompleto'] + ($d['beneficiosCompleto'] * $d['categoria']['agravo'] / 100));
                    endif;
                    ?>
                </tbody>
            </table>
            <?php if (count(array_filter($d['opcionais'])) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th colspan="2" class="text-center">OPCIONAIS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach (getOpcionaisLider($d['codeCategoria']) as $k => $o) :
                            if ($o['tipo'] != 'oculto' && isset($d['opcionais'][$o['slug']])) :
                                $o['valor'] = (is_array($d['opcionais'][$o['slug']])) ? $d['opcionais'][$o['slug']]['valor'] : $o['valor'];
                        ?>
                                <tr>
                                    <td class="no" style="font-size:1rem">Incluído</td>
                                    <td class="text-left" style="width:85%">
                                        <h3>
                                            <a target="_blank" href="javascript:;">
                                                <?= $o['titulo'] ?>
                                            </a>
                                        </h3>
                                        <?= $o['descricao'] ?>
                                    </td>
                                </tr>
                        <?php
                                $mensalidade = $mensalidade + ($o['valor']);
                            elseif ($o['obrigatorio']) :
                                // SOMA O VALOR NA PROPOSTA MAS NÃO EXIBE
                                $mensalidade = $mensalidade + ($o['valor']);
                            endif;
                        endforeach;
                        ?>
                    </tbody>
                </table>
            <?php endif; ?>
            <table>
                <tfoot>
                    <tr>
                        <td></td>
                        <td style="text-align:right"><br></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align:right">
                            <h2>
                                <?= money($mensalidade, true) ?><small>/mês</small>
                                <br>

                                <span style="font-size:14pt">Adesão:</span>
                                <?= money($d['adesao'], true) ?>
                                <h2>
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
        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->

    </div>
</div>