<?php
class ContactoSede
{
	private $db;
	private $sede;

	//funcion principal
	public function __construct()
	{
		$this->db = Conectar::conexion();
		$this->sede = array();
	}

	//funcion para obtener las sedes registradas
	public function get_sedes()
	{
		$sql = "SELECT * FROM sede";
		$resultado = $this->db->query($sql);
		while ($row = $resultado->fetch_assoc()) {
			$this->sede[] = $row;
		}
		return $this->sede;
	}

	//funcion para procesar las solicitudes de la vista

	public function getSolicitudes() {
		$sql = "SELECT da.Matricula,CONCAT(a.NombreA,' ', a.ApellidoP, ' ', a.ApellidoM) as fullName,pr.NombrePE as nombreProceso,s.NombreSede as NombreSede,s.correoContacto as CorreoContacto,s.telefono as Telefono FROM docalumnoperiodo as da INNER JOIN alumnos as a ON a.Matricula = da.Matricula INNER JOIN sede as s ON s.NombreSede = s.NombreSede INNER JOIN proceso as pr ON pr.IdProceso = da.IdProceso INNER JOIN alumnosede as ae ON ae.Matricula = a.Matricula WHERE ae.NombreSede = s.NombreSede"; // Agregar la condición de postulación a la misma sede
	
		$resultado = $this->db->query($sql);
		$solicitudes = [];
		$alumnosProcesados = []; // Almacena las matrículas de los alumnos procesados
	
		while ($row = $resultado->fetch_assoc()) {
			// Verifica si la matrícula ya fue procesada
			if (!in_array($row['Matricula'], $alumnosProcesados)) {
				$solicitudes[] = $row;
				$alumnosProcesados[] = $row['Matricula'];
			}
		}
		return $solicitudes;
	}
}
