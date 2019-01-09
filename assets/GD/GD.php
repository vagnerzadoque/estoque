<?php

function cropImagen($imagem){

$arquivo = $imagem['foto']['tmp_name'];

$max_width = 400;

$max_height = 400;


list($width_origins, $height_origins) = getimagesize($arquivo);

$ratio = $width_origins / $height_origins;

if($max_width / $max_height > $ratio){

    $max_width = $max_height * $ratio;

}else{
    $max_height = $max_width / $ratio;
}


$imagem_final = imagecreatetruecolor($max_width, $max_height);

if($imagem['foto']['type']== 'image/jpeg'){

    $imagem_original = imagecreatefromjpeg($arquivo);
}else{
    $imagem_original = imagecreatefrompng($arquivo);
}

imagecopyresampled($imagem_final, $imagem_original, 0,0,0,0, $max_width, $max_height, $width_origins, $height_origins);
$nomeImagen = md5($imagem['foto']['name']);
$nomeOriginal = $imagem['foto']['name'];
imagepng($imagem_final, "../../assets/imagens/".$nomeImagen.'-'.$nomeOriginal.".jpg");

return "../../assets/imagens/".$nomeImagen.'-'.$nomeOriginal.".jpg";

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form method="POST" enctype="multipart/form-data">
<input type="file" name="foto" id="ft " >

<button type="submit">Enviar</button>
</form>

<?php 
$img = $_FILES;
var_dump($img);
$nn = cropImagen($img);

echo '<img src='.$nn.'>';
?>
    
</body>
</html>