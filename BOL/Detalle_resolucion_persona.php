<?php
//CREACIÓN DE LA CLASE DETALLE_RESOLUCION_PERSONA
class Detalle_resolucion_persona
{
	//SE CREAN LAS VARIABLES DE LA CLASE
	private $id_detalle_res_p;
	private $id_persona;
	private $id_resolucion;

    //SE LES ASIGNA LAS VARIABLES QUE DEPENDEN DE OTRA CLASE
	public function __construct()
	{
		$this->id_persona = new Persona();
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
?>