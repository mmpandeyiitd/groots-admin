<?php 

class VendorDao{
	public function getProcExecutiveDropdownData(){
		$connection = Yii::app()->secondaryDb;
        $sql = 'select employee_id, employee_name from cb_dev_groots.groots_employee where department_id = ? and designation_id = ?';
        //echo $sql; die;
        $command = $connection->createCommand($sql);
        $command->execute();
        $data = $command->queryAll();
        $array = array();
        foreach ($data as $key => $value) {
        	$array[$value['employee_id']] = $value['employee_name'];
        }
        return $array;
	}
}

?>