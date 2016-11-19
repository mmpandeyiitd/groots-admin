<?php 

class VendorDao{
	public function getProcExecutiveDropdownData(){
        $connection = Yii::app()->secondaryDb;
        $sql = 'select employee_id, employee_name from cb_dev_groots.groots_employee where department_id = 1 and designation_id = 1';
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

    public function getVendorProductList($productId){
        $connection = Yii::app()->secondaryDb;
        $sql = 'select vpm.vendor_id, v.name from cb_dev_groots.vendor_product_mapping as vpm left join cb_dev_groots.vendors as v on v.id = vpm.vendor_id where vpm.base_product_id = '.$productId;
        //echo $sql; die;
        $command = $connection->createCommand($sql);
        $command->execute();
        $data = $command->queryAll();
        $array = array();
        foreach ($data as $key => $value) {
                $array[$value['vendor_id']] = $value['name'];
        }
        return $array;
    }

    public function getVendorProductIds($vendor_id){
        $sql = 'select base_product_id from cb_dev_groots.vendor_product_mapping where vendor_id = '.$vendor_id;

        $command = $connection->createCommand($sql);
        $command->execute();
        $data = $command->queryAll();
        $array = array();
        foreach ($data as $key => $value) {
            array_push($array, $value['base_product_id']);
        }
        return $array;
    }
        
}

?>