<?php

class m170508_065139_permitted_file_types extends CDbMigration
{
    private $_db= '';
	public function up()
	{
        try{
            $this->_db = 'cb_dev_groots';
            $transaction=$this->getDbConnection()->beginTransaction();
            $this->createTable('permitted_file_types', array(
                'id' => 'int(11) not null AUTO_INCREMENT',
                'file_class' => 'varchar (20) not null',
                'file_type' => 'varchar(10) not null',
                'PRIMARY KEY (ID)'
            ),'ENGINE=InnoDB CHARSET=utf8');
            //$this->addForeignKey('fk_vu_2', 'vendor_upload', 'file_type', 'permitted_file_types', 'file_type','CASCADE','CASCADE');
            $sql = 'insert into permitted_file_types values(null, "Document", "doc"), (null, "Document","docx"),(null,"Document","rtf"),(null, "Document","txt"),
                    (null ,"Excel","xls"),(null ,"Excel","xlsx"),(null ,"Excel","csv"),(null ,"Presentation","ppt"),(null ,"Presentation","pptx"),(null ,"Adobe","pdf"),
                    (null ,"Image","jpg"),(null ,"Image","jpeg"),(null ,"Image","png")';
            $this->execute($sql);
            $sql = 'insert into app_versions (id,app_version,platform_id) values(4,1.4,1)';
            $this->execute($sql);
            $sql = 'insert into api_configs (id,app_version_id,auth_expirytime,api_config_version,status,added_on) values(4,4,999999999,1.0,1,now())';
            $this->execute($sql);
        } catch(Exception $e){
            echo "Exception: ".$e->getMessage()."\n";
            $transaction->rollBack();
            return false;
        }
	}

	public function down()
	{
		echo "m170508_065139_permitted_file_types does not support migration down.\n";
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