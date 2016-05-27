<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" />
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<?php 
    /** Check Url First**/
    $token = "";
    $url = "";
 	$url = explode('&', $_SERVER['REQUEST_URI'], 2);
    $url = $url[0];



    if(isset($_REQUEST['key']) && !empty($_REQUEST['key']) ){
        $key = $_REQUEST['key'];
    }else{
        echo "Invalid Request ";
        die;
    }
    

    /** Print Validation Messages **/
    if(isset($_REQUEST['error']) && !empty($_REQUEST['error'])){
    	$error =  $_REQUEST['error'];
    	if($error=="bpnm"){
    		$error_message	 = "Both Password Not Matched";
    	}
    	else if($error=="ef"){
    		$error_message	 = "Both Fields Required";
    	}
    	echo "<p class='alert alert-danger col-md-4 col-md-offset-4 alert-dismissible' style='margin-top:20px !important;'>".$error_message."<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span>&times;</span></button></p>";
    }



    /** Check If Form Submited **/
    if($_POST['create_password']){
        
        /** Checking Parameters **/
        if(
            isset($_POST['key']) && !empty($_POST['key']) &&
            isset($_POST['new_password']) && !empty($_POST['new_password']) &&
            isset($_POST['re_new_password']) && !empty($_POST['re_new_password'])
        ){
            /** Paramters **/
            $password = $_POST['new_password'];
            $re_new_password = $_POST['re_new_password'];
            $key = $_POST['key'];
            
            if($_POST['new_password']==$_POST['re_new_password']){
                /** Call Api to Generate New Password **/

                $data = array('key'=>$key,'password'=>$password);

                /** Reset Password **/
                $ch = curl_init();
				$timeout = 100; // set to zero for no timeout
				$myurl = "http://api.groots.dev.canbrand.in/index.php/api/resetPassword";
				curl_setopt($ch,CURLOPT_HTTPHEADER,array('API_KEY: andapikey','APP_VERSION: 1.0','CONFIG_VERSION: 1.0'));
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				curl_setopt ($ch, CURLOPT_URL, $myurl);
				curl_setopt ($ch, CURLOPT_HEADER, 0);
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
				$result = curl_exec($ch);
				$curl_error = curl_errno($ch);
				curl_close($ch);
				
				$result = json_decode($result);
				echo "<p class='alert alert-info col-md-4 col-md-offset-4' style='margin-top20px;' role='alert'>".($result->msg)."</p>";
				die;

            }else{
                /** Send Error Of Both Password Not Matched **/
                $url = explode('&', $_SERVER['REQUEST_URI'], 2);
                $url = $url[0];
                $url = $url.'&error=bpnm';
                echo "<script>location.href='".$url."';</script>";
            }
        }else{
        	$url = explode('&', $_SERVER['REQUEST_URI'], 2);
            $url = $url[0];
            $url = $url.'&error=ef';
            echo "<script>location.href='".$url."';</script>";
        }    
    }
?>
<div class="container" style="margin-top:50px;">
    <div class="col-md-4 col-md-offset-4 col-xs-12"><div class="panel panel-default">
        <div class="panel-heading">Change Password </div>
          <div class="panel-body">
            <form name="create_password" action="<?php echo $url;?>" method="post">
                <input type="hidden" value="<?php echo $key;?>" name='key'/>
                <div class="form-group">
                    <label for="new_password">Enter New Password</label>
                    <input type='text' name='new_password' id='new_password' class="form-control"placeholder="****">
                </div>

                <div class="form-group">
                    <label for="re_new_password">Confirm Password</label>
                    <input type='text' name='re_new_password' class="form-control" placeholder="****" id='re_new_password'/>
                </div>
                <div class="form-group">
                    <div class="text-right">
                      <input class="btn btn-info" name='create_password' type="submit" value="Create"/>
                    </div>
                </div>
            </form>
          </div>
        </div>
    </div>
</div>