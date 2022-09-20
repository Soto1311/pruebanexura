<!DOCTYPE html>
<html lang="en">
<head>
  <title>Editar Empleado</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
</head>
<body>
  <div id="alertDiv" class="alert alert-danger fade show" role="alert">
  </div>
  <div class="container">
    <h2>Editar empleado <?php echo $empleado->nombre; ?></h2>
    <div class="alert alert-info">
      <strong>¡Atención!</strong>Los campos con asteriscos (*) son obligatorios.
    </div>
    <form id="frm-update" action="?c=empleado&a=update" method="post"  class="form-horizontal">
    <input type="hidden" name="id" value="<?php echo $empleado->id; ?>" />
      <div class="form-group">
        <label class="control-label col-sm-2" for="nombre">Nombre Completo*:</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="nombre" placeholder="Nombre completo del empleado" value="<?php echo $empleado->nombre; ?>" name="nombre" required>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="email">Email*:</label>
        <div class="col-sm-10">          
          <input type="email" class="form-control" id="email" placeholder="Correo electrónico" value="<?php echo $empleado->email; ?>" name="email" required>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="sexo">Sexo*:</label>
        <div class="col-sm-10">
          <div class="form-check">
            <input type="radio" <?php if ($empleado->sexo == 'M') echo 'checked="checked"'; ?> id="M" name="sexo" value="M">
            <label for="M">Masculino</label><br>
            <input type="radio" <?php if ($empleado->sexo == 'F') echo 'checked="checked"'; ?> id="F" name="sexo" value="F">
            <label for="F">Femenino</label><br>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="area">Area*:</label>
        <div class="col-sm-10">
        <select class="form-control form-select-lg mb-3" id="area" name="area" required>
          <option disabled>Seleccione un area</option>
          <?php foreach($this->model->getAreas() as $r): ?>
            <option value="<?php echo $r->id; ?>" <?php if ($empleado->area == $r->id) echo 'selected'; ?>><?php echo $r->nombre; ?></option>
          <?php endforeach; ?>
        </select>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="descripcion">Descripción*:</label>
        <div class="col-sm-10">          
        <textarea id="descripcion" name="descripcion" class="form-control" rows="3"  required><?php echo $empleado->descripcion; ?></textarea>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="roles">Roles*: <?php json_encode($roles); ?></label>
        <div class="col-sm-10">
          <div class="checkbox" style="display: grid;">
                <?php foreach($this->model->getRoles() as $r): ?>
                    <?php if ( in_array($r->id, $roles) ): ?>
                        <label>
                            <input type="checkbox" id="roles" name="roles[]" checked value="<?php echo $r->id; ?>">
                            <?php echo $r->nombre; ?>
                            <br/>
                        </label>
                    <?php else: ?>
                        <label>
                            <input type="checkbox" id="roles" name="roles[]" value="<?php echo $r->id; ?>">
                            <?php echo $r->nombre; ?>
                            <br/>
                        </label>
                    <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <div class="form-group">        
        <div class="col-sm-offset-2 col-sm-10">
        <button id="btnSave" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </form>
  </div>

</body>
</html>

<script>
  //Guardo todos los check de rol marcados en un array para crear la relación en BD
  var roles = <?php echo json_encode($roles); ?>;
  let allCheckBox = document.querySelectorAll('#roles');
  allCheckBox.forEach((checkbox) => { 
    checkbox.addEventListener('change', (event) => {
      if (event.target.checked) {
        roles.push(event.target.value)
      }else{
        index = roles.indexOf(event.target.value);
        roles.splice(index, 1);
      }
      document.getElementsByName("roles").value = roles;
      console.log("ROLES =>",document.getElementsByName("roles").value);
    })
  })

  $(document).ready(function(){
    $("#frm-update").submit(function(){
      var message = "";
      if(document.getElementById("nombre").value == null || document.getElementById("nombre").value == ""){
        message += "<br>-Debe indicar el nombre del empleado."; 
      }

      if(document.getElementById("email").value == null || document.getElementById("email").value == ""){
        message += "<br>-Debe indicar el email del empleado.";

      }

      if($('input[name="sexo"]:checked').val() == null){
        message += "<br>-Debe indicar el sexo del empleado";

      }

      if($('#area option:selected').val() == null || $('#area option:selected').val() == "" || $('#area option:selected').val() == "Seleccione un area"){
        message += "<br>-Debe indicar el área del empleado.";

      }

      if(document.getElementById("descripcion").value == null || document.getElementById("descripcion").value == ""){
        message += "<br>-Debe indicar una descripción de la experiencia del empleado.";
      }

      if(roles.length == 0){
        message += "<br>-Debe indicar al menos un rol del empleado";
      }

      if(message != ""){
        $('html, body').animate({ scrollTop: 0 }, 'fast');

        document.getElementById("alertDiv").innerHTML = "<strong>¡Atención!</strong>"+message; 
        var element = document.getElementById("alertDiv");
        element.classList.remove("fade");
        message = "";
        return false;
      }
    });
  })
</script>
