<?php

abstract class Model_Base_Parametro extends Doctrine_Record
{
	public function setTableDefinition()
	{
		$this->setTableName('parametro');
		$this->hasColumn('parametro_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             'primary' => true,
        	 'autoincrement' => true,
		));
		
		$this->hasColumn('nombre', 'string', 4, array(
             'type' => 'string',
             'length' => '4',
             'primary' => false,
			 'notnull' => false,
		));
		
		$this->hasColumn('valor', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             'fixed' => false,
             'notnull' => false,
             'primary' => false,
             'autoincrement' => false,
		));

		
	}

}
