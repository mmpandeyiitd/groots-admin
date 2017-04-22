<?php

class m170306_140018_collection_id extends CDbMigration
{
	public function up()
	{
        //$connection = Yii::app()->db;
        $transaction = Yii::app()->db->beginTransaction();
	    try{
            $connection = Yii::app()->db;

            $sql = 'insert into cb_dev_groots.users (username, password, email, status, create_at)
                        values ("CollectionEditorHO", md5("col@123"), "col@123",1 , CURDATE() ),
                         ("CollectionViewerB", md5("basai@123"), "basai123.com",1 , CURDATE() ), 
                         ("CollectionViewerA", md5("azd@123"), "azd@123",1 , CURDATE() ),
                         ("trilok", md5("tri@123"), "trilok@gogroots.com",1 , CURDATE() )';
            $command = $connection->createCommand($sql);
            $command->execute();
            $sql = 'select id, username from users where username in ( "CollectionEditorHO", "trilok", "CollectionViewerA", "CollectionViewerB")';
            $command = $connection->createCommand($sql);
            $result = $command->queryAll();
            $editorId = $trilokId = $azdViewId = $basaiViewId = '';
            foreach ($result as $row){
                if($row['username'] == 'CollectionEditorHO'){
                    $editorId = $row['id'];
                }
                else if($row['username'] == 'trilok'){
                    $trilokId = $row['id'];
                }
                else if($row['username'] == 'CollectionViewerA'){
                    $azdViewId = $row['id'];
                }
                else if($row['username'] == 'CollectionViewerB'){
                    $basaiViewId = $row['id'];
                }
            }
            $sql = 'insert into cb_dev_groots.AuthAssignment 
                      values("CollectionEditor" ,'.$editorId.', "return $params['."'warehouse_id'".']==3;", null),
                      ("CollectionViewer" ,'.$trilokId.', "return $params['."'warehouse_id'".']==3;", null),
                      ("CollectionViewer" ,'.$azdViewId.', "return $params['."'warehouse_id'".']==2;", null),
                      ("CollectionViewer" ,'.$basaiViewId.', "return $params['."'warehouse_id'".']==1;", null)';
            $command = $connection->createCommand($sql);
            $command->execute();
            $sql = 'insert into cb_dev_groots.profiles select id, username, username from cb_dev_groots.users where id>32';
            $command = $connection->createCommand($sql);
            $command->execute();
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