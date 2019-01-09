<section class="content-header">
      <h1>
        Cadastrar Produtos
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

    
    <div class="box box-solid box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Cadastre aqui seus Produtos</h3>
            </div>
            <div class="box-body">

    <div class="row "> <!-- inicio da row -->


<div class="col-md-6">

    <!-- Formulario para Inserir Produto -->
        <div class="box-nav">
<form method="POST" enctype="multipart/form-data" action="<?php echo uri();?>cadastrar/cadastrar">
    
    <div class="form-group">
       
        <input type="text" name="nome" class="form-control" id="exampleInputEmail1" placeholder="Nome do Produto">
    </div>




  <div class="form-group">

<select name="unidade" class="form-control">
<option>Unidade de Medida</option>
<option>PC</option>
<option>CX</option>
<option>Unidade</option>

</select>

</div>



<div class="form-group">
        
        <input type="text" name="quantX" class="form-control" id="exampleInputPassword1" placeholder="Quantidade X do PC ou CX">
    </div>


    <div class="form-group">
        
        <input type="text" name="valorunitario" class="form-control" id="exampleInputPassword1" placeholder="R$ Valor Unitario">
    </div>



<div class="form-group">

    <select name="fornecedor" class="form-control">

    <option>Qual Fornecedor</option>
   <?php foreach ($fornecedor as $forneValue) { ?>
    <option><?php echo $forneValue['nome']?></option>
   
   
   <?php } ?>
    

  
   
    </select>


    </div>

    <div class="form-group">
        <label for="exampleInputFile">Foto do Produto</label>
        <input onchange() name="foto" type="file" id="exampleInputFile">
        <p class="help-block">Aqui a foto do produto.</p>
    </div>
   


    <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>


    
    
    
    

   
    </div>
    <!-- FIM Formulario para Inserir Produto -->


</div><!-- fim col md6 -->


<div class="col-md-6">

          <div class="box box-solid">
          
            <div class="box-header with-border">
              <h3 class="box-title">Produtos inseridos</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">

                <?php  for ($i=0; $i < count($produtos); $i++) { ?>

                  <li data-target="#carousel-example-generic" data-slide-to="<?php echo $i?>" class=""></li>
                 
                  
                <?php }?>
                </ol>
                <div class="carousel-inner">

                    <?php if(count($produtos) > 0)  {?>
                  <?php foreach ($produtos as $key => $value) { ?>
                    
                    
                      <div class="item <?php if($key === 0) echo 'active'?>">
          <div style=" height:300px; z-index: 999; background-color: #ccc; padding: 10px; color:#fff; display: flex;  align-item: center"> 

                    <!-- <h1> <?php echo $value['nome']?></h1> -->
                   <img src="./assets/imagens/<?php echo $value['foto']?>" alt="Second slide">
                    
                    
                   <!--  <h3 style=" margin:30px; ">  <small>Fornecedor</small><br /> <?php echo $value['fornecedor']?></h3> -->
                    
                    <div class="carousel-caption">
                      <div style="width: 100%; height: 85px; background-color:rgba(0,0,255,0.3);">
                      <h1 > <?php echo $value['nome'];?><br /></h1>
                      <p> <?php echo $value['quantx'];?> Cada <?php echo $value['unidade'];?></p>
                     
                      </div>
                      
        </div>

                    </div>
                       
                  </div>



                 <?php } } else{echo 'Não existe Produtos';}?>
                 

                
                  
                  <!-- <div class="item active">
                    <img src="http://placehold.it/900x500/3c8dbc/ffffff&amp;text=I+Love+Bootstrap" alt="Second slide">

                    <div class="carousel-caption">
                      Second Slide
                    </div>
                  </div> -->

                  <!-- <div class="item">
                    <img src="http://placehold.it/900x500/f39c12/ffffff&amp;text=I+Love+Bootstrap" alt="Third slide">

                    <div class="carousel-caption">
                      Third Slide
                    </div>
                  </div> -->





                </div>
                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                  <span class="fa fa-angle-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                  <span class="fa fa-angle-right"></span>
                </a>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>





</div> <!-- fim da row -->








              <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                Click Para Inserir
              </button> -->
              
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


<form method="POST" enctype="multipart/form-data" action="<?php echo uri(); ?>cadastro/cadastrar">
  
  
  <div class="form-group">
    <label for="exampleInputEmail1">Nome do Produto</label>
    <input type="text" name="produto" class="form-control" id="produto" aria-describedby="emailHelp" placeholder="Nome do Produto">
  </div>

<label for="exampleInputEmail1">Escolha o Produto</label>

<select class="form-control">
  <option>1</option>
  <option>2</option>
  <option>3</option>
  <option>4</option>
  <option>5</option>
</select>



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