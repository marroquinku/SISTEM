<?php
//CREACIÓN DE LA CLASE PERSONA
class Persona
{
	//SE CREAN LAS VARIABLES DE LA CLASE
	private $id_persona;
	private $documento;
	private $nombre;
	private $apellido_paterno;
	private $apellido_materno;
	private $fecha_nacimiento;
	private $sexo;

    //SE CREA LAS FUNCIONES DE OBTENER E INGRESAR A LAS VARIABLES
	public function __GET($x)
	{
		return $this->$x;
	}

	public function __SET($x, $y)
	{
		return $this->$x = $y;
	}
}
?>