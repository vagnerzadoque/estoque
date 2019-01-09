
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
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->

<div class="box box-solid box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Consultar Produto em Estoque</h3>
            </div>
            
            <div class="box-body table-responsive">
<table id="relatorio" class="table table-striped table-hover"> 
<thead> 
    <tr>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Unidade</th>
            <th>Total Unitario</th>
            <th>Custo Total</th>
    </tr>
</thead>



<tbody>
<?php if(!empty($rel['relatorio'])) foreach ($rel['relatorio'] as $produto => $value) { ?>
        <tr>
        <td> <?php echo $produto; ?> </td>
        <td> <?php 
        if($value['Quantidade'] <6){
          echo '<span style="color: red"><h3>'.$value['Quantidade'].'- Comprar</h3> </span>';
        }else{

          echo $value['Quantidade']; 
        }
        
        
        ?> </td>
        <td> <?php echo $value['Unidade_entrada']; ?> </td>
        <td> <?php echo $value['TotalUnitario']; ?> </td>
        <td> <?php echo $value['ValorTotal']; ?> </td>
        </tr>
<?php } ?>
</tbody>


</table>



    <!-- Formulario para Inserir Produto -->
        <div class="box-nav">


    
    
    
    

   
    </div>
    <!-- FIM Formulario para Inserir Produto -->

    </div>
    </div>


     <!--  <div class="jumbotron">
        <a href="<?php echo BASE_URL; ?>cadastro"><button class="btn btn-primary btn-lg btn-block">
          <i class="fa fa-bolt"></i> Inicio</button></a> -->



          


























</div>
        
     
           

    </section>






