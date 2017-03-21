<?php

class m170321_124958_vendorLogTrigger extends CDbMigration
{
	public function up()
	{

        $triggerInsert = 'create trigger vendor_log_insert after insert on cb_dev_groots.vendors for each row
                            insert into vendor_log(vendor_id, total_pending,base_date, created_at, updated_at)
                            values (NEW.id, sum(NEW.total_pending_amount, NEW.initial_pending_amount), NEW.initial)'
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