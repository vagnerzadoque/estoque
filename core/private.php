<?php
defined('BASEPATH') OR exit('Nenhum acesso direto ao script é permitido');
class ControllersPrivate extends Controllers {
	/**
	 * $user
	 *
	 * Dados usuário
	 *
	 * @access public
	 */
	public $user;

	/**
	 * $permissionRequired
	 *
	 * Permissão necessária
	 *
	 * @access protected
	 */
	protected $permissionRequired = array('any');

	/**
	 * $loginRequired
	 *
	 * Se a página precisa de login
	 *
	 * @access protected
	 */
	protected $loginRequired = false;

	/**
	 * Usuário logado ou não
	 *
	 * Verdadeiro se ele estiver logado.
	 *
	 * @public
	 * @access public
	 * @var boolean
	 */
	public $loggedIn = false;

	/**
	 * $redirect
	 *
	 * Onde devemos redirecionar o usuário logado,
	 * mas que não tem permissão de acesso
	 *
	 * @access protected
	 */
	protected $redirect;

	/**
	 * Dados do usuário
	 *
	 * @public
	 * @access public
	 * @var array
	 */
	public $userdata;

	/**
	 * Mensagem de erro para o formulário de login
	 *
	 * @public
	 * @access public
	 * @var string
	 */
	public $message;

	/**
	 * Instância de CRUD
	 *
	 * @public
	 * @access public
	 */
	public $db;

	function __construct($arguments) {
         
		parent::__construct($arguments);
		
		// Caso a sessão não esteja iniciada, inicia a sessão
		if(!isset($_SESSION)) {
		   session_cache_expire(SESSION_CACHE);
		   ini_set('session.cookie_lifetime', 0);
		   ini_set('session.use_strict_mode', 'On');
		   ini_set('session.cookie_httponly', 'On');
		   ini_set('session.gc_maxlifetime', SESSION_CACHE * 60);
		   session_start();
		}
		
		if(!isset($_SESSION['id'])) $_SESSION['id'] = session_id();

		$this->user = $this->getUser($_SESSION['id']);

		if(!isset($_SESSION['loggedIn'])) $_SESSION['loggedIn'] = $this->user->loggedIn();
		if(!isset($_SESSION['user'])) $_SESSION['user'] = $this->user->id;
		if(!isset($_SESSION['home'])) $_SESSION['home'] = $this->user->home;
	}
	/**
	* setRequired
	*
	* Atribui o valor true para a variavel $loginRequired dessa classe
	*
	* Atribui o valor informado nessa função para a variavel $permissionRequired dessa classe
	*
	* Executa a função checkLogin()
	*
	* @since 0.1
	* @access protected
	*/
	protected function setRequired ($permission = false, $redirect = false) {
		
		//Se não for enviada a(s) permissão(ões) ou a(s) permissão(ões) não for um array não iremos fazer nada
      if (!$permission || !is_array($permission)) return;
      
		// iremos alterar o direcionamento padrão para o controller informado
		if($redirect) $this->redirect = $redirect;

		// indicamos que o login é necessário
		$this->loginRequired = true;

		// informamos a(s) permissão(ões) necessária(s)
		$this->permissionRequired = $permission;

		// executamos a função responsável pelas verificações de usuário e permissões
		$this->checkLogin();

	}// Fim -> setRequired();

	/**
	* checkLogin
	*
	* Executa a função check_userlogin() de UserLogin.class.php
	*
	* @since 0.1
	* @access protected
	*/
	protected function checkLogin() {

		// Se o usuário não estiver logado redireciona
		if ($_SESSION['loggedIn'] === false) {
			$_SESSION['loginRequired'] = $this->navigation['controller'];
			$_SESSION['loginRequired'].= $this->navigation['method'] !== 'index' ? '/'.$this->navigation['method'] : '';
			navTo('login');
			exit();
		}
		if($this->user === NULL) $this->user = $this->getUser();
		
		$redirect = empty($this->redirect) ? $this->user->home : $this->redirect;

      // Se o usuário estiver logado e não tiver permissão redireciona para $controller informado na função
      if(!$this->checkPermissions($this->permissionRequired, $this->user->profile)) navTo($redirect);
	}// Fim -> checkLogin();

