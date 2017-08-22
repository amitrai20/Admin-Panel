<?php $active ='Security Center'; ?>

<?php 
include_once('common.php');
page_protect();
if(!isset($_SESSION['user_id']))
{
	logout();
}

$password = "";
$confirmpassword = "";
$spendingpassword = "";
$confirmspendingpassword = "";
$currentpassword = "";
$currentspendingpassword = "";

$user_session = $_SESSION['user_session'];
$user_current_balance = 0;

$error = array();
$error2 = array();
$client = "";
if(_LIVE_)
{
	$client = new Client($rpc_host, $rpc_port, $rpc_user, $rpc_pass);
	if(isset($client))
	{
		$user_current_balance = $client->getBalance($user_session) - $fee;
	}
}


if(isset($_POST['btnverify']))
{
	
	$new_password = rand(0,99999999);
	$otp_value = hash('sha256',addslashes(strip_tags($new_password)));
	
	$sub =" Email Verification Mail";
	$message_body =" Dear User \n";
	$message_body .= " Your email verification OTP is $new_password \n\n";
	$message_body .= " \n\n";
	$message_body .= " Thanks \n";
	$message_body .= " Administrator";
	
	$qstring = "update users set `otp_value` ='".$otp_value."'"; 
	$qstring .= " WHERE ";
//	$qstring .= " encrypt_username = '" . hash('sha256',$user_session) . "' and ";
	$qstring .= " id = ".$_SESSION['user_id'];
	//echo $new_password; 
	$result2	= $mysqli->query($qstring);
//	$user2 = $result2->fetch_assoc();
	
	sendpmail($user_session,$sub,$message_body);
	
	header("Location:verifyemail.php");
	exit();
}


if(isset($_POST['btnlogin']))
{
	//var_dump($_POST);
	
	
	$currentpassword = $_POST['currentpassword'];
	$password = $_POST['signuppassword'];
	$confirmpassword = $_POST['confirmpassword'];
	$spendingpassword = $_POST['spendingpassword'];
	$confirmspendingpassword = $_POST['confirmspendingpassword'];
	$currentspendingpassword = $_POST['currentspendingpassword'];

	if (empty($currentpassword))
	{
		$error['currentpasswordError'] = "Please Provide your current login password.";
	}	
	if(empty($password))
	{
		$error['passwordError'] = "Please Provide valid Password.";
	}
	if(empty($confirmpassword))
	{
		$error['confirmpasswordError'] = "Please Provide valid Confirm Password.";
	}
	else if($confirmpassword != $password)
	{
		$error['confirmpasswordError'] = "Password and Confirm Password Must be same.";
	}
		
	$password_value = hash('sha256',addslashes(strip_tags($currentpassword)));
	$qstring = "select coalesce(id,0) as id
				from users WHERE encrypt_username = '".hash('sha256',$user_session)."' and `password` = '" . $password_value . "'";
	
//	echo $qstring;
//	die;
	$result	= $mysqli->query($qstring);
	$user = $result->fetch_assoc();
//	var_dump($user);
	if ($user['id'] <= 0)
	{
		$error['currentpasswordError'] = "Your current Login password do not matched.";
	}
	
	if(empty($error))
	{	
		$password_value = hash('sha256',addslashes(strip_tags($password)));

		$qstring = "update `users`set "; 
		$qstring .= "`password` = ";
		$qstring .= "'".$password_value."'";
		$qstring .= " where encrypt_username = '".hash('sha256',$user_session)."' and id = ".$user['id'];
		//echo $qstring;
		$result	= $mysqli->query($qstring);
		if($result)
		{
			$error['currentpasswordError2'] = "Your  Login password has been successfully updated.";
			$password = "";
			$confirmpassword = "";
			$currentpassword = "";
		}
	}
}

