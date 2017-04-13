<?php

class m170413_071530_vendorPaymentsAlter extends CDbMigration
{
	public function up()
	{
        $transaction = Yii::app()->secondaryDb->beginTransaction();
        try{
            $connection = Yii::app()->secondaryDb;
            $sql = 'alter table groots_orders.vendor_payments MODIFY column receiving_acc_no bigint(18) not null';
            $this->execute($sql);
            $sql = "update groots_orders.vendor_payments as vp left join cb_dev_groots.vendors as v on vp.vendor_id = v.id set receiving_acc_no = v.bank_account_no where receiving_acc_no is null or receiving_acc_no = ''";
            $this->execute($sql);
            $sql = 'alter table groots_orders.vendor_payments change `cheque_issue_date` `cheque_date` date default null';
            $this->execute($sql);
            $transaction->commit();
            return true;
        } catch(Exception $e){
            echo "Exception: ".$e->getMessage()."\n";
            $transaction->rollBack();
            return false;
        }
	}

	public function down()
	{
		echo "m170413_071530_vendorPaymentsAlter does not support migration down.\n";
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