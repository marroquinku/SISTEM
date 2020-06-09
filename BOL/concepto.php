<?php
//CREACIÓN DE LA CLASE CONCEPTO
class Concepto
{
	//SE CREAN LAS VARIABLES DE LA CLASE
	private $id_concepto;
	private $concepto;

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