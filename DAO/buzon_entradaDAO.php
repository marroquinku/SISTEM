<?php
//CREACIÓN DE LA CLASE BUZON_ENTRADADAO
class Buzon_EntradaDAO
{
	//SE CREA LA VARIABLE QUE HACE REFERENCIA A LA CONEXION A LA BASE DE DATOS
	private $pdo;

    //SE CREA LA FUNCION PARA OBTENER LA CONEXION
	public function __construct()
	{
		$dba = new DBAccess();
		$this->pdo = $dba->get_connection();
	}

    //SE CREA LA FUNCION PARA EL REGISTRO DE BUZON DE ENTRADA A LA BASE DE DATOS
	public function Registrar(Buzon_Entrada $buzonDeEntrada)
	{

		try
		{
			$statement = $this->pdo->prepare("CALL up_registrar_buzon_entrada_v1(?,?,?,?,?)");

			$tempIdAmbiente = $buzonDeEntrada->__GET('id_ambiente')->__GET('id_ambiente');
			$tempIdEstado = $buzonDeEntrada->__GET('id_estado')->__GET('id_estado');
			$tempIdNumeroResolucion = $buzonDeEntrada->__GET('id_resolucion')->__GET('numero');
			$tempIdTipoResolucion = $buzonDeEntrada->__GET('id_resolucion')->__GET('id_tipo_resolucion');
			$tempIdAnioResolucion = $buzonDeEntrada->__GET('id_resolucion')->__GET('anio');

			$statement->bindParam(1, $tempIdAmbiente);
			$statement->bindParam(2, $tempIdEstado);
			$statement->bindParam(3, $tempIdNumeroResolucion);
			$statement->bindParam(4, $tempIdTipoResolucion);
			$statement->bindParam(5, $tempIdAnioResolucion);

			$statement->execute();


		} catch (Exception $e)
		{
			die($e->getMessage());
				//echo $e->getMessage()." <br>";
		}
	}

    //SE CREA LA FUNCION PARA EL ENVIO DE CORREOS A LOS DIFERENTES USUARIOS REGISTRADOS
	public function EnviarMensage($correos,$bodyPass)
	{
		$body = $bodyPass;

		$mail = new PHPMailer;

		try {

			    $mail->isSMTP();                // Set mailer to use SMTP
			    $mail->SMTPOptions = array(
			    	'ssl' => array(
			    		'verify_peer' => false,
			    		'verify_peer_name' => false,
			    		'allow_self_signed' => true
			    	)
			    );
				$mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
				$mail->SMTPAuth = true;                     // Enable SMTP authentication
				$mail->Username = 'ruizugel@gmail.com';     // SMTP username
				$mail->Password = 'Ruizugel123'; 			// SMTP password
				$mail->SMTPSecure = 'tls';                  // Enable TLS encryption, `ssl` also accepted
				$mail->Port = 587;                          // TCP port to connect to

				$mail->setFrom('ruizugel@gmail.com', "Encargado de Mesa de partes");

				for ($i=0; $i < count($correos); $i++) { 
					$mail->addAddress($correos[$i]);    
					$mail->isHTML(true);                                  
					$mail->Subject = "Notificacion de correo electronico";
					$mail->Body    = $body;
					$mail->CharSet = "UTF-8"; 
					$mail->send();
				}


			} catch (Exception $e) {
				echo 'No se envio el correo ', $mail->ErrorInfo;
			}

		}

