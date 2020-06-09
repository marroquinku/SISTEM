<?php
//CREACIÓN DE LA CLASE NIVEL
class Nivel
{
	//SE CREAN LAS VARIABLES DE LA CLASE
	private $id_nivel;
	private $nombre_nivel;

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