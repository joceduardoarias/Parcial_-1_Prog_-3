<?php

class usuario{

    
    // Definiendo atributos.
    
    public $email;
    public $clave;
    public $tipo;
    //Constructor

    function __construct($email,$clave,$tipo){
        $this->email = $email;
        $this->clave = $clave;
        $this->tipo = $tipo;
    }


}