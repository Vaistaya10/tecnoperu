<?php

//isset = is-set ¿esta asignado? ¿existe?
if (isset($_SERVER['REQUEST_METHOD'])){

  //las respuestas estan formateadas como JSON
  header('Content-type: application/json; charset = utf-8');

  require_once "../models/Producto.php";
  $producto = new Producto() ;
  
switch ($_SERVER['REQUEST_METHOD']) {
  case 'GET':
    echo json_encode($producto->getAll());
    break;
  
  case 'POST':
    //los datos llegan del cliente en formato: JSON/XML/TXT/FORMDATA
    $input = file_get_contents('php://input');
    $dataJSON = json_decode($input,true);

    //Registrar un nuevo producto
    $registro = [
      'idmarca'     => htmlspecialchars($dataJSON['idmarca']),
      'tipo'        => htmlspecialchars($dataJSON['tipo']),
      'descripcion' => htmlspecialchars($dataJSON['descripcion']),
      'precio'      => htmlspecialchars($dataJSON['precio']),
      'garantia'    => htmlspecialchars($dataJSON['garantia']),
      'esnuevo'     => htmlspecialchars($dataJSON['esnuevo']),
    ];

    $n = $producto->add($registro);
    echo json_encode(["rows" => $n]); //{"rows" => 1}

    break;
}

}