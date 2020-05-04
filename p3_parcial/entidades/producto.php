<?php

class producto
{
    public $sabor;
    public $precio;
    public $stock;
    public $foto;
    public $tipo;

    function __construct($tipo,$precio,$sabor,$stock,$foto){
        $this->tipo = $tipo;
        $this->precio = $precio;
        $this->sabor = $sabor;
        $this->stock = $stock;
        $this->foto = $foto;
    }

}
