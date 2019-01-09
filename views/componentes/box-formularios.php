<section class="content-header">
      <h1>
        Iniciando Sistema
        <small>Optional description</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid col-md-4 ">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->

     <div class="box box-solid box-primary ">

            <div class="box-header with-border">
              <h3 class="box-title">Entradas no Estoque</h3>
            </div>
           
            <!-- Box Formulario -->
            <div class="box-body">
              
           



                  

<!-- Formulario para Inserir Produto -->
    <div class="box-nav">
<form method="POST" enctype="multipart/form-data" action="<?php echo uri();?>cadastrar/cadastrar">


<div class="form-group"> <!-- NOME DO PRODUTO -->

<select name="fornecedor" class="form-control">

<option>Nome do Produto</option>
<?php foreach ($produtos as $forneValue) { ?>
<option><?php echo $forneValue['nome']?></option>


<?php } ?>

</select>

</div> <!-- FIM NOME DO PRODUTO -->

<div class="form-group">
    
    <input type="text" name="Quantidade" class="form-control" id="exampleInputPassword1" placeholder="Quantidade">
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

<div class="form-group"> <!-- NOME DO FORNECEDOR -->

<select name="fornecedor" class="form-control">

<option>Nome do Fornecedor</option>
<?php foreach ($fornecedor as $forneValue) { ?>
<option><?php echo $forneValue['fornecedor']?></option>


<?php } ?>

</select>

</div> <!-- FIM NOME DO FORNECEDOR -->



<div class="form-group">
    <label for="exampleInputFile">Foto do Produto</label>
    <input onchange() name="foto" type="file" id="exampleInputFile">
    <p class="help-block">Aqui a foto do produto.</p>
</div>



<button type="submit" class="btn btn-primary">Cadastrar</button>
</form>








</div>
<!-- FIM Formulario para Inserir Produto -->












             </div>
            <!-- Fim do Box Formulario -->
           
            


    </div>

</section>












<!--Section Lado B  -->

 <section class="content container-fluid col-md-6 ">

<!--------------------------
  | Your Page Content Here |
  -------------------------->
 

<div class="box box-solid box-success  ">

      <div class="box-header with-border">
        <h3 class="box-title">Consultar Produto em Estoque</h3>
      </div>
     
      
      <div class="box-body">
      Lado B
       </div>

     
      


</div>

</section>