<?php
//CREACIÓN DE LA CLASE TELEFONO
class Telefono
{
	//SE CREAN LAS VARIABLES DE LA CLASE
	private $id_telefono;
	private $id_persona;
	private $numero;

    //SE LES ASIGNA LAS VARIABLES QUE DEPENDEN DE OTRA CLASE
	public function __construct()
	{
		$this->id_persona = new Persona();
	}

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
