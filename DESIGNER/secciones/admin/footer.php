
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="../tema/js/jquery-3.4.0.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../tema/js/bootstrap.min.js"></script>
<script src="../tema/js/metisMenu.min.js"></script>
<script type="text/javascript" src="../tema/js/bootstrap-filestyle.min.js"> </script>
<script type="text/javascript" src="../tema/js/bootstrap-select.js"> </script>


<script>
/*
	Este fragmento de codigo sirve para enviar un valor a un input , cuando el  combobox es seleccionado
*/
$('#tipoResolucion').on('change', function() {
	console.log($(this).find("option:selected").text().trim());
	var nombreTipoResolucion = $(this).find("option:selected").text().trim();
	$('#tipoResolucionNombre').val(nombreTipoResolucion);
});

/*
	Este fragmento de codigo sirve para recorrer una tabla y obtener las datos de los atributtos data-data
	que html proporciona. Estos datos obtenidos sirven para enviar valores a los inputs que se encuentran
	en el formulario
*/
$('.lista-res .table  tbody tr').click(function(){
			var n = $(this).data("numero");
			var tipoRes = $(this).data("tipores");
			var anioRes = $(this).data("aniores");
			var fechaEmision = $(this).data("fechaemision");


			if(!isNaN(parseFloat(n)) && isFinite(n)){
				$('#numeroResolucion').val(n);
			}

			
			$('#fechaemisionres').val(fechaEmision);
			

			$('#tipoResolucion').find('option').each(function() {
			    var numberList = $(this).val();

			    if(new Number(numberList) == tipoRes){
					//alert($(this).val());
					$('#tipoResolucion').val(tipoRes).change();
					console.log(tipoRes);
			    }

			});

			$('#anioResolucion').find('option').each(function() {
			    var numberList = $(this).val();

			    if(new Number(numberList) == anioRes){
					//alert($(this).val());
					$('#anioResolucion').val(anioRes).change();
					console.log(tipoRes);
			    }

			});

		});

	$('.ambiente-select').selectpicker();
	$('#metismenu').metisMenu();
	$('#conteido-app').css('height', $(window).height());

/*
	Este fragmento de codigo sirve para validar los inputs de tipo correo, esto permite
	identificar un correo valido que se ingresa en el input
*/
	$('#correoPersona').on('input', function (event) {
		 campo = event.target;
		 valido = document.getElementById('emailOK');
		        
		 var reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

		 var regOficial = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;

		    //Se muestra un texto a modo de ejemplo, luego va a ser un icono
		    if (reg.test(campo.value) && regOficial.test(campo.value)) {
		      valido.innerText = "válido oficial y extraoficialmente";
		    } else if (reg.test(campo.value)) {
		      valido.innerText = "válido extraoficialmente";

		    } else {
		      valido.innerText = "incorrecto";

		}
	});
/*
	Este es un fragmento de codigo que nos permiten consumir datos json, con el cual
	validamos la existencia de una resolucion, a traves de sus campos 'Numero de la resolucion',
	'Año de la resolucion', 'Tipo de resolucion'
*/

	function realizaProceso(){
		        var parametros = {
			            "resolucionNumero" : $('#numeroResolucion').val(),
			            "anioRes" : $('select[name=anioResolucion]').val(),
						"tipoRes" : $('select[name=tipoResolucion]').val()
		        };

		        $.ajax({
			                data:  parametros,
			                url:   '../ajax/buscar_resolucion.php',
			                type:  'post',
			                beforeSend: function () {
				                        $("#resultado").html("Procesando, espere por favor...");
			                },
			                success:  function (data) {

				if (data.success === 1) {

					if($('#alerta-resolucion2')){
						$('#alerta-resolucion2').removeClass('collapsed');
						$('#alerta-resolucion2').addClass('collapse');
					}

					$('#alerta-resolucion').removeClass('collapse');
					$('#alerta-resolucion').addClass('collapsed');
					$('#btnGuardarRes').attr("disabled", true);
											//console.log(data.data.message);
										}else{
											$('#alerta-resolucion').removeClass('collapsed');
											$('#alerta-resolucion').addClass('collapse');
											
											$('#alerta-resolucion2').removeClass('collapse');
											$('#alerta-resolucion2').addClass('collapsed');

											$('#anioResolucion').attr("readonly", true);
											$('#anioResolucion').attr("style", "pointer-events: none;");
											$('#tipoResolucion').attr("readonly", true);
											$('#tipoResolucion').attr("style", "pointer-events: none;");
											$('#numeroResolucion').prop("readonly",true);

											$('#btnGuardarRes').removeAttr("disabled");
											//console.log(data.data.message);
										}

									                },
									error: function(){

									} 
								        });
	}