   protected function getUser($id = 0) {
      static $user;

      if(empty($user)) $user = new User($id);

      return $user;
   }

	protected function nova_senha() {
 		if(isset($_POST['nova_senha'])){

 			$password = base64_encode($_POST['nova_senha']);
 			$password = md5($password);
 			$values 	= [
 				'senha'			=> $password,
 				'alterarsenha' => 0
 			];
 			$this->db = new CRUDModel();
 			// Verifica se o usuário existe na base de dados
 			$query = $this->db->update( 'p1_usuarios', 'codusuario', $_SESSION['userdata']['codusuario'], $values );

 			if($query['linhas'] === 1) {

 				// Configura a propriedade dizendo que o usuário está logado
 				$this->loggedIn 							= true;
 				// Informa a sessão que o usuário foi logado
 				$_SESSION['status']['logado'] = $this->loggedIn;
 				return true;
 			}
 				$this->loggedIn = false;
 				$_SESSION['mensagem'] = [
 					'status'	=> true,
 					'tipo'		=> 'erro',
 					'texto'		=> 'Não foi possível gravar a nova senha na base de dados! Por favor, contate o administrador do sistema'
 					];

 				return false;
 		}
	 }// Fim -> nova_senha

	/**
	 * Verifica permissões
	 *
	 * @param string $required A permissão requerida
	 * @param array $user_permissions As permissões do usuário
	 * @final
	 */
	protected function checkPermissions($required = array('any'), $user_permissions = 'any') {
		// Se o usuário não tiver permissão retorna falso
		if (!in_array( $user_permissions, $required ) && $required[0] !== 'any') return false;
      
      // Se o usuário tiver permissão retorna verdadeiro
		return true;

	}// Fim -> checkPermissions

  protected function check_post(){
    if(!isset($_POST['edit_profile']) || !is_array($_POST['edit_profile']))
    {
      return array('status' => false);
    }
    if(isset($_POST['edit_profile']['remove_foto']) && $_POST['edit_profile']['remove_foto'] === 'remover')
    {
      $retorno['foto'] = uri(VIEWS . '/imagens/foto_profile/sem_foto.png');
    }
    if(isset($_POST['edit_profile']['nova_senha']) && !empty($_POST['edit_profile']['nova_senha']))
    {
      $password         = base64_encode($_POST['edit_profile']['nova_senha']);
      $retorno['senha'] = md5($password);
    }
    if(isset($_POST['edit_profile']['email']) && $_POST['edit_profile']['email'] !== $_SESSION['userdata']['email'])
    {
      $retorno['email'] = strtolower($_POST['edit_profile']['email']);
    }
    if(isset($_FILES['foto_profile']) && !empty($_FILES['foto_profile']['name']))
    {
      $ext_aceita = array('gif','jpg','jpe','jpeg','png');
      $extensao   = explode ( '.' , $_FILES['foto_profile']['name']);
      if(in_array (strtolower(end($extensao)) , $ext_aceita))
      {
        $nome_foto  = md5($_SESSION['userdata']['codusuario']);
        $uploadfile = VIEWS_DIR . '/imagens/foto_profile/' . $nome_foto . '.';
        $uploadfile.= end($extensao);
        if(move_uploaded_file($_FILES['foto_profile']['tmp_name'], $uploadfile)) {
          $foto = uri(VIEWS . '/imagens/foto_profile/' . $nome_foto . '.');
          $foto.= end($extensao);
          $retorno['foto'] = $foto;
        }
      }
    }
    if(isset($retorno['foto']) || isset($retorno['senha']) || isset($retorno['email']))
    {
      $retorno['status'] = true;
    }
    else{
      $retorno['status'] = false;
    }
    return $retorno;
  }
}// Fim -> Class Usuarios
