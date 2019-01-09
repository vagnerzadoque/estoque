<?php
/**
 * Escolha Soluções MVC 
 */
class ESMVC {

	/**
	* $controlador
	*
	* Receberá o valor do controlador (Vindo da URL).
	* exemplo.com/controlador/
	*
	* @access private
	*/
	private $controllerName;

	/**
	* $controller
	*
	* Receberá o prefixo mais o nome do controlador (Vindo de PREFIXO_CONTROLADOR.$controlador.'php').
	* exemplo: 'controller-home.php'
	*
	* @access private
	*/
	private $controller;

	/**
	* $acao
	*
	* Receberá o nome do metodo (Também vem da URL):
	* exemplo.com/[controller-class]/[controller-method]
	*
	* @access private
	*/
	private $method;

	/**
	* $parameters
	*
	* Receberá um array dos parâmetros (Também vem da URL):
	* exemplo.com/controlador/acao/param1/param2/param50
	*
	* @access private
	*/
	private $parameters;

	/**
	* $arguments
	*
	* Receberá os argumentos que serão passados ao método (Também vem da URL):
	* exemplo.com/[controller-class]/[controller-method]/[controller-method-argument1]/[controller-method-argument2]/[controller-method-argument3]...
	*
	*/
	private $arguments;

	/**
	* $import
	*
	* Respossavél pelas importações
	*
	* @access private
	*/
	private $import;

	/**
	 * Construtor para essa classe
	 *
	 * Obtém os valores do controlador, ação e parâmetros. Configura
	 * o controlado e a ação (método).
	 */
	public function __construct () {
      
		// Obtém os valores do controlador, ação e parâmetros da URL.
		// E configura as propriedades da classe.
		$this->getUrlData();

		if($this->controllerName === 'sair' OR $this->method === 'sair') {
			session_start();

			if(isset($_SESSION['expiredSession'])) {
				require COREPATH.DIRECTORY_SEPARATOR.'alert.php';
				dialog('Seu tempo de conexão expirou', 'warning', 2.1, 'center');
			}

			if(isset($_SESSION['otherLogin'])) {
				require COREPATH.DIRECTORY_SEPARATOR.'alert.php';
				dialog('O usuário dessa sessão se logou em outro local', 'warning', 2.1, 'center');
			}

			if(isset($_SESSION['user']) && $_SESSION['user'] !== 0) {
				$db = new Models('users');
				$db->update($_SESSION['user'], ['sessionID' => null, 'loginDate' => null]);
			}
			// Remove tudo de $_SESSION
			$_SESSION = array();
			// Acaba com a sessão
	      session_destroy();
			navTo();
		}

		/**
		 * Verifica se o controlador existe. Caso contrário, adiciona o
		 * controlador padrão (controllers/home-controller.php) e chama o método index().
		 */
		// if ( ! $this->controlador ) {
		// 	// Atribui o valor 'home' ao controlador
		// 	$this->controlador = $route['default_controller'];
		//
      // }
		switch ($this->controllerName) {
			case 'e1':
			case 'e1_controllers':
			case 'e1_models':
			case 'e1_views':
				navTo();
				return;
				break;
			case '19ad89bc3e3c9d7ef68b89523eff1987':
				$install = new InstallTableUser();
				if($this->method === 'api') { 
					$install->api();
				} else {
					$install->index();
				}
				break;

			default:
			// if($this->controlador === '404')
			// {
			// 	$this->controlador = 'erro';
			// }
			//Se foi passado um controller iremos instanciar o atributo controller.
			$controllerName = ucwords($this->controllerName);

			if(empty($this->method) OR $this->method === NULL) {
				$this->method = DEFAULT_METHOD;
				$this->parameters['navigation']['method'] = DEFAULT_METHOD;
				$this->parameters['navigation']['urlLong'] = uri($this->controllerName.'/'.$this->method, false);
			}
			
			$this->parameters['navigation']['url'] = uri($this->controllerName.'/'.$this->method, false);
			$this->parameters['navigation']['urlFull'] = $this->parameters['navigation']['urlLong'];

			if(!empty($this->parameters['get'])) {
				$queryParams = '?';
				foreach($this->parameters['get'] as $key => $value) {
					$queryParams .= $key.'='.$value;
				}
				$this->parameters['navigation']['urlFull'] .= $queryParams;
			} 

			// Remove caracteres inválidos do nome do controlador para gerar o nome
			// da classe. Se o arquivo chamar "news-controller.php", a classe deverá
			// se chamar NewsController.

			$this->controller = ucwords(preg_replace('/[^a-zA-Z0-9]/is', ' ', $controllerName.CONTROLLERSUFFIX));

	 		$this->controller = str_replace(" ", "", $this->controller);

			// Cria o objeto da classe do controlador e envia os parâmentros
			$this->controller = new $this->controller($this->parameters);
         
			// Remove caracteres inválidos do nome da ação (método)
			$this->method = strtolower(preg_replace( '/[^a-zA-Z0-9]/is', '_', $this->method ));
			// Se o método indicado existir, verificaremos se ele pode ser chamado
			if(method_exists( $this->controller, $this->method)) {
				// Se o método pode ser chamado iremos verificar se foi enviado argumentos 
				if(is_callable(array($this->controller, $this->method))) {
					// Se foi enviado argumentos executa o método e envia os argumentos
					if(is_array($this->arguments)) {
						call_user_func_array(array($this->controller, $this->method),$this->arguments);
					} else {
						$this->controller->{$this->method}();
					}
	
					// FIM :)
					return;
				}
			}
			echo '<h1>404</h1>';
		  // goto_page(uri(404));
			return;
		}
	} // Fim -> __construct