/*
	Este es un fragmento de codigo que nos permiten consumir datos json, con el cual
	validamos la existencia de una persona, a traves de sus campos 'documento de la persona persona'
*/

	function buscarPersonaDocumento() {
		var parametros = {
			"documentoPersona": $('#documentoKeyEnter').val()
		};

		$.ajax({
			data: parametros,
			url: '../ajax/buscar_persona.php',
			type: 'post',
			beforeSend: function() {
				$("#resultado").html("Procesando, espere por favor...");
			},
			success: function(data) {

				if (data.success === 1) {
					console.log(1);
					$('#documentoKeyEnter').css({'border':'1px solid green'});

					$('#pr_nombre').val("" + data.data.nombre);
					$('#pr_apellidoP').val("" + data.data.apellido_paterno);
					$('#pr_apellidoM').val("" + data.data.apellido_materno);
					$('#pr_FechaNacimiento').val("" + data.data.FechaNacimiento);
					$('#idPersonaNs').val("" + data.data.idPersona);

					$('#pr_nombre').prop('readonly', true);
					$('#pr_apellidoP').prop('readonly', true);
					$('#pr_apellidoM').prop('readonly', true);
					$('#pr_FechaNacimiento').prop('readonly', true);
					$('#btn_pr_persona').prop('disabled', false);

				} else {
					console.log(0);
					$('#documentoKeyEnter').css({'border':'1px solid red'});
					alert("Persona no encontrado");
					$('#pr_nombre').val("");
					$('#pr_apellidoP').val("");
					$('#pr_apellidoM').val("");
					$('#pr_FechaNacimiento').val("");
				}

			},
			error: function() {

			}
		});
	}

/*
	Este es un fragmento de codigo que nos permiten consumir datos json, con el cual
	validamos la existencia de una persona y si esta cuenta con un usuario dentro de sistema,
	a traves de sus campos 'documento de la persona persona'
*/


	function buscarPersonaDocumentoRegistrarUsuario() {
		var parametros = {
			"documentoPersona": $('#numeroDeDNI').val()
		};

		$.ajax({
			data: parametros,
			url: '../ajax/buscar_persona.php',
			type: 'post',
			beforeSend: function() {
				$("#resultado").html("Procesando, espere por favor...");
			},
			success: function(data) {

				if (data.success === 1) {
					console.log(1);
					$('#numeroDeDNI').css({'border':'1px solid green'});
					var nombreAMAP = ""+data.data.nombre+" "+data.data.apellido_paterno+" "+data.data.apellido_materno;
					$('#nombresApellidos').val(nombreAMAP);
					$('#FechaNacimiento').val("" + data.data.FechaNacimiento);
					$('#Documento').val("" + data.data.Documento);
					$('#sexo').val("" + data.data.Sexo);
					$('#idPersona').val("" + data.data.idPersona);

				} else {
					console.log(0);
					$('#numeroDeDNI').css({'border':'1px solid red'});
					alert("Persona no encontrado");
					$('#nombresApellidos').val("");
					$('#FechaNacimiento').val("");
					$('#Documento').val("");
					$('#sexo').val("");
					$('#idPersona').val("");
				}

			},
			error: function() {

			}
		});
	}

