<?php
	/** Code Created By Mohd Alam  **/
	class Log{

		function insertLog($data){
           // $data['oldAttrs']=mysql_escape_string($data['oldAttrs']);
           // $data['newAttrs']=mysql_escape_string($data['newAttrs']); 
			$connection = Yii::app()->db_log;

            //$sql = "INSERT INTO log_master(user_id,name,action,work_info,work_info_after_save,created_at,ip_address)VALUES('".Yii::app()->session['user_id']."','coupons','update','".$oldAttrs."','".$newAttrs."','".date('Y:m:d h-i-s')."','".$_SERVER['REMOTE_ADDR']."')";
            $sql = "INSERT INTO log_master(user_id,login_id,name,action,work_info,work_info_after_save,created_at,ip_address)VALUES('".$data['user_id']."','".@$data['login_id']."','".$data['name']."','".$data['action']."','".$data['oldAttrs']."','".$data['newAttrs']."','".date('Y:m:d h-i-s')."','".$_SERVER['REMOTE_ADDR']."')";
            $command = $connection->createCommand($sql);
            $command->execute();
		}


		/** USERS **/
		function insertUserLog($data){
            $data['oldAttrs']=mysql_escape_string($data['oldAttrs']);
            $data['newAttrs']=mysql_escape_string($data['newAttrs']); 
			$connection = Yii::app()->db_log;
            $sql = "INSERT INTO log_master_users(user_id,login_id,name,action,work_info,work_info_after_save,created_at,ip_address)VALUES('".$data['user_id']."','".@$data['login_id']."','".$data['name']."','".$data['action']."','".$data['oldAttrs']."','".$data['newAttrs']."','".date('Y:m:d h-i-s')."','".$_SERVER['REMOTE_ADDR']."')";
            $command = $connection->createCommand($sql);
            $command->execute();
            Yii::app()->session['oldjson']="";
            Yii::app()->session['newjson']="";
		}


		/**  STORE FRONT **/
		function insertStoreFrontLog($data){
            $data['oldAttrs']=mysql_escape_string($data['oldAttrs']);
            $data['newAttrs']=mysql_escape_string($data['newAttrs']); 
			$connection = Yii::app()->db_log;
            $sql = "INSERT INTO log_master_stores_front(user_id,login_id,name,action,work_info,work_info_after_save,created_at,ip_address)VALUES('".$data['user_id']."','".@$data['login_id']."','".$data['name']."','".$data['action']."','".$data['oldAttrs']."','".$data['newAttrs']."','".date('Y:m:d h-i-s')."','".$_SERVER['REMOTE_ADDR']."')";
            $command = $connection->createCommand($sql);
            $command->execute();
		}

                 /**  RETAILER LIST **/
	function insertRetailerListLog($data){
          
          $data['oldAttrs']=mysql_escape_string($data['oldAttrs']);
          $data['newAttrs']=mysql_escape_string($data['newAttrs']); 
            $connection = Yii::app()->db_log;
            $sql = "INSERT INTO log_master_retailerlist(user_id,login_id,name,action,work_info,work_info_after_save,created_at,ip_address)VALUES('".$data['user_id']."','".@$data['login_id']."','".$data['name']."','".$data['action']."','".$data['oldAttrs']."','".$data['newAttrs']."','".date('Y:m:d h-i-s')."','".$_SERVER['REMOTE_ADDR']."')";
            $command = $connection->createCommand($sql);
            $command->execute();
	}
        
          /**  Press LIST **/
	function insertPressreleasLog($data){
          $data['oldAttrs']=mysql_escape_string($data['oldAttrs']);
          $data['newAttrs']=mysql_escape_string($data['newAttrs']); 
            $connection = Yii::app()->db_log;
            $sql = "INSERT INTO log_master_press(user_id,login_id,name,action,work_info,work_info_after_save,created_at,ip_address)VALUES('".$data['user_id']."','".@$data['login_id']."','".$data['name']."','".$data['action']."','".$data['oldAttrs']."','".$data['newAttrs']."','".date('Y:m:d h-i-s')."','".$_SERVER['REMOTE_ADDR']."')";
            $command = $connection->createCommand($sql);
            $command->execute();
	}
                
        /**  Lookbook  **/
	function insertLookbookLog($data){
          $data['oldAttrs']=mysql_escape_string($data['oldAttrs']);
          $data['newAttrs']=mysql_escape_string($data['newAttrs']); 
            $connection = Yii::app()->db_log;
            $sql = "INSERT INTO log_master_lookbook(user_id,login_id,name,action,work_info,work_info_after_save,created_at,ip_address)VALUES('".$data['user_id']."','".@$data['login_id']."','".$data['name']."','".$data['action']."','".$data['oldAttrs']."','".$data['newAttrs']."','".date('Y:m:d h-i-s')."','".$_SERVER['REMOTE_ADDR']."')";
            $command = $connection->createCommand($sql);
            $command->execute();
	}
        /**  Photogallery Log LIST **/
	function insertPhotogalleryLog($data){
          $data['oldAttrs']=mysql_escape_string($data['oldAttrs']);
          $data['newAttrs']=mysql_escape_string($data['newAttrs']); 
            $connection = Yii::app()->db_log;
            $sql = "INSERT INTO log_master_photogallery(user_id,login_id,name,action,work_info,work_info_after_save,created_at,ip_address)VALUES('".$data['user_id']."','".@$data['login_id']."','".$data['name']."','".$data['action']."','".$data['oldAttrs']."','".$data['newAttrs']."','".date('Y:m:d h-i-s')."','".$_SERVER['REMOTE_ADDR']."')";
            $command = $connection->createCommand($sql);
            $command->execute();
	}
        
                
		/**  PREPAID SELLER **/
		function insertPrepaidSellerLog($data){
            $data['oldAttrs']=mysql_escape_string($data['oldAttrs']);
            $data['newAttrs']=mysql_escape_string($data['newAttrs']); 
			$connection = Yii::app()->db_log;
            $sql = "INSERT INTO log_master_prepaid_seller(user_id,login_id,name,action,work_info,work_info_after_save,created_at,ip_address)VALUES('".$data['user_id']."','".@$data['login_id']."','".$data['name']."','".$data['action']."','".$data['oldAttrs']."','".$data['newAttrs']."','".date('Y:m:d h-i-s')."','".$_SERVER['REMOTE_ADDR']."')";
            $command = $connection->createCommand($sql);
            $command->execute();
		}

		/**  COUPONS **/
		function insertCouponsLog($data){
            $data['oldAttrs']=mysql_escape_string($data['oldAttrs']);
            $data['newAttrs']=mysql_escape_string($data['newAttrs']); 
			$connection = Yii::app()->db_log;
            $sql = "INSERT INTO log_master_coupon(user_id,login_id,name,action,work_info,work_info_after_save,created_at,ip_address)VALUES('".$data['user_id']."','".@$data['login_id']."','".$data['name']."','".$data['action']."','".$data['oldAttrs']."','".$data['newAttrs']."','".date('Y:m:d h-i-s')."','".$_SERVER['REMOTE_ADDR']."')";
            $command = $connection->createCommand($sql);
            $command->execute();
		}


		/**  CMS **/
		function insertCMSLog($data){
            $data['oldAttrs']=mysql_escape_string($data['oldAttrs']);
            $data['newAttrs']=mysql_escape_string($data['newAttrs']); 
			$connection = Yii::app()->db_log;
            $sql = "INSERT INTO log_master_cms(user_id,login_id,name,action,work_info,work_info_after_save,created_at,ip_address)VALUES('".$data['user_id']."','".@$data['login_id']."','".$data['name']."','".$data['action']."','".$data['oldAttrs']."','".$data['newAttrs']."','".date('Y:m:d h-i-s')."','".$_SERVER['REMOTE_ADDR']."')";
            $command = $connection->createCommand($sql);
            $command->execute();
		}


		/**  LOGIN LOG **/
		function insertLoginLog(){
          //  $data['oldAttrs']=mysql_escape_string($data['oldAttrs']);
          //  $data['newAttrs']=mysql_escape_string($data['newAttrs']); 
			$connection = Yii::app()->db_log;
            $sql = "INSERT INTO log_master_login(user_id,login_date)VALUES('".Yii::app()->session['user_id']."','".date('Y:m:d h-i-s')."')";
            $command = $connection->createCommand($sql);
            $command->execute();
		}

		/**  STORE LOG **/
		function insertStoreLog($data){
            $data['oldAttrs']=mysql_escape_string($data['oldAttrs']);
            $data['newAttrs']=mysql_escape_string($data['newAttrs']); 
			$connection = Yii::app()->db_log;
            $sql = "INSERT INTO log_master_store(user_id,login_id,name,action,work_info,work_info_after_save,created_at,ip_address)VALUES('".$data['user_id']."','".@$data['login_id']."','".$data['name']."','".$data['action']."','".$data['oldAttrs']."','".$data['newAttrs']."','".date('Y:m:d h-i-s')."','".$_SERVER['REMOTE_ADDR']."')";
            $command = $connection->createCommand($sql);
            $command->execute();
		}

		/**  CATEGORY LOG **/
		function insertCategoryLog($data){
            $data['oldAttrs']=mysql_escape_string($data['oldAttrs']);
            $data['newAttrs']=mysql_escape_string($data['newAttrs']); 
			$connection = Yii::app()->db_log;
            $sql = "INSERT INTO log_master_category(user_id,login_id,name,action,work_info,work_info_after_save,created_at,ip_address)VALUES('".$data['user_id']."','".@$data['login_id']."','".$data['name']."','".$data['action']."','".$data['oldAttrs']."','".$data['newAttrs']."','".date('Y:m:d h-i-s')."','".$_SERVER['REMOTE_ADDR']."')";
            $command = $connection->createCommand($sql);
            $command->execute();
		}

		/**  BASE PRODUCT LOG **/
		function insertBaseproductLog($data){
            $data['oldAttrs']=mysql_escape_string($data['oldAttrs']);
            $data['newAttrs']=mysql_escape_string($data['newAttrs']); 
			$connection = Yii::app()->db_log;
            $sql = "INSERT INTO log_master_baseproduct(user_id,login_id,name,action,work_info,work_info_after_save,created_at,ip_address)VALUES('".$data['user_id']."','".@$data['login_id']."','".$data['name']."','".$data['action']."','".$data['oldAttrs']."','".$data['newAttrs']."','".date('Y:m:d h-i-s')."','".$_SERVER['REMOTE_ADDR']."')";
            $command = $connection->createCommand($sql);
            $command->execute();
		}


		/**  BASE PRODUCT LOG **/
		function insertCategoryBannerLog($data){
            $data['oldAttrs']=mysql_escape_string($data['oldAttrs']);
            $data['newAttrs']=mysql_escape_string($data['newAttrs']); 
			$connection = Yii::app()->db_log;
            $sql = "INSERT INTO log_master_categorybanner(user_id,login_id,name,action,work_info,work_info_after_save,created_at,ip_address)VALUES('".$data['user_id']."','".@$data['login_id']."','".$data['name']."','".$data['action']."','".$data['oldAttrs']."','".$data['newAttrs']."','".date('Y:m:d h-i-s')."','".$_SERVER['REMOTE_ADDR']."')";
            $command = $connection->createCommand($sql);
            $command->execute();
		}

		/**  ORDER HEADER LOG **/
		function insertOrderheaderLog($data){
            $data['oldAttrs']=mysql_escape_string($data['oldAttrs']);
            $data['newAttrs']=mysql_escape_string($data['newAttrs']); 
			$connection = Yii::app()->db_log;
            $sql = "INSERT INTO log_master_orderheader(user_id,login_id,name,action,work_info,work_info_after_save,created_at,ip_address)VALUES('".$data['user_id']."','".@$data['login_id']."','".$data['name']."','".$data['action']."','".$data['oldAttrs']."','".$data['newAttrs']."','".date('Y:m:d h-i-s')."','".$_SERVER['REMOTE_ADDR']."')";
            $command = $connection->createCommand($sql);
            $command->execute();
		}

		/**  ORDER HEADER LOG **/
		function insertOrderlineLog($data){
            $data['oldAttrs']=mysql_escape_string($data['oldAttrs']);
            $data['newAttrs']=mysql_escape_string($data['newAttrs']); 
			$connection = Yii::app()->db_log;
            $sql = "INSERT INTO log_master_orderline(user_id,login_id,name,action,work_info,work_info_after_save,created_at,ip_address)VALUES('".$data['user_id']."','".@$data['login_id']."','".$data['name']."','".$data['action']."','".$data['oldAttrs']."','".$data['newAttrs']."','".date('Y:m:d h-i-s')."','".$_SERVER['REMOTE_ADDR']."')";
            $command = $connection->createCommand($sql);
            $command->execute();
		}

		
	}	

	
?>