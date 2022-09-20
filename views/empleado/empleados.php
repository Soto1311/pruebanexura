<!DOCTYPE html>
<html lang="en">
<head>
  <title>Listado de Empleados</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<div class="container">
  <h2>Listado de empleados</h2>
  <div class="d-grid gap-2 d-md-block">
  <a href="?c=empleado&a=create" class="btn btn-primary" role="button" data-bs-toggle="button"><i class="fa fa-solid fa-user-plus"></i> Crear</a>
  </div>
  <table class="table">
    <thead>
      <tr>
        <th><i class="fa fa-solid fa-user"></i> Nombre</th>
        <th><i class="fa fa-solid fa-at"></i> Email</th>
        <th><i class="fa fa-solid fa-venus-mars"></i> Sexo</th>
        <th><i class="fa fa-solid fa-briefcase"></i> Área</th>
        <th><i class="fa fa-solid fa-envelope"></i> Boletín</th>
        <th>Modificar</th>
        <th>Eliminar</th>
      </tr>
    </thead>
    <tbody>
        <?php foreach($this->model->index() as $r): ?>
            <tr>
                <td><?php echo $r->nombre; ?></td>
                <td><?php echo $r->email; ?></td>
                <td><?php echo $r->sexo; ?></td>
                <td><?php echo $r->area; ?></td>
                <td><?php echo $r->boletin; ?></td>
                <td>
                    <a href="?c=empleado&a=select&id=<?php echo $r->id; ?>"><i class="fa fa-pencil-square-o"></i></a>
                </td>
                <td>
                    <a onclick="javascript:return confirm('¿Seguro de eliminar este registro?');" href="?c=empleado&a=delete&idEmpleado=<?php echo $r->id; ?>"><i class="fa fa-solid fa-trash"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
  </table>
</div>

</body>
</html>
