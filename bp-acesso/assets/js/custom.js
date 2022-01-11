var baseUrl = $('#cfg').attr('data-baseUrl');
var accessToken = $('#cfg').attr('data-accessToken');

function getCookie(cname) {
	var name = cname + "=";
	var decodedCookie = decodeURIComponent(document.cookie);
	var ca = decodedCookie.split(';');
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) === ' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) === 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
}

$(document).ready(function () {

	const Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timer: 3000,
		timerProgressBar: true,
		didOpen: (toast) => {
			toast.addEventListener('mouseenter', Swal.stopTimer)
			toast.addEventListener('mouseleave', Swal.resumeTimer)
		}
	})

	$('.money').mask("#0.00", { reverse: true, selectOnFocus: true });


	$('input[data-required]').prop('required', true)

	$('input[data-required]').on('change', function () {
		var group = $(this).data('required');
		if ($(this).is(':checked')) {
			$('input[data-required="' + group + '"]').prop('required', false);
		}
		else {
			$('input[data-required="tr' + group + '"]').prop('required', true);
		}
	});

	$('.shareButton').on('click', function (e) {
		e.preventDefault();
		var $url = $(this).attr('href');

		Swal.fire({
			icon: 'info',
			title: 'Compartilhar proposta',
			input: 'url',
			html: '<a href="' + $url + '" target="_blank">Abrir proposta no portal</a>',
			inputValue: $url,
			inputAttributes: { readonly: 'on', autofocus: 'on' },
			showDenyButton: true,
			showCancelButton: true,
			confirmButtonText: '<i class="lni lni-whatsapp"></i> Whatsapp',
			confirmButtonColor: '#25d366',
			denyButtonText: '<i class="bx bx-copy"></i> Copiar link',
			denyButtonColor: '#008cff',
			cancelButtonText: 'Fechar',
			cancelButtonColor: '#666',

		}).then(function ($return) {
			if ($return.isConfirmed === true) {
				var content = encodeURIComponent("Olá! Segue o link da proposta: \r\n" + $url + "\n\r");
				var win = window.open("https://wa.me?text=" + content, '_blank');
				win.focus();
			}
			else if ($return.isDenied === true) {
				copyToClipboard($url);
				Toast.fire({
					icon: 'success',
					title: 'Link copiado para área de transferência.'
				})
			}
		});
	});

	$('.confirm').on('click', function (e) {
		e.preventDefault();
		var $url = $(this).attr('href');
		Swal.fire({
			icon: 'warning',
			title: 'Tem certeza disso?',
			html: '',
			showDenyButton: true,
			confirmButtonText: `Sim!`,
			confirmButtonColor: '#990000',
			denyButtonText: `Não`,
			denyButtonColor: '#666',
		}).then(function ($return) {
			if ($return.isConfirmed === true) {
				location.href = $url;
			}
		});
	});

	$('input[name="tipoPagina"]').on('change', function () {
		if ($(this).is(':checked') && $(this).val() == '1') {
			$('#singleSelect').show();
			$('#multipleSelect').hide();
		} else if ($(this).is(':checked') && $(this).val() == '2') {
			$('#singleSelect').hide();
			$('#multipleSelect').show();
		}
	});

	$('select[name="acessoTipo"]').on('change', function () {
		if ($(this).val() == '1') {
			$('#all').show();
			$('#getFilial').hide();
			$('#getUsuario').hide();
		} else if ($(this).val() == '2') {
			$('#all').hide();
			$('#getFilial').show();
			$('#getUsuario').hide();
		} else if ($(this).val() == '3') {
			$('#all').hide();
			$('#getFilial').hide();
			$('#getUsuario').show();
		}
	});

	$('#formWithPassword #inputPassword').blur(function () {
		checkPass();
	});
	$('#formWithPassword #inputPasswordConfirm').blur(function () {
		checkPass();
	});
});

