<section class="content-header">
      <h1>
        Retiradas de Produtos 
        <small>Saidas do estoque</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Saídas</a></li>
        <li class="active">Retiradas</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid col-md-4 ">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->

     <div class="box box-solid box-warning ">

            <div class="box-header with-border">
              <h3 class="box-title">Saidas no Estoque</h3>
            </div>
           
            <!-- Box Formulario -->
            <div class="box-body">
              
           



                  

<!-- Formulario para Inserir Produto -->
    <div class="box-nav">
<form method="POST" enctype="multipart/form-data" action="<?php echo uri();?>saida/saidaProdutos">


<div class="form-group"> <!-- NOME DO PRODUTO -->

<select name="Produto" class="form-control">

<option value="">Nome do Produto</option>
<?php foreach ($produtos as $forneValue) { ?>
<option><?php echo $forneValue['nome']?></option>


<?php } ?>

</select>

</div> <!-- FIM NOME DO PRODUTO -->

<div class="form-group">
    
    <input type="text" name="Quantidade" class="form-control" id="exampleInputPassword1" placeholder="Quantidade">
</div>


<div class="form-group"> <!-- Select -->

<select required name="Unidade_entrada" class="form-control">
<option value="">Unidade de Medida</option>
<option>PC</option>
<option>CX</option>
<option>Unidade</option>

</select>

</div> <!-- Fim Select -->



<div class="form-group">
    
    <input type="text" name="QuantX" class="form-control" id="exampleInputPassword1" placeholder="Quantidade X do PC ou CX">
</div>


<div class="form-group">
    
    <input type="hidden" name="ValorUnitario" value=0 class="form-control" id="exampleInputPassword1" placeholder="R$ Valor Unitario">
</div>

<div class="form-group"> <!-- NOME DO FORNECEDOR -->

<select name="Fornecedor" class="form-control">

<option value="">Nome do Fornecedor</option>
<?php foreach ($fornecedor as $forneValue) { ?>
<option><?php echo $forneValue['fornecedor']?></option>


<?php } ?>

</select>

</div> <!-- FIM NOME DO FORNECEDOR -->



<div class="form-group"> <!-- Select -->

<select name="departamento" class="form-control">
<option value="">Departamento</option>
<option>ADM</option>
<option>RH</option>
<option>TI</option>
<option>Coordenacao</option>
<option>Direção</option>

</select>

</div> <!-- Fim Select -->


<div class="form-group"> <!-- Select -->

<select name="escola" class="form-control">
<option value="">Escola</option>
<option>Centro</option>
<option>Glicerio</option>
<option>SBC</option>


</select>

</div> <!-- Fim Select -->

<div class="form-group">
    
    <input type="hidden" name="movimento" value='saida' class="form-control" id="exampleInputPassword1" placeholder="R$ Valor Unitario">
</div>


<!-- <div class="form-group">
    <label for="exampleInputFile">Foto do Produto</label>
    <input onchange() name="foto" type="file" id="exampleInputFile">
    <p class="help-block">Aqui a foto do produto.</p>
</div> -->



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