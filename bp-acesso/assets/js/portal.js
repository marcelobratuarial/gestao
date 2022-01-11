var baseUrl = $('#cfg').attr('data-baseUrl');
var accessToken = $('#cfg').attr('data-accessToken');
$(document).ready(function () {

});

function sendCodeEmail() {
	var $email = $('input[name="email"]').val();
	var $code = $('input[name="codeProposta"]').val();
	Swal.fire({
		'icon': 'info',
		'title': 'Solicitar código de segundo fator',
		'html': 'O código será enviado para o email:<br><input id="swal-input1" class="swal2-input text-center" value="' + $email + '"><br>Lembre-se de conferir sua caixa de spam.',
		'confirmButtonText': 'Solicitar código',
		preConfirm: () => {
			return [
				document.getElementById('swal-input1').value,
				document.getElementById('swal-input2').value
			]
		}
	});
	if (formValues) {
		Swal.fire(JSON.stringify(formValues))
		// $.post(baseUrl + '/portal/solicitarcodigo', { email: $email, codeProposta: $code }, function ($result) {
		// 	swal.fire("Tudo certo!", "Email enviado.", 'success');
		// });
	}

}

function checkCodeEmail($code) {
	$.post(baseUrl + '/portal/checaCodigoEmail', { 'code': $code }, function (result) {
		if (result == 'true') {
			$('input[name="codigo_email"]').addClass('is-valid').removeClass('is-invalid');
			$('input[name="codigo_email"]')[0].setCustomValidity("");
		} else {
			$('input[name="codigo_email"]').removeClass('is-valid').addClass('is-invalid');
			$('input[name="codigo_email"]')[0].setCustomValidity(true);
			// localStorage.setItem('buttonSubmit', false);
		}
	});
}
function checkName() {
	var nome = $('input[name="nomecompleto"]').val();
	var words = nome.split(' ').filter(function (v) { return v !== '' });
	if (words.length >= 2) {
		$('input[name="nomecompleto"]').addClass('is-valid').removeClass('is-invalid');
		$('input[name="nomecompleto"]')[0].setCustomValidity("");
		console.log('valido');
	} else {
		$('input[name="nomecompleto"]').removeClass('is-valid').addClass('is-invalid');
		$('input[name="nomecompleto"]')[0].setCustomValidity(true);
	}
}

function loadFile(event, imgId) {
	var image = document.getElementById(imgId);
	image.style.backgroundImage = "url(" + URL.createObjectURL(event.target.files[0]) + ")";
};


