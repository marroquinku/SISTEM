<?php
//CREACIÓN DE LA CLASE INSTITUCION
class Institucion
{
	//SE CREAN LAS VARIABLES DE LA CLASE
	private $id_institucion;
	private $id_nivel;
	private $cod_modular;
	private $nombre;

    //SE LES ASIGNA LAS VARIABLES QUE DEPENDEN DE OTRA CLASE
	public function __construct()
	{
		$this->id_nivel = new Nivel();
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