<?php
use \Firebase\JWT\JWT;
class DAO
{   /**Funación Alta
    Recibe como parametro un objeto y lo guarda en un archivo JSON
    */
    public function Alta($obj)
    {
        try {
            $auxArray = array();
            $retorno = true;
            
            //Leemos el JSON
            $datos_usuarios = file_get_contents("usuarios.json");
            $json_usuarios = json_decode($datos_usuarios, true);
            
            if ($json_usuarios != null) {
                foreach ($json_usuarios as $value) {
                            
                    array_push($auxArray,$value);
                                
                }
                    array_push($auxArray,$obj);
            }
            else {
                    array_push($auxArray,$obj);
            }
            //abro el archivo para escribir
            $json_usuarios = fopen("usuarios.json","w");
            $json_string = json_encode($auxArray);
            fwrite($json_usuarios,$json_string);
            return $retorno;
        } catch (Exception $e) {
            echo "Erro realizando el Alta", $e->getMessage(), "\n";
            return false;
        }
    }
    /**Funación Alta Producto
    Recibe como parametro un objeto y lo guarda en un archivo JSON
    */
    public function AltaProducto($obj)
    {
        try {
            $auxArray = array();
            $retorno = true;
            
            //Leemos el JSON
            $datos_productos = file_get_contents("productos.json");
            $json_productos = json_decode($datos_productos, true);
            
            if ($json_productos != null) {
                foreach ($json_productos as $value) {
                            
                    array_push($auxArray,$value);
                                
                }
                    array_push($auxArray,$obj);
            }
            else {
                    array_push($auxArray,$obj);
            }
            //abro el archivo para escribir
            $json_productos = fopen("productos.json","w");
            $json_string = json_encode($auxArray);
            fwrite($json_productos,$json_string);
            $this->cargarImg();
            return $retorno;
        } catch (Exception $e) {
            echo "Erro realizando el Alta Productos", $e->getMessage(), "\n";
            $retorno = false;
            return $retorno;
        }
    }
    /**LOGIN
     * Recibe nombre y clave
     * Retorna el token
     */
    public function logIn($obj)
    {
            $payload = array(
                "iss" => "http://example.org",
                "aud" => "http://example.com",
                "iat" => 1356999524,
                "nbf" => 1357000000,
                "email" => $obj->email,
                "tipo" => $obj->tipo,
            );
            $jwt = JWT::encode($payload, $obj->clave);
             //abro el archivo para escribir
             $json_token_file = fopen("token.json","w");
             $json_string = json_encode($jwt);
             fwrite($json_token_file,$json_string);
            //  print_r($decoded);
            print_r($jwt);
            $this->userLogeado($obj);
    }
    /**GENERAR ID 
     * Se genera un id unico
    */
    public function generarId($str1,$str2)
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return $str1.substr(str_shuffle($permitted_chars), 0, 16).$str2;
    }

     /**
     * Esta funcion se encarga de cargar la imagen
     */
    public function cargarImg()
    {
       try {
          
            //print_r($_FILES);
                
                        $origen = $_FILES["foto"]["tmp_name"];
                      $nombre = $_FILES["foto"]["name"];
                        // $nombre =   basename($_FILES['foto']['name']);
                        $destino = 'imagenes/'.$nombre; 
                        move_uploaded_file($origen, $destino);
       } catch (Exception $e) {
        echo "Error cargando imagen", $e->getMessage(), "\n";
        return false;
       }
        
    }
    /**BUSCAR USUARIO
     *Busca en el archivo usuarios por clave y nombre 
     - si coincide retorna el objeto de lo contrario retorna null
     */
    public function buscarUsuario($clave,$nombre)
    {
        
         try {
             //Leemos el JSON
            $datos_usuarios = file_get_contents("usuarios.json");
            $json_usuarios = json_decode($datos_usuarios, true);
            foreach ($json_usuarios as $key => $value) {
                // obj existe
                if ($value['clave'] ==$clave && $value['email'] == $nombre){
                    $obj = new usuario($value['email'],$value['clave'],$value['tipo']);
                    return $obj;
                }
            }
            //obj no existe
            return null;
        } catch (Exception $e) {
            echo "Error validar si existe ", $e->getMessage(), "\n";
            return false;
        }
        
    }
     /**BUSCAR USUARIO
     *Busca en el archivo usuarios por Id 
     - si coincide retorna el objeto de lo contrario retorna null
     */
    public function traerTodos()
    {
        
         try {
            $auxArray = array();
             //Leemos el JSON
            $datos_usuarios = file_get_contents("productos.json");
            $json_usuarios = json_decode($datos_usuarios, true);
            foreach ($json_usuarios as $key => $value) {
                // obj existe
                
                    $obj = new producto($value['tipo'],$value['precio'],$value['sabor'],$value['stock'],$value['foto']);
                    array_push($auxArray,$obj);
            }
            //obj no existe
            return $auxArray;
        } catch (Exception $e) {
            echo "Error validar si existe ", $e->getMessage(), "\n";
            return false;
        }
        
    }
    /**
     * Esta funcion recibe JWT, el objeto contenedor de la key y retorna un array
     */
    public function decodificarToken($token, $key)
    {
         $decoded = JWT::decode($token, $key, array('HS256'));
         return $decoded;   
    }
    /**
     * Guarda los datos del usuario logeado
     */
    public function userLogeado($obj)
    {   
        try {
            $auxArray = array();
            $json_UseLog = fopen("usuarioLogueado.json","w");
            array_push($auxArray, $obj);
            $json_string = json_encode($auxArray);
            fwrite($json_UseLog,$json_string);
        } catch (Exception $e) {
            echo "Error genarado achivo usuario logueado ", $e->getMessage(), "\n";
            return false;
        }
           

    }
    /**
     * Devuelve el usuario logueado.
     */
    public function buscarLogeado()
    {   
        try {
            $datos_usuarios = file_get_contents("usuarioLogueado.json");
            $json_usuarios = json_decode($datos_usuarios, true);
            foreach ($json_usuarios as $key => $value) {
                // obj existe
                $obj = new usuario($value['email'],$value['clave'],$value['tipo']);
            }
            return $obj;
        } catch (Exception $e) {
            echo "Error genarado achivo usuario logueado ", $e->getMessage(), "\n";
            return false;
        }
           

    }
}