/*
	Este es un fragmento de codigo que nos permiten consumir datos json, con el cual
	validamos la existencia de una institucion dentro del sistema,
	a traves de sus campos 'Codigo modular'
*/

	function buscarInstitucionModular() {
		var parametros = {
			"codigoModular": $('#modularKeyEnter').val()
		};

		$.ajax({
			data: parametros,
			url: '../ajax/buscar_institucion.php',
			type: 'post',
			beforeSend: function() {
				$("#resultado").html("Procesando, espere por favor...");
			},
			success: function(data) {

				if (data.success === 1) {
					console.log(1);
					$('#modularKeyEnter').css({'border':'1px solid green'});

					$('#pr_nombreIns').val("" + data.data.nombre);
					$('#pr_nivelIns').val("" + data.data.nivel);
					$('#idInstituciones').val("" + data.data.id_institucion);
					

					$('#pr_nombreIns').prop('readonly', true);
					$('#pr_nivelIns').prop('readonly', true);
					$('#btn_ir_institucion').prop('disabled', false);

				} else {
					console.log(0);
					$('#modularKeyEnter').css({'border':'1px solid red'});
					alert("Institucion no encontrado");
					$('#pr_nombreIns').val("");
					$('#pr_nivelIns').val("");
					$('#idInstituciones').val("");
					$('#btn_ir_institucion').prop('disabled', true);
				}

			},
			error: function() {

			}
		});
	}



	function buscarUsuarioPersonaDocumento(){
		        var parametros = {
			                "documentoPersona" : $('#numeroDeDNI').val()
		        };

		        $.ajax({
			                data:  parametros,
			                url:   '../ajax/buscar_usuario_persona.php',
			                type:  'post',
			                beforeSend: function () {
				                        $("#resultado").html("Procesando, espere por favor...");
			                },
			                success:  function (data) {

				if (data.success === 1) {
					console.log(1);
					$('#nombresApellidos').val(""+data.data.nombreApellidos);
					$('#FechaNacimiento').val(""+data.data.FechaNacimiento);
					$('#Documento').val(""+data.data.Documento);
					$('#sexo').val(""+data.data.Sexo);
					$('#idPersona').val(""+data.data.idPersona);
					$('#usuarioPersona').val(""+data.data.Usuario);
					$('#idUsuario').val(""+data.data.idUsuarios);
				}else{
					alert("Persona sin usuario o no encontrado");
					$('#nombresApellidos').val("");
					$('#FechaNacimiento').val("");
					$('#Documento').val("");
					$('#sexo').val("");
					$('#usuarioPersona').val("");
					$('#idUsuario').val("");
				}

			                },
			error: function(){

			} 
		        });
	}

/*
	Este es un fragmento de codigo que nos permiten consumir datos json, con el cual
	validamos la existencia de una institucion dentro del sistema,
	a traves de sus campos 'Codigo modular'
*/

	$('#btn-buscar-usuario-persona').click(function(e){
		var value = $("#numeroDeDNI").val().length;
		if (value>0) {
			buscarUsuarioPersonaDocumento();
		}else{
			alert("Ingrese un numero");
		}
	});

	/*BUSCAR PERSONA PARA REGISTRAR UYSUARIO*/
	$('#btn-buscar-persona-ru').click(function(e){
		var value = $("#numeroDeDNI").val().length;
		if (value>0) {
			buscarPersonaDocumentoRegistrarUsuario();
		}else{
			alert("Ingrese un numero");
		}
	});


	$('#btn-verificar').click(function(e){
		var value = $("#numeroResolucion").val().length;
		if (value>0) {
			realizaProceso();
		}else{
			alert("Ingrese un numero");
		}
	});

	$('#btnResetearRes').click(function(e){
		$('#anioResolucion').removeAttr("readonly");
		$('#anioResolucion').removeAttr("style");
		$('#tipoResolucion').removeAttr("readonly");
		$('#tipoResolucion').removeAttr("style");
		$('#numeroResolucion').removeAttr("readonly");
		$('#btnGuardarRes').attr("disabled", true);
		$('#alerta-resolucion2').removeClass('collapsed');
		$('#alerta-resolucion2').addClass('collapse');
	});


	$("#subirResolucion").filestyle({
		btnClass: "btn-success",
		text: "Buscar",
		placeholder: "Archivo.pdf"
	});

