<?php

class m170321_124958_vendorLogTrigger extends CDbMigration
{
	public function up()
	{
        $transaction = Yii::app()->db->beginTransaction();
        try{
            $connection = Yii::app()->db;

            $sql = 'select max(base_date) from vendor_log';
            $command = $connection->createCommand($sql);
            $currentPendingDate = $command->queryScalar();
            $triggerInsert = 'create trigger vendor_log_insert after insert on cb_dev_groots.vendors for each row
                            insert into vendor_log(vendor_id, total_pending,base_date, created_at, updated_at)
                            values (NEW.id, NEW.total_pending_amount + NEW.initial_pending_amount, "'.$currentPendingDate.'", CURRENTDATETIME(), CURRENTDATETIME())';
            $this->execute($triggerInsert);
            $sql = 'insert into cb_dev_groots.vendor_log (vendor_id , total_pending, base_date, created_at, updated_at) (select id, initial_pending_amount, "2017-02-28", CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP() from cb_dev_groots.vendors as v where v.id > 37 )' ;
            $this->execute($sql);
        } catch(Exception $e){
            echo "Exception: ".$e->getMessage()."\n";
            $transaction->rollBack();
            return false;
        }

	}

	public function down()
	{
		echo "m170321_124958_vendorLogTrigger does not support migration down.\n";
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