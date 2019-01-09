<?php
defined('BASEPATH') OR exit('Nenhum acesso direto ao script é permitido');

/**
 * 
 * Usuários da estrutura mvc
 * @version 0.0.2
 * 
 */
class User extends Models {
   public $id = 0;
   public $name = 'Visitante';
   public $familyName = '';
   public $email = '';
   public $home = '';
   public $profile = 'any';
   public $photo = '';
   public $active = true;
   public $changePassword = false;
   public $creationDate = '';
   public $sessionID;
   public $loginDate = '';
   public $activeSession;
   public $delSessionID;
   protected $password;
   protected $errorList = array();

   function __construct($arg1 = 0, $arg2 = false, $arg3 = true) {
      parent::__construct('users');
      if(!$this->checkTable()) navTo(md5('install'));

      if($arg1 === 'create') {
         if(!is_array($arg2) || !isset($arg2['name']) || !isset($arg2['familyName']) || !isset($arg2['email']) || !isset($arg2['password'])) return $this->errorList[] = 'Verifique [NOME || SOBRENOME || EMAIL || SENHA]';
         if($arg3) $arg2['password'] = $this->transformToPassword($arg2['password']);

         $where = [
            0 => [
               'where' => 'email',
               'condition' => 'LIKE',
               'value' => $arg2['email'],
            ]
         ]; 

         $user = $this->select('*', $where, 1);
         if($user['rows'] !== 0) return $this->errorList[] = 'Já existe o email informado!';

         if(!isset($arg2['active'])) $arg2['active'] = 1;
         if(!isset($arg2['changePassword'])) $arg2['changePassword'] = 1;
         if(!isset($arg2['home'])) $arg2['home'] = DEFAULT_CONTROLLER;
         if(!isset($arg2['profile'])) $arg2['profile'] = 'any';

         var_dump($exec = $this->insert($arg2));

         if($exec['status']) {
            if($exec['lastInsert']) $this->setUserData($exec['lastInsert']);
            else $this->errorList[] = 'O usuário foi criado, porém não conseguimos recuperar seu ID para inserir seus dados na instância';
         } else {
            $this->errorList[] = 'Houve algum problema não tradado na inserção dos dados';
         }
         return;
      }

      if(($arg1 !== 0 && $arg1 !== 'create' )&& $arg2 === false) {

         if(is_int($arg1)) {

            $where[0] = [
               'where' => 'id',
               'condition' => 'LIKE',
               'value' => $arg1
            ];
         } else {

            $where[0] = [
               'where' => 'sessionID',
               'condition' => 'LIKE',
               'value' => $arg1
            ];
         }
   
         $user = $this->select('*', $where, 1);

         if($user['rows'] === 1) {
            $this->setUserData($user['query'][0]);
            
            if(!empty($this->loginDate)){
               if($this->expiredSession()) {
                  $this->update($this->id, ['sessionID' => NULL]);
                  $_SESSION['expiredSession'] = true;
                  if($arg3) navTo('sair');
               } else if(time() + 60 > strtotime($this->loginDate)) {
                  $this->loginDate = date('Y-m-d H:i:s');
                  $this->update($this->id, ['loginDate' => $this->loginDate]);     
               }
            }
         } else {
            if(isset($_SESSION['user']) && $_SESSION['user'] !== 0) {
               $_SESSION['otherLogin'] = true;
               navTo('sair');
            } 
         }

      }

      if($arg1 && $arg2) {
         $where = [
            0 => [
               'where' => 'email',
               'condition' => 'LIKE',
               'value' => $arg1,
               'expression' => 'AND',
            ],
            1 =>  [
               'where' => 'password',
               'condition' => 'LIKE',
               'value' => $this->transformToPassword($arg2),
            ],
         ]; 
         $user = $this->select('*', $where, 1);
         if($user['rows'] === 1) $this->setUserData($user['query'][0]);
      }

      if($this->name === 'Visitante' && empty($this->sessionID)) $this->sessionID = $_SESSION['id'];

   
   }//FIM -> __construct

   protected function setUserData($data) {
      if(!is_array($data)) return;

      extract($data);
   
      $this->id             = (int)$id;
      $this->name           = $name;
      $this->familyName     = $familyName;
      $this->email          = $email;
      $this->password       = $password;
      $this->home           = $home;
      $this->profile        = $profile;
      $this->photo          = $photo;
      $this->active         = $active === '0' ? false : true;
      $this->changePassword = $changePassword === '0' ? false : true;
      $this->creationDate   = $creationDate;
      $this->loginDate      = $loginDate;
      $this->sessionID      = $sessionID;
      $this->activeSession = empty($this->loginDate) ? false : !$this->expiredSession();
      $this->delSessionID  = $this->activeSession ?$this->sessionID : '';
   }