	/**
	* Configura as propriedades
	* $this->controlador, $this->acao e $this->parametros
	*
	* A URL deverá ter o seguinte formato:
	* http://www.example.com/controlador/acao/parametro1/parametro2/etc...
	*/
	public function getUrlData () {

		// Verifica se o parâmetro path foi enviado
		if (isset( $_GET['url'])) {
		   $getUrl = false;
	      // Captura o valor de $_GET['url']
	      $getUrl['url'] = strip_tags(trim(filter_input(INPUT_GET,'url', FILTER_SANITIZE_URL)));

	      if(count($_GET) > 1) {
	         unset($_GET['url']);
				foreach ($_GET as $key => $value) {
	      	   $getUrl['get'][$key] = strip_tags(trim(filter_input(INPUT_GET, $key, FILTER_SANITIZE_STRING, [FILTER_FLAG_STRIP_LOW, FILTER_FLAG_STRIP_HIGH, FILTER_FLAG_STRIP_BACKTICK])));
					$_GET[$key] =  $getUrl['get'];
				}
				$this->parameters['get'] = $getUrl['get'];
	      }

			
			// Obtem o array de parâmetros
			// $url = explode('/', $getUrl['url']);
			if(substr($getUrl['url'], -1) === '/') {
				$url = substr($getUrl['url'], 0, -1);
			} else {
				$url = $getUrl['url'];
			}

			$this->parameters['navigation']['urlLong'] = uri($url, false);
         
			$url = explode('/', $url);

			// Configura as propriedades
			$this->controllerName = checkArray( $url, 0 );
			$this->method = checkArray( $url, 1 );
			$this->parameters['navigation']['controller'] = $this->controllerName;
			$this->parameters['navigation']['method'] = $this->method;

			// Configura os parâmetros
			if ( checkArray( $url, 2 ) ) {
				unset( $url[0] );
				unset( $url[1] );

				// Os parâmetros sempre virão após a ação
				$this->arguments = array_values( $url );
			}
		} else {
			$this->parameters['navigation']['controller'] = DEFAULT_CONTROLLER;
			$this->controllerName = DEFAULT_CONTROLLER;
		}
	} // getUrlData

	protected function checkRouterConfig($config, $args = array(), $url = '') {
		$verification		 = explode('/', $config);
		$r['controller'] = $verification[0];
      unset($verification[0]);
      
		if(isset($verification[1])) {
			if(strpos($verification[1], '(:') !== false OR $verification[1] === 'index') {
				$r['method'] = $verification[1];
				unset($verification[1]);
			} else {
				$r['method'] = 'index';
			}
      }
      
		if(!empty($args)) $r['args'] = $args;

		if(isset($r['controller'])) {
			if(!empty($url)) {
				$nav = explode('/',$url);
				$this->parameters['navigation']['url'] = array_values($nav);
			}
		}

		$this->parameters['navigation']['controller'] = $r['controller'];
		$this->parameters['navigation']['method'] 	 = $r['method'];

		return $r;
	}

}
