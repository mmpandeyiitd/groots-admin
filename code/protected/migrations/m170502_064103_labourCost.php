<?php

class m170502_064103_labourCost extends CDbMigration
{
	public function up()
	{
	    $transaction = Yii::app()->secondaryDb->beginTransaction();
	    try{
            $sql = 'alter table groots_orders.purchase_header add column labour_cost decimal(10,2) NOT NULL DEFAULT "0.00"';
            $this->execute($sql);

        } catch(Exception $e){
            echo "Exception: ".$e->getMessage()."\n";
            $transaction->rollBack();
            return false;
        }
	}

	public function down()
	{
		echo "m170502_064103_labourCost does not support migration down.\n";
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