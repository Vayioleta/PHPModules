<?php 

class ServicioWeb {

    private $request;
    public $mysqli;
    public $dataSanitize;
  
    function __construct( $request ){
  
       $db_host = getenv("DB_HOST");
       $db_user = getenv("DB_USER");
       $db_pass = getenv("DB_PASS");
       $db_name = getenv("DB_NAME");
  
  
       $this->mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
       // Verificar si se realizó la conexión correctamente
       if ($this->mysqli->connect_error) {
           die('Error de conexión: ' . $mysqli->connect_error);
       }
  
       $this->request = $request;
       $this->dataSanitize = [];
       $this->sanitizeRequest();
    }
  
    function sanitizeRequest() {
        $sanitizedRequest = array();
        foreach ($this->request as $key => $value) {
          // Eliminar etiquetas HTML
          $sanitizedValue = strip_tags( $value );
          // Escapar caracteres especiales para evitar la inyección de código
          $sanitizedValue = htmlspecialchars($sanitizedValue, ENT_QUOTES, 'UTF-8');
          $sanitizedValue = strtolower( $sanitizedValue );
          $sanitizedValue = $this->sanitizeMySQL( $value );
          // Agregar el valor sanitizado al array de respuesta
          $sanitizedRequest[$key] = $sanitizedValue;
        }
        $this->dataSanitize = $sanitizedRequest;
    }
  
    function sanitizeMySQL( string $input ) {
      // Escapar caracteres especiales para evitar la inyección de código
      $input = $this->mysqli->real_escape_string($input);
      return $input;
    }
  
  }//end class ServicioWeb