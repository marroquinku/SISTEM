<?php
//CREACIÓN DE LA CLASE DETALLE_RESOLUCION_INSTITUCION
class Detalle_resolucion_institucion
{
	//SE CREAN LAS VARIABLES DE LA CLASE
	private $id_detalle_res_i;
	private $id_institucion;
	private $id_resolucion;

    //SE LES ASIGNA LAS VARIABLES QUE DEPENDEN DE OTRA CLASE
	public function __construct()
	{
		$this->id_institucion = new Institucion();
		$this->id_resolucion = new Resolucion();
	}

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