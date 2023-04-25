<?php
 //Proporciona un intermediario de un objeto para controlar su acceso.

  class Proxy {

    function __construct( string $method_name, $data ){
      $this->method_name = $method_name;
      $this->data = $data;
    }

    function is_enrutable(){
      return method_exists( $this , $this->method_name ); //preguntar si es posible enrutar
    }

    function enroute(){
      if( $this->is_enrutable() ){
          return $this->{$this->method_name}($this->data);
        }else{
        $error = '[NeuronProxy/enroute] No se puede encontrar el metodo: '.$this->method_name;
        error_log($error, 0);
        return $error;
      }
    }//end enroute

  }
