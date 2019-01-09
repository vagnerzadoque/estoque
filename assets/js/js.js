


    $(document).ready(function(){
        var URL = 'http://localhost/estoque/';
      /*   var URL = 'https://institutopoligono.com.br/estoque/'; */
        
        $('a.entrada').click(function(){
            $('#Atualizar-entrada').val('')
           var NavID = $(this).attr('id')
            var coluna = $(this).attr('class')
            
            
             $('[coluna]').attr('coluna', coluna)         
           var dados = {id:NavID}

           $.ajax({
               type: "post",
               url: URL+'cadastro/getprod',
               data: dados,
               dataType: "json",
               success: function (res) {
                   console.log(res);
                   $('#h3-modal').text(res.item)
                   $('#h5-modal').text(res.id_item)
                   $('#im-modal').attr('src', 'URL+assets/imagens/'+res.foto_item )
                   $('#Atualizar-entrada').val(res.entrada)
                   $('#btn-modal').click()
                   $('#Atualizar-saida').hide()
                   $('#Atualizar-entrada').show()
                   $('label.label-saida').hide()
                   $('label.label-entrada').show()
                   
               }
           });
        });


        $('a.saida').click(function(){

            $('#Atualizar-saida').val('')
            var SaiID = $(this).attr('id')
            
            var coluna = $(this).attr('class')
             $('[coluna]').attr('coluna', coluna)  
            
            var dados = {id:SaiID}
 
            $.ajax({
                type: "post",
                url: URL+"cadastro/getprod",
                data: dados,
                dataType: "json",
                success: function (res) {
                    console.log(res);
                    $('#h3-modal').text(res.item)
                    $('#h5-modal').text(res.id_item)
                    $('#im-modal').attr('src', URL+'assets/imagens/'+res.foto_item )
                    $('#Atualizar-saida').val(res.saida)
                    $('#btn-modal').click()
                    $('#Atualizar-entrada').hide()
                    $('#Atualizar-saida').show()
                    $('label.label-entrada').hide()
                    $('label.label-saida').show()
                }
            });
         });


        $('#btn-salvar').click(function(){

            var entrada = $('#Atualizar-entrada').val()
            var saida = $('#Atualizar-saida').val()
            var id_item = $('#h5-modal').text()
            var coluna = $('[coluna]').attr('coluna');
            
            if(coluna == 'entrada'){
                var salvarDados = {valor:entrada, id:id_item, coluna:coluna}
                
            }else{
                var salvarDados = {valor:saida, id:id_item, coluna:coluna}
               
            }
            

            $.ajax({
                type: "post",
                url: URL+"cadastro/UpdateProduto",
                data: salvarDados,
                dataType: "json",
                success: function (res) {
                   location.reload();
                }
            });


        })

        $('[data-dismiss]').click(function(){

            location.reload();
        })
        
    

           
        
        
        $('#inserir').on('submit', function(e){
            e.preventDefault()
            
            var form = document.getElementById('inserir');
            
            var data = new FormData(form)
        $.ajax({
            type: "POST",
            url: URL+'inserir/uploadImagem',
            data: data,
            contentType: false,
            processData: false,
            success: function (response) {
                window.location.assign(URL+"inserir")
            }
        });


})

})

    




