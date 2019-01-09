<?php
defined('BASEPATH') OR exit('Nenhum acesso direto ao script é permitido');
/**   ---   Arquivo de Funções Globais   ---   **/

/**
 * Verifica chaves de arrays
 *
 * Verifica se a chave existe no array e se ela tem algum valor.
 *
 * @param array  $array O array
 * @param string $key A chave do array
 * @return string|null  O valor da chave do array ou nulo
 * @since 0.1
 */
function checkArray ($array, $key) {
   // Verifica se a chave existe no array
   if (isset($array[ $key ]) && ! empty($array[ $key ])) {

      // Retorna o valor da chave
      return $array[ $key ];
   }

   // Retorna nulo por padrão
   return null;
} // Fim -> checkArray

/**
 * Obtém parâmetros de $_GET['url']
 *
 * A URL deverá ter o seguinte formato:
 * http://www.example.com/controlador/acao/parametro1/parametro2/etc...
 * @since 0.1
 */
function getUrl() {
   $getUrl = false;
   // Verifica se o parâmetro path foi enviado
   if (isset( $_GET['url'])) {
      // Captura o valor de $_GET['url']
      $getUrl['url'] = strip_tags(trim(filter_input(INPUT_GET,'url', FILTER_SANITIZE_URL)));

      if(count($_GET) > 1) {
         unset($_GET['url']);
         $getUrl['get'] =  $_GET;
      }
   }
   // Retorna false se o parâmetro path não foi enviado
   return $getUrl;
} // Fim -> getUrl


/**
 * Envia para página informada no parametro $adress
 * ou envia para pagina principal caso não seja passado $adress
 * @since 0.1
 *
 */
function navTo($adress = '') {
   $navTo = uri($adress);
   // Redireciona
   echo '<meta http-equiv="Refresh" content="0; url='.$navTo.'">';
   echo '<script type="text/javascript">window.location.href = "'.$navTo.'";</script>';

} // Fim -> navTo


function uri($nav = NULL, $bar = true) {

   $uri = $_SERVER['SCRIPT_NAME'];
   $uri = substr($uri, 0, strpos($uri, 'index.php'));
   $uri = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'].$uri;

   if( $nav !== NULL ) {
  	   if( strpos($nav, '/') === 0 ) $nav = substr($nav, 1);
   }

   $uri .= $nav;

   if($bar) {
      if(substr($uri, -1) !== '/') $uri .= '/';
   } else {
      if(substr($uri, -1) === '/') $uri = substr($uri, 0, -1);
   }

   return $uri;
}
function uriAssets($adress) {

   $uri = uri('assets').$adress;

   return $uri;
}

/**
 * Função que verifica um diretório.
 * Retorna um array com a lista de arquivos e pastas (caso haja) ou
 * Retorna falso caso diretório não exista ou esteja vazio
 */
function checkDir($fileDir){

   // Verifica se o diretório existe
   if(is_dir($fileDir)){
      // Remove os valores (.) e (..) do array
      $files = array_diff(scandir($fileDir), array('.', '..'));

      //Se existir arquivos e pastas retorna um array com arquivos e pastas, ou retorna falso caso o diretório esteja vazio
      return (!empty($files)) ? $files : false;
   }

   // se o diretório não existir retorna falso
   return false;
}// Fim -> checkDir



// ------------------------------------------------------------------------

if (!function_exists('load_helpers')) {
	function load_helpers() {
      $helpers_folder = checkDir(BASEPATH.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR);

      if($helpers_folder === false) return;

      foreach ($helpers_folder as $value) {
         $check_file  = explode('.', $value);
         $check_file  = strtolower(end($check_file));
         $is_file_php = ($check_file === 'php') ? true : false;

         if($is_file_php) require_once BASEPATH.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.$value;
      }
	}
}


// ------------------------------------------------------------------------

