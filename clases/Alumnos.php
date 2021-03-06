<?php
require_once"accesoDatos.php";
class Alumno
{
	private $id;
	private $nombre;
 	private $apellido;
  	private $dni;
  	private $foto;

  	public function GetId()
	{
		return $this->id;
	}
	
	public function GetApellido()
	{
		return $this->apellido;
	}
	
	public function GetNombre()
	{
		return $this->nombre;
	}
	
	public function GetDni()
	{
		return $this->dni;
	}
	
	public function GetFoto()
	{
		return $this->foto;
	}
	
	public function SetId($valor)
	{
		$this->id = $valor;
	}
	
	public function SetApellido($valor)
	{
		$this->apellido = $valor;
	}
	
	public function SetNombre($valor)
	{
		$this->nombre = $valor;
	}
	
	public function SetDni($valor)
	{
		$this->dni = $valor;
	}
	
	public function SetFoto($valor)
	{
		$this->foto = $valor;
	}

	public function __construct($dni=NULL)
	{
		if($dni != NULL)
		{
			$obj = Alumno::TraerUnAlumno($dni);
			
			$this->apellido = $obj->apellido;
			$this->nombre = $obj->nombre;
			$this->dni = $dni;
			$this->foto = $obj->foto;
		}
	}

  	public function ToString()
	{
	  	return $this->apellido."-".$this->nombre."-".$this->dni."-".$this->foto;
	}

	public static function TraerUnAlumno($idParametro) 
	{	
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select * from alumnos where id =:id");
		$consulta->bindValue(':id', $idParametro, PDO::PARAM_INT);
		$consulta->execute();
		$alumnoBuscado= $consulta->fetchObject('alumnos');
		return $alumnoBuscado;				
	}
	
	public static function TraerTodosLosAlumnos()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select * from alumnos");
		$consulta->execute();			
		$arrAlumnos= $consulta->fetchAll(PDO::FETCH_CLASS, "Alumno");	
		return $arrAlumnos;
	}
	
	public static function Borrar($idParametro)
	{	
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("delete from alumnos WHERE id=:id");	
		$consulta->bindValue(':id',$idParametro, PDO::PARAM_INT);		
		$consulta->execute();
		return $consulta->rowCount();	
	}
	
	public static function Modificar($alumno)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("update alumnos set nombre=:nombre, apellido=:apellido, foto=:foto WHERE id=:id");
		$consulta->bindValue(':id',$alumno->id, PDO::PARAM_INT);
		$consulta->bindValue(':nombre',$alumno->nombre, PDO::PARAM_STR);
		$consulta->bindValue(':apellido', $alumno->apellido, PDO::PARAM_STR);
		$consulta->bindValue(':foto', $alumno->foto, PDO::PARAM_STR);
		return $consulta->execute();
	}

	public static function Insertar($alumno)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into alumnos (nombre,apellido,dni,foto)values(:nombre,:apellido,:dni,:foto)");
		$consulta->bindValue(':nombre',$alumno->nombre, PDO::PARAM_STR);
		$consulta->bindValue(':apellido', $alumno->apellido, PDO::PARAM_STR);
		$consulta->bindValue(':dni', $alumno->dni, PDO::PARAM_STR);
		$consulta->bindValue(':foto', $alumno->foto, PDO::PARAM_STR);
		$consulta->execute();		
		return $objetoAccesoDato->RetornarUltimoIdInsertado();			
	}	
}