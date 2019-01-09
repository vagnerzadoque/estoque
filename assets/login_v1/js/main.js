(function ($) {
    "use strict";

    
    /*==================================================================
    [ Validate ]*/
    var input = $('.validate-input .input100');
    const loading = '<div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'
    const btn = $('.container-login100-form-btn').html()

    console.log(window.location)
    $('.validate-form').on('submit',function(event){
        var check = true;

        for(var i=0; i<input.length; i++) {
            if(validate(input[i]) == false){
                showValidate(input[i]);
                check=false;
            }
        }
        if(check) {
            
            const toast = swal.mixin({
                toast: true,
                position: 'center',
                showConfirmButton: false,
                timer: 4000
            });
            $.ajax({
                url: `${window.location.origin}${window.location.pathname}/authenticate`,
                type: 'post',
                dataType: 'json',
                data: {
                    email: $('[name=email]').val(),
                    password: $('[name=pass]').val()
                },
                beforeSend: () => $('.container-login100-form-btn').html(loading),
                complete: ()=> $('.container-login100-form-btn').html(btn)
            })
            .done(function(resp){
                switch (resp.cod) {
                    case 1:
                        swal({
                            position: 'center',
                            type: 'error',
                            title: resp.title,
                            text: resp.text,
                            showConfirmButton: false,
                            timer: 2400
                        })
                        $('[name=email]').val(''),
                        $('[name=pass]').val('')
                        break;
                    case 2:
                        swal.mixin({
                            input: 'password',
                            confirmButtonText: 'Próximo &rarr;',
                            showCancelButton: false,
                            progressSteps: ['1', '2'],
                            inputValidator: (value) => {
                                check = value.trim() == '' || value.length < 2 ? true : false
                                return check && 'A sehna é obrigatória e deve ter mais de três caracteres!'
                            },
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        }).queue([
                            {
                            title: 'Nova senha',
                            text: 'Você presica alterar sua senha'
                            },
                            'Digite novamente a senha'
                        ]).then((result) => {
                            if (result.value[0] != result.value[1]) {
                                swal({
                                    type: 'error',
                                    title: 'As senhas não coincedem!',
                                    text: 'Tente novamente',
                                    confirmButtonText: 'Sair'
                                })
                            }
                            if (result.value[0] === result.value[1]) {
                                $.ajax({
                                    url: `${window.location.origin}${window.location.pathname}/newpass`,
                                    type: 'post',
                                    dataType: 'json',
                                    data: {
                                        id: resp.user.id,
                                        password: result.value[0]
                                    },
                                    beforeSend: () => $('.container-login100-form-btn').html(loading),
                                    complete: ()=> $('.container-login100-form-btn').html(btn)
                                })
                                .done(function(respB){
                                    if(respB.status) {
                                        swal({
                                            type: 'success',
                                            title: 'Nova senha salva com successo!',
                                            showConfirmButton: false,
                                            timer: 2200
                                        })
                                        setTimeout(() => setLogin(resp.user), 1200)
                                    } else {
                                        swal({
                                            type: 'error',
                                            title: respB.message,
                                            showConfirmButton: true,
                                            confirmButtonText: 'Sair',
                                            timer: 2200
                                        })
                                    }
                                })
                                .fail(function(){
                                    toast({
                                        type: 'error',
                                        title: '[A2C2F] Falha na conexão, avise o administrador do sistema!'
                                    });
                                })
                            }
                           /*  if (result.value) {
                                swal({
                                    title: 'All done!',
                                    html:
                                    'Your answers: <pre><code>' +
                                        JSON.stringify(result.value) +
                                    '</code></pre>',
                                    confirmButtonText: 'Lovely!'
                                })
                            } */
                        })
                        break
                    case 3:
                        swal({
                            type: 'warning',
                            title: 'Existia uma sessão ativa com seu usuário!',
                            text: 'Recomendamos trocar a senha caso você não tenha deixado o sistema aberto em outro lugar',
                            showConfirmButton: false,
                            timer: 3000
                        })
                    setTimeout(() => setLogin(resp.user), 2800)
                        break
                    case 4:
                        setLogin(resp.user)
                        break
                    default:
                        toast({
                            type: 'error',
                            title: '[A1CDD] Ocorreu algum erro, avise o administrador do sistema!'
                        });
                        break;
                }
            })
            .fail(function(){
                /*  */
                
                toast({
                    type: 'error',
                    title: '[A1F] Falha na conexão, avise o administrador do sistema!'
                });
            })
            
        }
        
        return false
    });


    $('.validate-form .input100').each(function(){
        $(this).focus(function(){
           hideValidate(this);
        });
    });

    function validate (input) {
        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        }
        else {
            if($(input).val().trim() == ''){
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }
    
    function setLogin(user) {   
        $.ajax({
            url: `${window.location.origin}${window.location.pathname}/startsessionlogin`,
            type: 'post',
            dataType: 'json',
            data: { user },
            beforeSend: () => $('.container-login100-form-btn').html(loading),
            complete: ()=> $('.container-login100-form-btn').html(btn)
        })
        .done(function(resp){
            if(resp.status) {
                window.location.reload()
            } else {
                swal({
                    type: 'error',
                    title: 'Por favor, recarregue a página e tente novamente',
                })
            }
        })
        .fail(function(){
            swal({
                type: 'error',
                title: '[A3F] Falha na conexão',
                text: 'Por favor, avise o administrador do sistema!'
            });
        })
    }

})(jQuery);