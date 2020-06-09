<?php
//CREACIÓN DE LA CLASE BUZON_ENTRADA
class Buzon_Entrada
{
	//SE CREAN LAS VARIABLES DE LA CLASE
	private $id_buzon;
	private $id_ambiente;
	private $id_estado;
	private $id_resolucion;
	private $fecha_derivada;
	private $fecha_recepcion;

    //SE LES ASIGNA LAS VARIABLES QUE DEPENDEN DE OTRA CLASE
	public function __construct()
	{
		$this->id_ambiente = new Ambiente();
		$this->id_estado = new Estado();
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