/*
	Este es un fragmento de codigo que nos permiten ocultar y mostrar el menu presionando el icono
	amburguesa.
*/
	$("#menu-toggle").click(function(e) {
		e.preventDefault();
		$("#wrapper").toggleClass("toggled");
		if (document.querySelector('.col-md-8') !== null && document.querySelector('.col-lg-10') !== null) {
			$("#conteido-app").removeClass();
			$("#conteido-app").addClass("col-md-12");
			$("#conteido-app").addClass("col-lg-12");
		}else{
			$("#conteido-app").removeClass();
			$("#conteido-app").addClass("col-md-8");
			$("#conteido-app").addClass("col-lg-10");
		}
	});


/*
	Este es un fragmento de codigo que nos permiten agregar y verficar una persona dentro de la 
	tabla persona a resolucion
*/

	$("#btn-agregar-p-r").click(function(e) {
		e.preventDefault();
				//alert(e);
				var foundDoc = false;

				$('#personas-rd > tbody  > tr').each(function(i, item) {
					var docTable = parseInt($(item).find('td').data('documento'));
					var docRegistes = parseInt($('#numeroDeDNI').val());
					if(docTable === docRegistes){
						foundDoc = true;
						return false;
					}
				    //alert(docTable+" - "+docRegistes);
				});

				if(foundDoc){
					alert("No puede agregar a una persona que ya esta en la resolucion");
				}else{
					aniadir_persona_resolucion();
				}
			});

	$("#btn_pr_persona").click(function(e) {
		e.preventDefault();
				//alert(e);
				var foundDoc = false;

				$('#personas-rd>tbody>tr').each(function(i, item) {
					var docTable = parseInt($(item).find('td:nth-child(2)').data('documento'));
					var docRegistes = parseInt($('#documentoKeyEnter').val());
					console.log(docRegistes);
					console.log(docTable);
					if(docTable === docRegistes){
						foundDoc = true;
						return false;
					}
				    //alert(docTable+" - "+docRegistes);
				});

				if(foundDoc){
					alert("No puede agregar a una persona que ya esta en la resolucion");
				}else{
					if ($("#documentoKeyEnter").val().length>0) {
						var nombre = $("#pr_nombre").val();
						var apellidoP = $("#pr_apellidoP").val();
						var apellidoM = $("#pr_apellidoM").val();
						var fechaN = $("#pr_FechaNacimiento").val();
						var dniP = $("#documentoKeyEnter").val();
						var idPe = $("#idPersonaNs").val();
						aniadir_persona_resolucion(nombre,apellidoP,apellidoM,fechaN,dniP,idPe);

						$("#pr_nombre").val("");
						$("#pr_apellidoP").val("");
						$("#pr_apellidoM").val("");
						$("#documentoKeyEnter").val("");
						$("#pr_FechaNacimiento").val("");
						$("#idPersonaNs").val("");
						$(this).prop('disabled',true);
					}else{
						alert("Complete los datos!");
					}
				}
			});



