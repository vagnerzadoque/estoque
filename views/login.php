<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="<?= uriAssets('login_v1/images/icons/favicon.ico') ?>"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= uriAssets('login_v1/vendor/bootstrap/css/bootstrap.min.css') ?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= uriAssets('login_v1/fonts/font-awesome-4.7.0/css/font-awesome.min.css') ?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= uriAssets('login_v1/vendor/animate/animate.css') ?>">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?= uriAssets('login_v1/vendor/css-hamburgers/hamburgers.min.css') ?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= uriAssets('login_v1/vendor/select2/select2.min.css') ?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= uriAssets('login_v1/css/util.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= uriAssets('login_v1/css/main.css') ?>">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="<?= uriAssets('login_v1/images/img-01.png') ?>" alt="IMG">
				</div>

				<form class="login100-form validate-form">
					
					<span class="login100-form-title">
						<h1 style="color:#005bab">Compras Polígono</h1>
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Digite um email válido: ex@abc.xyz">
						<input class="input100" type="text" name="email" placeholder="Email">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Senha obrigatória">
						<input class="input100" type="password" name="pass" placeholder="Senha">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Entrar
						</button>
					</div>
					
					<!-- <div class="text-center p-t-12">
						<span class="txt1">
							Forgot
						</span>
						<a class="txt2" href="#">
							Username / Password?
						</a>
					</div> -->

					<div class="text-center p-t-136">
						<a class="txt2" href="#">
							Esqueceu a senha?
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	
<?php
if(isset($_SESSION['loginRequired'])){
	require COREPATH.DIRECTORY_SEPARATOR.'alert.php';
	toast('Para acessar a página '.$_SESSION['loginRequired'].' é necessário estar logado', 'info', 4, 'top');
	unset($_SESSION['loginRequired']);
}
sweetAlert();
?>
	
<!--===============================================================================================-->	
	<script src="<?= uriAssets('login_v1/vendor/jquery/jquery-3.2.1.min.js') ?>"></script>
<!--===============================================================================================-->
	<script src="<?= uriAssets('login_v1/vendor/bootstrap/js/popper.js') ?>"></script>
	<script src="<?= uriAssets('login_v1/vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
<!--===============================================================================================-->
	<script src="<?= uriAssets('login_v1/vendor/select2/select2.min.js') ?>"></script>
<!--===============================================================================================-->
	<script src="<?= uriAssets('login_v1/vendor/tilt/tilt.jquery.min.js') ?>"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="<?= uriAssets('login_v1/js/main.js') ?>"></script>

</body>
</html>