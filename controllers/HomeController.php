<?php
class HomeController extends ControllersPrivate {
   function __construct($args) {
      parent::__construct($args);
      $this->setRequired(['manager']);
   }
   
   function index(){
     /*  $newUser = new User('create', ['name' => 'Vagner', 'familyName' => 'Barbosa', 'email' => 'vagner.zaham@gmail.com', 'password' => '123', 'profile' => 'manager']);
      var_dump($newUser->getErrors(), $newUser); */

      $itens = new ItensModel();
      $data['user'] = $this->user;
      $data['rel'] = $itens->pegarDados();
     
      $this->loadTemplateView('template','consultar', $data);
   }

   public function teste(){

      $data = ['Raphael' => 'Rafael quer brincar', 'NomedoVagner' => $this->user];
      $this->loadTemplateView('testetemplate','teste', $data);
   }
}