<div class="card-title d-flex align-items-center">
    <div>
        <i class="bx bxs-edit me-1 font-22 text-primary"></i>
    </div>
    <h5 class="mb-0 text-primary">Assinatura eletrônica </h5>
</div>
<hr>
<form method="post" id="codigo" action="<?= base_url('portal/solicitarcodigo') ?>">
    <div class="row g-3">
        <div class="col-md-5">
            Para garantir a legitimidade da assinatura eletrônica da proposta, precisamos validar algumas informações do signatário do contrato. Por gentileza confirme os dados abaixo e solicite um código de autenticação de segundo fator que enviaremos ao seu e-mail.
        </div>
        <div class="col-md-3">
            <label for="inputName" class="form-label">Email</label>
            <input type="text" name="email" class="form-control" value="<?= $proposta->email ?>" id="inputName">
        </div>
        <div class="col-md-4" style="display:block; margin:auto; text-align: center">
            <button type='submit' name="codeProposta" value="<?= $proposta->code ?>" class="btn btn-primary px-5 center-block">
                Solicitar código via e-mail
            </button>
        </div>

    </div>
</form>
<br>
<hr>
<br>