<style>
    .title {
        width: 100%;
        background-color: #444;
        color: white;
        text-align: center;
        padding: 10px
    }

    .linha {
        width: 100%;
        border-bottom: 1px solid #888;
        border-right: 1px solid #888;
        background-color: #eee;
    }

    .coluna {
        float: left;
        padding: 10px;
        border-left: 1px solid #888;
    }

    .coluna span {
        color: #888;
        font-size: 10px;
        text-transform: uppercase;
    }
</style>
<?php # dd($venda) 
?>
<div id="dados">
    <div class="title">DADOS DO PROPONENTE</div>

    <div class="linha">
        <div class="coluna" style="width: 70%;"><span>Nome: </span><?= $venda['cliente']['nome'] ?></div>
        <div class="coluna"><span>Data de nasc: </span> <?= date('d/m/Y', strtotime($venda['cliente']['data_nascimento'])) ?></div>
        <div style="clear: both;"></div>
    </div>

    <div class="linha">
        <div class="coluna" style="width: 33%;"><span>CPF/CNPJ: </span> <?= $venda['cliente']['cpf'] ?></div>
        <div class="coluna" style="width: 33%;"><span>Email: </span><?= $venda['cliente']['email'] ?></div>
        <div class="coluna"><span>Telefone: </span><?= $venda['cliente']['telefone'] ?></div>
        <div style="clear: both;"></div>
    </div>
    <div class="linha">
        <div class="coluna" style="width: 50%;"><span>Endereço: </span> <?= $venda['cliente']['endereco'] ?></div>
        <div class="coluna" style="width: 13%;"><span>Número: </span> <?= $venda['cliente']['numero'] ?></div>
        <div class="coluna"><span>Complemento: </span> <?= $venda['cliente']['complemento'] ?></div>
        <div style="clear: both;"></div>
    </div>
    <div class="linha">
        <div class="coluna" style="width: 33%;"><span>Bairro: </span> <?= $venda['cliente']['bairro'] ?></div>
        <div class="coluna" style="width: 33%;"><span>Cidade: </span> <?= $venda['cliente']['cidade'] ?></div>
        <div class="coluna" style="width: 10%;"><span>Estado: </span> <?= $venda['cliente']['uf'] ?></div>
        <div class="coluna"><span>CEP: </span> <?= $venda['cliente']['cep'] ?></div>
        <div style="clear: both;"></div>
    </div>
    <br>
    <?php foreach ($venda['veiculo'] as $key => $veiculo) : ?>
        <div class="title">DADOS DO VEICULO <?= $key + 1 ?></div>
        <?php if (isset($veiculo['marca'])) : ?>
            <div class="linha">
                <div class="coluna" style="width: 85%;"><span>Marca/Modelo: </span><?= $veiculo['marca'] . ' / ' . $veiculo['modelo'] ?></div>
                <div class="coluna"><span>Ano: </span><?= $veiculo['ano'] ?></div>
                <div style="clear: both;"></div>
            </div>
            <div class="linha">
                <div class="coluna" style="width: 20%;"><span>Placa: </span><?= $veiculo['placa'] ?></div>
                <div class="coluna" style="width: 40%;"><span>Renavam: </span><?= $veiculo['renavam'] ?></div>
                <div class="coluna"><span>Chassi: </span><?= $veiculo['chassi'] ?></div>
                <div style="clear: both;"></div>
            </div>
            <div class="linha">
                <div class="coluna" style="width: 20%;"><span>Cód. Fipe: </span><?= $veiculo['fipe'] ?></div>
                <div class="coluna" style="width: 25%;"><span>Valor: </span><?= money($veiculo['valor'], true) ?></div>
                <div class="coluna" style="width: 20%;"><span>Cota participativa: </span><?= $veiculo['cota_participativa'] ?>%</div>
                <div class="coluna"><span>Cota mínima: </span><?= money($veiculo['cota_min'], true) ?></div>
                <div style="clear: both;"></div>
            </div>
        <?php endif; ?>
        <?php if (isset($veiculo['implemento'])) : ?>
            <div class="linha">
                <div class="coluna" style="width: 85%;"><span>Tipo: </span><?= $veiculo['implemento']['tipo'] ?></div>
                <div class="coluna"><span>Valor declarado: </span><?= money($veiculo['implemento']['valor'], true) ?></div>
                <div style="clear: both;"></div>
            </div>
        <?php endif; ?>
        <?php if (isset($veiculo['carreta'])) : ?>
            <?php foreach ($veiculo['carreta'] as $key => $carreta) : ?>
                <div class="title" style="background-color:#999">CARRETA <?= $key + 1 ?></div>
                <div class="linha">
                    <div class="coluna" style="width: 20%;"><span>Tipo: </span><?= $carreta['tipo'] ?></div>
                    <div class="coluna" style="width: 50%;"><span>Valor declarado: </span><?= $carreta['valor'] ?></div>
                    <div class="coluna"><span>Placa: </span><?= $carreta['placa'] ?></div>
                    <div style="clear: both;"></div>
                </div>
                <div class="linha">
                    <div class="coluna" style="width: 50%;"><span>Chassi: </span><?= $carreta['chassi'] ?></div>
                    <div class="coluna"><span>Renavam: </span><?= $carreta['renavam'] ?></div>
                    <div style="clear: both;"></div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <br>
        <div class="title">BENEFÍCIOS</div>
        <div class="linha">
            <div class="coluna" style="line-height: 2em;"><?= $veiculo['categoria']['beneficios'] ?></div>
            <div style="clear: both;"></div>
        </div>
    <?php endforeach; ?>
    <?php if (isset($venda['contrato']['opcionais'])) : ?>
        <div class="title" style="background-color:#999">BENEFÍCIOS ADICIONAIS</div>

        <div class="linha">
            <div class="coluna" style="line-height: 2em;">
                <?php foreach ($venda['contrato']['opcionais'] as $key => $opcional) :
                    helper('custom_motorhome');
                    $opt = getOpcionalMotorhome($veiculo['categoria']['code'], $key); ?>
                    - <?= $opt['titulo'] ?><?= isset($opcional['titulo']) ? ' - ' . $opcional['titulo'] : null ?><br>
                <?php endforeach; ?>
            </div>
            <div style=" clear: both;"></div>
        </div>
    <?php endif; ?>
    <div class="title">CARACTERISTICAS DO PLANO DE BENEFÍCIOS</div>
    <div class="linha">
        <div class="coluna" style="width:30%"><span>VENCIMENTO BOLETO DIA: </span><?= $venda['contrato']['vencimento'] ?></div>
        <div class="coluna" style="width:30%"><span>Entrada: </span><?= money($venda['contrato']['adesao'], true) ?></div>
        <div class="coluna" style=""><span>Mensalidade: </span><?= money($venda['contrato']['mensalidade'], true) ?></div>
        <div style="clear: both;"></div>
    </div>
    <div class="title">O PROPONENTE, QUE SE TORNARÁ ASSOCIADO, SE COMPROMETE</div>
    <div class="linha">
        <div class="coluna" style="text-align: justify;">O Proponente, que ora pleiteia filiação, declara para todos os fins de direito que já tomara prévio conhecimento do regulamento interno da associação, bem como de suas atividade de natureza cível e não comercial, cuja regras se encontra para livre acesso em seu sítio da internet no seguinte endereço: www.grupomotorhome.com.br. Declara que se compromete a seguir as regras ali descritas em todo o seu teor, medianta expressão livre e desembaraçada vontade pessoal. Declara ainda, para todos os fins de direito, estar ciente que não contrata nesse ato qualquer espécie de contrato securitário nem acredita ser o grupo MOTOR HOME entidade de caráter comercial voltada para corretagem, intermediação ou venda de seguros. Por ser correta manifestação da verdade e expressão de sua livre e desimpedida vontade, vem, portanto, requerer sua filiação ao quadro de associados dessa entidade, dentro das modalidade acima descritas, ciente de que quaisquer benefícios que sejam disponibilizados pela Associação aos seus filiados, se dar-se através da aplicação do princípio da mutualidade.
            O PROPONENTE se declara ciente e concordad que fica eleito, exclusivamente, o foro da cidade de Belo horizonte/MG, desde já negando qualquer prerrogativa de foro que proventura possa lhe favorecer, para que seja dirimmidas eventuais desavenças oriundass de sua associação e efeitos jurídocos advindos de sua condição.
        </div>
        <div style="clear: both;"></div>
    </div>
    <div class="title"></div>
    <div class="linha">
        <div class="coluna" style="text-align: justify;">
            <?= $venda['contrato']['rodape'] ?>
        </div>
        <div style="clear: both;"></div>
    </div>

</div>
<br>
<br>