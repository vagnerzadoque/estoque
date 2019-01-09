<?php
defined('BASEPATH') OR exit('Nenhum acesso direto ao script é permitido');
/**
 * Classe para gerenciamento da base de dados
 * @version 0.0.3
 */
class Models {
  /** Crud properties */
  
	/**
	 * $pdo
	 *
	 * Nossa conexão com o BD
	 *
	 * @access private
	 */
	private $pdo = NULL;

	private $internalSelect = false;

	/**
	 * $error
	 *
	 * Configura o erro
	 *
	 * @access private
	 */
	private $error = NULL;

	/**
	 * $error
	 *
	 * Último ID inserido
	 *
	 * @access private
	 */
	private $lastInsertId = NULL;

	/**
	 * $table_prefix
	 *
	 * Prefixo das tabelas do banco
	 *
	 * @access private
	 */
	public $table;

	/**
	 * $table_prefix
	 *
	 * Prefixo das tabelas do banco
	 *
	 * @access private
	 */
	public $pk = 'id';

	/**
	 * $table_prefix
	 *
	 * Prefixo das tabelas do banco
	 *
	 * @access private
	 */
	private $rules = array();

	/**
	 * $pdo
	 *
	 * Nossa conexão com o BD
	 *
	 * @access private
	 */
	private $required = array();

   function __construct($table = '') {
		// Se estiver ativo o deubg iremos testar a conexão com o banco
		if(DBDEBUG){
			$check_connect = $this->connect();
			if($check_connect['error']) dbDebugExit($check_connect['message'], 500);
		}

		$this->table = DBPREFIX.$table;
   }

  /**
   * Cria a conexão PDO
   *
   * @since 0.1
   * @access private
   */
   protected function connect() {

		/* Monta os detalhes da nossa conexão PDO */
		$pdo_details  = 'mysql:host='.DBHOSTNAME.';';
		$pdo_details .= 'dbname='.DB.';';
		$pdo_details .= 'charset='.DBCHARSET.';';

		// Tenta conectar
		try {

			$this->pdo = new PDO($pdo_details, DBUSERNAME, DBPASS, array (PDO::MYSQL_ATTR_FOUND_ROWS => true));
			// Configura o PDO ERROR MODE
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			return array('error' => false);
		} catch (PDOException $e) {
			return array(
				'error'   => true,
				'cod'	    => $e->getCode(),
				'message' => $e->getMessage()
			);

			// Kills the script
			die();
		} // catch
  } // Fim -> connect
  
  // ------------------------------------------------------------------------
   public function checkTable() {
	   return $this->query('SELECT COUNT(*) FROM '.$this->table)['status'];
   }

  // ------------------------------------------------------------------------

	/**
	 * query - Consulta PDO
	 *
	 * @since 0.1
	 * @access public
	 * @param string $statement String com a declaração da consulta
	 * @param array $data_array Array opcional com os valores da declaração
	 * @return array 
	 */

	public function query($statement, $data_array = array()) {
    /* exit(json_encode(array($statement,$data_array))); */
    // Se não existir a conexão, conecta
		if($this->pdo === NULL) $this->connect();

		try {
			// Prepara e executa
			//echo "<h1>$statement</h1>";
			$query = $this->pdo->prepare($statement);
			$query->execute($data_array);
			$sucess = true;
		} catch (PDOException $e) {
			$sucess =  false;
			if(DBDEBUG) {
				$error	= [
					'cod'	 	 => $e->getCode(),
					'message' => $e->getMessage()
				];
			} else {
				$error	= [
					'cod'	 	 => 0,
					'message' => ''
				];
			}
      }
    
		// Verifica se a consulta aconteceu com sucesso
		if($sucess) {
			return [
				'status' => true,
				'rows'	=> $query->rowCount(),
				'query'	=> $query,
				'error'  => false,
			];

		} else {
			return [
				'status' => false,
				'error'  => $error
			];
		}
  }// Fim -> query
  
  // ------------------------------------------------------------------------

	/**
	 * query - Consulta PDO
	 *
	 * @since 0.1
	 * @access public
	 * @param array $where Array os termos da declaração
	 * @return array 
	 */

