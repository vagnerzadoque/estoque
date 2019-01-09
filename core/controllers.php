<?php
/**
 * Controller - Todos os controllers deverão estender essa classe
 *
 * @package Escolha Resultado Produto 1 Lead
 * @since 0.1
 */
class Controllers {
   
	/**
	 * $parametros
	 *
	 * @access protected
	 * protected $parameters = array();
	 */

	/**
	 * $navigation
	 *
	 */
	protected $navigation;

	/**
	 * $get
	 *
	 */
	protected $get;

	/**
	 * $data
	 *
	 */
	protected $data;

	/**
	 * $views_list_up
	 *
	 */
	protected $views_list_up;

	/**
	 * $views_list_down
	 *
	 */
	protected $views_list_down;


	protected $view = false;
	
	protected $variables = false;


	/**
	 * Construtor da classe
	 *
	 * Configura as propriedades e métodos da classe.
	 *
	 * @since 0.1
	 * @access public
	 */

	public function __construct ($arguments) {
		$this->navigation = isset($arguments['navigation']) ? $arguments['navigation'] : NULL;
		$this->get = isset($arguments['get']) ? $arguments['get'] : false;

      if($this->get !== false) $_GET = $this->get;
      
		//Atribuindo o array que é enviando como parametro na chamada do controller na variavel $parametros dessa classe
		// var_dump($this->parameters);

		// Verifica se o login é necessário
		if(isset($this->login_required) && $this->login_required) $this->check_login();
	} // __construct


	/**
	* get_header
	*
	* Carrega, por padrão, o head global e local
	* e também carrega, por padrão, as folhas de estilo do bootstrap e font awesome
	*
  * @param boolean $global_css Caso true irá carregar os arquivos de css globais
  * @param boolean $local_head Caso true irá importar o head do controlador em execução
  * @return void
	* @since 0.1
	* @access protected
	*/
	protected function loadView($addresses = false, $variables = false) {

		static $_variables;

		if($variables !== false && is_array($variables)) {
			foreach ($variables as $var => $value) {
				$_variables[$var] = $value;
			}
		}	
	
		if(is_string($variables)) {
			
			if(strpos($variables, ',') !== false) {
				$variables = explode(',', $variables);
			} else {
				$variables = array($variables);
			}
			
			foreach ($variables as $statement) {
				$var_name  = substr($statement, 0, strpos($statement, ':'));
				$position  = strpos($statement, ':') + 1;
				$var_value = substr($statement, $position);
			}
			
			if(!empty($var_name) && !empty($var_value)) $_variables[$var_name] = $var_value;
		}
	
		if(!empty($_variables)) extract($_variables);
		
		if (is_string($addresses)) {
			if(file_exists(VIEWSPATH.DIRECTORY_SEPARATOR.$addresses.'.html')) $file = VIEWSPATH.DIRECTORY_SEPARATOR.$addresses.'.html';
			if(file_exists(VIEWSPATH.DIRECTORY_SEPARATOR.$addresses.'.php')) $file = VIEWSPATH.DIRECTORY_SEPARATOR.$addresses.'.php';
			if(isset($file)) include $file;
		} else if(is_array($addresses)) {
			foreach($addresses as $address) {
				if(file_exists(VIEWSPATH.DIRECTORY_SEPARATOR.$address.'.html')) $file = VIEWSPATH.DIRECTORY_SEPARATOR.$address.'.html';
				if(file_exists(VIEWSPATH.DIRECTORY_SEPARATOR.$address.'.php')) $file = VIEWSPATH.DIRECTORY_SEPARATOR.$address.'.php';
				if(isset($file)) include $file;
			}
		}

	}// Fim -> load_view();

	protected function loadTemplateView($template = false, $view = '', $variables = false) {
		
		$this->view = $view;
		$this->variables = $variables;
      
		$this->loadView($template, $variables);
	}// Fim -> load_view();

	public function loadViewInTemplate() {
		$this->loadView($this->view, $this->variables);
	}

	public function loadModel($model_name = true, $parameters = false) {
		$file = MODELSPATH.DIRECTORY_SEPARATOR.$model_name.'.php';

      if(file_exists($file) && !is_dir($file)) require_once $file;
      
		// Verifica se a classe existe
		if (class_exists($model_name)) {
			if($parameters !== false) return new $model_name($parameters);
			return new $model_name();
		}
	} // load_model
}
