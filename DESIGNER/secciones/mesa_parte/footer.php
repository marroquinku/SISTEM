
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="../tema/js/jquery-3.4.0.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="../tema/js/bootstrap.min.js"></script>
		<script src="../tema/js/metisMenu.min.js"></script>
		<script type="text/javascript" src="../tema/js/bootstrap-filestyle.min.js"> </script>

		<script>
			$('#anioResolucion').attr("style", "pointer-events: none;");
			$('#tipoResolucion').attr("style", "pointer-events: none;");

		$('.lista-res li').click(function(){
			var n = $(this).data("numero");
			var tipoRes = $(this).data("tipores");
			var anioRes = $(this).data("aniores");

			if(!isNaN(parseFloat(n)) && isFinite(n)){
				$('#numeroResolucion').val(n);
			}

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


			$('#metismenu').metisMenu();
 			$('#conteido-app').css('height', $(window).height());


		 		function realizaProceso(){
				        var parametros = {
				                "resolucionNumero" : $('#numeroResolucion').val(),
				                "anioRes" : $('select[name=anioResolucion]').val(),
								"tipoRes" : $('select[name=tipoResolucion]').val()
				        };
						console.log("Numero: "+parametros.resolucionNumero);
						console.log("Año: "+parametros.anioRes);
						console.log("Tipo de resolucion: "+parametros.tipoRes);

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
											console.log(data.data.message);
										}else{
											$('#alerta-resolucion').removeClass('collapsed');
											$('#alerta-resolucion').addClass('collapse');
											
											$('#alerta-resolucion2').removeClass('collapse');
											$('#alerta-resolucion2').addClass('collapsed');

											$('#anioResolucion').attr("disabled", true);
											$('#tipoResolucion').attr("disabled", true);

											$('#btnGuardarRes').removeAttr("disabled");
											console.log(data.data.message);
										}

				                },
			          			error: function(){

			          			} 
				        });
				}
			
			$('#btn-verificar').click(function(e){
				var value = $("#numeroResolucion").val().length;
				if (value>0) {
					realizaProceso();
				}else{
					alert("Ingrese un numero");
				}
			});

			$("#subirResolucion").filestyle({
				btnClass: "btn-success",
				text: "Buscar"
			});

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

			$(document).ready(function(){
		   $('.button-left').click(function(){
		       $('.sidebar').toggleClass('fliph');
		   });
		});

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

        function ponerCeros(num) {
	       while (num.value.length<5)
		   num.value = '0'+num.value;
        }

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

		</script>
	</body>
	</html>