	protected function getWhere($where, $get_id = false){
		// Se $where não for um array não prossiga
		if(!is_array($where)) return;
		
		// Criando a condição onde
		$statement_where = ' WHERE';
		$question_value = array();
		if(isset($where['order'])){
			$order = $where['order'];
			unset($where['order']);
		}
		// Intero sobre os termos buscandos as regras
		foreach($where as $rules) {
			// Se as regras não estiverem corretas interrompemos a interação
			if(!is_array($rules) || !isset($rules['where']) || !isset($rules['value'])) break;

			// (Obs.: Se Existir) Capturamos a ordenação e pulamos para próxima interação
			/* if($rules['where'] === 'orderBy' || $rules['where'] === 'orderByDESC') {
				$order = [
					strpos($rules['where'], 'DESC') > 0 ? 'DESC' : 'ASC' => $rules['value'] 
				];
				continue;
			} */
			if($get_id) continue;
			// Se estivermos começando a aplicação de uma nova regra colocamos a expresão
			if(isset($expression)) {
				$statement_where .= $expression;
				unset($expression);
			}

			if($rules['value'] === '__NULL') {
				// Escrevendo a string da condição WHERE
				$statement_where .= ' '.$this->table.'.'.$rules['where'].' ';
				$statement_where .= 'IS';
				$statement_where .= ' NULL';

			} else if($rules['value'] === '__NOT_NULL') {
				// Escrevendo a string da condição WHERE
				$statement_where .= ' '.$this->table.'.'.$rules['where'].' ';
				$statement_where .= 'IS NOT';
				$statement_where .= ' NULL';
			} else {
				// Escrevendo a string da condição WHERE
				$statement_where .= ' '.$this->table.'.'.$rules['where'].' ';
				$statement_where .= isset($rules['condition']) ? $rules['condition'] : '=';
				$statement_where .= ' ?';
	
				// Se foi não passada regra de condição OR é setado para próxima interação
				$expression = isset($rules['expression']) ? ' '.$rules['expression'] : ' OR';
				
				// Valor correspondentes as ? da declaração
				$question_value[] = $rules['value'];
			}
		}// FIM -> foreach
		if($statement_where === ' WHERE' && !$get_id) {

			// Se não foi recebido nenhuma regra para WHERE e ORDER BY retorna array vazio
			if(!isset($order)) return array();
	
			// Se houve regras ORDER BY retorna um array só com o indice order
			if(isset($order)) return array('order' => $order);
		}
		if($get_id){
			return array(
				'statement' => $statement_where.' '.$this->pk.' = ?',
				'value' => array($get_id),
				'order' => isset($order) ? $order : false
			);
		}
		// Se houve regras WHERE retornaremos todas as regras corretas
		return array(
			'statement' => $statement_where,
			'value' => $question_value,
			'order' => isset($order) ? $order : false
		);
		
  }// Fim -> getWhere
  
  // ------------------------------------------------------------------------

	/**
	 * select - Consulta PDO
	 *
	 * @since 0.1
	 * @access public
	 * @param string $statement String com a declaração da consulta
	 * @param array $data_array Array opcional com os valores da declaração
	 * @return array 
	 */

	public function select($columns = '*', $where = array(), $limit = false){

		// Garantindo que $columns será uma string na montagem da declaração
		if(is_array($columns) && !empty($columns)){
			if(isset($columns['join'])) {
				if(!isset($columns['count'])) {
					$l = 0;
					foreach ($columns['join'] as $key => $value) {
						if($l === 0 && $key === 'inner') {
							$table_join = TABLE_PREFIX.$value;
							$join = ' INNER JOIN '.$table_join.' ON ';
						}
						if($l === 1) {
							$join .= $this->table.'.'.$key.' = ';
							$join .= $table_join.'.'.$value;
						} 
						$l++;
					}
				}
				unset($columns['join']);
			}
			
			if(isset($columns['count'])) {
				$count = $columns['count'];
				unset($columns['count']);
			}

			if(isset($columns['group'])) {
				$group = $columns['group'];
				unset($columns['group']);
			}

			if(empty($columns)) $columns = '*';
			else $columns = implode(', ', $columns);
		} 
		if(!is_string($columns)) $columns = '*';
		
		// Montagem da declaração
		if(isset($count)) {
			if($columns === '*') $statement = "SELECT COUNT(*) FROM {$this->table}";
			else $statement = "SELECT {$columns}, COUNT(*) FROM {$this->table}";
		} else {
			$statement = "SELECT {$columns} FROM {$this->table}";
		}
		$statement.= isset($join) ? $join : '';
		$where = $this->getWhere($where);
		
		if(!empty($where)) {
			if(isset($where['statement'])) {
				$statement.= $where['statement'];
				if(isset($count)) {
					if($columns !== '*') $statement.= ' GROUP BY '.$columns;
				}
			}
			if(isset($where['order']) && $where['order']) $statement.=  isset($where['order']['ASC']) ? ' ORDER BY '.$this->table.'.'.$where['order']['ASC'] : ' ORDER BY '.$this->table.'.'.$where['order']['DESC'].' DESC';
		} else {
			if(isset($count)) {
				if($columns !== '*') $statement.= ' GROUP BY '.$columns;
			}
		}
		
		if(!isset($count) && (isset($group) && $columns !== '*')) $statement.= ' GROUP BY '.$columns;
		
		//exit($statement);
		
		// (Obs.:Se houver) Captura dos valores da interrogações da declaração 
		$data = empty($where) || !isset($where['value']) ? null : $where['value'];

		if($limit) $statement .= ' LIMIT '.$limit;

		// Retorna a execução da consulta
		$query = $this->query($statement, $data);

		$return = array();

		if($query['status'] && $query['rows'] > 0) $return = $query['query']->fetchAll(PDO::FETCH_ASSOC);

		if($query['status'] === false) {
			$error_message = isset($query['error']['message']) ? $query['error']['message'] : 'Erro ao tentar executar a solicitação';
			dbDebugExit($error_message, 500);
		}

		return array(
			'status' => $query['status'],
			'rows' => isset($query['rows']) ? $query['rows'] : 0 ,
			'query' => $return
		);

  }// Fim -> select
  
