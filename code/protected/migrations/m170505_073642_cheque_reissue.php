<?php

class m170505_073642_cheque_reissue extends CDbMigration
{
	public function up()
	{
        $transaction = Yii::app()->secondaryDb->beginTransaction();
        try{
            $sql = 'alter table groots_orders.vendor_payments
                    add column is_cheque_reissued enum("Yes", "No") not null default "No",
                    add column reissue_ref_no VARCHAR (256) default null';
            $this->execute($sql);
        } catch(Exception $e){
            echo "Exception: ".$e->getMessage()."\n";
            $transaction->rollBack();
            return false;
        }
	}

	public function down()
	{
		echo "m170505_073642_cheque_reissue does not support migration down.\n";
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