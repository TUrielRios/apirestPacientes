<?php

// Definimos una clase llamada "respuestas"
class respuestas {

    // Definimos una propiedad privada llamada "response" que contiene un array con valores predeterminados
    public $response = [
        'status' => 'ok',
        "result" => array()
    ];

    
    // Método para manejar el error 400
    public function error_400() {
        // Cambiamos el estado de "response" a "error"
        $this->response['status'] = "error";
        // Establecemos los detalles del error 400
        $this->response['result'] = array(
            "error_id" => "400",
            "error_msg" => "Datos enviados incompletos o incorrecto"
        );
        // Devolvemos la respuesta con los detalles del error
        return $this->response;
    }
    
    // Método para manejar el error 405
    public function error_405() {
        // Cambiamos el estado de "response" a "error"
        $this->response['status'] = "error";
        // Establecemos los detalles del error 405
        $this->response['result'] = array(
            "error_id" => "405",
            "error_msg" => "Metodo no permitido"
        );
        // Devolvemos la respuesta con los detalles del error
        return $this->response;
    }

    // Método para manejar el error 200 (con un mensaje personalizable)
    public function error_200($string = "Datos incorrectos") {
        // Cambiamos el estado de "response" a "error"
        $this->response['status'] = "error";
        // Establecemos los detalles del error 200 con el mensaje personalizado o predeterminado
        $this->response['result'] = array(
            "error_id" => "200",
            "error_msg" => $string
        );
        // Devolvemos la respuesta con los detalles del error
        return $this->response;
    }


    // Método para manejar el error 200 (con un mensaje personalizable)
    public function error_500($string = "Error interno del servidor") {
        // Cambiamos el estado de "response" a "error"
        $this->response['status'] = "error";
        // Establecemos los detalles del error 200 con el mensaje personalizado o predeterminado
        $this->response['result'] = array(
            "error_id" => "500",
            "error_msg" => $string
        );
        // Devolvemos la respuesta con los detalles del error
        return $this->response;
    }
    

    // Método para manejar el error 200 (con un mensaje personalizable)
    public function error_401($string = "No autorizado.") {
        // Cambiamos el estado de "response" a "error"
        $this->response['status'] = "error";
        // Establecemos los detalles del error 200 con el mensaje personalizado o predeterminado
        $this->response['result'] = array(
            "error_id" => "401",
            "error_msg" => $string
        );
        // Devolvemos la respuesta con los detalles del error
        return $this->response;
    }
    

}

?>