/*
	Este es un fragmento de codigo que nos permiten agregar y verficar una institucion dentro de la 
	tabla intitucion a resolucion
*/

	$("#btn_ir_institucion").click(function(e) {
		e.preventDefault();
				//alert(e);
				var foundDoc = false;

				$('#institucion-rd>tbody>tr').each(function(i, item) {
					var docTable = parseInt($(item).find('td:nth-child(3)').data('cmodular'));
					var docRegistes = parseInt($('#modularKeyEnter').val());
					console.log(docRegistes);
					console.log($('#institucion-rd>tbody>tr'));
					if(docTable === docRegistes){
						foundDoc = true;
						return false;
					}
				    //alert(docTable+" - "+docRegistes);
				});

				if(foundDoc){
					alert("No puede agregar a una institucion que ya esta en la resolucion");
				}else{
					if ($("#modularKeyEnter").val().length>0) {
						var nombre = $("#pr_nombreIns").val();
						var nivel = $("#pr_nivelIns").val();
						var idInsticion = $("#idInstituciones").val();
						var codModular = $("#modularKeyEnter").val();
						aniadir_institucion_resolucion(codModular,nombre,nivel,idInsticion);

						$("#pr_nombreIns").val("");
						$("#pr_nivelIns").val("");
						$("#idInstituciones").val("");
						$("#modularKeyEnter").val("");
						$(this).prop('disabled',true);
					}else{
						alert("Complete los datos!");
					}
				}
			});



/*
	Este es un fragmento de codigo que nos permiten crear una tabla de instituciones a nivel dinamica
	resiviendo parametros tales como codigo modular, nombre , nuvel , id Insitucion
*/

	function aniadir_institucion_resolucion(codModular,nombre,nivel,idIns) {
		$("#institucion-rd").find('tbody')
		.append($('<tr>')
			.append($('<td align="center">')
				.append($('<button onclick="f1(this)">')
					.append('<img src="../img/eliminar.gif">')
					)
				)
			.append($('<td>')
				.append("")
				)
			.append($('<td align="center" data-cmodular="'+codModular+'">')
				.append(codModular)
				)
			.append($('<td align="center">')
				.append(nombre)
				)
			.append($('<td align="center">')
				.append(nivel)
				.append($('<input type="hidden" name="idInsticion[]" value="'+idIns+'">')
					)
				)
			.append($('<td>')
				.append("")
				)
			);
	}

/*
	Este es un fragmento de codigo que nos permiten crear una tabla de personas a nivel dinamica
	resiviendo parametros tales como Nombre, apellido paterno, apellido materno, fecha de nacimiento,
	dni y id persona.
*/

	function aniadir_persona_resolucion(nom,appP,appM,fechaN,dni,idPe) {
		$("#personas-rd").find('tbody')
		.append($('<tr>')
			.append($('<td align="center">')
				.append($('<button onclick="f1(this)">')
					.append('<img src="../img/eliminar.gif">')
					)
				)
			.append($('<td align="center" data-documento="'+dni+'">')
				.append(dni)
				)
			.append($('<td align="center">')
				.append(nom)
				)
			.append($('<td align="center">')
				.append(appP+" "+appM)
				)
			.append($('<td align="center">')
				.append(fechaN)
				.append($('<input type="hidden" name="idPersona[]" value="'+idPe+'">')
					)
				)
			);
	}

	function f1(param){
		$(param).closest('tr').remove();
	}

	$("#contendor-persona").find("*").prop("disabled", true);


