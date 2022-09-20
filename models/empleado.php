<?php
class Empleado
{
	private $pdo;

    public $id;
    public $nombre;
    public $email;
    public $sexo;
    public $area_id;
    public $boletin;
    public $descripcion;

	public function __CONSTRUCT(){
		try
		{
			$this->pdo = Db::connect();
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function index(){
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT 
                                            empleado.id as id, 
                                            empleado.nombre AS nombre, 
                                            empleado.email AS email, 
                                            empleado.sexo AS sexo,
                                            areas.nombre AS area,
                                            empleado.boletin AS boletin
                                        FROM empleado 
                                        LEFT JOIN areas ON empleado.area_id = areas.id
                                        WHERE deleted = 0");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

    public function getAreas(){
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM areas");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

    public function getRoles(){
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM roles");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function select($idEmpleado){
		try
		{
			$stm = $this->pdo->prepare("SELECT 
                                            empleado.id as id, 
                                            empleado.nombre AS nombre, 
                                            empleado.email AS email, 
                                            empleado.sexo AS sexo,
                                            areas.id AS area,
                                            empleado.boletin AS boletin,
											empleado.descripcion AS descripcion
                                        FROM empleado 
                                        LEFT JOIN areas ON empleado.area_id = areas.id
                                        WHERE deleted = 0
										AND empleado.id = ?");
			$stm->execute(array($idEmpleado));
			return $stm->fetch(PDO::FETCH_OBJ);
		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function selectRoles($idEmpleado){
		try
		{
			$stm = $this->pdo->prepare("SELECT rol_id FROM empleado_rol WHERE empleado_id = ?");
			$stm->execute(array($idEmpleado));
			$roles = [];
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $key => $value){
                array_push($roles, $value->rol_id);
            }
			return $roles;
		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function delete($idEmpleado){
		try
		{
			$stm = $this->pdo
			            ->prepare("UPDATE empleado SET deleted = 1 WHERE id = ?");

			$stm->execute(array($idEmpleado));
		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function update($data){
		try
		{
			$sql = "UPDATE empleado SET
						nombre = ?,
						email = ?,
                        sexo = ?,
                        area_id = ?,
                        descripcion = ?
				    WHERE id = ?";

			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                        $data->nombre,
                        $data->email,
                        $data->sexo,
                        $data->area_id,
                        $data->descripcion,
                        (int)$data->id,
					)
				);
			
			$sql = "DELETE FROM empleado_rol WHERE empleado_id = ?";

			$this->pdo->prepare($sql)
				->execute(
					array(
						$data->id
					)
				);

			foreach ($data->roles as $key => $value) {
				$sql = "INSERT INTO empleado_rol (empleado_id,rol_id)
						VALUES (?, ?)";

				$this->pdo->prepare($sql)
					->execute(
						array(
							(int)$data->id,
							$value
						)
					);
			}
			
		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function saveNew(empleado $data){
		try{
			$sql = "INSERT INTO empleado (nombre,email,sexo,area_id,boletin,descripcion)
					VALUES (?, ?, ?, ?, ?, ?)";

			$this->pdo->prepare($sql)
				->execute(
					array(
						$data->nombre,
						$data->email,
						$data->sexo,
						$data->area_id,
						0,
						$data->descripcion
					)
				);

			$idEmpleado = $this->pdo->lastInsertId();
			foreach($data->roles as $key => $value){
				$sql = "INSERT INTO empleado_rol (empleado_id,rol_id)
						VALUES (?, ?)";

				$this->pdo->prepare($sql)
					->execute(
						array(
							$idEmpleado,
							$value
						)
					);
			}
		} catch (Exception $e){
			die($e->getMessage());
		}
	}
}