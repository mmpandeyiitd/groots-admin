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
                     bucket VARCHAR (100) not null,
                     file_name VARCHAR (300) not null,
                     file_size decimal(10,2) not null,
                     file_link VARCHAR (500) not null,
                     file_type VARCHAR (10) not null,
                     date date not null,
                     created_at datetime not null,
                     updated_at timestamp default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP ,
                     uploaded_by int(11) not null,
                     updated_by int(11) not null,
                     primary key (id),
                     key fk_vu_1 (uploaded_by),
                     constraint fk_ep_dpt_1 foreign key (uploaded_by) REFERENCES cb_dev_groots.groots_employee (id),
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