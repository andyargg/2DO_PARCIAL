<?php

require_once './db/AccesoDatos.php';

Class Producto{
    public $id;
    public $titulo;
    public $precio;
    public $tipo;
    public $formato;
    public $anioDeSalida;
    public $stock;
    public $imagen;


    public function crearProducto(){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO productos (titulo, precio, tipo, anioDeSalida, formato, stock, imagen) 
            VALUES (:titulo, :precio, :tipo, :anioDeSalida, :formato, :stock, :imagen)");


        $consulta->bindValue(':titulo', $this->titulo, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(':anioDeSalida', $this->anioDeSalida, PDO::PARAM_STR);
        $consulta->bindValue(':formato', $this->formato, PDO::PARAM_STR);
        $consulta->bindValue(':stock', $this->stock, PDO::PARAM_STR);
        $consulta->bindValue(':imagen', $this->imagen, PDO::PARAM_STR);

        $consulta->execute();
    }

    public static function obtenerProductoId($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM productos WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Producto');
    }
    public static function obtenerProductoPorTituloTipoFormato($titulo, $tipo, $formato) {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM productos WHERE titulo = :titulo AND tipo = :tipo AND formato = :formato");

        $consulta->bindValue(':titulo', $titulo, PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $tipo, PDO::PARAM_STR);
        $consulta->bindValue(':formato', $formato, PDO::PARAM_STR);

        $consulta->execute();
        return $consulta->fetchObject('Producto');
    }
   

    public static function validarProducto($producto){
        if($producto){
            return true;
        }
        return false;
    }

    public static function actualizarStock($id, $stock) {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("UPDATE productos SET stock = stock + :stock WHERE id = :id");

        $consulta->bindValue(':stock', $stock, PDO::PARAM_INT);
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);

        $consulta->execute();
    }
}