        //SE CREA LA FUNCION PARA LISTAR LOS MENSAJES QUE EXISTEN EN EL BUZON DE ENTRADA
		public function Listar()
		{
			try
			{
				$result = array();

				$statement = $this->pdo->prepare("call PRO_LISTAR_BUZON_ENTRADA()");
				$statement->execute();

				foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$per = new BuzonDeEntrada();

					$per->__SET('id_buzon', $r->id_buzon);
					$per->__GET('id_ambiente')->__SET('id_ambiente', $r->id_ambiente);
					$per->__GET('id_estado')->__SET('id_estado', $r->id_estado);
					$per->__GET('id_resolucion')->__SET('id_resolucion', $r->id_resolucion);
					
					$result[] = $per;
				}

				return $result;
			}
			catch(Exception $e)
			{
				die($e->getMessage());
			}
		}

        //SE CREA LA FUNCION PARA LISTAR LOS MENSAJES PENDIENTES EN EL BUZON DE ENTRADA
		public function Listar_buzon_ambiente_pendientes(Buzon_Entrada $buzonDeEntrada)
		{
			try
			{
				$result = array();

				$statement = $this->pdo->prepare("call up_listar_resoluciones_pendientes_oficina(?)");

				$tempIdAmbiente = $buzonDeEntrada->__GET('id_ambiente')->__GET('id_ambiente');
				$statement->bindParam(1, $tempIdAmbiente);
				$statement->execute();

				foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$per = new Buzon_Entrada();

					$per->__SET('id_buzon', $r->id_buzon);
					$per->__GET('id_resolucion')->__SET('id_resolucion', $r->id_resolucion);
					$per->__GET('id_resolucion')->__SET('numero', $r->numero);
					$per->__GET('id_resolucion')->__SET('anio', $r->anio);
					$per->__GET('id_resolucion')->__GET('id_tipo_resolucion')->__SET('tipo_resolucion', $r->tipo_resolucion);
					$per->__GET('id_resolucion')->__GET('id_concepto')->__SET('concepto', $r->concepto);
					$per->__GET('id_resolucion')->__GET('id_estado')->__SET('tipo_estado', $r->tipo_estado);

					$result[] = $per;
				}

				return $result;
			}
			catch(Exception $e)
			{
				die($e->getMessage());
			}
		}

        //SE CREA LA FUNCION PARA LISTAR LOS MENSAJES RECIBIDOS EN EL BUZON DE ENTRADA
		public function Listar_buzon_ambiente_recibidos(BuzonDeEntrada $buzonDeEntrada)
		{
			try
			{
				$result = array();

				$statement = $this->pdo->prepare("call up_listar_resoluciones_recibidas(?)");

				$tempIdAmbiente = $buzonDeEntrada->__GET('id_ambiente')->__GET('id_ambiente');
				$statement->bindParam(1, $tempIdAmbiente);
				$statement->execute();

				foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$per = new BuzonDeEntrada();

					$per->__SET('id_buzon', $r->id_buzon);
					$per->__GET('id_resolucion')->__SET('id_resolucion', $r->id_resolucion);
					$per->__GET('id_resolucion')->__SET('numero', $r->numero);
					$per->__GET('id_resolucion')->__SET('anio', $r->anio);
					$per->__GET('id_resolucion')->__GET('id_tipo_resolucion')->__SET('tipo_resolucion', $r->tipo_resolucion);
					$per->__GET('id_resolucion')->__GET('id_concepto')->__SET('concepto', $r->concepto);
					$per->__GET('id_resolucion')->__GET('id_estado')->__SET('tipo_estado', $r->tipo_estado);

					$result[] = $per;
				}

				return $result;
			}
			catch(Exception $e)
			{
				die($e->getMessage());
			}
		}

        //SE CREA LA FUNCION PARA LISTAR LOS MENSAJES ACEPTADOS EN EL BUZON DE ENTRADA
		public function Listar_buzon_ambiente_aceptados(Buzon_Entrada $buzonDeEntrada)
		{
			try
			{
				$result = array();

				$statement = $this->pdo->prepare("call up_listar_resoluciones_aceptados(?,?,?)");

				$tempIdAmbiente = $buzonDeEntrada->__GET('id_ambiente')->__GET('id_ambiente');
				$tempNumero = $buzonDeEntrada->__GET('id_resolucion')->__GET('numero');
				$tempAnio = $buzonDeEntrada->__GET('id_resolucion')->__GET('anio');


				$statement->bindParam(1, $tempIdAmbiente);
				$statement->bindParam(2, $tempNumero);
				$statement->bindParam(3, $tempAnio);

				$statement->execute();

				foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$per = new Buzon_Entrada();

					$per->__SET('id_buzon', $r->id_buzon);
					$per->__GET('id_resolucion')->__SET('id_resolucion', $r->id_resolucion);
					$per->__GET('id_resolucion')->__SET('numero', $r->numero);
					$per->__GET('id_resolucion')->__SET('anio', $r->anio);
					$per->__GET('id_resolucion')->__GET('id_tipo_resolucion')->__SET('tipo_resolucion', $r->tipo_resolucion);
					$per->__GET('id_resolucion')->__GET('id_concepto')->__SET('concepto', $r->concepto);
					$per->__GET('id_resolucion')->__GET('id_estado')->__SET('tipo_estado', $r->tipo_estado);

					$result[] = $per;
				}

				return $result;
			}
			catch(Exception $e)
			{
				die($e->getMessage());
			}
		}

        //SE CREA LA FUNCION PARA LISTAR TODOS LOS MENSAJES ACEPTADOS EN EL BUZON DE ENTRADA
		public function Listar_buzon_ambiente_aceptados_todo(Buzon_Entrada $buzonDeEntrada)
		{
			try
			{
				$result = array();

				$statement = $this->pdo->prepare("call up_listar_resoluciones_aceptados_todo(?)");

				$tempIdAmbiente = $buzonDeEntrada->__GET('id_ambiente')->__GET('id_ambiente');
				$statement->bindParam(1, $tempIdAmbiente);

				$statement->execute();

				foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$per = new Buzon_Entrada();

					$per->__SET('id_buzon', $r->id_buzon);
					$per->__GET('id_resolucion')->__SET('id_resolucion', $r->id_resolucion);
					$per->__GET('id_resolucion')->__SET('numero', $r->numero);
					$per->__GET('id_resolucion')->__SET('anio', $r->anio);
					$per->__GET('id_resolucion')->__GET('id_tipo_resolucion')->__SET('tipo_resolucion', $r->tipo_resolucion);
					$per->__GET('id_resolucion')->__GET('id_concepto')->__SET('concepto', $r->concepto);
					$per->__GET('id_resolucion')->__GET('id_estado')->__SET('tipo_estado', $r->tipo_estado);

					$result[] = $per;
				}

				return $result;
			}
			catch(Exception $e)
			{
				die($e->getMessage());
			}
		}

        //SE CREA LA FUNCION PARA ACEPTAR LAS RESOLUCIONES PENDIENTES EN EL BUZON DE ENTRADA
		public function aceptar_resoluciones_pendientes(Buzon_Entrada $buzonDeEntrada)
		{
			try
			{
				$statement = $this->pdo->prepare("call up_recibir_resoluciones_pendientes(?)");

				$tempIdBuzon = $buzonDeEntrada->__GET('id_buzon');

				
				$statement->bindParam(1, $tempIdBuzon);
				$statement->execute();

			}
			catch(Exception $e)
			{
				die($e->getMessage());
			}
		}

	}
?>