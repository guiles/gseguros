<?php
require_once ('IndexController.php');

class Operaciones_DeudaAseguradoController extends Operaciones_IndexController
{
	private $_solicitud = null;
	private $_sesion = null;
	private $_usuario = null;
	private $_services_solicitud = null;
	private $_t_usuario = null;


	public function init()
	{

		if ( ! (Zend_Auth::getInstance()->hasIdentity())  ) {

			$this->_helper->redirector('index','login','default');
		}

		$this->_helper->layout->disableLayout();
		$this->_solicitud = new Domain_Poliza();
		$this->_services_simple_crud = new Services_SimpleCrud();
		$this->_services_solicitud = new Services_Solicitud();
		$this->_sesion = Domain_Sesion::getInstance();
		$this->_usuario = $this->_sesion->getUsuario();
		$this->_t_usuario = $this->_usuario->getTipoUsuario();

		if( $this->_usuario->getAcl()->hasPermission('solicitud') ) {

			//exit('tiene permiso');
		} else {
			//exit('no tiene permiso');
		}
		
		$this->view->isAgente = false;

		$rol_usuario = $this->_t_usuario->getNombre();
                if($rol_usuario=='AGENTE'){

                        $this->view->isAgente = true;
                        $this->view->agente_id = $this->_usuario->getModel()->usuario_tipo_id;
                        $this->view->agente_nombre = Domain_Agente::getNameById($this->_usuario->getModel()->usuario_tipo_id);
                        //print_r($this->view->agente_nombre);
                }elseif($rol_usuario=='OPERADOR'){

                        $this->view->isOperador = true;
               }


		$logger = Zend_Registry::get('logger');
		$logger->log($this->_usuario->getEntidad() , Zend_Log::INFO);
			
	}

	public function indexAction()
	{
		$this->_forward('list','solicitud','poliza');

	}

	public function listAction()
	{
		$solicitud = new Domain_Asegurado();

		$params = $this->_request->getParams();
		//Buscar es siempre true por ahora
		$this->view->buscar = true;
		/*if(isset($params['buscar'])){
			$rows =$this->_t_usuario->findAseguradoByNombre($params['nombre']);

			}else{
			$rows = $this->_t_usuario->getAsegurados();
			}*/

		$rows =$this->_t_usuario->findAseguradoByNombre($params['criterio']);

		$page=$this->_getParam('page',1);
			
		$paginator = Zend_Paginator::factory($rows);
		$paginator->setItemCountPerPage(10);
		$paginator->setCurrentPageNumber($page);
		$this->view->criterio = $params['criterio'];

		$this->view->rows = $paginator;

	}
	//Por ahora trae por separado los tipos de poliza, despues ver una solucion
	//integral, esto es para que pueda usarlo sconsultora
	public function deudaAseguradoAction(){
		
		$params = $this->_request->getParams();
	
		$this->view->asegurado = Domain_Asegurado::getNameById($params['asegurado_id']);
		//Trae el pago del asegurado
		//Seria la sumatoria de todos los pagos que hizo
		$moneda_pesos = Domain_Helper::getHelperIdByDominioAndName('moneda', 'PESOS');
		$moneda_dolar = Domain_Helper::getHelperIdByDominioAndName('moneda', 'DOLAR');
		$moneda_euro = Domain_Helper::getHelperIdByDominioAndName('moneda', 'EURO');
		 
		
		
		//Trae la sumatoria de todo lo que pago
		$this->view->debe_pesos = Domain_Asegurado::getDebeByAseguradoIdAndMoneda($params['asegurado_id'],$moneda_pesos);
		$this->view->debe_dolar = Domain_Asegurado::getDebeByAseguradoIdAndMoneda($params['asegurado_id'],$moneda_dolar);
		$this->view->debe_euro = Domain_Asegurado::getDebeByAseguradoIdAndMoneda($params['asegurado_id'],$moneda_euro);
		
		//Me trae las polizas del asegurado por ahora todas
		//$rows = $this->_t_usuario->getPolizaByAsegurado($params['asegurado_id']);
		
		//Trae las polizas aduaneras
		//$this->view->polizas_aduaneros = $this->_t_usuario->getPolizaInpagaByAseguradoAndTipo($params['asegurado_id'],2);
		//$this->view->polizas_automotor = $this->_t_usuario->getPolizaInpagaByAseguradoAndTipo($params['asegurado_id'],7);
		//$this->view->polizas_alquiler = $this->_t_usuario->getPolizaInpagaByAseguradoAndTipo($params['asegurado_id'],5);
		//$this->view->polizas_construccion = $this->_t_usuario->getPolizaInpagaByAseguradoAndTipo($params['asegurado_id'],4);
		
		
		$this->view->monedas = Domain_Helper::getHelperByDominio('moneda');
		$this->view->asegurado_id = $params['asegurado_id'];
		
	}
	

