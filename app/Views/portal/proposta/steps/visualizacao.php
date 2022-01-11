<?= view("$propostaPath/proposta_view.php") ?>
<div class="px-5">

	<?php if ($proposta->status != 'final') : ?>
		<form class="was-validated" action="<?= base_url('portal/aceitartermos') ?>" method="post">


			<?php if (!$vencida) : ?>

				<?php if (getEmpresa(CODEEMPRESA, 'assinatura') == 0) : ?>
					<div class="row">
						<div class="col-md-6">
							<label for="inputPassword" class="form-label">Dia de vencimento dos boletos</label>
							<select name="vencimento" class="form-select">
								<?php foreach ($vencimento as $v) : ?>
									<option value="<?= $v ?>"><?= $v ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				<?php endif; ?>

				<div class="row">
					<div class="col-md-6">
						<div class="form-check mb-3">
							<br>
							<input type="checkbox" name="aceite" value="true" class="form-check-input" id="validationFormCheck1" required>
							<label class="form-check-label" for="validationFormCheck1">Declaro que li e estou de acordo com os termos apresentados na proposta</label>
							<div class="invalid-feedback">É necessário marcar o termo acima para prosseguir.</div>
						</div>
					</div>


					<div class="mb-3">
						<a href="<?= base_url('portal/download') . '/' . $proposta->code ?>.pdf" target="_blank" class="btn btn-primary px-5">
							<i class="lni lni-download"></i> Proposta PDF
						</a>
						<?php if (getEmpresa(CODEEMPRESA, 'assinatura') == 1) : ?>
							<button class="btn btn-primary" name="code" value="<?= $proposta->code ?>" type="submit">Avançar</button>
						<?php else : ?>
							<button class="btn btn-primary" name="code" value="<?= $proposta->code ?>" type="submit">Aceitar</button>
						<?php endif; ?>
					</div>
				</div>
			<?php else : ?>
				<div class="text-center bg-warning px-4 py-3 fs-5"><i class="lni lni-alarm-clock my-3"></i> PROPOSTA VENCIDA</div>
			<?php endif; ?>


		</form>
	<?php elseif ($proposta->status == 'final') : ?>
		<div class="text-center">
			<?php if (getEmpresa(CODEEMPRESA, 'assinatura') == 1) : ?>
				<form class="was-validated" action="<?= base_url('portal/aceitartermos') ?>" method="post">
					<button class="btn bg-success px-4 fs-5 text-white" name="code" value="<?= $proposta->code ?>" type="submit"><i class="lni lni-checkmark-circle my-3"></i> PROPOSTA ACEITA</button>
				</form>
			<?php else : ?>
				<span class="bg-success px-4 py-5 fs-5 text-white"><i class="lni lni-checkmark-circle my-3"></i> PROPOSTA ACEITA</span>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</div>