/*
	Este es un fragmento de codigo que nos permiten verificar la existencia de una resolucion dentro
	de la base de datos, utilizando el numero de la resolucon, año , tipo de resolucion. Obteniendo un
	Json para su comsumo posterior.
*/

	$("#btn-buscar-resolucion").click(function(e) {
		var parametros = {
			"resolucionNumero": $('#numeroResolucion').val(),
			"anioRes": $('select[name=anioResolucion]').val(),
			"tipoRes": $('select[name=tipoResolucion]').val()
		};
    /*console.log("Numero: "+parametros.resolucionNumero);
    console.log("Año: "+parametros.anioRes);
    console.log("Tipo de resolucion: "+parametros.tipoRes);*/

    $.ajax({
    	data: parametros,
    	url: '../ajax/buscar_resolucion_existe.php',
    	type: 'post',
    	beforeSend: function() {
    		$("#message-box-pr").html("Procesando, espere por favor...");
    	},
    	success: function(data) {
    		if (data.success === 1) {

    			var mssg = "Los datos ingresados pertenecen a la resolucion numero: "+data.data.Numero+" del año: "+data.data.Anio+" y tipo: "+data.data.TipoResolucion;
    			$("#message-box-pr").empty().append($('<div class="alert alert-success">').html(mssg));
    			$('#anioResolucion').attr("readonly", true);
    			$('#anioResolucion').attr("style", "pointer-events: none;");
    			$('#tipoResolucion').attr("readonly", true);
    			$('#tipoResolucion').attr("style", "pointer-events: none;");
    			$('#numeroResolucion').prop("readonly", true);
    			$("#contendor-persona").find(":input").prop("disabled", false);
    			$("#id_resolucion_pr").val(""+data.data.idResoluciones);

    		} else {
    			$("#message-box-pr").empty().append($('<div class="alert alert-warning">').html("Los datos ingresados no concuerdan con ninguna resolucion"));
    			$("#contendor-persona").find(":input").prop("disabled", true);
    			$("#id_resolucion_pr").val("");
    		}
    	},
    	error: function() {

    	}
    });
});

	$('#btnResetearRes-buscar').click(function(e){
		$("#message-box-pr").empty();
		$('#anioResolucion').removeAttr("readonly");
		$('#anioResolucion').removeAttr("style");
		$('#tipoResolucion').removeAttr("readonly");
		$('#tipoResolucion').removeAttr("style");
		$('#numeroResolucion').removeAttr("readonly");
		$('#btnGuardarRes').attr("disabled", true);
		$('#alerta-resolucion2').removeClass('collapsed');
		$('#alerta-resolucion2').addClass('collapse');


		$('#resNumRD').val("");
		$('#resConceptoRD').val("");
		$('#resAnioRD').val("");
		$('#resTipoRD').val("");
		$('#id_resolucion_pr').val("");
	});

	$('#btn-buscar-persona-p').click(function(e){
		var value = $("#numeroDeDNI").val().length;
		if (value>0) {
			buscarPersonaDocumento();
		}else{
			alert("Ingrese un numero");
		}
	});


//#######################################################################################
            // Validar solo numeros - agregar_personas - listar_persona

            $('#Documento').keyup(function(e){
            	if (/\D/g.test(this.value))
            	{
				// Filter non-digits from input value.
				this.value = this.value.replace(/\D/g, '');
			}
		});


/*
	Este fragmento de codigo te permite seleccionar y cambiar la longitud de caracteres del documento
	de la persona
*/

 $('#TipoDocumento').change(function(){
     var val = $("#TipoDocumento option:selected").text();
				var input=  $("#inpDocumento").val();

				switch(String(val)){	
					case 'DNI':
					console.log(val+" - "+1);
                    limitar_borrar('#inpDocumento', '7');
                    console.log(val+" - fin"+1);
		 			break;

		 			case 'CARNET DE EXTRANJERIA': 
		 			console.log(val+" - "+2);
		 			limitar_borrar('#inpDocumento', '12');
	console.log(val+" - fin"+2);
					break;
					
					case 'PASAPORTE':
					console.log(val+" - "+3);
				    limitar_borrar('#inpDocumento', '12');
				    console.log(val+" - fin"+3);
					break;
				}      
    });
    
    