function money(valor) {
	return valor.toLocaleString("pt-BR", { style: "currency", currency: "BRL" });
}
function checkPass() {
	var pass = $('#inputPassword').val();
	var repass = $('#inputPasswordConfirm').val();
	if ((pass.length == 0) || (repass.length == 0)) {
		$('#inputPassword').addClass('border-danger');
		$('#buttonSubmit').attr('type', 'button').addClass('disabled');
	}
	else if (pass != repass) {
		$('#inputPassword').addClass('border-danger');
		$('#inputPasswordConfirm').addClass('border-danger');
		$('#buttonSubmit').attr('type', 'button').addClass('disabled');
	}
	else {
		$('#inputPassword').removeClass('border-danger').addClass('border-success');
		$('#inputPasswordConfirm').removeClass('border-danger').addClass('border-success');
		$('#buttonSubmit').attr('type', 'submit').removeClass("disabled");
	}
}

function checkModuloPai(codeModulo) {
	//se seleciona o filho seleciona o pai
	$('#permissaoModulos input[value="' + codeModulo + '"').prop('checked', true);
}
function checkModuloFilhos(codeModulo) {
	//se seleciona o pai seleciona os filhos
	if ($('#permissaoModulos input[value="' + codeModulo + '"').prop('checked')) {
		$('#permissaoModulos input[data-pai="' + codeModulo + '"').prop('checked', true);
	} else {
		$('#permissaoModulos input[data-pai="' + codeModulo + '"').prop('checked', false);
	}
}

function carregaCidades($uf) {
	$('select[name="cidade"] option').html('Carregando...');
	$.ajax({
		url: baseUrl + '/api/publico/cidades/' + $uf,
		type: 'GET',
		contentType: 'application/json',
		beforeSend: function (requisicao) {
			requisicao.setRequestHeader('Authorization', 'bearer ' + accessToken);
		},
		success: function ($result) {
			$('select[name="cidade"]').html('<option value="">Selecione uma cidade</option>');
			$.each($result, function ($key, $item) {
				$('select[name="cidade"]').append('<option value="' + $item.nome + '">' + $item.nome + '</option>');
			});
		}
	});
}


function statusDelete($del) {
	var url = baseUrl + '/configuracao/apagarStatus/' + $del;
	$.post(url, function (result) {
		$('#' + result).remove();
	});
}

function changeColor($color) {
	$.post(baseUrl + '/configuracao/updateColor', {
		cor: $color
	});
}

function changeLogo() {
	var file_data = $('input[name="logo"]').prop('files')[0];
	var form_data = new FormData();
	form_data.append('logo', file_data);
	$.ajax({
		url: baseUrl + '/configuracao/changeLogo',
		dataType: 'text', // <-- what to expect back from the PHP script, if anything
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,
		type: 'post',
		success: function (php_script_response) {
			location.reload();
		}
	});
}

function changeIcone() {
	var file_data = $('input[name="icone"]').prop('files')[0];
	var form_data = new FormData();
	form_data.append('icone', file_data);
	$.ajax({
		url: baseUrl + '/configuracao/changeIcone',
		dataType: 'text', // <-- what to expect back from the PHP script, if anything
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,
		type: 'post',
		success: function (php_script_response) {
			location.reload();
		}
	});
}

function responseMail($titulo, $code) {
	$('.compose-mail-popup .compose-mail-title').html('Responder ' + $titulo);
	$('#SelectTipo').html('');
	$('input[name="assunto"]').val('RES: ' + $titulo);
	$('.compose-mail-popup form').prepend('<input type="text" name="codeSuporte" value="' + $code + '" class="d-none">');
}

function composeMail() {
	$('.compose-mail-popup .compose-mail-title').html('Novo chamado');
	$('#SelectTipo').html('<select class="form-control" name="tipo"><option value="1">Chamado comum</option><option value="2">Reportar Bug</option></select>');
	$('input[name="assunto"]').val('');
	$('input[name="codeSuporte"]').remove();
}