if(isset($_POST['btnSpending']))
{
	$currentpassword = $_POST['currentpassword'];
	$password = $_POST['signuppassword'];
	$confirmpassword = $_POST['confirmpassword'];
	$spendingpassword = $_POST['spendingpassword'];
	$confirmspendingpassword = $_POST['confirmspendingpassword'];
	$currentspendingpassword = $_POST['currentspendingpassword'];

	
	if(empty($currentspendingpassword))
	{
		$error2['currentspendingpasswordError'] = "Please Provide your current Spending Password";
	}
	if(empty($spendingpassword))
	{
		$error2['spendingpasswordError'] = "Please Provide valid Spending Password";
	}
	if(empty($confirmspendingpassword))
	{
		$error2['confirmspendingpasswordError'] = "Please Provide valid Confirm Spending Password";
	}
	else if($confirmspendingpassword != $spendingpassword)
	{
		$error2['confirmpasswordError'] = "Spending Password and Confirm Password Spending Must be same";
	}
	
	$spendingpassword_value = hash('sha256',addslashes(strip_tags($currentspendingpassword)));
	$qstring = "select coalesce(id,0) as id
				from users where encrypt_username = '".hash('sha256',$user_session)."' and `transcation_password` = '" . $spendingpassword_value . "'";
	
	$result2 = $mysqli->query($qstring);
	$user2 = $result2->fetch_assoc();
	//var_dump($user);
	if ($user2['id'] <= 0)
	{
		$error2['currentspendingpasswordError'] = "Your current spending password do not matched.";
	}
	
	if(empty($error2))
	{	
		$spendingpassword_value = hash('sha256',addslashes(strip_tags($spendingpassword)));

		$qstring = "update `users`set "; 
		$qstring .= "`transcation_password` = ";
		$qstring .= "'".$spendingpassword_value."' ";
		$qstring .= " where encrypt_username = '".hash('sha256',$user_session)."' and id = ".$user2['id'];
		$result3 = $mysqli->query($qstring);
		if($result3)
		{
			$error2['currentspendingpasswordError2'] = "Your  Spending Password has been successfully updated.";
			$spendingpassword = "";
			$confirmspendingpassword = "";
			$currentspendingpassword = "";
		}
	}
}
?>

<?php
include('header.php');
?>


            <!-- #User Info -->
            <!-- Menu -->
           				<?php
                         include('menubar.php');
                       ?>

            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2016 - 2017 <a href="javascript:void(0);">AdminBSB - Material Design</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.5
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        
    </section>
    <!-- Widgets -->

    <?php
