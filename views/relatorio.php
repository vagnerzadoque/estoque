


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?= uriAssets('login_v1/vendor/bootstrap/css/bootstrap.min.css') ?>">
    <title>Document</title>
</head>
<body>

<div class="container">


        <table id="example1" class="table table"> 
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
        <?php foreach ($relatorio as $produto => $value) { ?>
                <tr>
                <td> <?php echo $produto; ?> </td>
                <td> <?php echo $value['Quantidade']; ?> </td>
                <td> <?php echo $value['Unidade_entrada']; ?> </td>
                <td> <?php echo $value['TotalUnitario']; ?> </td>
                <td> <?php echo $value['ValorTotal']; ?> </td>
                </tr>
   <?php } ?>
        </tbody>
     
    
      </table>
    
    

</div>
</body>
</html>