   public function getName($length = 0, $end_name = false) {
      
      if($length > 0 && $length <=3) return '...';

      $familyName = explode(' ', $this->familyName);

      if($end_name) {
         $familyName = end($familyName);
         $full_name = $this->name.' '.$familyName;
      } else {
         $full_name = $this->name.' '.$this->familyName;
      }

      if($length === 0) return $full_name;

      if(strlen($this->name) > $length) {
         $length = $length - 3;
         $name   = substr($this->name, 0, $length);
         return $name.'...';
      }

      if(strlen($this->name) === $length OR strlen($this->name) + 1 === $length) return $this->name;

      if(strlen($full_name) <= $length) return $full_name;

      $familyName  = explode(' ', $full_name);
      $name       = $familyName[0];
      unset($familyName[0]);
      $_familyName = array_values($familyName);
      $while      = $full_name;
      $short      = '';

      while (strlen($while) > $length) {
         $limit  = count($_familyName);
         $limit  = $limit - 1;
         if(count($_familyName) > 1){
            for ($i=0; $i < $limit; $i++) {
            $first  = ucfirst($_familyName[$i]);
            $second = substr($first, 0, 1);
            if($short !== '') {
               $short .= ' '.$second.'.';
            } else {
               $short .= $second.'.';
            }
            unset($_familyName[$i]);
            }
            $while = $name.' '.$short.' '.end($_familyName);
         } elseif(count($_familyName) === 1 && $short !== '') {
            $short = str_replace ('.', '', $short);
            $while = $name.' '.$short.' '.end($_familyName);
            $short = '';
            $last  = TRUE;
         } elseif(isset($last)) {
            $while = $name.' '.end($_familyName);
            $_familyName = array();
         } else {
            $while = $this->name;
         }
      }
      return $while;



      //
      //   $name = $this->name.' '.$short.' '.end($familyName);
      //
      //   if(strlen($name) < $length)
      //   {
      //     return $name;
      //   }
      //
      //   $new_short = explode(' ', $short);
      //   $new_short = implode('', $new_short);
      //   $name      = $this->name.' '.$new_short. ' '.end($familyName);
      //
      //   if(strlen($name) < $length)
      //   {
      //     return $name;
      //   }
      //
      //   $name      = $this->name.' '.$new_short. ' '.end($familyName);
      //
      //   $first  = ucfirst(end($familyName));
      //   $second = substr($first, 0, 1);
      //   $name   = $this->name.' '.$short.' '.$second.'.';
      //
      //   if(strlen($name) < $length)
      //   {
      //     return $name;
      //   }
      //
      //   $name = $this->name.' '.$new_short.$second.'.';
      //
      //   if(strlen($name) < $length)
      //   {
      //     return $name;
      //   }
      // }
      // A partir daqui quem passou um Sobrenome
   }// FIM-> getName

   public function newPassword($password, $changePassword = true) {
      $update = ['password' => $password];
      $update['changePassword'] = $changePassword ? 1 : 0;
      $check = $this->update($this->id, $update);

      return $check['rows'] === 1;
   }

   public function validateSession($sessionID) {
       return false;
      return true;
   }

   public function getEmail($length = 0, $suffix = '...') {
      if($length <= strlen($suffix)) return $this->email;

      if(strlen($this->email) > $length) {
         $length = $length - strlen($suffix);
         $email  = substr($this->email, 0, $length);
         $email .= $suffix;
      } else {
         $email = $this->email;
      }

      return $email;
   }// FIM -> getEmail

   public function loggedIn() {
      if($this->id > 0) {
         if(empty($this->sessionID)) return false;
         return true;
      } else {
         return false;
      }
   }

   public function expiredSession() {
      return time() - strtotime($this->loginDate) > SESSION_CACHE * 60;
   }

   public function transformToPassword($pass) {
      $check = base64_encode($pass);
      $check = md5($check);
      return $check;
   }

   public function checkPassword($password = '', $transforme = true) {
      if($transforme) {
         $check = base64_encode($password);
         $check = md5($check);
      } else {
         $check = $password;
      }
      return $check === $this->password;
   }// FIM -> checkPassword

   public function getErrors() {
      if(empty($this->errorList)) return false;
      return $this->errorList;
   }
}