  // ------------------------------------------------------------------------

	/**
	 * insert - Insere valores
	 *
	 * Insere os valores e tenta retornar o último id enviado
	 *
	 * @since 0.1
	 * @access public
	 * @param string $table O nome da tabela
	 * @param array ... Ilimitado número de arrays com chaves e valores
	 * @return object|array Retorna a consulta realizada ou array vazio
	 */
	public function insert($data = array()) {
		if(empty($data) || !is_array($data)) return array('status' => false, 'message' => 'Não existe dados para inserção!');
		
		// Configura o array de colunas
		$columns = array();

		// Configura o array de valores
		$values = array();

		// Configura o valor inicial do modelo
		$placeHolders = '(';

		// O $j assegura que colunas serão configuradas apenas uma vez
		$j = 0;

		// Verifica se é um array com colunas/valor ou
		// array com cada indice contendo um conjunto de colunas/valor
		$dimension = array_key_exists(0, $data) ? 2 : 1;
		
		if($dimension === 1) {

			$getData = $this->getDataInsert($data);

			// Configura os nomes das colunas
			$columns = $getData['columns'];
	
			// Configura o array de valores
			$values = $getData['values'];

			// Remove os caracteres extra dos place holders
			$placeHolders .= $getData['placeHolders'];
		
			// Configura os divisores
			$placeHolders .= ')';
		} else {
			$getColumns = true;

			for ($i=0; $i < count($data); $i++) {

				$getData = $this->getDataInsert($data[$i], $getColumns);
				
				if($i === 0) {
					$getColumns = false;
					// Configura os nomes das colunas
					$columns = $getData['columns'];
				}
				// Adiciono a $values o array $getData['values']
				$values = $getData['values'];
	
				// Remove os caracteres extra dos place holders
				$placeHolders .= $getData['placeHolders'];
			
				// Configura os divisores
				$placeHolders .= '), (';
			}
			// Remove os caracteres extra dos place holders
			$placeHolders = substr($placeHolders, 0, strlen($placeHolders) - 3);
		}
		
		// Separa as colunas por vírgula
		$columns = implode(', ', $columns);

		// Cria a declaração e executa
		$statement = "INSERT INTO `{$this->table}` ($columns) VALUES $placeHolders";
		$exec = $this->query($statement, $values);

		// Se a declaração foi executada com sucesso iremos pegar o último ID inserido
		if($exec['status'] && $exec['rows'] > 0) {

			$return = array(
				'status' => true,
				'rows' => $exec['rows']
			);
			
			$lastId = $this->query("SELECT MAX({$this->pk}) as ID FROM {$this->table}");

			// Se conseguiu pegar o ultimo ID retornaremos os dados inseridos
			if($lastId['status'] && $lastId['rows'] === 1) {
				$lastId = $lastId['query']->fetch(PDO::FETCH_ASSOC)["ID"];
				
				$this->internalSelect = true;

				$lastIdWhere = [
					0 => [
						'where' => $this->pk,
						'condition' => 'LIKE',
						'value' => $lastId,
					]
				]; 

				$last_insert = $this->select('*', $lastIdWhere);
				
				if($last_insert['status']) {
					$return['lastInsert'] = $last_insert['query'][0];
				}

			}
			
			if(!isset($return['lastInsert'])) $return['lastInsert'] = false;
		}
		if(!isset($return)) $return = array('status' => false, 'message' => 'Não foi possível realizar a inserção de dados');
		unset($getData['placeHolders']);
		$return['insertData'] = $data;
		if(DBDEBUG) $return['exec'] = $exec;
		return $return;
  }// Fim -> Insert
  
