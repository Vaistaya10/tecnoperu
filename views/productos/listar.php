<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Listar</title>
    <!--Bootstrap-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
              <th>Acciones</th>
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
 const tabla = document.querySelector("#tabla-productos tbody");
 let enlace = null; // Objeto publico - dinamico

  function obtenerDatos() {
    //fetch(URL_CONTROLADOR).then(JSON).then(DATOS).catch(ERROR)
    fetch(`../../app/controllers/ProductoController.php?task=getAll`,{
      method: 'GET'
    })
    .then(response =>{return response.json()})
    .then(data =>{
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
          <td>
          <a href='editar.php?id=${element.id}' class='btn btn-sm btn-warning'><i class="fa-solid fa-pen-to-square"></i> </a>
          <a href='#' data-idproducto='${element.id}' class='btn btn-sm btn-danger delete'><i class="fa-solid fa-trash"></i> </a>

          </td>
        </tr>
        
        `;
      });

    })
    .catch(error =>{console.error(error)});
    
  }

  //¿Como enviamos los datos?
  // GET : en URL(miweb.com?ape=Frnacia&nom=Jhon&edad=18)
  //POST : JSON ({"clave": "valor"})
  //DELETE : en la URL (miweb.com/productos/5
  function eliminarProducto(ideliminar) {
    fetch(`../../app/controllers/ProductoController.php/${ideliminar}`,{method: 'DELETE'})
    .then(response => {return response.json()})
    .then(data => {
      if(data.rows > 0 ){
        const fila = enlace.closest('tr');
        if(fila) {
          fila.remove();
        }
      }else{
        alert("No se pudo eliminar el registro");
      }
    })
    .catch(error => {console.error(error)});
  }

  document.addEventListener("DOMContentLoaded", () => {
  //cuando la pagina esta lista, renderiza los datos
    obtenerDatos()

    //¿Se puede asociar el evento a un objeto que NO existe? => NO
    //Solucion => "Delegacion de eventos"
    tabla.addEventListener("click", (event) =>{
      //enlace (boton eliminar)
      //en CSS podemos agregar a <i> pointer-events: none
      enlace = event.target.closest("a"); //busca la etiqueta "a" proxima
      //       console.log(enlace);

      //identificando el enlace

      if (enlace && enlace.classList.contains("delete")){
        event.preventDefault(); //Hipervinculo deja de funcionar
        const idproducto = parseInt(enlace.getAttribute("data-idproducto"));
        if(confirm("¿Estas seguro de eliminar el registro?")){
          eliminarProducto(idproducto);

        }
      }
    });
  });
</script>

</body>

</html>