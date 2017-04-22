<?php

class m170329_062017_VendorAccountDetails extends CDbMigration
{
	public function up()
	{
        $transaction = Yii::app()->db->beginTransaction();
        try{
            $sql = 'alter table cb_dev_groots.vendors add column account_holder_name varchar(255) default null, add column bank_account_no BIGINT(18) default null, 
                      add column account_type enum ("Saving", "Current") default "Saving", add column bank_name VARCHAR (300) default null , 
                      add column branch_name VARCHAR (255) default null, add column isfc_code varchar (15)';
            $this->execute($sql);
            return true;
        } catch(Exception $e){
            echo "Exception: ".$e->getMessage()."\n";
            $transaction->rollBack();
            return false;
        }
	}

	public function down()
	{
		echo "m170329_062017_VendorAccountDetails does not support migration down.\n";
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