if (!function_exists('is_php')) {
	/**
	 * Determina se a versão atual do PHP é igual ou superior ao valor fornecido
	 *
	 * @param	string
	 * @return	bool	true se a versão atual for $version ou superior
	 */
	function is_php($version) {
		static $_is_php;
		$version = (string) $version;

		if (!isset($_is_php[$version])) $_is_php[$version] = version_compare(PHP_VERSION, $version, '>=');

		return $_is_php[$version];
	}
}

// ------------------------------------------------------------------------

if (!function_exists('is_really_writable')) {
	/**
	 * Testes para gravação de arquivos
	 *
	 * is_writable() retorna true em servidores Windows quando você realmente não
   * pode gravar no arquivo, com base no atributo somente leitura.
	 * is_writable() também não é confiável em servidores Unix se safe_mode estiver ativado.
	 *
	 * @link	https://bugs.php.net/bug.php?id=54709
	 * @param	string
	 * @return	bool
	 */
	function is_really_writable($file) {
		// Se estivermos em um servidor Unix com safe_mode off nós chamamos is_writable()
		if (DIRECTORY_SEPARATOR === '/' && (is_php('5.4') OR ! ini_get('safe_mode'))) return is_writable($file);

		// Para servidores Windows e safe_mode "on", vamos realmente escrever um arquivo e depois lê-lo.
		if (is_dir($file)) {
			$file = rtrim($file, '/').'/'.md5(mt_rand());
         
         if (($fp = @fopen($file, 'ab')) === false) return false;

			fclose($fp);
			@chmod($file, 0777);
			@unlink($file);
			return true;
		} elseif (! is_file($file) OR ($fp = @fopen($file, 'ab')) === false) return false;

		fclose($fp);
		return true;
	}
}

// ------------------------------------------------------------------------

if (!function_exists('load_class')) {
	/**
	 * Registro de classse
	 *
	 * Esta função funciona como um singleton. Se a classe solicitada não existir,
	 * ela é instanciada e configurada para uma variável estática. static $_classes['class']
	 * Se já foi instanciado, a variável é retornada.
	 *
	 * @param	string	o nome da classe solicitada
	 * @param	string	o diretório onde a classe deve ser encontrada
	 * @param	mixed	  um argumento opcional para passar para o construtor da classe
	 * @return	object
	 */
	function &load_class($class, $param = false, $directory = 'libraries') {
		static $_classes = array();

		// Se a classe já foi instanciada, terminamos ...
		if (isset($_classes[$class])) return $_classes[$class];

      $find = false;
      
	   //Procure a classe primeiro na pasta local application/libraries em seguida, na pasta system/libraries
		foreach (array(BASEPATH.DIRECTORY_SEPARATOR, BASEPATH) as $path) {
			if (file_exists($path.$directory.DIRECTORY_SEPARATOR.$class.'.php')) {
            $find = true;
				if (class_exists($class, false) === false) require_once($path.$directory.DIRECTORY_SEPARATOR.$class.'.php');
				break;
			}
		}

		// Achamos a classe?
		if ($find === false) {
			// // Nota: Usamos exit () em vez de show_error () para evitar um loop de auto-referência com a classe Exceptions
			// set_status_header(503);
			echo 'Não é possível localizar a classe especificada: '.$class.'.php';
			exit(5);
		}

		// Mantem o que acabamos de carregar
		is_loaded($class);

		$_classes[$class] = ($param !== false) ? new $class($param) : new $class();
		return $_classes[$class];
	}
}

// --------------------------------------------------------------------

if (!function_exists('is_loaded'))
{
	/**
	 * Manter o registro de quais bibliotecas foram carregadas.
    * Esta função é chamada pela função load_class () acima
	 *
	 * @param	string
	 * @return	array
	 */
	function &is_loaded($class = '') {
		static $_is_loaded = array();

		if ($class !== '') $_is_loaded[strtolower($class)] = $class; 

		return $_is_loaded;
	}
}

// ------------------------------------------------------------------------

