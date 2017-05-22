<?php

class m170519_074454_vendor_account_no extends CDbMigration
{
	public function up()
	{
        try{
            $transaction=$this->getDbConnection()->beginTransaction();
            $sql = 'alter table groots_orders.vendor_payments modify column receiving_acc_no varchar(25) not null';
            $this->execute($sql);
            $sql = 'alter table cb_dev_groots.vendors modify column bank_account_no VARCHAR (25) DEFAULT NULL ';
            $this->execute($sql);
            $transaction->commit();
            return true;
        }catch (Exception $e){
            echo "Exception: ".$e->getMessage()."\n";
            $transaction->rollback();
            return false;
        }
	}

	public function down()
	{
		echo "m170519_074454_vendor_account_no does not support migration down.\n";
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