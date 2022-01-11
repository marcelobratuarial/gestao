<?php
$dadosEmpresa = getEmpresa(CODEEMPRESA);
helper('custom_alliance');
?>
<div id="invoice" class="bg-white px-5">
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
                            <div class="name"><?= $d['veiculo_modelo']  . ' - ' . $d['veiculo_ano']  ?></div>
                        </th>
                    </tr>
                </thead>
            </table>
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
                <thead>
                    <tr>
                        <th colspan="2" class="text-center">OPCIONAIS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $mensalidade = $d['tabela']['mensalidade'];
                    foreach (getOpcionaisCustom($d['codeCategoria']) as $k => $o) :
                        if ($o['tipo'] != 'oculto' && isset($d['opcionais'][$o['slug']])) :
                            $o['valor'] = (is_array($d['opcionais'][$o['slug']])) ? $d['opcionais'][$o['slug']]['valor'] : $o['valor'];
                    ?>
                            <tr>
                                <td class="no" style="font-size:1rem">Incluído</td>
                                <td class="text-left" style="width:85%; background-color:#FFFFFF">
                                    <a href="javascript:void();">
                                        <?= $o['titulo'] ?>
                                    </a>
                                    <br>
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
                            </h2>
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