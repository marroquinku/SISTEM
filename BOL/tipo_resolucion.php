<?php
//CREACIÓN DE LA CLASE TIPO DE RESOLUCION
class Tipo_resolucion
{
	//SE CREAN LAS VARIABLES DE LA CLASE
	private $id_tipo_resolucion;
	private $tipo_resolucion;

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