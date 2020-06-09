<?php
//CREACIÓN DE LA CLASE AMBIENTE
class Ambiente
{
	//SE CREAN LAS VARIABLES DE LA CLASE
	private $id_ambiente;
	private $nombre_ambiente;
	private $id_tipo_rol;
	private $id_area;

    //SE LES ASIGNA LAS VARIABLES QUE DEPENDEN DE OTRA CLASE
	public function __construct()
	{
		$this->id_tipo_rol = new Tipo_rol();
		$this->id_area = new Area();
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