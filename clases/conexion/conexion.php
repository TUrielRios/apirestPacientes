<?php

// Aquí definimos una clase llamada "conexion"
class conexion {
    // Definimos las propiedades de la clase
    private $server;
    private $user;
    private $password;
    private $database;
    private $port;
    private $conexion;

    // Esta función se llama automáticamente cuando creamos un objeto de esta clase
    function __construct()
    {
        // Llamamos a la función "datosConexion" para obtener los datos de conexión
        $listadatos = $this->datosConexion();
        // Iteramos sobre los datos de conexión obtenidos
        foreach ($listadatos as $key => $value){
            // Asignamos los valores a las propiedades de la clase
            $this->server = $value['server'];
            $this->user = $value['user'];
            $this->password = $value['password'];
            $this->database = $value['database'];
            $this->port = $value['port'];
        }

        // Creamos una conexión mysqli usando los datos de conexión
        $this->conexion = new mysqli($this->server, $this->user, $this->password, $this->database, $this->port);
        
        // Verificamos si hay errores en la conexión
        if ($this->conexion->connect_errno) {
            // Si hay un error, imprimimos un mensaje y terminamos el script
            echo("Algo va mal con la conexion");
            die();
        }
    }

    // Esta función obtiene los datos de conexión desde un archivo JSON
    private function datosConexion () {
        // Obtenemos la ruta del directorio actual
        $direccion = dirname(__FILE__);
        // Leemos el contenido del archivo "config" que contiene los datos de conexión
        $jsondata = file_get_contents($direccion . "/" . "config");
        // Convertimos el contenido del archivo JSON a un array asociativo
        return json_decode($jsondata, true);
    }

    // Esta función convierte todos los elementos de un array a UTF-8
    private function convertirUTF8($array) {
        // Iteramos sobre cada elemento del array
        array_walk_recursive($array, function(&$item,$key) {
            // Verificamos si el elemento no está en UTF-8
            if(!mb_detect_encoding($item, 'utf-8', true)){
                // Si no está en UTF-8, lo convertimos a UTF-8
                $item = utf8_encode($item);
            }
        });
        // Devolvemos el array convertido
        return $array;
    }

    // Esta función ejecuta una consulta SQL y devuelve los resultados en formato UTF-8
    public function obtenerDatos($sqlstr){
        // Ejecutamos la consulta SQL
        $results = $this->conexion->query($sqlstr);
        // Convertimos los resultados a un array
        $resultArray = array();
        foreach ($results as $key) {
            $resultArray[] = $key;
        }
        // Convertimos todos los elementos del array a UTF-8 y devolvemos el array
        return $this->convertirUTF8($resultArray);
    }

    // Esta función ejecuta una consulta SQL que no devuelve resultados
    public function nonQuery($sqlstr) {
        // Ejecutamos la consulta SQL
        $results = $this->conexion->query($sqlstr);
        // Devolvemos el número de filas afectadas por la consulta
        return $this->conexion->affected_rows;
    }

    // Esta función ejecuta una consulta SQL y devuelve el ID del último registro insertado
    public function nonQueryId($sqlstr) {
        // Ejecutamos la consulta SQL
        $results = $this->conexion->query($sqlstr);
        // Obtenemos el número de filas afectadas por la consulta
        $filas = $this->conexion->affected_rows;
        // Si hay al menos una fila afectada, devolvemos el ID del último registro insertado
        if ($filas >= 1) {
            return $this->conexion->insert_id;
        } else {
            // Si no hay filas afectadas, devolvemos 0
            return 0;
        }
    }

    //encriptar

    protected function encriptar($string){
        return md5($string);
    }
}

?>
