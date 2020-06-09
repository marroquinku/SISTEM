<?php
//CREACIÓN DE LA CLASE AREA
class Area
{
	//SE CREAN LAS VARIABLES DE LA CLASE
	private $id_area;
	private $nombre_area;

    //SE CREA LAS FUNCIONES DE OBTENER E INGRESAR DE LAS VARIABLES
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