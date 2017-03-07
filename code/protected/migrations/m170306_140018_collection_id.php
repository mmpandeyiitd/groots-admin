<?php

class m170306_140018_collection_id extends CDbMigration
{
	public function up()
	{
        //$connection = Yii::app()->db;
        $transaction = Yii::app()->db->beginTransaction();
	    try{
            $connection = Yii::app()->db;

            $sql = 'insert into cb_dev_groots.users (username, password, email, status, create_at) values ("CollectionEditor", md5("cols@123"), "col@123",1 , CURDATE() )';
            $command = $connection->createCommand($sql);
            $command->execute();
            $sql = 'insert into cb_dev_groots.users (username, password, email, status, create_at) values ("Trilok", md5("tri@123"), "trilok@gogroots.com",1 , CURDATE() )';
            $command = $connection->createCommand($sql);
            $command->execute();
            $sql = 'select id, username from users where username in ( "CollectionEditor", "Trilok")';
            $command = $connection->createCommand($sql);
            $result = $command->queryAll();
            $editorId = $trilokId = '';
            foreach ($result as $row){
                if($row['username'] == 'CollectionEditor'){
                    $editorId = $row['id'];
                }
                else if($row['username'] == 'Trilok'){
                    $trilokId = $row['id'];
                }
            }
            $sql = 'insert into cb_dev_groots.AuthAssignment values("CollectionEditor" ,'.$editorId.', "return $params['."'warehouse_id'".']==2;", null)';
            $command = $connection->createCommand($sql);
            $command->execute();
            $sql = 'insert into cb_dev_groots.AuthAssignment values("TrilokGroots" ,'.$trilokId.', "return $params['."'warehouse_id'".']==2;", null)';
            $command = $connection->createCommand($sql);
            $command->execute();
            $sql = 'insert into cb_dev_groots.profiles select id, username, username from cb_dev_groots.users where id>23';
            $command = $connection->createCommand($sql);
            $command->execute();
            $transaction->commit();
            return true;
        } catch(Exception $e){
            echo "Exception: ".$e->getMessage()."\n";
            //$transaction->rollBack();
            return false;
        }
	}

	public function down()
	{
		echo "m170306_140018_collection_id does not support migration down.\n";
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