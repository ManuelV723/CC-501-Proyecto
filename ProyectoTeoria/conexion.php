<?php 
session_start();
class Connect{
    private $server ="localhost";
    private $user ="root";
    private $pass ="";
    private $db ="bd_proyecto";
    public $conexion;
    public function __construct(){
        $this->conexion = new mysqli($this->server, $this->user, $this->pass,$this->db) or die(mysql_error());
        $this->conexion->set_charset("utf8");
    }

 //INSERTAR
    public function insertar($tabla, $datos){
        $resultado =    $this->conexion->query("INSERT INTO $tabla VALUES (null,$datos)") or die($this->conexion->error);
        if($resultado)
            return true;
        return false;
    } 
    //BORRAR
    public function borrar($tabla, $condicion){    
        $resultado  =   $this->conexion->query("DELETE FROM $tabla WHERE $condicion") or die($this->conexion->error);
        if($resultado)
            return true;
        return false;
    }
    //ACTUALIZAR
    public function actualizar($tabla, $campos, $condicion){    
        $resultado  =   $this->conexion->query("UPDATE $tabla SET $campos WHERE $condicion") or die($this->conexion->error);
        if($resultado)
            return true;
        return false;        
    } 
    //BUSCAR
    public function buscar($tabla, $campos, $condicion){
        $resultado = $this->conexion->query("SELECT $campos FROM $tabla WHERE $condicion") or die($this->conexion->error);
        if($resultado)
            return $resultado;
        return false;
    }
    //VERIFICAR SESSION
    public function sesion(){
    	if(!isset($_SESSION['id'])){
    		header("Location: index.php");
    	}else{
    		return true;
    	}
    }

    public function rolCliente($rol){
        if($rol==2){
            header('Location: inicio_empresa.php');
        }
    }
    public function rolEmpresa($rol){
        if($rol==1){
            header('Location: index.php');
        }
    }

}

 ?>