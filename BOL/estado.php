<?php
//CREACIÓN DE LA CLASE ESTADO
class Estado
{
	//SE CREAN LAS VARIABLES DE LA CLASE
	private $id_estado;
	private $tipo_estado;

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