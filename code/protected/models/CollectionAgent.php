<?php
/**
 * This is the model class for table "collection_agent".
 *
 * The followings are the available columns in table 'collection_agent':
 * @property integer $id
 * @property string $name
*/


class CollectionAgent extends CActiveRecord{


	public function tableName() {
        return 'collection_agent';
    }

    public function rules() {
    	return array(
    		array('id,name', 'required'),
    		array('id','numerical','integerOnly'),
    		array('name','length','max' => 250),
    		array('name', 'match', 'pattern' => '/^[a-zA-Z\s]+$/', 'message' => 'Invalid characters in name.'),
    		array('name', 'unique', 'on' => 'insert', 'message' => 'name already exists!'),
    		array('id', 'unique', 'on' => 'insert', 'message' => 'id already exists!'),
    		array('id, name' , 'safe', 'on' => 'search'),
    		);
    }
    public function relations(){
    	return array();
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
?>