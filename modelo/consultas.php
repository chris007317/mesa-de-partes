<?php 
	require_once "conexion.php";
	class Consultas{
		
		private $conexion;
		private $strquery;
		private $arrValues;
		
		function __construct(){
			$this->conexion = new Conexion();
			$this->conexion = $this->conexion->conect();
		}
		//Insertar un registro
		public function insert(string $query, array $arrValues){
			$this->strquery = $query;
			$this->arrValues = $arrValues;
			$insert = $this->conexion->prepare($this->strquery);
			$resInsert = $insert->execute($this->arrValues);
			if ($resInsert) {
				$lastInsert = $this->conexion->lastInsertId();
			}else{
				$lastInsert = 0;
			}
			return $lastInsert;
		}
		//Buscar un registr
		public function select(string $query){
			$this->strquery = $query;
			$result = $this->conexion->prepare($this->strquery);
			$result->execute();
			$data = $result->fetch(PDO::FETCH_ASSOC);
			return $data;
		}
		//Buscar todos los registros
		public function selectAll(string $query){
			$this->strquery = $query;
			$result = $this->conexion->prepare($this->strquery);
			$result->execute();
			$data = $result->fetchall(PDO::FETCH_ASSOC);
			return $data;
		}
		//Actualizar registro
		public function update(string $query, array $arrValues){
			$this->strquery = $query;
			$this->arrValues = $arrValues;
			$update = $this->conexion->prepare($this->strquery);
			$resExecute = $update->execute($this->arrValues);
			return $resExecute;
		}
		//Eliminar un registro
		public function delete(string $query){
			$this->strquery = $query;
			$result = $this->conexion->prepare($this->strquery);
			$del = $result->execute();
			return $del;
		}
	}
 ?>