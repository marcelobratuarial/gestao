<div class="invoice px-4">
	<?= view($view_assinatura) ?>

	<div style="font-weight: bold">Assinaturas</div>
	<div style="border: 1px solid #999; margin: 4px 0;"></div>

	<table>
		<tbody>
			<tr>
				<td style="background:none; margin-top: 1rem;  max-width: 300px; margin-right: 10%; text-align: center;">
					<div>Representante</div>
					<span style="border-bottom: 1px solid #999;">
						<span style='font-family: YellowTail; font-size:1.5rem;'> <?= $assinaturaConsultor != null && $assinaturaConsultor->nomecompleto != null ? $assinaturaConsultor->nomecompleto : "" ?> </span>
					</span>
					<div style="font-weight: bold"><?= $assinaturaConsultor != null && $assinaturaConsultor->nomecompleto != null ? $assinaturaConsultor->nomecompleto : "Assinatura pendente" ?><br><?= $assinaturaConsultor != null && $assinaturaConsultor->identificador_usuario != null ? mask(base64_decode($assinaturaConsultor->identificador_usuario), "###.###.###-##") : "" ?></div>
				</td>
				<td style="background:none; margin-top: 1rem;  max-width: 300px; margin-right: 10%; text-align: center;">
					<div>Cliente</div>
					<span style="border-bottom: 1px solid #999;">
						<span style='font-family: Satisfy; font-size:1.5rem;'> <?= $assinaturaCliente != null && $assinaturaCliente->nomecompleto != null ? $assinaturaCliente->nomecompleto : "" ?> </span>
					</span>
					<div style="font-weight: bold"><?= $assinaturaCliente != null && $assinaturaCliente->nomecompleto != null && $assinaturaCliente->nomecompleto != null ? $assinaturaCliente->nomecompleto : "Assinatura pendente" ?> <br><?= $assinaturaCliente != null && $assinaturaCliente->identificador_usuario != null ? mask(base64_decode($assinaturaCliente->identificador_usuario), "###.###.###-##") : "" ?> </div>
				</td>
			</tr>
		</tbody>
	</table>
	<br><br>
	<div style="font-weight: bold">Auditoria</div>
	<div style="border: 1px solid #999; margin: 4px 0;"></div>

	<table>
		<tbody>
			<tr>
				<td style="background:none; margin-top: 1rem;  max-width: 600px; margin-right: 10%; text-align: left;">
					<div>Representante:</div>
					<span style="font-weight:bold">Nome:</span> <?= $assinaturaConsultor != null && $assinaturaConsultor->nomecompleto != null ? $assinaturaConsultor->nomecompleto : "" ?> - <span style="font-weight:bold">CPF:</span> <?= $assinaturaConsultor != null && $assinaturaConsultor->identificador_usuario != null ? mask(base64_decode($assinaturaConsultor->identificador_usuario), "###.###.###-##") : "" ?> <br>
					<span style="font-weight:bold">E-mail:</span> <?= $assinaturaConsultor != null && $assinaturaConsultor->email != null ? $assinaturaConsultor->email : "" ?> - <span style="font-weight:bold">Data:</span> <?= $assinaturaConsultor != null && $assinaturaConsultor->created_at != null ? date('d/m/Y H:i', strtotime($assinaturaConsultor->created_at)) : "" ?><br>
					<span style="font-weight:bold">Status:</span> <?= $assinaturaConsultor != null ? "Assinado eletronicamente, mediante confirmação de identidade por segundo fator de autenticação via e-mail. " : "Assinatura pendente." ?><br>
					<span style="font-weight:bold">IP:</span> <?= $assinaturaConsultor != null && $assinaturaConsultor->ip_Address != null ? $assinaturaConsultor->ip_Address : "" ?>
				</td>
			</tr>
			<tr>
				<td style="background:none; margin-top: 1rem;  max-width: 600px; margin-right: 10%; text-align: left;">
					<div>Cliente:</div>
					<span style="font-weight:bold">Nome:</span> <?= $assinaturaCliente != null && $assinaturaCliente->nomecompleto != null ? $assinaturaCliente->nomecompleto : "" ?> - <span style="font-weight:bold">CPF:</span> <?= $assinaturaCliente != null && $assinaturaCliente->identificador_usuario != null ? base64_decode($assinaturaCliente->identificador_usuario) : "" ?> <br>
					<span style="font-weight:bold">E-mail:</span> <?= $assinaturaCliente != null && $assinaturaCliente->email != null ? $assinaturaCliente->email : "" ?> - <span style="font-weight:bold">Data:</span> <?= $assinaturaCliente != null && $assinaturaCliente->created_at != null ? date('d/m/Y H:i', strtotime($assinaturaCliente->created_at)) : "" ?><br>
					<span style="font-weight:bold">Status:</span> <?= $assinaturaCliente != null ? "Assinado eletronicamente, mediante confirmação de identidade por segundo fator de autenticação via e-mail. " : "Assinatura pendente." ?><br>
					<span style="font-weight:bold">IP:</span> <?= $assinaturaCliente != null && $assinaturaCliente->ip_Address != null ? $assinaturaCliente->ip_Address : "" ?>
				</td>
			</tr>

		</tbody>
	</table>

	<!--	<br><br>
	<div style="font-weight: bold">Autenticidade</div>
	<div style="border: 1px solid #999; margin: 4px 0;"></div>

	<table>
		<tbody>
			<tr>
				<td style="background:none; margin-top: 1rem;  max-width: 600px; margin-right: 10%; text-align: left;">
					<div style="font-size:14px">
						<span style="font-weight:bold">Para verificar a autenticidade do documento acesse o link abaixo:</span>
						<br>
						<a href="<?= base_url('portal/validador') . '/' . base64_encode($proposta->code) ?>" target="_blank"><?= base_url('portal/validador') . '/' . base64_encode($proposta->code) ?> </a>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
-->
</div>