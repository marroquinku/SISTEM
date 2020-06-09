<?php
//CREACIÓN DE LA CLASE TIPO DE ROL
class Tipo_rol
{
	//SE CREAN LAS VARIABLES DE LA CLASE
	private $id_tipo_rol;
	private $tipo_rol;

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