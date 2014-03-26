<?php

/**
 * BaseUsuario
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @property integer $usuario_id
 * @property string $usuario
 * @property string $clave
 * @property string $notas
 * @property Doctrine_Collection $GruposUsuario
 *
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class Model_Base_Usuario extends Doctrine_Record
{
	public function setTableDefinition()
	{
		$this->setTableName('usuario');
		$this->hasColumn('usuario_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             'primary' => true,
             'autoincrement' => true,
		));
		 
		$this->hasColumn('tipo_usuario_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             'notnull' => false,
             'primary' => false,
             'autoincrement' => false,
		));
		$this->hasColumn('usuario_tipo_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             'notnull' => false,
             'primary' => false,
             'autoincrement' => false,
		));
		 
		$this->hasColumn('username', 'string', 50, array(
             'type' => 'string',
             'length' => '50',
             'fixed' => false,
             'notnull' => true,
             'primary' => false,
             'autoincrement' => false,
		));
		$this->hasColumn('password', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             'fixed' => false,
             'notnull' => false,
             'primary' => false,
             'autoincrement' => false,
		));
	}


}