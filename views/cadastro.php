
<section class="content-header">
      <h1>
        Iniciando Sistema
        <small>Controle de Estoque</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inserir</a></li>
        <li class="active">Produtos</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->

    <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Inserir Produtos</h3>
            </div>
            <div class="box-body">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                Click Para Inserir
              </button>
              
            </div>
          </div>

<div class="modal modal-info fade" id="modal-default" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Cadastre o Produto!</h4>
              </div>
              <div class="modal-body">
              <div class="master">

<!-- Fromulario da Cadastro do Produto -->
<div class="container">


<form method="POST" enctype="multipart/form-data" action="<?php echo BASE_URL; ?>cadastro/cadastrar">
  <div class="form-group">
    <label for="exampleInputEmail1">Nome do Produto</label>
    <input type="text" name="produto" class="form-control" id="produto" aria-describedby="emailHelp" placeholder="Nome do Produto">
  </div>

    <div class="form-group">
    <label for="exampleInputEmail1">Unidade</label>
    <input type="text" name="Unidade" class="form-control" id="produto" aria-describedby="emailHelp" placeholder="Unidade do Produto">
  </div>

  

   <div class="form-group">
    <label for="exampleFormControlFile1">Foto do Produto</label>
    <input name="foto" type="file" class="form-control-file" id="exampleFormControlFile1">
  </div>





  <div class="form-group form-check">
  
  </div>

  <button type="submit" class="btn btn-primary">Cadastrar Produto</button>
</form>
</div>
</div>
<hr />

<!-- FIM DO CADASTRO -->
              </div>
              <div class="modal-footer">
               <!--  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button> -->
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>


        
      
<?php
foreach ($viewData as $key => $value) {?>
  


<?php $sa = $value['entrada'] - $value['saida']; ?>


<div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-blue">
              <div class="widget-user-image">
                <img class="img-circle" src="<?php echo BASE_URL; ?>assets/imagens/<?php echo $viewData[$key]['foto_item']; ?>" alt="User Avatar">
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?php echo $viewData[$key]['item']; ?></h3>
              <h5 class="widget-user-desc"><?php echo $viewData[$key]['data']; ?> <h3>0<?php echo $viewData[$key]['id_item']; ?></h3></h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a class="entrada" id="<?php echo $viewData[$key]['id_item']; ?>" href="#">Entrada <span class="pull-right badge bg-blue"><?php echo $viewData[$key]['entrada']; ?></span></a></li>
                <li><a class="saida" id="<?php echo $viewData[$key]['id_item']; ?>" href="#">Saida <span class="pull-right badge bg-aqua"><?php echo $viewData[$key]['saida']; ?></span></a></li>
                <!-- <li><a href="#">Completed Projects <span class="pull-right badge bg-green">12</span></a></li> -->
                <li><a href="#">Total de Estoque <span class="pull-right badge bg-red"><?php echo $sa; ?></span></a></li>
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>

<?php } ?>


    </section>


<!-- Botao Click Modal escondido -->
<div id="btn-modal" class="btn" data-toggle="modal" data-target="#janela"></div>

<div class="modal fade" id="janela" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Controle seu Estoque</h4>
      </div>
      <div class="modal-body">
        

        <div class="widget-user-header bg-blue" style="padding:30px;">
              <div class="widget-user-image">
                <img id="im-modal" class="img-circle" src="" alt="User Avatar" style="width:80px;">
              </div>
              <!-- /.widget-user-image -->
              <h3 id="h3-modal" class="widget-user-username"></h3>
              <h5  class="widget-user-desc">Id do Produto <h3 id="h5-modal">0</h3></h5>
            </div>






    <div class="form-group">
    <label class="label-entrada" for="exampleInputEmail1">Entrada</label>
    <input type="text" name="entrada" class="form-control" id="Atualizar-entrada" aria-describedby="emailHelp" placeholder="Quantidade do Produto">
  </div>


      <div class="form-group">
    <label class="label-saida" for="exampleInputEmail1">Saida</label>
    <input type="text" name="saida" class="form-control" id="Atualizar-saida" aria-describedby="emailHelp" placeholder="Quantidade do Produto">
  </div>

  






      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="btn-salvar" coluna="teste" type="button" class="btn btn-primary" data-dismiss="modal">Salvar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->





