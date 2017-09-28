<?php
class Domain_Parametro {
	private $_model ;
	

	public function __construct($id=null){

		$model = new Model_Parametro();
		$this->_model = ($id==null)?new $model: $model->getTable()->find($id) ;
		

	}
	public function getModel(){
		return $this->_model;
	}

	public function getById($id){
		$row = $this->_model
		->getTable()
		->createQuery()
		->andWhere('perfil_id = ?',$id)
		->execute()
		->toArray();
		return $row;
	}
	public function deleteByPerfilId($id){

		$this->_model_menu_perfil->getTable()->findByPerfilId($id)->delete();
		//echo "<pre>";
		//print_r($temp);
		//exit;
	}
	public function addMenuByPerfil($perfil_id,$menu_items){

		foreach ($menu_items as $menu_id){
			if(!empty($menu_id)){
				$m_menu_perfil = new Model_MenuPerfil();
				$m_menu_perfil->perfil_id = $perfil_id;
				$m_menu_perfil->menu_id = $menu_id;
				$m_menu_perfil->save();
			}
		}

	}
	public static function existsMenu($perfil_id,$menu_id){
		$m_menu_perfil = new Model_MenuPerfil();
		
		$menu_id =  $m_menu_perfil->getTable()
		->createQuery()
		->andWhere('perfil_id = ? and menu_id= ?',array($perfil_id,$menu_id))
		->execute()
		->toArray();
		
		$empty = empty($menu_id);
		return $empty;
	}

	public static function getParametros(){
		$m_parametro = new Model_Parametro();
		return $m_parametro->getTable()->findAll()->toArray();
	}


	public static function getParametroByNombre($nombre){
		$m_parametro = new Model_Parametro();
		
		$valor =  $m_parametro->getTable()
		->createQuery()
		->andWhere('nombre = ?',array($nombre))
		->execute()
		->toArray();
		//print_r($valor);
		//$empty = empty($valor);
		return $valor[0]['valor'];
	}
}