  // ------------------------------------------------------------------------

	/**
	 * query - Consulta PDO
	 *
	 * @since 0.1
	 * @access public
	 * @param string $statement String com a declaração da consulta
	 * @param array $data_array Array opcional com os valores da declaração
	 * @return array 
	 */

	public function getDataInsert($data, $columns = true){
		if($columns) $columns = array();
		$placeHolders = '';

		foreach ($data as $column => $value) {
			// (Se $columns true) Configura os nomes das colunas
			if(!is_bool($columns)) $columns[] = "`$column`";
			
			$values[] = $value;
	
			// Configura os place holders do PDO
			$placeHolders .= '?, ';
		}
		$placeHolders = substr($placeHolders, 0, strlen($placeHolders) - 2);

		return array(
			'columns' => $columns,
			'values' => $values,
			'placeHolders' => $placeHolders
		);

  }// FIM -> getDataInsert
  
  // ------------------------------------------------------------------------

	/**
	 * Update simples
	 *
	 * Atualiza uma linha da tabela baseada em um campo
	 *
	 * @since 0.1
	 * @access protected
	 * @param string $table Nome da tabela
	 * @param string $where_field WHERE $where_field = $where_field_value
	 * @param string $where_field_value WHERE $where_field = $where_field_value
	 * @param array $values Um array com os novos valores
	 * @return object|bool Retorna a consulta ou falso
	 */
	public function update($id, $values = array()) {
		// Você tem que enviar todos os parâmetros
		if (empty($values) || empty($id)) dbDebugExit('Não foi passado todos os parametros necessários');
		
		// Consultamos o banco para verificar se existe o $id na tabela
		$this->internalSelect = true;

		$where[0] = [
         'where' => $this->pk,
         'condition' => 'LIKE',
         'value' => $id
		];

		$old_select = $this->select('*', $where);
		if(!isset($old_select['status']) || $old_select['status'] === false || $old_select['rows'] === 0) {
			debugExit('Não foi possível localizar na tabela: '.$this->table.' o identificador: '.$id, 500);
		} else {
			$old = $old_select['query'][0];
		}


		// Começa a declaração
		$statement = " UPDATE `{$this->table}` SET";

		// Configura o array de valores
		$set = array();

		// Configura a declaração do WHERE campo=valor
		$where = " WHERE {$this->pk} = ?";

		$alteration = false;
		// Configura as colunas a atualizar
		foreach ($values as $column => $value) {

			if($old[$column] != $value) {
				$alteration = true;
			}
			
			$set[] = " `$column` = ?";
		}

		if($alteration === false) {
			return [
				'status' => false,
				'message' => 'Nenhuma diferença entre os dados enviados e os que estão no banco de dados'
			];
		}

		// Separa as colunas por vírgula
		$set = implode(',', $set);

		// Concatena a declaração
		$statement .= $set . $where;

		// Configura o valor do campo que vamos buscar
		$values[] = $id;

		// Garante apenas números nas chaves do array
		$values = array_values($values);
		
		// Atualiza
		$exec = $this->query($statement, $values);

		if($exec['status'] && $exec['rows'] > 0) {
			$return['status'] = true;
			$return['rows'] = $exec['rows'];

			$this->internalSelect = true;

			$last_update = $this->select('*', $id);
			
			$return['update'] = $last_update['status'] ? $last_update['query'][0] : false;
			$return['old'] = $old;
			$return['alteration'] = true;

		} else {
			$return['status'] = false;
			$return['message'] = 'Não foi possível atualizar o identificador: '.$id;
			if(DBDEBUG) $return['query'] = $exec;
		}

		return $return;

	}// FIm -> update
  
  // ------------------------------------------------------------------------

	/**
	 * Delete
	 *
	 * Deleta uma linha da tabela
	 *
	 * @since 0.1
	 * @access protected
	 * @param string $table Nome da tabela
	 * @param string $where_field WHERE $where_field = $where_field_value
	 * @param string $where_field_value WHERE $where_field = $where_field_value
	 * @return object|bool Retorna a consulta ou falso
	 */
	public function delete($id) {
		// Você precisa enviar todos os parâmetros
		if (empty($id) || is_array($id)) return;

		// Inicia a declaração
		$statement = " DELETE FROM `{$this->table}` ";

		// Configura a declaração WHERE campo=valor
		$where = "WHERE {$this->pk} = ?";

		// Concatena tudo
		$statement .= $where;

		// O valor que vamos buscar para apagar
		$values = array($id);
		// Apaga
		return $this->query($statement, $values);
		
	} //Fim -> delete

} //Fim -> Class CRUD
