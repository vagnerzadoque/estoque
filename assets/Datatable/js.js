

$(document).ready(function(){

    //alert('olá mundo')




$('#myTable').DataTable( {
    fixedHeader: true,
    responsive: true,
    ajax: "http://localhost/php/banco-json/banco.php",
    columns: [
        { data: 'id' },
        { data: 'data' },
        { data: 'nome' },
        { data: 'celular' },
        { data: 'email' },
       
      
       
      
    ],

  

    language: {
        processing:     "Procurando dados...",
        search:         "Pesquisar:",
        lengthMenu:    "Mostrar _MENU_ Registros",
        info:           "Mostrar de _START_ &agrave; _END_ do total de _TOTAL_ Registros",
        infoEmpty:      "Nada Encontrado",
        infoFiltered:   "(No Filtro de _MAX_ Registros no total)",
        infoPostFix:    "",
        loadingRecords: "Carregando...",
        zeroRecords:    "Nada Encontrado",
        emptyTable:     "Nao ha dados disponiveis na tabela",
        paginate: {
            first:      "Primeiro",
            previous:   "Anterior",
            next:       "Proximo",
            last:       "Ultimo"
        },
        aria: {
            sortAscending:  ": activer pour trier la colonne par ordre croissant",
            sortDescending: ": activer pour trier la colonne par ordre décroissant"
        }
    },

    dom: 'Bfrtip',
        buttons: [
              'excel', 'csv', 'print',"pdf"
        ]

} );



new $.fn.dataTable.FixedHeader( table, {
    alwaysCloneTop: true
});

 new $.fn.dataTable.Buttons( table, {
buttons: [
    'excel', 'csv', 'print',"pdf"
]
      });


})