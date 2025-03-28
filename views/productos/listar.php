<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Listar</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>

  <div class="container">
    <div class="card mt-3">
      <div class="card-header">
        <div class="row">
          <div class="col">
            <strong>Lista de  producto</strong>
          </div>
          <div class="col text-end">
            <a href="registrar.php" class="btn btn-sm btn-outline-dark" >Nuevo producto</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <table class="table table-striped table-sm" id="tabla-productos">
          <thead>
            <tr>
              <th>ID</th>
              <th>Marca</th>
              <th>Tipo</th>
              <th>Descripcion</th>
              <th>Precio</th>
              <th>Garantia</th>
              <th>Nuevo</th>
            </tr>
          </thead>
          <tbody>
            <!--Contenido dinamico-->
          </tbody>
        </table>
      </div> <!--/card-body-->
    </div> <!--/card-->
  </div> <!--/container-->

<script>

  /*/consideraciones
  1. nunca devolver TODAS las filas de la tabla
  2. mostrar solo los campos relevantes
  3. agregar comandos (botones) al final - utilice ICONOS 
  */
  function obtenerDatos() {
    //fetch(URL_CONTROLADOR).then(JSON).then(DATOS).catch(ERROR)
    fetch(`../../app/controllers/ProductoController.php`,{
      method: 'GET'
    })
    .then(response =>{return response.json()})
    .then(data =>{
      const tabla = document.querySelector("#tabla-productos tbody");
      data.forEach(element => {
        tabla.innerHTML += `
        <tr>
          <td>${element.id}</td>
          <td>${element.marca}</td>
          <td>${element.tipo}</td>
          <td>${element.descripcion}</td>
          <td>${element.precio}</td>
          <td>${element.garantia}</td>
          <td>${element.esnuevo}</td>
        </tr>
        
        `;
      });

    })
    .catch(error =>{console.error(error)});
    
  }

  document.addEventListener("DOMContentLoaded", obtenerDatos());
</script>

</body>

</html>