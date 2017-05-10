<?php

class m170510_110632_addZipFile extends CDbMigration
{
    private $_db= '';
	public function up()
	{
	    try{
            $this->_db = 'cb_dev_groots';
            $transaction=$this->getDbConnection()->beginTransaction();
            $sql = 'insert into permitted_file_types values(null , "Zip", "zip"), (null, "Zip", "rar")';
            $this->execute($sql);
            return true;
        }catch (Exception $e){
            echo "Exception: ".$e->getMessage()."\n";
	        $transaction->rollback();
	        return false;
        }
	}

	public function down()
	{
		echo "m170510_110632_addZipFile does not support migration down.\n";
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