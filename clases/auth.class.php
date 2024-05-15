<?php 

require_once ('conexion/conexion.php');
require_once ('respuestas.class.php');

class auth extends conexion{

    public function login ($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);
        if(!isset($datos['usuario']) || !isset($datos['password'])){
            //error con los campos
            return $_respuestas->error_400();
        }else{
            //todo anda clean
            $usuario = $datos['usuario'];
            $password = $datos['password'];
            $password = parent::encriptar($password);

            $datos = $this->obtenerDatosUsuario($usuario);
            if ($datos) {
                # code...
                //verificar si la contraseña es correcta
                if($password == $datos[0]['Password']){
                    if($datos[0]['Estado']== 'Activo'){
                        //crear token
                        $verificar = $this->insertarToken($datos[0]['UsuarioId']);
                        if ($verificar) {
                            # code...
                            //si se guardó
                            $result = $_respuestas->response;
                            $result['result'] = array(
                                "token" => $verificar
                            );
                            return $result;

                        }else{
                            //si no se guardó
                            return $_respuestas->error_500("Error interno, no hemos podido guardar");
                        }
                        
                    }else{
                        //El usuario está inactivo
                        return $_respuestas->error_200("El usuario esta inactivo");
                    }

                }else{
                    //la contraseña no es igual
                    return $_respuestas->error_200("El password es invalido");

                }


            }else{
                //si no existe el usuario
                return $_respuestas->error_200("El usuario $usuario no existe");
            }
        }
    }



    private function obtenerDatosUsuario($correo){
        $query = "SELECT UsuarioId, Password, Estado FROM usuarios WHERE Usuario = '$correo'";
        $datos = parent::obtenerDatos($query);

        if (isset($datos[0]["UsuarioId"])) {
            # code...
            return $datos ;
        }else{
            return 0;
        }
    }

    private function insertarToken($usuarioid){
        $val = true;
        $token = bin2hex(openssl_random_pseudo_bytes(16, $val));
        $date = date("Y-m-d H:i");

        $estado = "Activo";
        $query = "INSERT INTO usuarios_Token (UsuarioId, Token, Estado, Fecha)VALUES('$usuarioid','ttoken','$estado', '$date')";
        $verificar = parent::nonQuery($query);
        if($verificar){
            return $token;
        }else{
            return 0;
        }
    }
}

?>