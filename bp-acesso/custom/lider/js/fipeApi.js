$(document).ready(function () {
    var apiUrl = 'http://fluid-blade-169321.appspot.com/api/1/';
    var apiUrl = 'https://fipeapi.appspot.com/api/1/';
    var apiUrl = 'https://parallelum.com.br/fipe/api/v1/';

    var ext = '.json';
    var ext = '';
    $('#fipe select[name="veiculo_tipo"]').on('change', function () {
        var tipo = $(this).val();
        $.getJSON(apiUrl + tipo + '/marcas' + ext, function (data) {
            var options = '<option value="">Selecione...</option>';
            $.each(data, function (k, i) {
                options = options + '<option value="' + i.codigo + '">' + i.nome + '</option>';
            });

            var target = {};
            var formLocalStorage = JSON.parse(localStorage.getItem('form'));
            $.extend(target, formLocalStorage, { 'veiculo_tipo': tipo });
            localStorage.setItem('form', JSON.stringify(target));

            $('#fipe select[name="veiculo_marca"]').prop('disabled', false).html(options);
        });
    });

    $('#fipe select[name="veiculo_marca"]').on('change', function () {
        var tipo = $('select[name="veiculo_tipo"]').val();
        var marca = $(this).val();
        $.getJSON(apiUrl + tipo + '/marcas/' + marca + '/modelos' + ext, function (data) {
            var options = '<option value="">Selecione...</option>';
            $.each(data.modelos, function (k, i) {
                options = options + '<option value="' + i.codigo + '">' + i.nome + '</option>';
            });
            $('#fipe select[name="veiculo_modelo"]').prop('disabled', false).html(options);
        });
    });

    $('#fipe select[name="veiculo_modelo"]').on('change', function () {
        var tipo = $('select[name="veiculo_tipo"]').val();
        var marca = $('#fipe select[name="veiculo_marca"]').val();
        var veiculo = $(this).val();
        $.getJSON(apiUrl + tipo + '/marcas/' + marca + '/modelos/' + veiculo + '/anos' + ext, function (data) {
            var options = '<option value="">Selecione...</option>';
            $.each(data, function (k, i) {
                options = options + '<option value="' + i.codigo + '">' + i.nome + '</option>';
            });
            $('#fipe select[name="veiculo_ano"]').prop('disabled', false).html(options);
        });
    });

    $('#fipe select[name="veiculo_ano"]').on('change', function () {
        var tipo = $('select[name="veiculo_tipo"]').val();
        var marca = $('#fipe select[name="veiculo_marca"]').val();
        var veiculo = $('#fipe select[name="veiculo_modelo"]').val();
        var modelo = $(this).val();
        var path = $(this).data('path');
        $.getJSON(apiUrl + tipo + '/marcas/' + marca + '/modelos/' + veiculo + '/anos/' + modelo + '' + ext, function (data) {

            $('#fipe').append('<input name="fipe" value=\'' + JSON.stringify(data) + '\' type="hidden">');


            $.post(baseUrl + '/' + path + '/api/tabela', { tipo: tipo, valor: data.Valor }, function (result) {
                $('#formCapture button').attr('type', 'submit').removeClass('disabled').html('AVANÇAR');
                if (result.error) {
                    swal.fire({
                        icon: 'error',
                        title: 'Que pena!',
                        html: result.error
                    }).then(function () {
                        $('#formCapture button').attr('type', 'button').addClass('disabled').html('SELECIONE OUTRO VEÍCULO');
                    });
                } else {
                   // console.log(JSON.stringify(result));
                    var html = '<div class="row my-3">';
                    html += '<div class="col-3">';
                    html += '<label class="form-label">Valor do veículo</label>';
                    html += '<input class="d-none" type="text" name="tabela" value=\'' + JSON.stringify(result) + '\'>';
                    html += '<input class="form-control radius-square" type="text" name="veiculo_valor"';
                    html += 'required value="' + data.Valor + '" readonly />';
                    html += '</div>';
                    html += '</div>';

                    $('#valorFipe').html(html);
                }
            }, 'json');

        });
    });
});