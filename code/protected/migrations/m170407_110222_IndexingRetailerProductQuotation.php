<?php

class m170407_110222_IndexingRetailerProductQuotation extends CDbMigration
{
	public function up()
	{
        $transaction = Yii::app()->db->beginTransaction();
        try{
            $sql = 'alter table cb_dev_groots.subscribed_product add index `status` (`status`)';
            $this->execute($sql);
            $sql = 'alter table cb_dev_groots.base_product add index `status` (`status`)';
            $this->execute($sql);
            $sql = 'alter table cb_dev_groots.base_product add index `grade` (`grade`)';
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
		echo "m170407_110222_IndexingRetailerProductQuotation does not support migration down.\n";
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