function limitar_borrar(id, tamanio) {
	$(id).keypress(function (e) {
      var letras = $(id).val();
      if(letras.length >= tamanio){
      	console.log(id+" - Mayor de "+tamanio);
        var arrSlice = letras.slice(0,tamanio);
         $(id).val(arrSlice);
      }
    });
}


			$('#Documento').on('keydown keypress',function(e){
				if(e.key.length === 1){
					if($(this).val().length < 8 && !isNaN(parseFloat(e.key))){
						$(this).val($(this).val() + e.key);
					}
					return false;
				}
			});

			$('#Nombre').bind('keypress', function(event) {
				var regex = new RegExp("^[a-zA-Z ]+$");
				var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
				if (!regex.test(key)) {
					event.preventDefault();
					return false;
				}
			});

			$('#ApellidoPaterno').bind('keypress', function(event) {
				var regex = new RegExp("^[a-zA-Z ]+$");
				var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
				if (!regex.test(key)) {
					event.preventDefault();
					return false;
				}
			});

			$('#ApellidoMaterno').bind('keypress', function(event) {
				var regex = new RegExp("^[a-zA-Z ]+$");
				var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
				if (!regex.test(key)) {
					event.preventDefault();
					return false;
				}
			});

			//Limitar cantidad de palabras 
			$(document).ready(function(){
				$('#Nombre').keyup(function(){
					$(this).val(limitar_palabras($(this).val(),3));
				});
			});
			function limitar_palabras(texto, limite){
				var palabras = texto.split(/\b[\s,\.\-:;]*/,limite);
				texto=palabras.join(" ");
				return texto;
			}	

			$(document).ready(function(){
				$('#ApellidoPaterno').keyup(function(){
					$(this).val(limitar_palabras($(this).val(),3));
				});
			});

			$(document).ready(function(){
				$('#ApellidoMaterno').keyup(function(){
					$(this).val(limitar_palabras($(this).val(),3));
				});
			});
			function limitar_palabras(texto, limite){
				var palabras = texto.split(/\b[\s,\.\-:;]*/,limite);
				texto=palabras.join(" ");
				return texto;
			}				

//########################################################################################
			// Validar solo numeros - agregar_institucion

			$('#CodModular').keyup(function(e){
				if (/\D/g.test(this.value))
				{
				// Filter non-digits from input value.
				this.value = this.value.replace(/\D/g, '');
			}
		});

			$('#CodModular').on('keydown keypress',function(e){
				if(e.key.length === 1){
					if($(this).val().length < 7 && !isNaN(parseFloat(e.key))){
						$(this).val($(this).val() + e.key);
					}
					return false;
				}
			});			

//#########################################################################################
			// Validar solo numeros - lista_institucion
			$('#numeroResolucion').keyup(function(e){
				if (/\D/g.test(this.value))
				{
				// Filter non-digits from input value.
				this.value = this.value.replace(/\D/g, '');
			}
		});

			$('#numeroResolucion').on('keydown keypress',function(e){
				if(e.key.length === 1){
					if($(this).val().length < 5 && !isNaN(parseFloat(e.key))){
						$(this).val($(this).val() + e.key);
					}
					return false;
				}
			});	


			$(function() {
				$('#correo').on('keypress', function(e) {
					if (e.which == 32)
						return false;
				});
			});


//#########################################################################################
			// Validar solo numeros - lista_institucion

			$('.spanMPIAgregar').click(function(e){
				console.log(1);
				$('.box-view').show();
				if ($('.box-view').hasClass("minimizado")) {
					$('.box-view').removeClass("minimizado").addClass("maximizado");
					$('.box-view').show();
				}else{
					$('.box-view').removeClass("maximizado").addClass("minimizado");
					$('.box-view').hide();
				}
			});

			function floatLabel(inputType){
				$(inputType).each(function(){
					var $this = $(

						this);
			// on focus add cladd active to label
			$this.focus(function(){
				$this.next().addClass("active");
			});
			//on blur check field and remove class if needed
			$this.blur(function(){
				if($this.val() === '' || $this.val() === 'blank'){
					$this.next().removeClass();
				}
			});
		});
			}
	// just add a class of "floatLabel to the input field!"
	floatLabel(".floatLabel");

	$('#documentoKeyEnter').keypress(function(e) {
		if(e.which == 32) {
			var value = $("#documentoKeyEnter").val().length;
			if (value>0) {
				buscarPersonaDocumento();
			}else{
				alert("Ingrese un numero");
			}
		}
	});


//Auto completar Agregar_Resolucion
function ponerCeros(num) {
	while (num.value.length<5)
		num.value = '0'+num.value;
}

