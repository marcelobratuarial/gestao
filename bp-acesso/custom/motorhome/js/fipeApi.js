

$(document).ready(function () {

    var BPToken = getCookie("BPToken");

    $('#opcionais .opt').on('change', function () {
        var total = 0;
        var mensalidade = 0;
        $('.valor_mensalidade').each(function () {
            var valor_mensalidade = $.trim($(this).html()).split('R$');
            valor_mensalidade = parseFloat(valor_mensalidade[1].replace('&nbsp;', '').replace('.', '').replace(',', '.'));
            mensalidade = mensalidade + valor_mensalidade;
        });
        $('#opcionais .opt').each(function () {
            var value = $(this).val();
            if ($.isNumeric(value)) {
                value = parseFloat(value);
                if (!$(this)[0].checked) {
                    value = 0;
                }
            } else if (value == '') {
                value = 0;
            } else {
                var opt = JSON.parse(value);
                value = parseFloat(opt.valor);
            }
            total = total + value;
        });
        $('#valor_opcionais').html(money(total));
        $('#valor_total').html(money(total + mensalidade));
    });

    // $('#opcionais .opt').on('change', function () {
    //     var value = $(this).val();
    //     if ($.isNumeric(value)) {
    //         value = parseFloat(value);
    //         if (!$(this)[0].checked) {
    //             value = 0;
    //         }
    //     } else {
    //         var opt = JSON.parse(value);
    //         value = parseFloat(opt.valor);
    //     }
    //     var mensalidade = $.trim($('#mensalidade').html()).split('R$');
    //     console.log(value);
    //     mensalidade = parseFloat(mensalidade[1].replace('&nbsp;', '').replace('.', '').replace(',', '.'));

    //     $('#mensalidade').html(money(mensalidade + value));
    // });


    var apiUrl = 'http://fluid-blade-169321.appspot.com/api/1/';
    var apiUrl = 'https://fipeapi.appspot.com/api/1/';
    var apiUrl = 'https://parallelum.com.br/fipe/api/v1/';

    var ext = '.json';
    var ext = '';
    $('#fipe select[name="veiculo_tipo"]').on('change', function () {
        var tipo = $(this).val();
        var implemento = $(this).find(':selected').data('implemento');
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
        $('.inputFipe input').val('').prop('required', false);
        $('.inputFipe select').prop('selectedIndex', 0).prop('required', false);
        $('#groupMotorhome input').val('').prop('required', false);
        $('#groupImplemento input').val('').prop('required', false);
        $('#groupImplemento select').prop('selectedIndex', 0).prop('required', false);
        $('#possuiCarreta select').prop('selectedIndex', 0).prop('required', false);
        $('#qtdCarreta select').prop('selectedIndex', 0).prop('required', false);

        $('.inputFipe').addClass('d-none');
        $('#groupImplemento').addClass('d-none');
        $('#groupMotorhome').addClass('d-none');
        $('#possuiCarreta').addClass('d-none');
        $('#qtdCarreta').addClass('d-none');
        $('#nomeImplemento').addClass('d-none');
        $('#valorImplemento').addClass('d-none');
        $('#groupCarreta').html('');

        $('#valorFipe').html('');
        $('#btnSubmit').prop('disabled', true).attr('type', 'button');


        if (implemento == 1 && tipo != 'carreta') {
            $('#groupImplemento').removeClass('d-none');
        }
        if (tipo == 'caminhoes') {
            // se caminhão pode ter carreta, implemento e fipe
            $('.inputFipe').removeClass('d-none');
            $('.inputFipe input').prop('required', true);
            $('.inputFipe select').prop('required', true);
            $('#possuiCarreta').removeClass('d-none');
            $('.inputFipe input[name="placa"]').prop('required', false);
        }
        else if (tipo == 'carreta') {
            $('.inputFipe').addClass('d-none');
            $('#qtdCarreta').removeClass('d-none');
        }
        else if (tipo == 'motorhome') {
            $('#groupMotorhome').removeClass('d-none')
            $('#groupMotorhome .maskMoney').val('').prop('required', false);
            $('#groupMotorhome .maskMoney').on('change', function () {
                var path = $('select[name="veiculo_ano"]').data('path');
                var tipo = 'motorhome';
                var value = $(this).val();
                var implemento = null;

                checaTabela(path, tipo, value, implemento);
            })
        }
        else {
            $('.inputFipe').removeClass('d-none');
            $('.inputFipe input').prop('required', true);
            $('.inputFipe select').prop('required', true);
            $('.inputFipe input[name="placa"]').prop('required', false);
        }
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


            var tipo = $('select[name="veiculo_tipo"]').find(':selected').data('code');
            var implemento = $('#valorImplemento input').val();
            var valor = data.Valor;

            checaTabela(path, tipo, valor, implemento);

        });
    });



    $('#possuiCarreta select').on('change', function () {
        var value = $(this).val();
        if (value == 'sim') {
            $('#qtdCarreta').removeClass('d-none');
            $('#qtdCarreta select').prop('required', true);
            $('#groupImplemento').addClass('d-none');
            $('#groupImplemento input').val('').prop('required', false);
            $('#groupImplemento select').prop('selectedIndex', 0).prop('required', false);
            $('#valorComImplemento').remove();
        } else {
            $('#qtdCarreta').addClass('d-none');
            $('#qtdCarreta select').prop('required', false);
            $('#groupCarreta').html('');
            $('#groupImplemento').removeClass('d-none');
            $('#possuiCarreta select').prop('selectedIndex', 0).prop('required', false);
            $('#qtdCarreta select').prop('selectedIndex', 0).prop('required', false);
        }
    });
    $('#qtdCarreta select').on('change', function () {
        var value = $(this).val();
        var html = '<div class="px-3 py-2">';
        $('#groupCarreta').html('');
        for (let $i = 1; $i <= value; $i++) {
            html += '<div class="row my-3">';
            html += '   <div id="tipoCarreta" class="col-md-4">';
            html += '       <label class="form-label">Tipo de carreta</label>';
            html += '       <select class="form-select radius-square carretaTipo" name="carreta_tipo[' + ($i - 1) + ']" required>';
            html += '          <option value="">Selecione</option>';
            html += '       </select>';
            html += '   </div>';
            html += '   <div id="placaCarreta" class="col-md-4">';
            html += '       <label class="form-label">Placa</label>';
            html += '       <input class="form-control radius-square" type="text" name="carreta_placa[' + ($i - 1) + ']" placeholder="Placa">';
            html += '   </div>';
            // html += '   <div id="chassiCarreta" class="col-3">';
            // html += '       <label class="form-label">Chassi</label>';
            // html += '       <input class="form-control radius-square" type="text" name="carreta_chassi[' + ($i - 1) + ']" placeholder="Chassi" required>';
            // html += '   </div>';
            html += '   <div id="valorCarreta" class="col-md-4">';
            html += '       <label class="form-label">Valor declarado</label>';
            html += '       <input class="maskMoney form-control radius-square" type="text" name="carreta_valor[' + ($i - 1) + ']" placeholder="Valor declarado" required>';
            html += '   </div>';
            html += '</div>';
        }
        html += '</div>';
        $('#groupCarreta').append(html);

        $.getJSON({
            url: baseUrl + '/api/v1/tabela-motorhome/implementos',
            headers: { "Authorization": "Bearer " + BPToken }
        }).done(function (json) {
            var opt = '';
            $.each(json, function (k, v) {
                opt += '<option value="' + v + '">' + v + '</option>';
                return opt;
            });
            $('.carretaTipo').append(opt);
        });

        $('.maskMoney').maskMoney({
            prefix: "R$ ",
            decimal: ',',
            thousands: '.',
            selectAllOnFocus: true,
            allowNegative: false
        });


        $('#groupCarreta .maskMoney').on('change', function () {
            var path = $('select[name="veiculo_ano"]').data('path');
            var tipo = 'carreta';
            var value = $(this).val();
            var implemento = 0;
            var name = $(this).attr('name');
            var $num = name.split('[');
            $num = $num[1].split(']');
            $num = $num[0];

            checaTabelaCarreta(path, tipo, value, implemento, $num);
        });



    });

});
function checaTabela($path, $tipo, $valor, $implemento) {
    $.post(baseUrl + '/' + $path + '/api/tabela', { tipo: $tipo, valor: $valor, implemento_valor: $implemento }, function (result) {
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
            var html = '';
            // console.log(JSON.stringify(result));            
            html += '<input class="d-none" type="text" name="tabela" value=\'' + JSON.stringify(result) + '\'>';

            html += '<div class="row my-3">';
            html += '<div class="col-md-3">';
            html += '<label class="form-label">Valor do veículo</label>';
            html += '<input class="form-control radius-square" type="text" name="veiculo_valor"';
            html += 'required value="' + $valor + '" readonly />';
            html += '</div>';

            if ($implemento) {
                html += '<div id="valorComImplemento" class="col-md-3">';
                html += '<label class="form-label">Valor do veículo + implemento</label>';
                html += '<input class="form-control radius-square" type="text" name="veiculo_implemento_valor"';
                html += 'required value="' + money(result.valor) + '" readonly />';
                html += '</div>';
            }
            html += '</div>';
            $('#valorFipe').html(html);
            $('#btnSubmit').prop('disabled', false).attr('type', 'submit');

        }

        $('input[name="implemento_valor"').on('change', function () {
            if ($valor) {
                var path = $('select[name="veiculo_ano"]').data('path');
                var tipo = $('select[name="veiculo_tipo"]').find(':selected').data('code');
                var implemento = $(this).val();
                checaTabela(path, tipo, $valor, implemento);
            }
        });
    }, 'json');
}
function checaTabelaCarreta($path, $tipo, $valor, $implemento, $num) {
    $.post(baseUrl + '/' + $path + '/api/tabela', { tipo: $tipo, valor: $valor, implemento_valor: $implemento }, function (result) {
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
            $('#fipe').append('<input class="d-none" type="text" name="tabela_carreta[' + $num + ']" value=\'' + JSON.stringify(result) + '\'>');
            $('#btnSubmit').prop('disabled', false).attr('type', 'submit');
        }
    }, 'json');
}

function exibeImplemento(value) {
    if (value == 'sim') {
        $('#nomeImplemento').removeClass('d-none');
        $('#nomeImplemento select').prop('required', true);
        $('#valorImplemento').removeClass('d-none');
        $('#valorImplemento input').prop('required', true);
    }
    else if (value == 'nao') {
        $('#nomeImplemento').addClass('d-none');
        $('#nomeImplemento select').prop('required', false);
        $('#valorImplemento').addClass('d-none');
        $('#valorImplemento input').prop('required', false);
    }
}
