<?php
class Domain_Compania {
	private $_model ;


	public function __construct($id=null){

		$model = new Model_Compania();
		$this->_model = ($id==null)?new $model: $model->getTable()->find($id) ;


	}
	public function getModel(){
		return $this->_model;
	}

	public function getById($id){
		
		$row = $this->_model
		->getTable()
		->createQuery()
		->andWhere('estado_id = ?',1)
		->andWhere('compania_id = ?',$this->_model->compania_id)
		->execute()
		->toArray();
		return $row;
	}

	
	/*
	 * Filtra poliza por compania
	 * estado_id=1 => solicitudes confirmadas
	 */
		
	public function getPolizas(){
	$this->_model_poliza = new Model_Poliza();
	
		$row = $this->_model_poliza
		->getTable()
		->createQuery()
		->andWhere('estado_id = ?',1)
		->andWhere('compania_id = ?',$this->_model->compania_id)
		->execute()
		->toArray();
		//->getSqlQuery();
		//echo "<pre>";
		//print_r($row);
		//print_r($this->_model->compania_id);
		return $row;

	}
	//Filtra poliza por compania
	public function findPolizaByNumero($numero){
		
	$this->_model_poliza = new Model_Poliza();
		$row = $this->_model_poliza
		->getTable()
		->createQuery()
		->andWhere('estado_id = ?',1)
		->andWhere('compania_id = ?',$this->_model->compania_id)
		->andWhere('numero_solicitud like ? OR numero_poliza like ?',array("%$numero%","%$numero%"))
		->execute()
		->toArray();
		//->getSqlQuery();
		//echo "<pre>";
		//print_r($row);
		return $row;

	}
	
	public static function getNameById($id){

		$m_compania = new Model_Compania();
		$compania = $m_compania->getTable()->find($id);
		
		return $compania->nombre;
	}

	public static function getDebeByCompaniaIdAndMoneda($compania_id,$moneda_id){

		$estado_id = Domain_Helper::getHelperIdByDominioAndName('estado_pago', 'DEBE');
		$estado_baja = Domain_EstadoPoliza::getIdByCodigo('BAJA_POR_LIBERACION');
		$estado_afectada = Domain_EstadoPoliza::getIdByCodigo('AFECTADA');
		$estado_vigente = Domain_EstadoPoliza::getIdByCodigo('VIGENTE');
		$estado_refacturado = Domain_EstadoPoliza::getIdByCodigo('REFACTURADO');
		$estado_baja_devolucion = Domain_EstadoPoliza::getIdByCodigo('BAJA_POR_DEVOLUCION');
		$estado_no_renovado = Domain_EstadoPoliza::getIdByCodigo('NO_RENOVADO');
		$estado_nota_credito = Domain_EstadoPoliza::getIdByCodigo('NOTA_DE_CREDITO');


		$debe = Doctrine_Query::create()
		->select('sum(dpc.importe) as debe')
		->from('Model_Poliza p, p.Model_DetallePago dp, dp.Model_DetallePagoCuota dpc')
		->where('p.compania_id = ? and dpc.pago_id = ? and dp.moneda_id = ? ',array($compania_id,$estado_id,$moneda_id))
		->andwhere('p.estado_id = ? OR p.estado_id =? OR p.estado_id =? 
		OR p.estado_id = ? OR p.estado_id = ? OR p.estado_id =? OR p.estado_id =?'
		,array($estado_baja,$estado_afectada,$estado_refacturado,$estado_vigente,$estado_baja_devolucion,$estado_no_renovado,$estado_nota_credito))
		->execute()
		->toArray();
		
		//Redondeo dos decimales
		return round($debe[0]['debe'],2);
	}
	
		public static function getDebeByCompaniaIdAndMonedaPremioAsegurado($compania_id,$moneda_id){

		$estado_id = Domain_Helper::getHelperIdByDominioAndName('estado_pago', 'DEBE');
		$estado_baja = Domain_EstadoPoliza::getIdByCodigo('BAJA_POR_LIBERACION');
		$estado_afectada = Domain_EstadoPoliza::getIdByCodigo('AFECTADA');
		$estado_vigente = Domain_EstadoPoliza::getIdByCodigo('VIGENTE');
		$estado_refacturado = Domain_EstadoPoliza::getIdByCodigo('REFACTURADO');
		$estado_baja_devolucion = Domain_EstadoPoliza::getIdByCodigo('BAJA_POR_DEVOLUCION');
		$estado_no_renovado = Domain_EstadoPoliza::getIdByCodigo('NO_RENOVADO');
		$estado_nota_credito = Domain_EstadoPoliza::getIdByCodigo('NOTA_DE_CREDITO');


		$debe = Doctrine_Query::create()
		->select('sum(pv.premio_asegurado) as debe')
		->from('Model_Poliza p, p.Model_PolizaValores pv')
		->where('p.compania_id = ? and p.pago_compania_id = ? and pv.moneda_id = ? ',array($compania_id,$estado_id,$moneda_id))
		->andwhere('p.estado_id = ? OR p.estado_id =? OR p.estado_id =? 
		OR p.estado_id = ? OR p.estado_id = ? OR p.estado_id =? OR p.estado_id =?'
		,array($estado_baja,$estado_afectada,$estado_refacturado,$estado_vigente,$estado_baja_devolucion,$estado_no_renovado,$estado_nota_credito))
		->execute()
		->toArray();
		//->getSqlQuery();
		
		//Redondeo dos decimales
		return round($debe[0]['debe'],2);
	}
	
