<?php

//LIMPIA EL BUFER DE SALIDA Y DESHABILITA EL ALMACENAMIENTO EN EL MISMO
ob_end_clean();

//ACTIVA EL ALMACENAMIENTO EN BUFER DE SALIDA
ob_start(); 

//SE REALIZA UNA HERENCIA A LA CLASE FPDF
class PDF extends FPDF
{
	//SE CREA "$pdo" A FIN DE ALMACENAR LA CONEXIONA A LA BASE DE DATOS
	private $pdo;

	public function __construct(){
        parent::__construct();
		$dba = new DBAccess();
		$this->pdo = $dba->get_connection();
	}
	// Cabecera de página
	function Header()
	{
		//Insetamos imagen
		$this->Image('../tema/img/logoUGEL.png', 5, 5, 50);

		//Tipo de letra, tamaño, color en el titulo
		$this->SetFont('Arial','B',20);
		$this->Cell(30);
		$this->Ln(20);
		$this->SetDrawColor(0,80,180);
        $this->SetFillColor(230,230,0);
        $this->SetTextColor(220,50,50);
		$this->Cell(275,10,'Estado de las resoluciones enviadas por Mesa de partes',0,0,'C');
		$this->Ln(20);
	}

	// FUNCION DEL PIE DE PAGINA
	function Footer()
	{
    // Posición: a 1,5 cm del final
		$this->SetY(-15);
    // Arial italic 8
		$this->SetFont('Arial','I',8);
    // Número de página
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}

    // FUNCION PARA EL CUERPO DEL REPORTE
	function Body($fDesde,$fHasta)
	{
		// NUMEROS DE PAGINA
		$this->AliasNbPages();
		$this->AddPage('O');

        // COLOR Y TIPO DE TEXTO
		$this->SetFillColor(232,232,232);
		$this->SetFont('Arial','B',8);

		$this->Cell(20,10,'Numero RD',			1,0,'C',1);
		$this->Cell(25,10,'Tipo Resolucion',	1,0,'C',1);
		$this->Cell(15,10,utf8_decode('Año'),	1,0,'C',1);
		$this->Cell(30,10,'Estado',				1,0,'C',1);
		$this->Cell(65,10,'Nombre Ambiente',	1,0,'C',1);
		$this->Cell(35,10,'Fecha derivada',		1,0,'C',1);
		$this->Cell(35,10,'Fecha de recepcion',	1,0,'C',1);
		$this->Cell(55,10,'Usuario',			1,1,'C',1);

		$this->SetFont('Arial','',8);

        // SE CREA UN OBJETO´PARA ALAMACENAR EL RANGO DE FECHAS PARA OBTENER LOS REGISTROS
		$resultadoReportes = $this->getData($fDesde,$fHasta);
        
        // RECORREMOS LOS REGISTROS DE ACUERDO AL RANGO DE FECHA
		foreach($resultadoReportes as $r_g){
			$this->Cell(20,10,utf8_decode($r_g->numero), 			1, 0 ,'C', 0);
			$this->Cell(25,10,utf8_decode($r_g->tipo_resolucion), 	1, 0 ,'C', 0);
			$this->Cell(15,10,utf8_decode($r_g->anio), 				1, 0 ,'C', 0);
			$this->Cell(30,10,utf8_decode($r_g->tipo_estado), 		1, 0 ,'C', 0);
			$this->Cell(65,10,utf8_decode($r_g->nombre_ambiente), 	1, 0 ,'C', 0);
			$this->Cell(35,10,utf8_decode($r_g->fecha_derivada), 	1, 0 ,'C', 0);
			$this->Cell(35,10,utf8_decode($r_g->fecha_recepcion), 	1, 0 ,'C', 0);
			$this->Cell(55,10,utf8_decode($r_g->usuario), 			1, 1 ,'C', 0);
		}
		ob_end_clean();
		$this->Output();
	}

    // FUNCION PARA OBTENER TODOS LOS REGISTROS DE ACUERDO A LAS FECHAS ESTABLECIDAD
	function getData($fDesde,$fHasta)
	{
		try
		{

			$result = array();
 
            // LLAMADO AL PROCEDIMIENTO ALMACENADO PARA EL REPORTE
			$statement = $this->pdo->prepare("CALL up_listar_reportes_Dfecha_Hfecha(?,?)");

			$tempfDesde = $fDesde;
			$tempfHasta = $fHasta;

			$statement->bindParam(1, $tempfDesde);
			$statement->bindParam(2, $tempfHasta);
			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$reporte = new stdClass();
				$reporte->numero = $r->numero;
				$reporte->tipo_resolucion = $r->tipo_resolucion;
				$reporte->anio = $r->anio;
				$reporte->tipo_estado = $r->tipo_estado;
				$reporte->nombre_ambiente = $r->nombre_ambiente;
				$reporte->fecha_derivada = $r->fecha_derivada;
				$reporte->fecha_recepcion = $r->fecha_recepcion;
				$reporte->usuario = $r->usuario;

				$result[] = $reporte;
			}

			return $result;

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
}
?>

