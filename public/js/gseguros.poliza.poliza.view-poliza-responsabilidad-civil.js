$(document).ready(
		function() {
			function confirmar() {
				return confirm('Desea agregar el registro?');
			}

		
		
			$('#fecha_vigencia_poliza_responsabilidad_civil').datepicker(
					{
						dateFormat : 'yy-mm-dd',
						dayNamesMin : [ 'Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi',
								'Sa' ],
						monthNames : [ 'Enero', 'Febrero', 'Marzo', 'Abril',
								'Mayo', 'Junio', 'Julio', 'Agosto',
								'Septiembre', 'Octubre', 'Noviembre',
								'Diciembre' ]
					});


			$('#datos_poliza_poliza_responsabilidad_civil_show').click(function() {
				$('#datos_poliza_poliza_responsabilidad_civil').toggle();
			});
			$('#datos_seguro_responsabilidad_civil_show').click(function() {
				$('#datos_seguro_responsabilidad_civil').toggle();
			});
			
			$('#detalle_riesgo_responsabilidad_civil_show').click(function() {
				$('#detalle_riesgo_responsabilidad_civil').toggle();
			});
			$('#datos_solicitud_responsabilidad_civil_show').click(function() {
				$('#datos_solicitud_responsabilidad_civil').toggle();
			});
			$('#valores_seguro_responsabilidad_civil_show').click(function() {
				$('#valores_seguro_responsabilidad_civil').toggle();
			});

			$('#datos_solicitud_responsabilidad_civil_show').click(function() {
				$('#datos_solicitud_responsabilidad_civil').toggle();
			});

			$('#observaciones_seguro_responsabilidad_civil_show').click(function() {
				$('#observaciones_seguro_responsabilidad_civil').toggle();
			});
		
			
			$("#datos_tarjeta_responsabilidad_civil_show").hide();
			$('#forma_pago_responsabilidad_civil_id').change(function(){
				//Si es el ID de pago con tarjeta
				//No deberia estar hardcodeado
				if($('#forma_pago_responsabilidad_civil_id').val()==2	){
					$("#datos_tarjeta_responsabilidad_civil_show").show();
				}else{
					$("#datos_tarjeta_responsabilidad_civil_show").hide();
				}
			});
			
//calcula importe - plus - premio asegurado
			
			$('#plus_responsabilidad_civil')
			.change(
					function() {

						var s_plus = $('#plus_responsabilidad_civil'),
						s_importe = $('#importe_responsabilidad_civil');
						 
						var plus= parseFloat(s_plus.val());
						var importe = parseFloat(s_importe.val());

						console.debug(plus);
						console.debug(importe);
						if ((plus != 0 && importe != 0)) {
							//importe = plus + premio_asegurado;
							premio_asegurado = importe - plus;
							$('#premio_asegurado_responsabilidad_civil').val(premio_asegurado.toFixed(2));
						}
					});
			$('#premio_asegurado_responsabilidad_civil')
			.change(
					function() {

						var s_premio_asegurado = $('#premio_asegurado_responsabilidad_civil'),
						s_importe = $('#importe_responsabilidad_civil');
						 
						var premio_asegurado= parseFloat(s_premio_asegurado.val());
						var importe = parseFloat(s_importe.val());

						console.debug(premio_asegurado);
						console.debug(importe);
						if ((premio_asegurado != 0 && importe != 0)) {
							//importe = plus + premio_asegurado;
							 plus = importe - premio_asegurado;
							$('#plus_responsabilidad_civil').val(plus.toFixed(2));
						}

					});
			
			
			
			
			// Guardar Solicitud
			$('#save_poliza_responsabilidad_civil').click(function() {
				
				//if(!$("#solicitud_poliza_responsabilidad_civil").valid())return false;	 

								// alert('clic');
								// trae id de tab
								var tabs_sel = $('#tabs').tabs();
								var idx = tabs_sel.tabs('option',
										'selected');

								// Trae el tab correspondiente
								var tab = $('#tabs ul li a')[idx];
								// //console.debug($('#tabs ul li a'));
								var href = $(tab).attr('href');

								// suponemos que el form es valido

								var data = $('#poliza_poliza_responsabilidad_civil').serializeArray();
								// console.debug(data);

								$.ajax({
											url : "./poliza/poliza/view-poliza-responsabilidad-civil",
											data : data,
											success : function(result) {
												$(href).html(result);
											}
										});

							});
			

		});
