<?php

class m170324_134046_CollectionAuthAssignment extends CDbMigration
{
	public function up()
	{
        $transaction = Yii::app()->db->beginTransaction();
        try{
            $sql = 'insert into cb_dev_groots.AuthItem (name, type) VALUES ("CollectionEditor", 1), ("CollectionViewer", 0)';
            $this->execute($sql);
            $sql = "insert into cb_dev_groots.AuthItemChild (parent, child) VALUES ('WarehouseEditor', 'CollectionEditor'), ('CollectionEditor', 'CollectionViewer')";
            $this->execute($sql);
        } catch(Exception $e){
            echo "Exception: ".$e->getMessage()."\n";
            $transaction->rollBack();
            return false;
        }

	}

	public function down()
	{
		echo "m170324_134046_CollectionAuthAssignment does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}