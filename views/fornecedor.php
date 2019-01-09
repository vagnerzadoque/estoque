<section class="content-header">
      <h1>
       Cadastro do Fornecedor
        <small>Insira os dados do Fornecedor</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Fornecedor</a></li>
        <li class="active">Produtos</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid col-md-5">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->

    <div class="box box-solid box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Cadastre seu Fornecedor</h3>
            </div>
            <div class="box-body">



    <!-- Formulario para Inserir Produto -->
        <div class="box-nav">
<form method="POST" action="<?php echo uri();?>fornecedor/cadastrar">
    
    <div class="form-group">
        <input type="text" required name="nome" class="form-control" id="exampleInputEmail1" placeholder="Nome do Fornecedor">
    </div>

     <div class="form-group">
       <input type="text" required name="telefone" class="form-control" id="exampleInputEmail1" placeholder="Telefone">
   </div>

    <div class="form-group">
       <input type="email"  required name="email" class="form-control" id="exampleInputEmail1" placeholder="Email do Fornecedor">
   </div>

    <div class="form-group">
       <input type="text" name="site" class="form-control" id="exampleInputEmail1" placeholder="Site do Fornecedor">
   </div>






    <button type="submit" class="btn btn-danger btn-block">Cadastrar</button>
    </form>


    
    
    
    

   
    </div>
    <!-- FIM Formulario para Inserir Produto -->

    </div>
    </div>