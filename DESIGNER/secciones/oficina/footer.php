
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="../tema/js/jquery-3.4.0.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="../tema/js/bootstrap.min.js"></script>
		<script src="../tema/js/metisMenu.min.js"></script>
		<script>
		
		$('#metismenu').metisMenu();
 		$('#conteido-app').css('height', $(window).height());

		/*
				efecto de ocultar al menu y adaptar el contenedor de la web
				a un tamaño mas amplio
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
			$(document).ready(function(){
		   $('.button-left').click(function(){
		       $('.sidebar').toggleClass('fliph');
		   });
		});


		/*
			
			Este codigo sirve para adaptar el menu izquierdo al tamaño del monitor del cliente

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



        function ponerCeros(num) {
	       while (num.value.length<5)
		   num.value = '0'+num.value;
        }

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