function selectPermissoes(selectObject) {
	var value = selectObject.value;
	var permissoes = $(selectObject).find(':selected').data('permissoes');
	$('#permissoesCheckboxes input').prop('checked', false);
	$('#permissoesCheckboxes').removeClass('d-none');
	$('#perfilDefault').remove();
	$.each(permissoes, function (key, item) {
		console.log(item);
		$('input#' + item).prop('checked', true);
	});
}


var celMask = function (val) {
	return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
},
	cOptions = {
		onKeyPress: function (val, e, field, options) {
			field.mask(celMask.apply({}, arguments), options);
		}
	};

$('input[name="telefone"]').mask(celMask, cOptions);
$('.celMask').mask(celMask, cOptions);
$('.telMask').mask(celMask, cOptions);

/********* MODAL ICON */
var iconModal = document.getElementById('iconModal')
if (iconModal) {
	iconModal.addEventListener('show.bs.modal', function (event) {
		// Button that triggered the modal
		var button = event.relatedTarget
		// Extract info from data-bs-* attributes
		var code = button.getAttribute('data-bs-code')
		var icon = button.getAttribute('data-bs-icon')
		// If necessary, you could initiate an AJAX request here
		// and then do the updating in a callback.
		//
		// Update the modal's content.
		$('#iconModal i').removeClass('text-white');
		$('#iconModal div').removeClass('text-white').removeClass('bg-primary');
		$('#iconModal .' + icon).parent().parent().addClass('bg-primary').addClass('text-white');
		$('#iconModal .' + icon).addClass('text-white');
		if (code != '') {
			$('.bxIcon').attr('data-code', code)
		} else {
			$('.bxIcon').attr('data-code', "no-auto-save")
		}
	})
}
function addModulo($code, $pai = null) {
	$.post(baseUrl + '/modulo/insert', { code: $code, pai: $pai }, function () {
		location.reload();
	})
}
function selectIcon($this) {
	var code = $($this).data('code');
	var icon = $($this).find('.ms-2').html();
	icon = 'bx-' + icon;

	if (code === 'no-auto-save') {
		$('#moduloIcone').removeClass().addClass('bx').addClass(icon);
		$('#inputModuloIcone').val(icon);
		$('#iconModal').modal('hide');

	} else {
		$.post(baseUrl + '/modulo/saveIcon', { code: code, icone: icon }, function ($return) {
			location.reload();
		});
	}
}
function updateNome($this) {
	//console.log($this);
	var nome = $($this).val();
	var code = $($this).data('code');
	$.post(baseUrl + '/modulo/update', { code: code, nome: nome });
}


function changeStatus(tabela, code) {

	$.get(baseUrl + '/status/tabela/' + tabela, function (options) {
		var listaOptions = '';
		$.each(options, function (item, v) {
			listaOptions += '<option value="' + item + '">' + v + '</option>';
		});

		Swal.fire({
			title: 'Selecione um novo status',
			html:
				'<select id="swal-input1" class="swal2-input">' +
				listaOptions +
				'</select>' +
				'<label>Informações adicionais: (opcional)</label>' +
				'<textarea rows="3" style="resize: none" id="swal-input2" class="swal2-textarea"></textarea>' +
				'',
			focusConfirm: false,
			preConfirm: () => {
				return [
					document.getElementById('swal-input1').value,
					document.getElementById('swal-input2').value
				]
			},
			showCancelButton: true,
			confirmButtonText: 'Salvar',
			cancelButtonText: 'Fechar',
			showLoaderOnConfirm: true,

		}).then((result) => {
			if (result.isConfirmed) {
				$.post(baseUrl + '/' + tabela + '/save', { code: code, codeStatus: result.value[0], obs: result.value[1] }, function () {
					location.reload();
				});
			}
		})
	}, 'json');
}




