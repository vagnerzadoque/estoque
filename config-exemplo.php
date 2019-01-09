<?php
defined('BASEPATH') OR exit('Nenhum acesso direto ao script é permitido');

/*
 * ------------------------------------------------------
 *  BANCO DE DADOS
 * ------------------------------------------------------
 */
define('DBHOSTNAME', 'localhost');
define('DBUSERNAME', '?');
define('DBPASS'    , '?');
define('DB'        , '?');
define('DBPREFIX'  , '');
define('DBCHARSET' , 'utf8');
define('DBCOLLAT'  , 'utf8_general_ci');
define('DBDEBUG'   , true);

/*
 * ------------------------------------------------------
 *  MVC
 * ------------------------------------------------------
 */
define('DEFAULT_CONTROLLER', 'home');
define('DEFAULT_METHOD'    , 'index');
define('DEBUG'             , true);

// Quantidade de minutos em que será armazenado o cache da sessão
define('SESSION_CACHE', 30);
