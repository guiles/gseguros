<?php

abstract class Model_Base_Poliza extends Doctrine_Record
{
	public function setTableDefinition()
	{
		$this->setTableName('poliza');
		$this->hasColumn('poliza_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             'primary' => true,
        	 'autoincrement' => true,
		));

		$this->hasColumn('tipo_poliza_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
              'notnull' => false,
        	 'autoincrement' => false,
		));
		$this->hasColumn('numero_solicitud', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
              'notnull' => false,
        	 'autoincrement' => false,
		));
		$this->hasColumn('numero_poliza', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             'fixed' => false,
             'notnull' => false,
             'primary' => false,
             'autoincrement' => false,
		));
		$this->hasColumn('numero_factura', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             'fixed' => false,
             'notnull' => false,
             'primary' => false,
             'autoincrement' => false,
		));

		$this->hasColumn('endoso', 'string', 4, array(
             'type' => 'string',
             'length' => '4',
             'fixed' => false,
             'notnull' => false,
             'primary' => false,
             'autoincrement' => false,
		));

		$this->hasColumn('tomador_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
              'notnull' => false,
        	 'autoincrement' => false,
		));

		$this->hasColumn('asegurado_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
              'notnull' => false,
        	 'autoincrement' => false,
		));

		$this->hasColumn('agente_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
              'notnull' => false,
        	 'autoincrement' => false,
		));

		$this->hasColumn('compania_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
              'notnull' => false,
        	 'autoincrement' => false,
		));

		$this->hasColumn('productor_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
              'notnull' => false,
        	 'autoincrement' => false,
		));

		$this->hasColumn('cobrador_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
      		  'notnull' => false,
        	 'autoincrement' => true,
		));

		$this->hasColumn('periodo_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
              'notnull' => false,
        	 'autoincrement' => true,
		));

		$this->hasColumn('forma_pago_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
              'notnull' => false,
        	 'autoincrement' => true,
		));

		$this->hasColumn('detalle_pago_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
              'notnull' => false,
        	 'autoincrement' => true,
		));

		$this->hasColumn('fecha_pedido', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             'fixed' => false,
             'notnull' => false,
             'primary' => false,
             'autoincrement' => false,
		));

		$this->hasColumn('fecha_vigencia', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             'fixed' => false,
             'notnull' => false,
             'primary' => false,
             'autoincrement' => false,
		));

		$this->hasColumn('fecha_vigencia_hasta', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             'fixed' => false,
             'notnull' => false,
             'primary' => false,
             'autoincrement' => false,
		));

		$this->hasColumn('poliza_detalle_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
              'notnull' => false,
        	 'autoincrement' => true,
		));

		$this->hasColumn('poliza_valores_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
              'notnull' => false,
        	 'autoincrement' => true,
		));


		$this->hasColumn('operacion_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
              'notnull' => false,
        	 'autoincrement' => true,
		));

		$this->hasColumn('estado_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
              'notnull' => false,
        	 'autoincrement' => true,
		));

        $this->hasColumn('tipo_endoso_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
              'notnull' => false,
             'autoincrement' => false,
        ));

		$this->hasColumn('fecha_baja', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             'fixed' => false,
             'notnull' => false,
             'primary' => false,
             'autoincrement' => false,
		));


		$this->hasColumn('observaciones_compania', 'string', 512, array(
             'type' => 'string',
             'length' => '512',
             'fixed' => false,
             'notnull' => false,
             'primary' => false,
             'autoincrement' => false,
		));


		$this->hasColumn('observaciones_asegurado', 'string',512, array(
             'type' => 'string',
             'length' => '512',
             'fixed' => false,
             'notnull' => false,
             'primary' => false,
             'autoincrement' => false,
		));
		$this->hasColumn('pago_compania_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
              'notnull' => false,
        	 'autoincrement' => true,
		));


        $this->hasColumn('poliza_poliza_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
              'notnull' => false,
             'autoincrement' => false,
        ));
	}

	public function setUp()
	{
		$this->hasOne('Model_DetallePago', array(
                'local' => 'detalle_pago_id',
                'foreign' => 'detalle_pago_id'
               	 )
               );

        $this->hasOne('Model_PolizaValores', array(
                'local' => 'poliza_valores_id',
                'foreign' => 'poliza_valores_id'
                )
                );
                
       $this->hasMany('Model_MovimientoPoliza', array(
                'local' => 'poliza_id',
                'foreign' => 'poliza_id'
                )
                );         
       $this->hasOne('Model_Asegurado', array(
                'local' => 'asegurado_id',
                'foreign' => 'asegurado_id'
                )
                );       
       $this->hasOne('Model_Agente', array(
                'local' => 'agente_id',
                'foreign' => 'agente_id'
                )
                );       
	}

}