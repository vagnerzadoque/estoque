<?php
defined('BASEPATH') OR exit('Nenhum acesso direto ao script é permitido');

if (!function_exists('toast') && !function_exists('dialog')) {
   sweetAlert();

   function toast($text = '', $type = 'question', $timer = 0, $position = 'top-end') {
      $timer = $timer > 0 ? $timer * 1000 : 3000;
      echo "
      <script>
         const toast = swal.mixin({
            toast: true,
            position: '{$position}',
            showConfirmButton: false,
            timer: {$timer}
         });
         
         toast({
            type: '{$type}',
            title: '{$text}'
         })
      </script>
      ";
   }

   function dialog($text = '', $type = 'question', $timer = 0, $position = 'top-end') {
      $timer = $timer > 0 ? $timer * 1000 : 1800;
      echo "
      <script>
         swal({
            position: '{$position}',
            type: '{$type}',
            title: '{$text}',
            showConfirmButton: false,
            timer: {$timer}
         })
      </script>
      ";
   }
}



