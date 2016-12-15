<?php 

class WarehouseDao{

	public function getWarehouseDropdownData(){
		$connection = Yii::app()->secondaryDb;
        $sql = 'select id , name from cb_dev_groots.warehouses';
        //echo $sql; die;
        $command = $connection->createCommand($sql);
        $command->execute();
        $data = $command->queryAll();
        $array = array();
        foreach ($data as $key => $value) {
        	$array[$value['id']] = $value['name'];
        }
        return $array;
	}
}

?>