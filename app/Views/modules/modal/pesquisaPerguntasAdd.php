<div class="modal modal-md fade" id="pesquisaPerguntasAdd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body pb-0">
                <div class="row">
                    <div class="col-12">
                        <h5 class="modal-title" id="staticBackdropLabel">Tipo de Pergunta</h5>
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-1-tab" data-bs-toggle="tab" data-bs-target="#nav-1" type="button" role="tab" aria-controls="nav-1" aria-selected="true"><strong>TEXTO</strong></button>
                                <button class="nav-link" id="nav-2-tab" data-bs-toggle="tab" data-bs-target="#nav-2" type="button" role="tab" aria-controls="nav-2" aria-selected="false"><strong>TEXTAREA</strong></button>
                                <button class="nav-link" id="nav-3-tab" data-bs-toggle="tab" data-bs-target="#nav-3" type="button" role="tab" aria-controls="nav-3" aria-selected="false"><strong>SELEÇÃO</strong></button>
                                <button class="nav-link" id="nav-4-tab" data-bs-toggle="tab" data-bs-target="#nav-4" type="button" role="tab" aria-controls="nav-4" aria-selected="false"><strong>BOTÃO DE OPÇÃO</strong></button>
                                <button class="nav-link" id="nav-5-tab" data-bs-toggle="tab" data-bs-target="#nav-5" type="button" role="tab" aria-controls="nav-5" aria-selected="false"><strong>CAIXA DE SELEÇÃO</button>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="modal-body border-1 border-top">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-1" role="tabpanel" aria-labelledby="nav-1-tab">
                        <form action="<?= base_url('pesquisa/savePergunta') ?>" method="post">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="inputPergunta" class="form-label">Pergunta</label>
                                    <input type="text" name="pergunta" class="form-control" id="inputPergunta">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="codePesquisa" value="<?= $code ?>" required>
                                <input type="hidden" name="type" value="1">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-primary">Adicionar</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="nav-2" role="tabpanel" aria-labelledby="nav-2-tab">
                        <form action="<?= base_url('pesquisa/savePergunta') ?>" method="post">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="inputPergunta" class="form-label">Pergunta</label>
                                    <input type="text" name="pergunta" class="form-control" id="inputPergunta">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="codePesquisa" value="<?= $code ?>" required>
                                <input type="hidden" name="type" value="2">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-primary">Adicionar</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="nav-3" role="tabpanel" aria-labelledby="nav-3-tab">
                        <form action="<?= base_url('pesquisa/savePergunta') ?>" method="post">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="inputPergunta" class="form-label">Pergunta</label>
                                    <input type="text" name="pergunta" class="form-control" id="inputPergunta">
                                </div>
                                <div class="col-md-12">
                                    <label for="inputSelecao" class="form-label">Seleção</label>
                                    <div id="inputFormRow">
                                        <div class="input-group mb-3">
                                            <input type="text" name="opcao[]" class="form-control m-input" placeholder="Opção" autocomplete="off">
                                            <div class="input-group-append">
                                                <button id="removeRow" type="button" class="btn btn-danger">Remover</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="newRow"></div>
                                    <button id="addRow" type="button" class="btn btn-info">Adicionar seleção</button>
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="codePesquisa" value="<?= $code ?>" required>
                                    <input type="hidden" name="type" value="3">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btn-primary">Adicionar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="nav-4" role="tabpanel" aria-labelledby="nav-4-tab">
                        <form action="<?= base_url('pesquisa/savePergunta') ?>" method="post">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="inputPergunta" class="form-label">Pergunta</label>
                                    <input type="text" name="pergunta" class="form-control" id="inputPergunta">
                                </div>
                                <div class="col-md-12">
                                    <label for="inputSelecao" class="form-label">Opção</label>
                                    <div id="inputFormRow1">
                                        <div class="input-group mb-3">
                                            <input type="text" name="opcao[]" class="form-control m-input" placeholder="Opção" autocomplete="off">
                                            <div class="input-group-append">
                                                <button id="removeRow1" type="button" class="btn btn-danger">Remover</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="newRow1"></div>
                                    <button id="addRow1" type="button" class="btn btn-info">Adicionar opção</button>
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="codePesquisa" value="<?= $code ?>" required>
                                    <input type="hidden" name="type" value="4">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btn-primary">Adicionar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="nav-5" role="tabpanel" aria-labelledby="nav-5-tab">
                        <form action="<?= base_url('pesquisa/savePergunta') ?>" method="post">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="inputPergunta" class="form-label">Pergunta</label>
                                    <input type="text" name="pergunta" class="form-control" id="inputPergunta">
                                </div>
                                <div class="col-md-12">
                                    <label for="inputSelecao" class="form-label">Seleção</label>
                                    <div id="inputFormRow2">
                                        <div class="input-group mb-3">
                                            <input type="text" name="opcao[]" class="form-control m-input" placeholder="Opção" autocomplete="off">
                                            <div class="input-group-append">
                                                <button id="removeRow2" type="button" class="btn btn-danger">Remover</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="newRow2"></div>
                                    <button id="addRow2" type="button" class="btn btn-info" style="color: whithe;">Adicionar seleção</button>
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="codePesquisa" value="<?= $code ?>" required>
                                    <input type="hidden" name="type" value="5">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btn-primary">Adicionar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    // add row
    $("#addRow").click(function() {
        var html = '';
        html += '<div id="inputFormRow">';
        html += '<div class="input-group mb-3">';
        html += '<input type="text" name="opcao[]" class="form-control m-input" placeholder="Opção" autocomplete="off">';
        html += '<div class="input-group-append">';
        html += '<button id="removeRow" type="button" class="btn btn-danger">Remover</button>';
        html += '</div>';
        html += '</div>';

        $('#newRow').append(html);
    });

    $("#addRow1").click(function() {
        var html = '';
        html += '<div id="inputFormRow">';
        html += '<div class="input-group mb-3">';
        html += '<input type="text" name="opcao[]" class="form-control m-input" placeholder="Opção" autocomplete="off">';
        html += '<div class="input-group-append">';
        html += '<button id="removeRow" type="button" class="btn btn-danger">Remover</button>';
        html += '</div>';
        html += '</div>';

        $('#newRow1').append(html);
    });

    // add row
    $("#addRow2").click(function() {
        var html = '';
        html += '<div id="inputFormRow">';
        html += '<div class="input-group mb-3">';
        html += '<input type="text" name="opcao[]" class="form-control m-input" placeholder="Opção" autocomplete="off">';
        html += '<div class="input-group-append">';
        html += '<button id="removeRow" type="button" class="btn btn-danger">Remover</button>';
        html += '</div>';
        html += '</div>';

        $('#newRow2').append(html);
    });

    // remove row
    $(document).on('click', '#removeRow', function() {
        $(this).closest('#inputFormRow').remove();
    });

    $(document).on('click', '#removeRow1', function() {
        $(this).closest('#inputFormRow1').remove();
    });

    $(document).on('click', '#removeRow2', function() {
        $(this).closest('#inputFormRow2').remove();
    });
</script>