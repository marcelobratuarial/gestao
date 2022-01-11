<?php
$dadosEmpresa = getEmpresa(CODEEMPRESA);
helper('custom_motorhome');
?>
<div id="invoice" style="padding-top: 0; padding-bottom: 0;" class="bg-white px-5">
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
                            <?php
                            if (isset($d['tabela']['cota_participativa'])) :
                                $cotaParticipativa = $d['tabela']['cota_participativa'];
                                $cotaMinima = $d['tabela']['cota_min'];
                            elseif (!isset($d['carreta'][1])) :
                                $cotaParticipativa = $d['carreta'][0]['cota_participativa'];
                                $cotaMinima = $d['carreta'][0]['cota_min'];
                                if ($d['carreta'][0]['tipo'] == 'Basculante') :
                                    $cotaParticipativa = 7;
                                    $cotaMinima = 7000;
                                endif;
                            else :
                                $cotaParticipativa = 0;
                                $cotaMinima = 0;
                            endif;

                            //VERIFICAR COTA PARTICIPATIVA CARRETAS
                            $cota = $d['valorTotal'] * $cotaParticipativa / 100; ?>
                            <div class="proposta"><b style="font-weight:bold; font-size:20px">Proposta:</b> <?= $code ?></div>
                            <?php if ($cota) : ?>
                                <div class="name"><b style="font-weight:bold; font-size:20px">Cota de participação:</b> <?= $cotaParticipativa ?>%</div>
                            <?php endif; ?>
                            <div class="name"><b style="font-weight:bold; font-size:20px">Valor protegido:</b> <?= money($d['valorTotal'], true)  ?></div>
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
                            <div class="to" style="text-transform:capitalize"><?= $d['nome'] ?></div>
                            <div class="address"><?= $d['cidade'] ?>/<?= $d['uf'] ?></div>
                            <div class="email"><?= $d['email'] ?></div>
                            <div class="telefone"><?= telMask($d['telefone']) ?></div>

                        </th>
                        <th class="invoice-details" style="background:none;">
                            <?php $usuario = getUsuario(isset($proposta->codeUsuario) ? $proposta->codeUsuario : $_SESSION['usuarioCode']); ?>
                            <div class="text-gray-light">CONSULTOR:</div>
                            <div class="to"><?= $usuario->nome ?></div>
                            <div class="email"><?= strtolower($usuario->email) ?></div>
                            <div class="telefone"><?= telMask($usuario->telefone) ?></div>

                        </th>
                    </tr>
                </thead>
            </table>
            <table>
                <thead>
                    <tr>
                        <th class="text-center">VEÍCULO</th>
                    </tr>
                </thead>
            </table>
            <?php if (isset($d['placa']) && isset($d['fipe'])) : ?>
                <table>
                    <tbody>

                        <tr>
                            <td style="background-color:#FFFFFF; line-height:2rem"><b style="font-weight:bold">Veículo:<b></td>
                            <td style="background-color:#FFFFFF; line-height:2rem">
                                <?= $d['veiculo_marca'] . ' - ' . $d['veiculo_ano']  . ' - ' . $d['veiculo_modelo']  ?>
                            </td>

                            <td style="background-color:#FFFFFF; line-height:2rem"><b style="font-weight:bold">Placa:</b></td>
                            <td style="background-color:#FFFFFF; line-height:2rem">
                                <?= ($d['placa']) ? strtoupper($d['placa']) : '- -' ?>
                            </td>

                            <td style="background-color:#FFFFFF; line-height:2rem">
                                <b style="font-weight:bold">Fipe:</b>
                            </td>
                            <td style="background-color:#FFFFFF; line-height:2rem">
                                <?= $d['fipe']  . ' - ' . money($d['veiculo_valor'], true)  ?>
                            </td>
                            <?php if (isset($d['carreta'][0])) :
                                $cota = $d['veiculo_valor'] * $d['tabela']['cota_participativa'] / 100;
                                $cotaMinima =  $d['tabela']['cota_min'];
                            ?>
                                <td style="background-color:#FFFFFF; line-height:2rem">
                                    <b style="font-weight:bold">Cota de participação:</b>
                                </td>
                                <td style="background-color:#FFFFFF; line-height:2rem">
                                    <?= $cotaParticipativa ?>%
                                </td>
                            <?php endif; ?>
                        </tr>
                    </tbody>
                </table>

            <?php endif; ?>
            <?php if ($d['veiculo_tipo'] == 'motorhome') : ?>
                <table>
                    <tbody>

                        <tr>
                            <td style="background-color:#FFFFFF; line-height:2rem">
                                <b style="font-weight:bold">Tipo:<b>
                            </td>
                            <td style="background-color:#FFFFFF; line-height:2rem">
                                <?= $d['categoria']['titulo']  ?>
                            </td>
                            <td style="background-color:#FFFFFF; line-height:2rem">
                                <b style="font-weight:bold">Valor declarado:<b>
                            </td>
                            <td style="background-color:#FFFFFF; line-height:2rem">
                                <?= money($d['veiculo_valor'], true) ?>
                            </td>
                        </tr>
                    </tbody>
                </table>

            <?php endif; ?>
            <?php if (isset($d['implemento_valor']) && isset($d['implemento_nome'])) : ?>
                <table>
                    <tbody>

                        <tr>
                            <td style="background-color:#FFFFFF; line-height:2rem">
                                <b style="font-weight:bold">Implemento:<b>
                            </td>
                            <td style="background-color:#FFFFFF; line-height:2rem">
                                <?= $d['implemento_nome']  ?>
                            </td>
                            <td style="background-color:#FFFFFF; line-height:2rem">
                                <b style="font-weight:bold">Valor declarado:<b>
                            </td>
                            <td style="background-color:#FFFFFF; line-height:2rem">
                                <?= $d['implemento_valor'] ?>
                            </td>
                        </tr>
                    </tbody>
                </table>

            <?php endif; ?>
            <?php if (isset($d['carreta'])) : ?>
                <table>
                    <tbody>
                        <?php foreach ($d['carreta'] as $k => $v) :
                            $n = $k + 1; ?>
                            <tr>
                                <td style="background-color:#FFFFFF; line-height:2rem">
                                    <b style="font-weight:bold">Carreta<?= isset($d['carreta'][$n]) ? ' ' . $n : null ?>:</b>
                                </td>
                                <td style="background-color:#FFFFFF; line-height:2rem">
                                    <?= $v['tipo'] ?>
                                </td>
                                <td style="background-color:#FFFFFF; line-height:2rem">
                                    <b style="font-weight:bold">Placa:</b>
                                </td>
                                <td style="background-color:#FFFFFF; line-height:2rem">
                                    <?= ($v['placa']) ? strtoupper($v['placa']) : '- -' ?>
                                </td>

                                <td style="background-color:#FFFFFF; line-height:2rem">
                                    <b style="font-weight:bold">Valor declarado:</b>
                                </td>
                                <td style="background-color:#FFFFFF; line-height:2rem">
                                    <?= $v['valor'] ?>
                                </td>
                                <?php
                                if (isset($d['carreta'][1])) :
                                    $cota = noMoney($v['valor']) * $d['carreta'][$k]['cota_participativa'] / 100;
                                    $cotaMinima =  $d['carreta'][$k]['cota_min'];
                                    if ($d['carreta'][$k]['tipo'] == 'Basculante') :
                                        $cota = noMoney($v['valor']) * 7 / 100;
                                        $cotaMinima = 7000;
                                    endif;
                                ?>
                                    <td style="background-color:#FFFFFF; line-height:2rem">
                                        <b style="font-weight:bold">Cota de participação:</b>
                                    </td>
                                    <td style="background-color:#FFFFFF; line-height:2rem">
                                        <?= $cotaParticipativa ?>%
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <?php if ($d['categoria']['beneficio']) : ?>
                <table>
                    <thead>
                        <tr>
                            <th colspan="2" class="text-center">BENEFÍCIOS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="no" style="font-size:1rem">Incluído</td>
                            <td style="background-color:#FFFFFF; line-height:2rem"><span><?= $d['categoria']['beneficio']; ?></span></td>
                        </tr>
                    </tbody>
                </table>
            <?php endif; ?>
            <?php if (isset($d['opcionais'])) : ?>
                <table>
                    <thead>
                        <tr>
                            <!-- OCULTAR -->
                            <th colspan="2" class="text-center">OPCIONAIS</th>
                        </tr>
                    </thead>
                </table>
            <?php endif; ?>
            <table>
                <tbody>
                    <?php
                    $mensalidade = isset($d['tabela']['mensalidade']) ? $d['tabela']['mensalidade'] : 0;
                    $mensalidade = $mensalidade + ($mensalidade * $d['categoria']['agravo'] / 100);
                    foreach (getOpcionaisCustom($d['codeCategoria']) as $k => $o) :
                        if ($o['tipo'] != 'oculto' && isset($d['opcionais'][$o['slug']])) :
                            $o['valor'] = (is_array($d['opcionais'][$o['slug']])) ? $d['opcionais'][$o['slug']]['valor'] : $o['valor'];
                            $o['descricao_select'] = (is_array($d['opcionais'][$o['slug']])) ? ' - ' . $d['opcionais'][$o['slug']]['titulo'] : null;
                    ?>
                            <tr>
                                <td class="no" style="font-size:1rem">Incluído</td>
                                <td class="text-left" style="width:85%; background-color:#FFFFFF">
                                    <a href="javascript:void();">
                                        <?= $o['titulo'] ?> - <?= money($o['valor'], true) ?>
                                    </a>
                                    <br>
                                    <?= $o['descricao'] ?><?= $o['descricao_select'] ?>
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
                <tfoot>
                    <tr>
                        <td></td>
                        <td style="text-align:right"><br></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align:right">


                            <?php if (isset($d['carreta'])) :
                                if ($mensalidade) : ?>
                                    <h4>
                                        <span style="font-size:12pt; color: #666">Mensalidade:</span> <?= money(round($mensalidade, 2)) ?>
                                    </h4>
                                <?php endif;
                                foreach ($d['carreta'] as $k => $v) :
                                    $mensalidadeCarreta = $v['mensalidade'] + ($v['mensalidade'] * $d['categoria']['agravo'] / 100);
                                    if ($d['tabela']) :
                                        $mensalidadeCarreta = $mensalidadeCarreta - (20 * $mensalidadeCarreta / 100);
                                    endif;
                                    $mensalidade = $mensalidade + $mensalidadeCarreta;  ?>
                                    <h4>
                                        <span style="font-size:12pt; color: #666">Mensalidade <?= $v['tipo'] ?>:</span> <?= money(round($mensalidadeCarreta, 2)) ?>
                                    </h4>
                                <?php endforeach;
                                if (isset($d['carreta'][1])) :
                                ?>
                                    <h2>
                                        <span style="font-size:12pt; color: #666">Total:</span> <?= money(round($mensalidade, 2)) ?>
                                    </h2>
                                <?php endif;
                            else : ?>
                                <h2>
                                    <span style="font-size:12pt; color: #666">Mensalidade:</span> <?= money(round($mensalidade, 2)) ?>
                                </h2>
                            <?php endif; ?>

                            <?php $d['adesao'] = isset($d['adesao']) && $d['adesao'] > 0 ? $d['adesao'] : $d['adesao'] = 0; ?>
                            <h2>
                                <span style="font-size:12pt; color: #666">Entrada:</span> <?= money($d['adesao'], true) ?>
                            </h2>

                        </td>
                    </tr>
                </tfoot>
            </table>
            <table>
                <tr>
                    <td style="font-size:9pt; width:70%"> <?= nl2br($d['categoria']['rodape']) ?></td>
                    <td class="text-end" style="vertical-align:bottom;font-size:9pt">
                        <div class="date">Data da proposta: <?= date('d/m/Y H:i', strtotime($proposta->created_at)) ?></div>
                        <?php if ($proposta->status != 'final') : ?>
                            <div class="date">Validade da proposta: <?= date('d/m/Y', strtotime($proposta->created_at . "+ $produto->validade days")) ?></div>
                        <?php elseif ($proposta->status == 'final') : ?>
                            <div class="date"><?= getEmpresa(CODEEMPRESA, 'assinatura') == 1 ? 'Assinada' : 'Aceita' ?> em: <?= date('d/m/Y H:i', strtotime($proposta->updated_at)) ?></div>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>
        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->

    </div>
</div>
<div id="contrato_adesao">

</div>