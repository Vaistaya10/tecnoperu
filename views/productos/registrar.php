<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

  <div class="container">

    <form action="" autocomplete="off" id="formulario-registro">
      <div class="card mt-3">

        <div class="card-header fw-bold">
          <div class="row">
            <div class="col"> <strong>Nuevo producto</strong></div>
            <div class="col text-end"><a href="listar.php" class="btn btn-sm btn-outline-warning">Mostrar Lista</a></div>
          </div>
         
          
        </div>

        <div class="card-body">

          <div class="form-floating mb-2">
            <select name="marcas" id="marcas" class="form-select" autofocus>
              <option value="">Seleccione</option>
              <option value="1">Samsung</option>
              <option value="2">Lenovo</option>
              <option value="3">Epson</option>
            </select>
            <label for="marcas">Marca del producto</label>
          </div>

          <div class="form-floating mb-2">
            <input type="text" class="form-control" id="tipo" placeholder="Tipo" required>
            <label for="Tipo">Tipo</label>
          </div>

          <div class="form-floating mb-2">
            <input type="text" class="form-control" id="descripcion" placeholder="Descripción" required>
            <label for="descripcion">Descripción</label>
          </div>

          <div class="row g-2">

            <div class="col-6 form-floating mb-2">
              <input type="number" class="form-control" id="precio" placeholder="Precio" required>
              <label for="precio">Precio</label>
            </div>

            <div class="col-6 form-floating mb-2">
              <input type="number" value="5" max="48" min="0" class="form-control" id="garantia" placeholder="Garantía" required>
              <label for="garantia">Garantía</label>
            </div>
          </div>


          <div class="form-floating">
            <select name="condicion" id="condicion" class="form-select">
              <option value="S">Producto nuevo</option>
              <option value="N">Semi nuevo nuevo</option>
            </select>
            <label for="condicion">Condición del prodcuto</label>
          </div>

        </div>
        <div class="card-footer text-end">
          <button class="btn btn-primary btn-sm" type="submit">Guardar</button>
          <button class="btn btn-danger btn-sm" type="reset">Cancelar</button>
        </div>

      </div>

    </form>


  </div>


  <script>

    //referencias
    
    const formulario = document.querySelector("#formulario-registro");
    const marcas = document.querySelector("#marcas");
    const tipo = document.querySelector("#tipo");
    const descripcion = document.querySelector("#descripcion");
    const precio = document.querySelector("#precio");
    const garantia = document.querySelector("#garantia");
    const condicion = document.querySelector("#condicion");

    function guardarDato() {
      //method: POST (empaquetar los datos JSON) >>> BACKEND (JSON{"rows": 1})
      fetch(`../../app/controllers/ProductoController.php`,{
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
          idmarca       : marcas.value,
          tipo          : tipo.value,
          descripcion   : descripcion.value,
          precio        : parseFloat(precio.value),
          garantia      : parseInt(garantia.value),
          esnuevo       :condicion.value
        })
      })
        .then(response => {return response.json()})
        .then(data =>{
          if(data.rows > 0){
            formulario.reset();
          }
        })
        .catch(error => {console.error(error)});
    }

    formulario.addEventListener("submit", function (e) {
      e.preventDefault(); //stop evento submit

      if (confirm("¿Desea registrar el producto?")) {
        guardarDato();
      }
    })
  </script>

</body>

</html>