if (!function_exists('show_error')) {
	/**
	 * Error Handler
	 *
	 * Esta função nos permite invocar a classe de exceção e exibir erros usando o
   * modelo de erro padrão localizado em application/views/errors/error_general.php
	 * in application/views/errors/error_general.php
	 * Esta função enviará a página de erro diretamente para o navegador e sairá.
	 *
	 * @param	string
	 * @param	int
	 * @param	string
	 * @return	void
	 */
	function show_error($message, $status_code = 500, $heading = 'Um erro foi encontrado') {
		$status_code = abs($status_code);
		if ($status_code < 100) {
			$exit_status = $status_code + 9; // 9 is EXIT__AUTO_MIN
			$status_code = 500;
		} else {
			$exit_status = 1; // EXIT_ERROR
		}

		$_error =& load_class('Exceptions', 'core');
		echo $_error->show_error($heading, $message, 'error_general', $status_code);
		exit($exit_status);
	}
}

// ------------------------------------------------------------------------

if (!function_exists('show404')) {
	/**
	 * Página 404
	 *
	 * Esta função é semelhante à função show_error () acima.
	 * No entanto, em vez do modelo de erro padrão, ele exibe o modelo de erro 404
	 *
	 * @param	string
	 * @param	bool
	 * @return	void
	 */
	function show_404($page = '', $log_error = true) {
		$_error =& load_class('Exceptions', 'core');
		$_error->show_404($page, $log_error);
		exit(4); // EXIT_ARQUIVO_NÃO_ENCONTRADO
	}
}

// ------------------------------------------------------------------------

if (!function_exists('checkConditionWhere')) {
	/**
	 * 
	 * Verifica o tipo de requisição e retorna o conteudo dela
	 * 
	 * @since 0.1
	 */
	function checkConditionWhere($string) {
		switch($string) {
			case '<':
			case '>':
			case '=':
				$condition = 1;
				break;
			case '<=':
			case '>=':
				$condition = 2;
				break;
			case 'OR_':
				$condition = 3;
				break;
			case 'AND':
				$condition = 4;
				break;
			default:
				$condition = 0;
		}
		return $condition;
	} // Fim -> checkConditionWhere
}
	
// ------------------------------------------------------------------------

if (!function_exists('dbDebugExit')) {
	function dbDebugExit($exit, $statu_code = 400) {
		if(DEBUG && DBDEBUG) debugExit($exit, $statu_code); 
		exit();
	} // Fim -> dbDebugExit
}

// ------------------------------------------------------------------------

if (!function_exists('debugExit')) {
	function debugExit($exit, $statu_code = 0) {
		if(DEBUG) {
			switch ($statu_code) {
				case 403:
					header('HTTP/1.1 403 Forbidden', true);
					break;
				
				case 400:
					header('HTTP/1.1 400 Bad Request', true);
					break;
				
				case 500:
					header('HTTP/1.1 500 Internal Server Error', true);
					break;
				default:
					header('HTTP/1.1 200 OK', true);
					break;
			}
			if(is_array($exit)) {
				foreach ($exit as $message) {
					echo '<p>'.$message.'</p>';
				}
			}
			echo $exit;
		}
		exit();
	} // Fim -> debugExit
}
	
// ------------------------------------------------------------------------

function setHeaderApi($allowOrigin = '*', $allowHeader = 'Content-Type', $allowMethods = 'GET, POST, PUT, DELETE', $contentType = 'application/json; charset=utf-8') {
	header('Access-Control-Allow-Origin: '.$allowOrigin);
	header('Access-Control-Allow-Headers: '.$allowHeader);
	header('Access-Control-Allow-Methods: '.$allowMethods);
	header('Content-Type: '.$contentType);
	header('X-Content-Type-Options: nosniff');
	header('Content-Language: pt-br');
	header('Cache-Control: no-cache');	
}

// ------------------------------------------------------------------------

function sweetAlert() {
	echo '<script src="'.uri('core').'sweetalert2.all.min.js"></script>';
}