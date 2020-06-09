<?php
//CREACIÓN DE LA CLASE USUARIO AMBIENTE
class Usuario_ambiente
{
	//SE CREAN LAS VARIABLES DE LA CLASE
	private $id_usuario_ambiente;
	private $id_usuario;
	private $id_ambiente;

    //SE LES ASIGNA LAS VARIABLES QUE DEPENDEN DE OTRA CLASE
	public function __construct()
	{
		$this->id_usuario = new Usuario();
		$this->id_ambiente = new Ambiente();
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