include('widget.php');
?>


     <!-- Widgets -->
  

    <section class="content" style="margin-top: 46px;">
        <div class="container-fluid">
            
            <div class="row clearfix">
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 style="font-size:33px;text-align:center"> 
                               Security Center	
                            </h2>
                            <p class="text-center" style="font-size:1.2em">Please update your password regularly</p>
                        </div>
                                        <style>
											@media screen and (max-width:786px){
												#half1231{
													    
   														 width: 77%!important;
   														 margin-left: 17px!important;
    													margin-top: -25px!important;
												}

												#btnverify{
													    margin-left: -113px;
    													margin-top: 63px!important;
												}

											}
												/*.form-control{
													background-color:#ffd6cc;
													margin-left:10px;
															}
												
                                                .form-group .form-control{
													width:29%;
												}	*/	
											</style> 
                        <div class="body">
                           <form action="securitycenter.php" method="post">
					
										<fieldset>
											<div class="row" style="border-bottom:1px solid black; margin-right:20px; margin-left:5px;">
												<div class="form-group col-md-3 col-sm-3" id="half1" style="margin-top:6px;margin-bottom:20px;width: 20%;margin-right: 5px;margin-left: -12px;">
													<label style="float: left;margin-left:6px;margin-top:-4px;padding:0px;margin-bottom: 12px;">Verfiy Your Email ID</label>
												</div>
												<div class="form-group col-md-9 col-sm-9" id="half1" style="margin-bottom:5px">
													<div class="form-group col-md-6 col-sm-12" id="half1231" style="margin-bottom:1px;width: 36%;margin-left:200px;margin-top:-47px;">
														<label style="color:red;margin-left:130px;margin-top:-85px;padding:0px"><font size="2"><?php if($_SESSION['is_email_verify'] == 1){ echo "<span class=\"messageClass2\">verified" ;} else { echo "<span class=\"messageClass\">Not Verified?" ; } ?></font></label>
													</div>
													<div class="form-group col-md-6 col-sm-12" style="margin-left:10px;margin-top:-62px;width:20%;font-weight:bold;font-size:1.3em; 
													float:right;margin-bottom:5px;">
														<input type="submit" class="btn btn-success" style="font-size:17px; margin-top:5px;" id="btnverify" name="btnverify" value="Verify Email"/>
													</div>
													
												</div>
											</div>
											
											
											<div class="row">
												<div class="col-md-6 col-sm-6 col-lg-6">
												
													<label style="float:left;margin-top:6px;color: #555;font-weight: bold;display: block;">Current Password</label>
													<input id="currentpassword" name="currentpassword" autocomplete="off" class="form-control" type="password" value="<?php echo $currentpassword;?>">
												
													<label style="float:left;color: #555;font-weight: bold;display: block;">New Password</label>
													<input id="signuppassword" name="signuppassword" autocomplete="off" class="form-control" type="password" value="<?php echo $password;?>">
													
												
												
													<label style="float:left;color: #555;font-weight: bold;display: block;">Confirm Password</label>
													<input id="confirmpassword" name="confirmpassword" class="form-control" autocomplete="off" type="password" value="<?php echo $confirmpassword;?>">
													
												
																						
														<input style="margin-top:10px;"type="submit" class="btn btn-info font-10" id="btnlogin" name="btnlogin" value="Update Login Password"/>

													<?php if(isset($error['currentpasswordError'])) { echo "<br/><span style='color: red' class=\"messageClass\">".$error['currentpasswordError']."</span>";  }?>	
													<?php if(isset($error['currentpasswordError2'])) { echo "<br/><span style='color: red' class=\"messageClass2\">".$error['currentpasswordError2']."</span>";  }?>	
													<?php if(isset($error['passwordError'])) { echo "<br/><span style='color: red' class=\"messageClass\">".$error['passwordError']."</span>";  }?>	
													<?php if(isset($error['confirmpasswordError'])) { echo "<span style='color: red' class=\"messageClass\">".$error['confirmpasswordError']."</span>";  }?>
												</div>
																						
											
												<div class="col-md-6 col-sm-6 col-lg-6">
												
													<label style="float:left;margin-top:6px;color: #555;font-weight: bold;display: block;">Current Spending Password</label>
													<input id="currentspendingpassword" name="currentspendingpassword" class="form-control" autocomplete="off" type="password" value="<?php echo $currentspendingpassword;?>">
												
												
													<label style="float:left;color: #555;font-weight: bold;display: block;">New Spending Password</label>
													<input id="spendingpassword" name="spendingpassword" class="form-control" autocomplete="off" type="password" value="<?php echo $spendingpassword;?>">
													
												
													<label style="float:left;color: #555;font-weight: bold;display: block;">Confirm Spending Password</label>
													<input id="confirmspendingpassword" name="confirmspendingpassword" class="form-control" autocomplete="off" type="password" value="<?php echo $confirmspendingpassword;?>">
													
												
												
												
													<input style="margin-top:10px;"type="submit" class="btn btn-success font-10" id="btnSpending" name="btnSpending" value="Update Spending Password"/>
												
													<?php if(isset($error2['currentspendingpasswordError'])) { echo "<br/><span style='color: red' class=\"messageClass\">".$error2['currentspendingpasswordError']."</span>";  }?>	
													<?php if(isset($error2['currentspendingpasswordError2'])) { echo "<br/><span style='color: red' class=\"messageClass2\">".$error2['currentspendingpasswordError2']."</span>";  }?>	
													<?php if(isset($error2['spendingpasswordError'])) { echo "<br/><span style='color: red' class=\"messageClass\">".$error2['spendingpasswordError']."</span>";  }?>	
													<?php if(isset($error2['confirmspendingpasswordError'])) { echo "<br/><span style='color: red' class=\"messageClass\">".$error2['confirmspendingpasswordError']."</span>";  }?>
												</div>
											</div>
											
											<!-- <div class="row">
												<div class="form-group col-md-6 col-sm-12" style="margin-left:45px;margin-top:12px;margin-bottom:10px; width:40%;font-weight:bold;font-size:1.3em">
													<input type="submit" class="btn btn-info font-10" id="btnlogin" name="btnlogin" value="Update Login Password"/>
												</div>
												<div class="form-group col-md-6 col-sm-12" style="margin-left:45px;margin-top:12px;margin-bottom:10px;width:50%;font-weight:bold;font-size:1.3em">
													<input type="submit" class="btn btn-success font-10" id="btnSpending" name="btnSpending" value="Update Spending Password"/>
												</div>
											<div>  -->
										</fieldset>
							
				</form> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
        
           			

<?php
include('footer.php');
?>
