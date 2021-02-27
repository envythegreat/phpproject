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
          if(is_array($param)):
            $param = json_encode($param, JSON_FORCE_OBJECT);
            $this->_query->bindValue($x, $param);
          endif;
          $this->_query->bindValue($x, $param);
          $x++;
        endforeach;
      endif;
      if($this->_query->execute() ) :
        $this->_result = $this->_query->fetchALL( PDO::FETCH_OBJ );
      else : $this->_error = true; endif;
    endif;
    return $this;
  }

  public function insert( String $table, Array $fields ) {
    $values = array_values( $fields );

    $fieldString = "`" . implode( "`, `", array_keys( $fields ) ) . "`";

    $valueString = '';
    for ( $i=1; $i <= count( $fields ); $i++ ) : $valueString .= '?, '; endfor;
    $valueString = rtrim( $valueString, ", " );

    $sql = "INSERT INTO {$table} ({$fieldString}) VALUES ({$valueString})";
    if ( !$this->query( $sql, $values )->error() )
      return true;
    return false;
  }

  public function error() {
    return $this->_error;
  }

}