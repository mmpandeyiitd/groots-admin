<?php

class m170429_072941_s3_table extends CDbMigration
{
	public function up()
	{
        $transaction = Yii::app()->db->beginTransaction();
        try{
            $sql = 'create table cb_dev_groots.vendor_upload(
                     id int(11) not null AUTO_INCREMENT,
                     vendor_id int(11) not null,
                     bucket VARCHAR (100) not null DEFAULT 0,
                     file_tag VARCHAR (300) not null,
                     file_name VARCHAR (300) not null,
                     file_size decimal(10,2) not null,
                     file_link VARCHAR (500) not null,
                     file_type VARCHAR (10) not null,
                     date date not null,
                     status int(1) not null default 1,
                     created_at datetime not null,
                     updated_at timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP ,
                     updated_by int(11) not null,
                     primary key (id)
                    )ENGINE=InnoDB default CHARSET=utf8';
            $this->execute($sql);
        } catch(Exception $e){
            echo "Exception: ".$e->getMessage()."\n";
            $transaction->rollBack();
            return false;
        }
	}

	public function down()
	{
		echo "m170429_072941_s3_table does not support migration down.\n";
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