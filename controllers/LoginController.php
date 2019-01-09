<?php
class LoginController extends ControllersPrivate {
   function __construct($args) {
      parent::__construct($args);
      if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) navTo($_SESSION['home']);
   }

   function index() {
      $this->loadView('login');
   }

   function authenticate() {
      if(!isset($_POST['email']) && !isset($_POST['password'])) exit();
      $email = strip_tags(trim(filter_input(INPUT_POST,'email', FILTER_SANITIZE_URL)));
      $password = strip_tags(trim(filter_input(INPUT_POST,'password', FILTER_SANITIZE_URL)));
      $user = new User($email, $password, false);

      if($user->id === 0) exit(json_encode(['cod' => 1, 'title' => 'Usuário ou senha está errado', 'text' => 'Tente novamente']));
      if($user->active === false) exit(json_encode(['cod' => 1, 'title' => 'Usuário Bloqueado', 'text' => 'Seu acesso ao sistema está bloqueado, procure o gerente do sistema para mais informações!']));
      if($user->changePassword) exit(json_encode(['cod' => 2, 'user' => $user]));
      if($user->activeSession) {
         $update = [
            'sessionID' => NULL,
            'loginDate' => NULL,
         ];
         $user->update($user->id, $update);
         exit(json_encode(['cod' => 3, 'user' => $user]));
      }
      exit(json_encode(['cod' => 4, 'user' => $user]));
   }

   function newpass() {
      if(!isset($_POST['id']) && !isset($_POST['password'])) exit();
      $id = (int)strip_tags(trim(filter_input(INPUT_POST,'id', FILTER_SANITIZE_URL)));
      $password = strip_tags(trim(filter_input(INPUT_POST,'password', FILTER_SANITIZE_URL)));
      $user = new User($id, false, false);
      $password = $user->transformToPassword($password);

      if($user->checkPassword($password, false)) exit(json_encode(['status' => false, 'message' => 'A nova senha deve ser diferente da antiga']));

      if ($user->newPassword($password, false)) exit(json_encode(['status' => true]));

      echo json_encode(['status' => false, 'message' => 'Falha ao tentar gravar nova senha, contate o administrador do sistema']);
   }

   function startsessionlogin() {
      if(empty($_POST)) exit();
      $loginDate = date('Y-m-d H:i:s');
      $id = (int)$_POST['user']['id'];
      $user = new User($id, false, false);
      $update = [
         'sessionID' => $_SESSION['id'],
         'loginDate' => $loginDate,
      ];

      $check = $user->update($id, $update);
      
      $_SESSION['loggedIn'] = true;
      $_SESSION['user'] = $id;
      $_SESSION['home'] = $_POST['user']['home'];
      echo json_encode(['status' => $check['status']]);
   }
}