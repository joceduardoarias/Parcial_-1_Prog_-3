<?php

include ("./entidades/usuario.php");
include ("./entidades/DAO.php");
include ("vendor/autoload.php");
include ("./entidades/producto.php");


$headers = getallheaders();
$token = $headers['token']??'';//Si no viene el token que pase un string vacio para que falle!
print_r($token);
// die();

$DAO = new DAO();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
   
    switch ($_SERVER['PATH_INFO']) {
        case '/usuario':
                $obj = new usuario($_POST['email'],$_POST['clave'],$_POST['tipo']);
                $DAO->Alta($obj);
            break;
        case '/login':
            //Buscamos el objeto en el archivo
            $clave = $_POST['clave'];
            $nombre = $_POST['email'];
            if ($DAO->buscarUsuario($clave,$nombre)!= null) {
                $obj = $DAO->buscarUsuario($clave,$nombre);
                $DAO->logIn($obj);
            } else {
                echo "No tiene permisos para acceder a esta acción";
            }
            break;
        case '/pizzas':
            $auxArray = array();
             $obj = $DAO->buscarLogeado();
            // $DAO->buscarUsuarioId($valor);                        
                if ($token != null) {
                $data = $DAO->decodificarToken($token,$obj->clave);
                foreach ($data as $key => $value) {
                    if ($value == 'encargado') {
                        $tipo = $_POST['tipo'];
                        $sabor = $_POST['sabor'];
                        $precio = $_POST['precio'];
                        $stock = $_POST['stock'];
                        $foto = $_FILES["foto"]["name"];
                        if ($sabor != 'jamon' && $sabor != 'napo' && $sabor != 'muzza') {
                            
                            echo 'Sabores no disponibles';
                            break;
                        }
                        if ($tipo != 'piedra' && $tipo != 'molde') {
                            
                            echo 'El tipo incorrecto';
                            break;
                        }
                       $auxArray = $DAO->traerTodos();
                        foreach ($auxArray as $key => $value) {
                            if ($value->tipo = $tipo && $value->sabor = $sabor ) {
                                echo "combinacion invalida";
                                $flag = false;
                            break;
                            }
                        }
                        if ($flag != false) {
                            $obj = new producto($tipo,$precio,$sabor,$stock,$foto);
                        
                            if ($DAO->AltaProducto($obj)) {
                                echo "Alta exitosa";
                            }
                        }
                         
                    } 
                }   
            }
           
            break;    
          
        default:
            # code...
            break;
    }
}else {
    switch ($_SERVER['PATH_INFO']) {
        case '/pizzas':
            $auxArray = array();
            $obj = $DAO->buscarLogeado();
           if ($token != null) {
            $data = $DAO->decodificarToken($token,$obj->clave);
            foreach ($data as $key => $value) {
                if ($value == 'encargado') {
                    
                       $auxArray = $DAO->traerTodos();
                       foreach ($auxArray as $key => $value) {
                               echo $value->tipo." ".$value->precio." ".$value->stock." ".$value->sabor;
                       }
                    
                }else {
                   $auxArray = $DAO->traerTodos();
                   foreach ($auxArray as $key => $value) {
                           echo $value->tipo." ".$value->precio." ".$value->sabor;
                   }
                }
              }
            }
             
            break;
        
        default:
            # code...
            break;
    }
}