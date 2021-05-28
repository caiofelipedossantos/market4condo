$(function () {
    var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
        spOptions = {
            onKeyPress: function (val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            }
        };

    $('#phone').mask(SPMaskBehavior, spOptions);

    $('.btn-send').on('click', function (e) {
        $.ajax({
            url: "/send.php",
            type: "POST",
            dataType: "json",
            data: {
                name: $('#name').val(),
                phone: $('#phone').val(),
                email: $('#email').val(),
                message: $('#message').val()
            },
            beforeSend: function () {
                $('.btn-send').prop('disabled', true);
                $('.btn-send').html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <span class="sr-only">Processando...</span>`);
                $('#alert').html('');
                $('#alert').removeClass('alert-success');
                $('#alert').removeClass('alert-danger');
                $('#alert').hide();
            },
            success: function (response) {
                if (response.status) {
                    $('.btn-send').html(`Quero receber mais informações`);
                    $('.btn-send').prop('disabled', false);
                    $('#alert').addClass('alert-success');
                    $('#alert').addClass('text-center');
                    $('#alert').html('Mensagem enviada com sucesso!');
                    $('#alert').show();
                }else{
                    $('#alert').addClass('alert-danger');
                    $('#alert').addClass('text-center');
                    $('#alert').text('Falha ao enviar mensagem, tente novamente mais tarde.');
                    $('#alert').show();
                }
            }
        });
    });
});