	public function pagarDeudaAseguradoAction(){

		$params = $this->_request->getParams();
		/*echo"<pre>";
		print_r($params);

		exit;*/
		//aca tiene que pasar el parametro de "pagar" o algo parecido
		if(!empty($params['array_polizas'])){
			
			//tipo de movimiento Deuda Asegurado ( tipo_movimiento_id=0)
			//1. Guardo el movimiento del pago
			$m_movimiento = new Model_Movimiento();
			$m_movimiento->importe = $params['importe'];
			$m_movimiento->importe_efectivo = $params['importe_efectivo'];
			$m_movimiento->cotizacion_divisa = $params['cotizacion_divisa'];
			$m_movimiento->asegurado_id = $params['asegurado_id'];
			$m_movimiento->fecha_pago = $params['fecha_pago'];
			$m_movimiento->moneda_id = $params['moneda_id'];
			$m_movimiento->descuento = $params['descuento'];
			$m_movimiento->tipo_movimiento_id = 0;
			$m_movimiento->numero_factura = $params['numero_factura'];
			$m_movimiento->save();
			
			/*
			 * Guardo datos del cheque, por ahora lo hago asi, no se que mierda le pasa que 
			 * no puedo pasar un array
			 * */
		
			for($i=0;$i<6;$i++){

			$m_datos_cheque = new Model_DatosCheque();
			$m_datos_cheque->movimiento_id = $m_movimiento->movimiento_id;
			$importe_cheque = 'importe_cheque_'.$i;
			$banco_cheque = 'banco_cheque_'.$i;
			$nro_cheque = 'nro_cheque_'.$i;

			$m_datos_cheque->importe = $params[$importe_cheque]; 
			$m_datos_cheque->banco = $params[$banco_cheque];
			$m_datos_cheque->numero = $params[$nro_cheque];
			
			$m_datos_cheque->save();
			//print_r($params['$importe_cheque']);
			}
/*			$m_datos_cheque = new Model_DatosCheque();
			$m_datos_cheque->movimiento_id = $m_movimiento->movimiento_id;
			$m_datos_cheque->importe = $params['importe_cheque_0']; 
			$m_datos_cheque->banco = $params['banco_cheque_0'];
			$m_datos_cheque->numero = $params['nro_cheque_0'];
			
			$m_datos_cheque->save();

			$m_datos_cheque = new Model_DatosCheque();
			$m_datos_cheque->movimiento_id = $m_movimiento->movimiento_id;
			$m_datos_cheque->importe = $params['importe_cheque_1']; 
			$m_datos_cheque->banco = $params['banco_cheque_1'];
			$m_datos_cheque->numero = $params['nro_cheque_1'];
			
			$m_datos_cheque->save();
			
			$m_datos_cheque = new Model_DatosCheque();
			$m_datos_cheque->movimiento_id = $m_movimiento->movimiento_id;
			$m_datos_cheque->importe = $params['importe_cheque_2']; 
			$m_datos_cheque->banco = $params['banco_cheque_2'];
			$m_datos_cheque->numero = $params['nro_cheque_2'];
			
			$m_datos_cheque->save();
*/			
			/*
			 * Fin guardo datos de cheques
			 */
			/*
			 * 2.Pongo como paga la poliza
			 * 3.Guardo las asociaciones con las polizas 
			 */
			$id_pago_poliza = explode(',',$params['array_polizas']);
			foreach($id_pago_poliza as $id_cuota_poliza){
				//echo "<br>Paga esta parte de la poliza".$id_cuota_poliza;

				if(empty($id_cuota_poliza)) break;
				//2.Marca como paga
				$m_detalle_pago_cuota = new Model_DetallePagoCuota();
				$res = $m_detalle_pago_cuota->getTable()
				->createQuery()//->toArray();
				->where("detalle_pago_cuota_id = ?",$id_cuota_poliza)
				->execute();
				//->toArray();
				//->getSqlQuery();
				//poliza_id = detalle_pago_cuota_id en movimiento poliza
				$detalle = $res->getFirst();
				$detalle->pago_id = 1;
				$detalle->fecha_pago = $params['fecha_pago'];
				$detalle->save();

			//3. Asocia el movimiento con la poliza
			$m_movimiento_poliza = new Model_MovimientoPoliza();
			$m_movimiento_poliza->movimiento_id = $m_movimiento->movimiento_id;

			//aca poliza_id es id_cuota_poliza porque en deuda cliente se paga en cuotas
			$m_movimiento_poliza->poliza_id = $id_cuota_poliza; 
			
			$m_movimiento_poliza->save();
			
			
				
			}
			
			$this->view->nro_movimiento = $m_movimiento_poliza->movimiento_id;
			 
		}


		/*if(!empty($params['array_polizas'])){
			$id_pago_poliza = explode(',',$params['array_polizas']);

			foreach($id_pago_poliza as $id_cuota_poliza){
			//Marca como pagada
			$m_detalle_pago_cuota = new Model_DetallePagoCuota();
			$res = $m_detalle_pago_cuota->getTable()
			->createQuery()//->toArray();
			->where("detalle_pago_cuota_id = ?",$id_cuota_poliza)
			->execute();
			//->toArray();
			//->getSqlQuery();
			$detalle = $res->getFirst();
			$detalle->pago = 1;
			$detalle->save();

			//print_r($res->getFirst()->detalle_pago_cuota_id);
			//print_r($m_detalle_pago_cuota);
			//echo " y esta:".$id_cuota_poliza;
			}
			}
			*/

	}
		
