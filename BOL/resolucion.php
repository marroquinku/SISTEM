<?php
//CREACIÓN DE LA CLASE RESOLUCION
class Resolucion
{
	//SE CREAN LAS VARIABLES DE LA CLASE
	private $id_resolucion;
	private $id_tipo_resolucion;
	private $id_estado;
	private $id_usuario_ambiente;
	private $proyecto;
	private $id_concepto;
	private $numero;
	private $anio;
	private $archivo;
	private $fecha_emision;

    //SE LES ASIGNA LAS VARIABLES QUE DEPENDEN DE OTRA CLASE
	public function __construct()
	{
		$this->id_tipo_resolucion = new Tipo_resolucion();
		$this->id_estado = new Estado();
		$this->id_usuario_ambiente = new Usuario_ambiente();
		$this->id_concepto = new Concepto();
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
