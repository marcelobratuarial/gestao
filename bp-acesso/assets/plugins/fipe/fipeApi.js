$(document).ready(function () {
    // var apiUrl = 'http://fluid-blade-169321.appspot.com/api/1/';
    // var apiUrl = 'https://fipeapi.appspot.com/api/1/';
    var apiUrl = 'https://parallelum.com.br/fipe/api/v1/';

    // var ext = '.json';
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
            $('#fipe select[name="veiculo_nome"]').prop('disabled', false).html(options);
        });
    });

    $('#fipe select[name="veiculo_nome"]').on('change', function () {
        var tipo = $('select[name="veiculo_tipo"]').val();
        var marca = $('#fipe select[name="veiculo_marca"]').val();
        var veiculo = $(this).val();
        $.getJSON(apiUrl + tipo + '/marcas/' + marca + '/modelos/' + veiculo + '/anos' + ext, function (data) {
            var options = '<option value="">Selecione...</option>';
            $.each(data, function (k, i) {
                options = options + '<option value="' + i.codigo + '">' + i.nome + '</option>';
            });
            $('#fipe select[name="veiculo_modelo"]').prop('disabled', false).html(options);
        });
    });

    $('#fipe select[name="veiculo_modelo"]').on('change', function () {
        var tipo = $('select[name="veiculo_tipo"]').val();
        var marca = $('#fipe select[name="veiculo_marca"]').val();
        var veiculo = $('#fipe select[name="veiculo_nome"]').val();
        var modelo = $(this).val();
        $.getJSON(apiUrl + tipo + '/marcas/' + marca + '/modelos/' + veiculo + '/anos/' + modelo + '' + ext, function (data) {
            var target = {};
            var formLocalStorage = JSON.parse(localStorage.getItem('form'));
            var fipe = { 'fipe': data };
            $.extend(target, formLocalStorage, fipe);
        });
    });
});