	public function buscarPolizaDeudaAseguradoAction(){
		
		$params = $this->_request->getParams();
		//echo "<pre>";
		//print_r($params);
		//Despues le pongo el asegurado
		$this->view->polizas = $this->_t_usuario->findPolizaInpagaByAsegurado($params['nro_poliza'],$params['asegurado_id']);
		
		//print_r($this->view->polizas);
		//exit;
		
	}
	
	public function imprimirListadoPolizaDeudaAction(){
		
		$params = $this->_request->getParams();
		echo "<pre>";
		print_r($params);
		//Despues le pongo el asegurado
		//$this->view->polizas = $this->_t_usuario->findPolizaInpagaByAsegurado($params['nro_poliza'],$params['asegurado_id']);
		
		//print_r($this->view->polizas);
		//exit;
		
	}
	
	public function viewAction()
	{

		$params = $this->_request->getParams();
		$row = $this->_services_simple_crud
		->getById($this->_solicitud->getModel(),array('primary_key'=>'solicitud_id','value'=>$params['id']));

		$this->view->row = $row;

	}
	public function addAction()
	{
		$params = $this->_request->getParams();
		$values =  array_slice($params,4); //saca la data de mas

		if( isset($params['add']) ){
			$this->_services_simple_crud->save($this->_solicitud->getModel(),$values);
		}

	}
	public function editAction()
	{
		$params = $this->_request->getParams();
		$values =  array_slice($params,3); //saca la data de mas
		$this->_services_simple_crud->save($this->_solicitud->getModel(),$values);
		$this->view->params = $params;


	}
	public function deleteAction()
	{

	}
	public function listarAseguradosAction(){

		$this->_helper->viewRenderer->setNoRender ();

		$asegurado= new Domain_Asegurado();
		$asegurados = $asegurado->getModel()->getTable()->findAll()->toArray();
		$asegurados_format = array();
		//le doy formato al array
		foreach($asegurados as $asegurado){
			$asegurados_format[$asegurado['nombre']]=$asegurado['asegurado_id'];
		}
		$params = $this->_request->getParams();
		$q = $params['q'];

		foreach ($asegurados_format as $key=>$value) {

			if (strpos(strtolower($key), $q) !== false) {
				echo "$key|$value\n";
			}

		}


	}
}