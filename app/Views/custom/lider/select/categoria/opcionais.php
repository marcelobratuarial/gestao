<div class="card border-top border-0 border-4 border-primary">
    <div class="card-body p-5">

        <div class="card-title d-flex align-items-center">
            <div>
                <i class="bx bxs-user-check me-1 font-22 text-primary"></i>
            </div>
            <h5 class="mb-0 text-primary">Opcionais</h5>

        </div>
        <hr>
        <div class="row pt-3">
            <div class="col h6">
                Titulo
            </div>

            <div class="col h6">
                Tipo
            </div>

            <div class="col h6">
                Valor
            </div>
            <div class="col h6">
                Cota
            </div>
            <div class="col h6">
                Cota min.
            </div>
            <div class="col h6 text-end">
                Ações
            </div>
        </div>
        <?php foreach ($opcionais as $o) : ?>

            <div class="row pt-3">
                <div class="col">
                    <?= $o->titulo; ?>
                    <small><?= $o->descricao; ?></small>
                </div>

                <div class="col">
                    <?php if ($o->tipo == 'select') : ?>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#<?= $o->slug ?>Modal">
                            <?= ucfirst($o->tipo); ?>
                        </a>
                        <div class="modal fade" id="<?= $o->slug ?>Modal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Opções: <?= $o->titulo ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php foreach (json_decode($o->options) as $opt) : ?>
                                            <div class=""><?= $opt->titulo ?></div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <?= ucfirst($o->tipo); ?>
                    <?php endif; ?>
                </div>

                <div class="col">
                    <?php if ($o->valor) : ?>
                        <?= money($o->valor, true); ?>
                    <?php else : ?>
                        -
                    <?php endif; ?>
                </div>
                <div class="col">
                    <?php if ($o->cota) : ?>
                        <?= money($o->cota, false); ?>%
                    <?php else : ?>
                        -
                    <?php endif; ?>
                </div>
                <div class="col">
                    <?php if ($o->cota_min) : ?>
                        <?= money($o->cota_min, true); ?>
                    <?php else : ?>
                        -
                    <?php endif; ?>
                </div>
                <div class="col text-end">
                    <a href="<?= base_url("$path/categoria/$code/opcional/$o->id") ?>" class="btn btn-primary btn-sm">EDITAR</a>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</div>


<div class="card border-top border-0 border-4 border-primary">
    <div class="card-body p-5">
        <div class="card-title d-flex align-items-center">
            <div>
                <i class="bx bxs-user-check me-1 font-22 text-primary"></i>
            </div>
            <h5 class="mb-0 text-primary">Adicionar Opcional</h5>
        </div>
        <hr>
        <form method="post" action="<?= base_url("$path/save/opcionais"); ?>">
            <div class="row g-3 my-3">
                <div class="col-md-4">
                    <label class="form-label">Categoria</label>
                    <select class="form-select" name="codeCategoria">
                        <option value="">Todas as Categorias</option>
                        <?php foreach ($categorias as $c) : ?>
                            <?php if ($c->code == $code) : ?>
                                <option value="<?= $c->code; ?>"><?= $c->titulo; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tipo</label>
                    <select onchange="makeSelect(this.value)" class="form-select" name="tipo">
                        <option value="checkbox">Checkbox</option>
                        <option value="select">Select</option>
                        <option value="oculto">Oculto</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Obrigatorio</label>
                    <select class="form-select" name="obrigatorio">
                        <option value="">Não</option>
                        <option value="1">Sim</option>
                    </select>
                </div>
            </div>
            <div class="row g-3">
                <div id="mkSelectOptions" class="col-12 my-3 border p-3 rounded d-none">
                    <h5>Opções Selecionáveis</h5>
                    <div id="mkSelectOption" class="row">
                        <div class="col">
                            <label for="inputOptTitulo" class="form-label">Titulo</label>
                            <input type="text" name="options[0][titulo]" class="form-control" id="inputOptTitulo" value="">
                        </div>

                        <div class="col">
                            <label for="inputOptValor" class="form-label">Valor</label>
                            <input type="text" name="options[0][valor]" data-mask="#00.00" data-mask-reverse="true" class="form-control" id="inputOptValor" value="">
                        </div>

                        <div class="col">
                            <label for="inputOptCota" class="form-label">Cota</label>
                            <input type="text" name="options[0][cota]" data-mask="#00.00" data-mask-reverse="true" class="form-control" id="inputOptCota" value="">
                        </div>

                        <div class="col">
                            <label for="inputOptCotaMin" class="form-label">Cota Min</label>
                            <input type="text" name="options[0][cota_min]" data-mask="#00.00" data-mask-reverse="true" class="form-control" id="inputOptCotaMin" value="">
                        </div>
                        <div id="mkSelectFirstOption" class="col">
                            <br>
                            <button type="button" class="btn btn-link btn-sm p-0" onclick="addSelectOption(1)"><i class="bx fs-2 bx-plus-circle m-0"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-3 my-3">
                <div class="col-md-4">
                    <label for="inputName" class="form-label">Titulo</label>
                    <input type="text" name="titulo" class="form-control" id="inputName" value="" required>
                </div>

                <div class="col-md-8">
                    <label for="inputName" class="form-label">Descricao</label>
                    <input type="text" name="descricao" class="form-control" id="inputName" value="">
                </div>
            </div>

            <div class="row g-3 my-3">
                <div class="col-md-4">
                    <label for="inputName" class="form-label">Valor</label>
                    <input type="text" name="valor" required data-mask="#00.00" data-mask-reverse="true" class="form-control" id="inputName" value="">
                </div>

                <div class="col-md-4">
                    <label for="inputName" class="form-label">Cota</label>
                    <input type="text" name="cota" data-mask="#00.00" data-mask-reverse="true" class="form-control" id="inputName" value="">
                </div>

                <div class="col-md-4">
                    <label for="inputName" class="form-label">Cota Min</label>
                    <input type="text" name="cota_min" data-mask="#00.00" data-mask-reverse="true" class="form-control" id="inputName" value="">
                </div>


            </div>

            <div class="row g-3 mt-4">
                <div class="col-12">
                    <button type="submit" name="codeCategoria" value="<?= $code ?>" class="btn btn-primary px-5">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</div>