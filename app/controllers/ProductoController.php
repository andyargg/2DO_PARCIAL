<?php
require_once './models/Producto.php';
Class ProductoController{

    public static function CargarProducto($request, $response, $args){
        $parametros = $request->getParsedBody();
        $producto = Producto::obtenerProductoPorTituloTipoFormato($parametros['titulo'], $parametros['tipo'], $parametros['formato']);
        if ($producto){
            Producto::actualizarStock($producto->id, $parametros['stock']);

            $payload = json_encode(array("mensaje" => "Stock actualizado con exito"));
        }
        else{
            $titulo = $parametros['titulo'];
            $precio = $parametros['precio'];
            $tipo = $parametros['tipo'];
            $formato = $parametros['formato'];
            $anioDeSalida = $parametros['anioDeSalida']; 
            $stock = $parametros['stock']; 

            $producto = new Producto();
            $producto->titulo = $titulo;
            $producto->precio = $precio;
            $producto->tipo = $tipo;
            $producto->formato = $formato;
            $producto->anioDeSalida = $anioDeSalida; 
            $producto->stock = $stock; 
            $producto->imagen = self::GuardarImagenProducto($titulo, $tipo);
            $producto->crearProducto();

            $payload = json_encode(array("mensaje" => "Producto creado con éxito"));

            

        }
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    private static function GuardarImagenProducto($titulo, $tipo) {
        $carpetaDestino = './ImagenesDeProductos/2024/';
        
        if (!is_dir($carpetaDestino)) {
            mkdir($carpetaDestino, 0777, true); 
        }
    
        $nombreArchivo = $titulo . '-' . $tipo . '.jpg';
    
        $rutaArchivo = $carpetaDestino . $nombreArchivo;
    
        move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaArchivo);
    
        return $rutaArchivo;
    }

    public static function ConsultarProducto($request, $response, $args){
        $parametros = $request->getParsedBody();
        $producto = Producto::obtenerProductoPorTituloTipoFormato($parametros['titulo'], $parametros['tipo'], $parametros['formato']);

        $payload = json_encode(array("mensaje" => $producto));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');

    }
    
}