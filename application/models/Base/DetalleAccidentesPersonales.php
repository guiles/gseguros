<?php
abstract class Model_Base_DetalleAccidentesPersonales extends Doctrine_Record
{
	public function setTableDefinition()
	{
		$this->setTableName('detalle_accidentes_personales');
		$this->hasColumn('detalle_accidentes_personales_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             'primary' => true,
        	 'autoincrement' => true,
		));

		$this->hasColumn('tipo_garantia_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
		     'notnull' => false,
             'primary' => false,
             'autoincrement' => false,
		));


		$this->hasColumn('motivo_garantia_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
		  'notnull' => false,
             'primary' => false,
             'autoincrement' => false,
		));

		$this->hasColumn('beneficiario_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
		  'notnull' => false,
             'primary' => false,
             'autoincrement' => false,
		));
		
		$this->hasColumn('cantidad_personas', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             'fixed' => false,
             'notnull' => false,
             'primary' => false,
             'autoincrement' => false,
		));

		$this->hasColumn('tareas_a_realizar', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             'fixed' => false,
             'notnull' => false,
             'primary' => false,
             'autoincrement' => false,
		));

		$this->hasColumn('altura_maxima', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             'fixed' => false,
             'notnull' => false,
             'primary' => false,
             'autoincrement' => false,
		));
		
		$this->hasColumn('datos_adicionales', 'string', 512, array(
             'type' => 'string',
             'length' => '512',
             'fixed' => false,
             'notnull' => false,
             'primary' => false,
             'autoincrement' => false,
		));

		$this->hasColumn('documentacion_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
              'notnull' => false,
             'primary' => false,
             'autoincrement' => false,
            ));

	}

}


