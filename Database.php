<?php

class Database {
  private $host = "localhost";
  private $name = "boutique";
  private $user = "root";
  private $pass = "";
  private $_pdo;
  private $_query;
  private $_error;
  private $_result;

  public function __construct(){
    $this->Connect();
  }

  private function Connect(){
    try{
      $this->_pdo = new PDO('mysql:host='.$this->host.';dbname='.$this->name,$this->user,$this->pass);
      $this->_pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
      $this->_pdo->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
    } catch (PDOException $e) {
      die($e->getMessage());
    }
  }

  public function query(String $sql, Array $params) {
    $this->_error = false;
    if( $this->_query = $this->_pdo->prepare( $sql ) ):
      if( count(  $params ) ):
        $x = 1;
        foreach ( $params as $param ) :
          $this->_query->bindValue($x, $param);
          $x++;
        endforeach;
      endif;
      if($this->_query-->execute() ) :
        $this->_result = $this->_query->fetchALL( PDO::FETCH_OBJ );
      else : $this->_error = true; endif;
    endif;
    return $this;
  }

  public function insert(String $table, Array $data) {
    $values = array_values($data);
    $dataString = "`". implode( "`, `", array_keys($data ) ). "`";
    print_r($dataString);
  }

}