	public static function getMovimientosByCompaniaId($id){
		$m_movimiento = new Model_Movimiento();
		$rows = $m_movimiento->getTable()
		->createQuery()
		->where('compania_id = ?',$id)
		->orderBy('movimiento_id desc')
		->execute()
		->toArray();	
		return $rows;
	}

	public static function getMovimientosByCompaniaIdAndPoliza($id,$numero_poliza=null){
//SELECT * FROM movimiento m, movimiento_poliza mp, 
//poliza p where m.movimiento_id=mp.movimiento_id and mp.poliza_id=p.poliza_id and numero_poliza like'%1234%'
	
	$rows = Doctrine_Query::create()
		->select('m.*')
		->from('Model_Movimiento m, m.Model_MovimientoPoliza mp,mp.Model_Poliza p')
		->where('m.compania_id = ?',array($id))
		->andWhere('p.numero_poliza like ? ',array("%$numero_poliza%"))
		->andWhere('m.tipo_movimiento_id = ?',1)
		->orderBy('m.movimiento_id desc')
		->execute()
		->toArray();
		//->getSqlQuery();

		return $rows;
	}
	
	public static function getDebePremioCompaniaByCompaniaIdAndMoneda($compania_id,$moneda_id){

		/*
		 *  SELECT sum( pv.premio_compania )
			FROM poliza p, poliza_valores pv
			WHERE p.poliza_valores_id = pv.poliza_valores_id
			AND p.compania_id =1
			AND p.pago_compania_id =0
		 * 
		 */
		$estado_id = Domain_Helper::getHelperIdByDominioAndName('estado_pago', 'DEBE');
		$estado_baja = Domain_EstadoPoliza::getIdByCodigo('BAJA_POR_LIBERACION');
		$estado_afectada = Domain_EstadoPoliza::getIdByCodigo('AFECTADA');
		$estado_vigente = Domain_EstadoPoliza::getIdByCodigo('VIGENTE');
		$estado_refacturado = Domain_EstadoPoliza::getIdByCodigo('REFACTURADO');
		$estado_baja_devolucion = Domain_EstadoPoliza::getIdByCodigo('BAJA_POR_DEVOLUCION');
		$estado_no_renovado = Domain_EstadoPoliza::getIdByCodigo('NO_RENOVADO');
		$estado_nota_credito = Domain_EstadoPoliza::getIdByCodigo('NOTA_DE_CREDITO');


		$debe = Doctrine_Query::create()
		->select('sum(pv.premio_compania) as debe')
		->from('Model_Poliza p, p.Model_PolizaValores pv')
		->where('p.compania_id = ? and p.pago_compania_id = ? and pv.moneda_id = ? ',array($compania_id,0,$moneda_id))
		->andwhere('p.estado_id = ? OR p.estado_id =? OR p.estado_id =? 
		OR p.estado_id = ? OR p.estado_id = ? OR p.estado_id =? OR p.estado_id =?'
		,array($estado_baja,$estado_afectada,$estado_refacturado,$estado_vigente,$estado_baja_devolucion,$estado_no_renovado,$estado_nota_credito))
		->execute()
		->toArray();
		//->getSqlQuery();
		//echo "<pre>";
		//print_r($debe);
		//Redondeo dos decimales
		return round($debe[0]['debe'],2);
	}
	
	public static function getPagoPremioCompaniaByCompaniaIdAndMoneda($compania_id,$moneda_id){

		/*
		 *  SELECT sum( pv.premio_compania )
			FROM poliza p, poliza_valores pv
			WHERE p.poliza_valores_id = pv.poliza_valores_id
			AND p.compania_id =1
			AND p.pago_compania_id =0
		 * 
		 */
		$estado_id = Domain_Helper::getHelperIdByDominioAndName('estado_pago', 'DEBE');
		$estado_baja = Domain_EstadoPoliza::getIdByCodigo('BAJA_POR_LIBERACION');
		$estado_afectada = Domain_EstadoPoliza::getIdByCodigo('AFECTADA');
		$estado_vigente = Domain_EstadoPoliza::getIdByCodigo('VIGENTE');
		$estado_refacturado = Domain_EstadoPoliza::getIdByCodigo('REFACTURADO');
		$estado_baja_devolucion = Domain_EstadoPoliza::getIdByCodigo('BAJA_POR_DEVOLUCION');
		$estado_no_renovado = Domain_EstadoPoliza::getIdByCodigo('NO_RENOVADO');
		$estado_nota_credito = Domain_EstadoPoliza::getIdByCodigo('NOTA_DE_CREDITO');


		$debe = Doctrine_Query::create()
		->select('sum(pv.premio_compania) as debe')
		->from('Model_Poliza p, p.Model_PolizaValores pv')
		->where('p.compania_id = ? and p.pago_compania_id = ? and pv.moneda_id = ? ',array($compania_id,1,$moneda_id))
		->andwhere('p.estado_id = ? OR p.estado_id =? OR p.estado_id =? 
		OR p.estado_id = ? OR p.estado_id = ? OR p.estado_id =? OR p.estado_id =?'
		,array($estado_baja,$estado_afectada,$estado_refacturado,$estado_vigente,$estado_baja_devolucion,$estado_no_renovado,$estado_nota_credito))
		->execute()
		->toArray();
		//->getSqlQuery();

		//Redondeo dos decimales
		return round($debe[0]['debe'],2);
	}
	
	
}
