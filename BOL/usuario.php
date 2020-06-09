<?php
//CREACIÓN DE LA CLASE USUARIO
class Usuario
{
	//SE CREAN LAS VARIABLES DE LA CLASE
	private $id_usuario;
	private $id_persona;
	private $usuario;
	private $contrasenia;
	private $estado;

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