function newPassword($this) {
	var $password = Math.random().toString(36).slice(-10);
	var $inputAdd = '<div class="input-group">';
	$inputAdd += '<input name="password" value="' + $password + '" class="form-control form-control-sm text-center" readonly>';
	$inputAdd += '<a href="javascript:;" onclick="copyToClipboard(\'' + $.trim($password) + '\');" class="btn btn-primary">Copiar</a>';
	$inputAdd += '</div>';

	$('#newPassword').html($inputAdd);


}

function copyToClipboard(element) {
	var $temp = $("<input>");
	$("body").append($temp);
	$temp.val(element).select();
	document.execCommand("copy");
	$temp.remove();
}
window.onbeforeunload = function (e) {
	localStorage.removeItem('mkSelectNumOptions');
}

function makeSelect($value) {
	if ($value == 'select') {
		$('#mkSelectOptions').removeClass("d-none");
		$('#mkSelectOptions input').prop('required', true);
	} else {
		$('#mkSelectOptions').addClass("d-none");
		$('#mkSelectOptions input').val('');
		$('#mkSelectOptions input').prop('required', false);
	}
}
function removeSelectOption($n) {
	$('#mkSelectOption' + $n).remove();
}
function addSelectOption($n) {
	var localN = localStorage.getItem('mkSelectNumOptions');
	console.log($n);
	if (localN == null) {
		$n = $n;
	} else {
		$n = parseInt(localN) + 1;
	}
	console.log($n);
	localStorage.setItem('mkSelectNumOptions', $n);

	var html;
	html = '<div id="mkSelectOption' + $n + '" class="row">';
	html += '<div class="col">';
	html += '<label for="inputOptTitulo' + $n + '" class="form-label">Titulo</label>';
	html += '<input type="text" name="options[' + $n + '][titulo]" class="form-control" id="inputOptTitulo' + $n + '" value="" required>';
	html += '</div>';

	html += '<div class="col">';
	html += '<label for="inputOptValor' + $n + '" class="form-label">Valor</label>';
	html += '<input type="text" name="options[' + $n + '][valor]"class="form-control money" id="inputOptValor' + $n + '" value="" required>';
	html += '</div>';

	html += '<div class="col">';
	html += '<label for="inputOptCota' + $n + '" class="form-label">Cota</label>';
	html += '<input type="text" name="options[' + $n + '][cota]" class="form-control money" id="inputOptCota' + $n + '" value="" required>';
	html += '</div>';

	html += '<div class="col">';
	html += '<label for="inputOptCotaMin' + $n + '" class="form-label">Cota Min</label>';
	html += '<input type="text" name="options[' + $n + '][cota_min]" class="form-control money" id="inputOptCotaMin' + $n + '" value="" required>';
	html += '</div>';
	html += '<div id="mkSelectFirstOption" class="col">';
	html += '<br>';
	html += '<button type="button" class="btn btn-link btn-sm p-0" onclick="addSelectOption()"><i class="bx fs-2 bx-plus-circle m-0"></i></button>';
	html += '<button type="button" class="btn btn-link btn-sm text-danger p-0" onclick="removeSelectOption(' + $n + ')"><i class="bx fs-2 bx-minus-circle m-0"></i></button>';
	html += '</div>';
	html += '</div>';

	$("#mkSelectOptions").append(html);
	$('#mkSelectOptions .money').mask("#0.00", { reverse: true });
}

function rejeitarProposta(codeProposta) {

	$.get(baseUrl + '/api/v1/get/status/' + usuarioAccessCode + '?tabela=' + tabela, function (options) {

		Swal.fire({
			title: 'Rejeitar proposta',
			title: 'Enter your IP address',
			input: 'text',
			inputLabel: 'Your IP address',
			inputValue: inputValue,
			showCancelButton: true,
			confirmButtonText: 'Salvar',
			cancelButtonText: 'Fechar',
			showLoaderOnConfirm: true,

		}).then((result) => {
			if (result.isConfirmed) {
				$.post(baseUrl + '/' + tabela + '/save', { code: code, codeStatus: result.value[0], obs: result.value[1] }, function () {
					location.reload();
				});
			}
		})
	}, 'json');
}