/*
	Este fragmento de codigo te permite buscar la institucion utilizando el teclado
	de barra espaciadora
*/

$('#modularKeyEnter').keypress(function(e) {
	if(e.which == 32) {
		var value = $("#modularKeyEnter").val().length;
		if (value>0) {
			buscarInstitucionModular();
		}else{
			alert("Ingrese un numero");
		}
	}
});


var previousValue = $("#modularKeyEnter").val();
$("#modularKeyEnter").keyup(function(e) {
	var currentValue = $(this).val();
	if(currentValue != previousValue) {
		previousValue = currentValue;
		$('#btn_ir_institucion').prop('disabled',true);
	}
});

$('#tipo_rol').bind('keypress', function(event) {
	var regex = new RegExp("^[a-zA-Z ]+$");
	var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	if (!regex.test(key)) {
		event.preventDefault();
		return false;
	}
});
		$(document).ready(function(){
		   $('.button-left').click(function(){
		       $('.sidebar').toggleClass('fliph');
		   });
		});

/*
	Este fragmento de codigo sirve para adaptar el ancho del menu de acuerdo al tamaño  
	de las resoluciones del usuario
*/

		function jqUpdateSize(){
            // Get the dimensions of the viewport
            var width = $(window).width();
            var heightW = $(window).height();
            var heightD = $(document).height();
            var height = 0;

            if (heightW>heightD) {
            	height += heightW;
            }else{
            	height += heightD;
            }

            console.log(heightW+"w - d"+heightD+" - h"+height);

            $('#jqWidth').html(width);
            $('#jqHeight').html(height);

            $('.sidebar').css(
            	{
            		height:  height,
            		overflow:" hidden"
            	}
            );

        }
        $(document).ready(jqUpdateSize);    // When the page first loads
        $(window).resize(jqUpdateSize);     // When the browser changes size

        $(window).on('resize', function() {
		    if($(window).width() < 600) {
		        $('.sidebar').addClass('fliph');
		        //$('.sidebar').removeClass('fliph');
		    }
		    else {
		        //$('.sidebar').addClass('fliph');
		        $('.sidebar').removeClass('fliph');
		    }
		});

		$(document).ready(function(){
		   if($(window).width() < 779) {
		        $('.sidebar').addClass('fliph');
		    }else {
		        $('.sidebar').removeClass('fliph');
		    }
		});


		// elementos de la lista
  var menues = $(".list-sidebar li a"); 

	$(document).ready(function () {
		$('.list-sidebar li a').each(function(){
        	$(this).removeClass('active');
        });
        var url = window.location;
    // Will only work if string in href matches with location
        $('.list-sidebar li a[href="' + url + '"]').addClass('active');

    // Will also work for relative and absolute hrefs
        $('.list-sidebar li a').filter(function () {
            return this.href == url;
        }).addClass('active').addClass('active');

    });

    $( function() {
    $("#TipoDocumento").change( function() {
        if ($(this).val() === "1") {
            $("#inpDocumento").prop("disabled", true);
        } else {
            $("#inpDocumento").prop("disabled", false);
        }
    });
    });

    function PasarValor()
    {
       document.getElementById("proyectoResolucion").value = document.getElementById("numeroResolucion").value;
    }




/*$('#FechaNacimiento').on('input', function() { 
	console.log(132);
    var dateWrite = $(this).val() // get the current value of the input field.
    var dateDif = new Date(2001, 0, 1);
    if (dateWrite > dateDif) {
    	 $(this).val("");
    }
});*/

/*$('#FechaNacimiento').on('focus blur change', function(e) {
  $(this).val(function(i, v) {
    //return v.split('/')[0].trim();
    console.log(v);
  })
});*/

/*$("#modularKeyEnter").on("input", function() {
	$('#btn_ir_institucion').prop('disabled',true);
    alert("Change to " + this.value);
});*/



</script>
</body>
</html>