<?php
require_once 'models/empleado.php';

class EmpleadoController{

    private $model;

    public function __CONSTRUCT(){
        $this->model = new empleado();
    }

    //Llamado listado de empleados
    public function Index(){
        require_once 'views/empleado/empleados.php';
    }

    public function select(){
        $empleado = new empleado();

        if(isset($_REQUEST['id'])){
            $empleado = $this->model->select($_REQUEST['id']);
            $roles = $this->model->selectRoles($_REQUEST['id']);
        }

        require_once 'views/empleado/edit.php';
    }

    public function create(){
        $empleado = new empleado();

        require_once 'views/empleado/create.php';
    }

    public function saveNew(){
        $empleado = new empleado();
        
        $empleado->nombre = $_REQUEST['nombre'];
        $empleado->email = $_REQUEST['email'];
        $empleado->sexo = $_REQUEST['sexo'];
        $empleado->area_id = $_REQUEST['area'];
        $empleado->descripcion = $_REQUEST['descripcion'];
        $empleado->roles = $_REQUEST['roles'];

        $this->model->saveNew($empleado);

        header('Location: index.php?c=empleado');
    }

    public function update(){
        $empleado = new empleado();
        
        $empleado->id = $_REQUEST['id'];
        $empleado->nombre = $_REQUEST['nombre'];
        $empleado->email = $_REQUEST['email'];
        $empleado->sexo = $_REQUEST['sexo'];
        $empleado->area_id = $_REQUEST['area'];
        $empleado->descripcion = $_REQUEST['descripcion'];
        $empleado->roles = $_REQUEST['roles'];

        $this->model->update($empleado);

        header('Location: index.php?c=empleado');
    }

    public function delete(){
        $this->model->delete($_REQUEST['idEmpleado']);
        header('Location: index.php');
    }
}